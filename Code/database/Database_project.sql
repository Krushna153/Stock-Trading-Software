create table Client(client_id varchar(20), 
		pan_number varchar(10) not null unique, 
		city varchar(20) not null,
		primary key(client_id));

insert into Client Values("1","ABCD123456", "Surat");
insert into Client Values("2","ABCDE23456", "AHD");
insert into Client Values("3","ABCDEF2345", "Mumbai");
insert into Client Values("4","ABCDEFG234", "Ananad");
insert into Client Values("5","ABCDEFGH23", "baroda");



create table KYC_detail(pan_number varchar(10), 
		f_name varchar(15) not null, 
		m_name varchar(15),
		l_name varchar(15) not null,      
		gender varchar(10), 
		primary key(pan_number));

create table Login_credential(client_id varchar(20) references Client(client_id),
			user_name varchar(25) not null,
			Password varchar(25),
			primary key(client_id));

create table Mobile_number(client_id varchar(20) references Client(client_id),
			mobile_number varchar(10) not null,
			primary key(client_id,mobile_number)); 

create table Email(client_id varchar(20) references Client(client_id), 
		email  varchar(30),
		primary key(client_id,email));

create table Bank_account_detail(client_id varchar(20) references Client(client_id),
			bank_acc_no varchar(20),
			balance float check(balance > 0),
			bank_name varchar(30), 
			flag tinyint,   		# 0 - not primary, 1- primary 
			primary key(bank_acc_no));

create table Demate_account(client_id  varchar(20) references Client(client_id),
			demate_acc_no varchar(20),
			primary key(demate_acc_no));

insert into Demate_account values("1","1234");
insert into Demate_account values("2","1235");
insert into Demate_account values("3","1236");
insert into Demate_account values("4","1237");
insert into Demate_account values("5","1238");

create table Demate_account_balance_detail(account_no varchar(20) references Demate_account(demate_acc_no),
				fund float check(fund > 0),
				primary key(account_no));

insert into Demate_account_balance_detail values("1234",100000);
insert into Demate_account_balance_detail values("1235",32873739);
insert into Demate_account_balance_detail values("1236",100);
insert into Demate_account_balance_detail values("1237",13456998);
insert into Demate_account_balance_detail values("1238",37263863);


create table Stock_detail(ticker_name varchar(15),
		price float check(price > 0),
		primary key(ticker_name));		#derived LTP

insert into Stock_detail values("TCS",2000);
insert into Stock_detail values("INFY",700);
insert into Stock_detail values("RIL",1340);
insert into Stock_detail values("ZEE",416);
 

create table Orders(order_id varchar(20),
		client_id varchar(20) references Client(client_id),
		order_type tinyint not null,       			#market -0 /limit-1  
		position_type tinyint not null,   			#type:MIS-0/delivery-1 
		ticker_name  varchar(10) references Stock_detail(ticker_name), 
		ticker_size bigint check(ticker_size <> 0),    	#can be negative if MIS
		price float default null, 
		status varchar(20),			        #derived and pending intially,
		primary key(order_id));


insert into Orders values("3","1",0,0,"TCS",5,null,"Pending");
insert into Orders values("2","3",0,1,"INFY",5,null,"Pending");
insert into Orders values("4","5",1,1,"RIL",10,1300,"Pending");

update Stock_detail set price = 1300 where ticker_name = "RIL";

insert into Orders values("4","1",1,1,"TCS",34,null,"Pending");
insert into Orders values("5","5",0,1,"INFY",34,null,"Pending");
insert into Orders values("7","1",1,0,"TCS",2,2000,"Pending");
insert into Orders values("8","1",0,0,"TCS",20,null,"Pending");
insert into Orders values("10","4",0,0,"INFY",20,null,"Pending");
insert into Orders values("9","1",0,0,"TCS",50,null,"Pending");
insert into Orders values("11","1",0,0,"TCS",10,null,"Pending");
insert into Orders values("12","3",0,1,"INFY",20,null,"Pending");
insert into Orders values("13","4",1,1,"INFY",25,710,"Pending");






create table P_L(client_id varchar(20) references Client(client_id),
		order_id varchar(20) references Orders(order_id), 
		Total_PL bigint,
		primary key(order_id));



#event for change stock-price
set global event_scheduler = on;

create event stock_price_change
on schedule every 2 minute
starts '2019-04-19 12:26:00'
ends '2019-04-19 14:00:00' 
do
update Stock_detail set price = price + ( rand()*(-10) +5);

#event for clearing limit_order on every 6 minute

create event limit_order_clear
on schedule every 1 minute
starts '2019-04-19 12:26:00'
ends '2019-04-19 14:00:00' 
do
call clearing_limit_order();

#event for clearing  market_order on every 2 minute

create event market_order_clear
on schedule every 1 minute
starts '2019-04-19 12:26:00'
ends '2019-04-19 14:00:00' 
do
call clearing_market_order();


#price for market order
delimiter $
create trigger Validition_order before insert on Orders 
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

set flag = is_valid(new.order_id,new.client_id,new.price*new.ticker_size);

if flag = 0 then

	set new.status = "Failed";

end if;
-

end$ 


#procedure for clearing limit order

delimiter $	
create procedure clearing_limit_order()
begin
declare name varchar(10);
declare price,actual_price float;
declare orderId ,clientId varchar(20);
declare end_of_table tinyint;
declare cur_order cursor for select order_id from Orders where Orders.order_type = 1 and Orders.status = "Pending";
declare continue handler for not found set end_of_table = 1;

set end_of_table = 0;
open cur_order;

fetch cur_order into orderId;
select Orders.price,Orders.ticker_name,Orders.client_id into price,name,clientId from Orders where order_id = orderId;

while end_of_table = 0 do

	if(price = (select Stock_detail.price from Stock_detail where Stock_detail.ticker_name = name)) then

		update Orders set Orders.status = "Executed" where Orders.order_id = orderId; 
		call add_position_holdings(clientId,orderId,price);

	end if;

	
	fetch cur_order into orderId;
select Orders.price,Orders.ticker_name,Orders.client_id into price,name,clientId from Orders where order_id = orderId;

#	select Stock_detail.price into actual_price from Stock_detail where Stock_detail.ticker_name = name;


end while;
close cur_order;
end$

create procedure clearing_market_order()
	begin

declare price float;
declare name varchar(10);
declare orderId ,clientId varchar(20);
declare end_of_table tinyint;
declare cur_order cursor for select order_id from Orders where Orders.order_type = 0 and Orders.status = "Pending";
declare continue handler for not found set end_of_table = 1;

set end_of_table = 0;
open cur_order;

fetch cur_order into orderId;
select Orders.ticker_name,Orders.client_id,Orders.price into name,clientId,price from Orders where order_id = orderId;

while end_of_table = 0 do

	
		update Orders set Orders.status = "Executed" where Orders.order_id = orderId; 
		call add_position_holdings(clientId,orderId,price);

	
	
	fetch cur_order into orderId;
select Orders.ticker_name,Orders.client_id,Orders.price into name,clientId,price from Orders where order_id = orderId;

#	select Stock_detail.price into actual_price from Stock_detail where Stock_detail.ticker_name = name;


end while;
close cur_order;
end$



delimiter $
create procedure add_position_holdings(in clientId varchar(20),in orderId varchar(20),in price float)

begin
declare new_ticker_name varchar(10);
declare p_type tinyint;
declare new_ticker_size bigint;

select Orders.ticker_name into new_ticker_name from Orders where Orders.order_id = orderId;
select Orders.ticker_size into new_ticker_size from Orders where Orders.order_id = orderId;
select Orders.position_type into p_type from Orders where Orders.order_id = orderId;


if p_type = 1 then   # insert/update Holdings

	insert into Holdings values(clientId,new_ticker_name,new_ticker_size,price);

else

	insert into Positions values(clientId,new_ticker_name,new_ticker_size,price);

end if;

end$

create function is_valid(orderId varchar(20), clientId varchar(20),total_money float) returns tinyint
	   deterministic
	begin

	declare  acc_no varchar(20);
	declare  acc_value float;

	select Demate_account.demate_acc_no into acc_no from Demate_account where Demate_account.client_id = clientId;

	select Demate_account_balance_detail.fund into acc_value from Demate_account_balance_detail 
	where Demate_account_balance_detail.account_no = acc_no;

	if(acc_value <= total_money) then
		return 0;

	else

		update Demate_account_balance_detail set Demate_account_balance_detail.fund = (acc_value - total_money) 
		where Demate_account_balance_detail.account_no = acc_no;
		return 1; 
	end if;

	end$

  create trigger new_demate_account after insert on Client
  	for each row

  	begin

  	insert into Demate_account values(new.client_id,new.client_id+100);
  	insert into Demate_account_balance_detail values(new.client_id+100, 100000);

  	end$