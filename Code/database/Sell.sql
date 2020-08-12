create table sellOrders(order_id varchar(20),
		client_id varchar(20) references Client(client_id),
		order_type tinyint not null,       			#market -0 /limit-1  
		position_type tinyint not null,   			#type:MIS-0/delivery-1 
		ticker_name  varchar(10) references Stock_detail(ticker_name), 
		ticker_size bigint check(ticker_size <> 0),    	#can be negative if MIS
		price float default null, 
		status varchar(20),			        #derived and pending intially,
		primary key(order_id));

insert into sellOrders values("3","7",1,1,"HDFC",5,1280,"Pending");
	
delimiter $
create trigger Validition_sellOrder before insert on sellOrders 
for each row

begin

declare market_price float;
declare name varchar(10);
declare flag tinyint;

if (new.price is null) then

set name = new.ticker_name;

select Stock_detail.price into market_price from Stock_detail where Stock_detail.ticker_name = name;
set new.price = market_price;

end if;
 
set flag = is_Sellvalid(new.client_id,new.order_id,new.ticker_name,new.ticker_size,new.position_type);

if flag = 0 then

	set new.status = "Failed";

end if;


end$ 


delimiter $
create function is_Sellvalid(clientId varchar(20),orderId varchar(20),ticker_name varchar(15),ticker_size bigint,p_type tinyint) returns tinyint
	   deterministic
	begin

	declare  avial_ticker_size bigint;
	declare  acc_value float;
	
if p_type = 1  then #Holdings...
		select Holdings.ticker_size into avial_ticker_size from Holdings where Holdings.client_id=clientId and Holdings.ticker_name=ticker_name;
	else #Positions...
		select Positions.ticker_size into avial_ticker_size from Positions where Positions.client_id=clientId and Positions.ticker_name=ticker_name;
	
	end if;

	if ticker_size > avial_ticker_size then
		return 0;
	else
		return 1;
	end if;
	
	end$

delimiter $
create procedure sell_position_holdings(in clientId varchar(20),in orderId varchar(20),in closePrice float)

begin
declare new_ticker_name varchar(10);
declare p_type tinyint;
declare avial_ticker_size bigint;
declare new_ticker_size bigint;
declare takenPrice float;
declare PL float;
declare acc_no varchar(20);
declare bal float;

select sellOrders.ticker_name into new_ticker_name from sellOrders where sellOrders.order_id = orderId;
select sellOrders.ticker_size into new_ticker_size from sellOrders where sellOrders.order_id = orderId;
select sellOrders.position_type into p_type from sellOrders where sellOrders.order_id = orderId;


if p_type = 1 then   # delete/update Holdings

	select Holdings.ticker_size into avial_ticker_size from Holdings 
	where Holdings.client_id = clientId and Holdings.ticker_name = new_ticker_name;

	#drop entry if net qauntity became 0;
	if (avial_ticker_size-new_ticker_size) = 0 then
		delete from Holdings where Holdings.client_id = clientId and Holdings.ticker_name = new_ticker_name; 

	#Upadte to new qauntity instaed.
	else  
		update Holdings set Holdings.ticker_size = (avial_ticker_size - new_ticker_size) 
		where Holdings.client_id = clientId  and Holdings.ticker_name = new_ticker_name; 

	end if;
	
	#Calculate P&L...
	select Holdings.price into takenPrice from Holdings where Holdings.client_id = clientId  and Holdings.ticker_name = new_ticker_name;
	set PL = (closePrice-takenPrice)*(new_ticker_size);	

else

	select ticker_size into avial_ticker_size from Positions
	where Positions.client_id = clientId and Positions.ticker_name = new_ticker_name;

		#drop entry if net qauntity became 0;
	if (avial_ticker_size-new_ticker_size) = 0 then
		delete from Positions where Positions.client_id = clientId and Positions.ticker_name = new_ticker_name; 

	#Upadte to new qauntity instaed.
	else  
		update Positions set Positions.ticker_size = (avial_ticker_size - new_ticker_size) 
		where Positions.client_id = clientId and Positions.ticker_name = new_ticker_name; 
	
	end if;
	
	#Calculate P&L...
	select Positions.price into takenPrice from Positions where Positions.client_id = clientId  and Positions.ticker_name = new_ticker_name;
	set PL = (closePrice-takenPrice)*(new_ticker_size);	

end if;

	#Upadte PL in funds...	declare  acc_no varchar(20);

	select Demate_account.demate_acc_no into acc_no from Demate_account where Demate_account.client_id = clientId;

	select Demate_account_balance_detail.fund into bal from Demate_account_balance_detail
	where Demate_account_balance_detail.account_no= acc_no;
	

	update Demate_account_balance_detail set Demate_account_balance_detail.fund = (bal+PL)
	where Demate_account_balance_detail.account_no = acc_no;
	

end$



delimiter $
create procedure clearing_market_Sellorder()
	begin

declare price float;
declare name varchar(10);
declare orderId ,clientId varchar(20);
declare end_of_table tinyint;
declare cur_order cursor for select order_id from sellOrders where sellOrders.order_type = 0 and sellOrders.status = "Pending";
declare continue handler for not found set end_of_table = 1;

set end_of_table = 0;
open cur_order;

fetch cur_order into orderId;
select sellOrders.ticker_name,sellOrders.client_id,sellOrders.price into name,clientId,price from sellOrders where sellOrders.order_id = orderId;

while end_of_table = 0 do
	
	update sellOrders set sellOrders.status = "Executed" where sellOrders.order_id = orderId; 
	call sell_position_holdings(clientId,orderId,price);

	fetch cur_order into orderId;
	
select sellOrders.ticker_name,sellOrders.client_id,sellOrders.price into name,clientId,price from sellOrders where order_id = orderId;


end while;
close cur_order;
end$

delimiter $	
create procedure clearing_limit_Sellorder()
begin
declare name varchar(10);
declare price,curr_price float;
declare orderId ,clientId varchar(20);
declare end_of_table tinyint;
declare cur_order cursor for select order_id from sellOrders where sellOrders.order_type = 1 and sellOrders.status = "Pending";
declare continue handler for not found set end_of_table = 1;

set end_of_table = 0;
open cur_order;

fetch cur_order into orderId;
select sellOrders.price,sellOrders.ticker_name,sellOrders.client_id into price,name,clientId from sellOrders where order_id = orderId;

while end_of_table = 0 do
	
	select Stock_detail.price into curr_price from Stock_detail where Stock_detail.ticker_name = name;
	if(curr_price >= price) then

		update sellOrders set sellOrders.status = "Executed" where sellOrders.order_id = orderId; 
		call sell_position_holdings(clientId,orderId,curr_price);

	end if;

	
	fetch cur_order into orderId;
select sellOrders.price,sellOrders.ticker_name,sellOrders.client_id into price,name,clientId from sellOrders where order_id = orderId;


end while;
close cur_order;
end$

drop event stock_price_change;
drop event market_sellOrder_clear;
drop event limit_sellOrder_clear;

set global event_scheduler = on;
#event for changing stock-price
create event stock_price_change
on schedule every 2 minute
starts '2020-05-14 18:00:00'
ends '2020-05-15 12:00:00' 
do
update Stock_detail set price = price + ( rand()*(-10) +5);

#event for clearing market-order on every 1 minute
create event market_sellOrder_clear
on schedule every 1 minute
starts '2020-05-14 18:00:00'
ends '2020-05-15 12:00:00'  
do
call clearing_market_Sellorder();

#event for clearing limit-order on every 1 minute
create event limit_sellOrder_clear
on schedule every 1 minute
starts '2020-05-14 18:00:00'
ends '2020-05-15 12:00:00' 
do
call clearing_limit_Sellorder();


