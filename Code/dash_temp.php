<!DOCTYPE html>
<html>
<head>
<title>Dashboard</title>
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<style type="text/css">
	.wrapper{
		margin: 20px;
	}
</style>
</head>
<body>
<p style="font-size: 50px;font-family: Arial;margin: 20px"> Brokerage</p>
<div class="wrapper">
    <ul class="nav nav-tabs">
        <li class="active"><a data-toggle="tab" href="#order-wrapper">Orders</a></li>
        <li class="dropdown">
        	<a class="dropdown-toggle" data-toggle="dropdown" href="#">Portfolio
		    <span class="caret"></span></a>
		    <ul class="dropdown-menu">
		      <li><a href="#position-dropdown" data-toggle="tab">Positions</a></li>
		      <li><a href="#holding-dropdown" data-toggle="tab">Holdings</a></li>
		    </ul>

        </li>
		<li><a data-toggle="tab" href="#neworder">New Order</a></li>
		<li><a data-toggle="tab" href="#watchlist">WatchList</a></li>

    </ul>

    <div class="tab-content">
        <div id="order-wrapper" class="tab-pane fade in active">	
					
			<?php 
				$nuser='root';
				$dbnames='test';
				$pdswd='';
           		$conn = new mysqli("localhost", $nuser,$pdswd,$dbnames);
            	$result = $conn->query("select usr from curusr ORDER BY id DESC LIMIT 1");
				while($row = $result->fetch_assoc()){
					$username=$row['usr'];{
				}
				//find client id
				$cidsql="select client_id from Login_credential where user_name='".$username."'";
				//echo $cidsql;
				$result=$conn->query($cidsql);
				
				while($row = $result->fetch_assoc()){
					$client_id=$row['client_id'];{
				}
				$sql="select * from Orders where client_id='".$client_id."'";
				$result=$conn->query($sql);
				
				if ($result->num_rows > 0) {
				    // output data of each row
				    while($row = $result->fetch_assoc()) {
				    		if ($row['position_type']) {
								$postype="Delivery";
							}else{
								$postype="MIS";
							}
							
							if ($row['order_type']==0) {
								$ordtype="Market Order";
							}else{
								$ordtype="Limit Order";
							}
				        echo "
							<div style=\"border: 2px solid black;
								margin: 9px;
								width:24%;
								height: 24%;
								padding:5px;
								overflow: hidden;
								float: left;\" id=\"order\" style=\"margin: 20px\">
								<label for=\"order-no\" style=\"font-size: 20px\">Order No. ".$row['order_id']."</label> <br>
				            	<label for=\"order-stock\">Stock Name: </label>".$row['ticker_name']."<br>
				            	<label for=\"order-stocksize\">Size: </label>".$row['ticker_size']."<br>
								<label for=\"order-stockprice\">Price: </label>".$row['price']."<br>
								<label for=\"order-positiontype\">Position Type: </label>".$postype."<br>
								<label for=\"order-ordertype\">Order Type: </label>".$ordtype."<br>
								<label for=\"status\">Status: </label>".$row['status']."<br>
							</div>
						";
				    }
				} else {
				    echo "<div id=\"order\" style=\"margin: 20px\">No Orders yet...</div>";
				}
				$conn->close();

				
			/*
				if(mysqli_num_rows($result)>0){
					//$rows=resultToarray($result);
						//var_dump($rows);
						while($row = $result->fetch_assoc()) {
							if ($row['position_type']) {
								$postype="Delivery";
							}else{
								$postype="MIS";
							}
							if ($row['order_type']) {
								$ordtype="Market Order";
							}else{
								$ordtype="Limit Order";
							}
						echo "
							<div id=\"order\" style=\"margin: 20px\">
								<label for=\"order-no\" style=\"font-size: 20px\">Order No. 0</label> <br>
				            	<label for=\"order-stock\">Stock Name: </label>TCS<br>
				            	<label for=\"order-stocksize\">Size: </label>5<br>
								<label for=\"order-stockprice\">Price: </label>1999.09<br>
								<label for=\"order-positiontype\">Position Type: </label>MIS<br>
								<label for=\"order-ordertype\">Order Type: </label>Market Order<br>
								<label for=\"status\">Status: </label>Pending<br>
							</div>
						";		
						}
					}*/
				
				
}}
            ?>
            

        </div>
        <div id="position-dropdown" class="tab-pane fade">
            	<div style="margin: 20px">
            		<?php
            			$conn = new mysqli("localhost", "root", "", "test");
		            	$result = $conn->query("select usr from curusr ORDER BY id DESC LIMIT 1");
						while($row = $result->fetch_assoc()){
							$username=$row['usr'];{
						}
						//find client id
						$cidsql="select client_id from Login_credential where user_name='".$username."'";
						//echo $cidsql;
						$result=$conn->query($cidsql);
						
						while($row = $result->fetch_assoc()){
							$client_id=$row['client_id'];{
						}
						$sql="select ticker_name,ticker_size,price from Positions where client_id='".$client_id."'";
						$result=$conn->query($sql);
						
						if ($result->num_rows > 0) {
						    // output data of each row
						     while($row = $result->fetch_assoc()) {
						    /*
				    		if ($row['position_type']) {
								$postype="Delivery";
							}else{
								$postype="MIS";
							}
							if ($row['order_type']) {
								$ordtype="Market Order";
							}else{
								$ordtype="Limit Order";
							}
							*/
				        echo "
							<div style=\"border: 2px solid black;
								margin: 9px;
								width:24%;
								height: 24%;
								padding:5px;
								overflow: hidden;
								float: left;\" id=\"order\" style=\"margin: 20px\">
								
				            	<label for=\"order-stock\">Stock Name: </label>".$row['ticker_name']."<br>
				            	<label for=\"order-stocksize\">Size: </label>".$row['ticker_size']."<br>
								<label for=\"order-stockprice\">Price: </label>".$row['price']."<br>
							</div>
						";
				    }
				} else {
				    echo "<div id=\"order\" style=\"margin: 20px\">No Orders yet...</div>";
				}
								$conn->close();

		            	}
		            }
            		?>
            	</div>
        </div>
        <div id="holding-dropdown" class="tab-pane fade">
            	<div style="margin: 20px">
            		<?php
            			$conn = new mysqli("localhost", 'root', '', 'test');
		            	$result = $conn->query("select usr from curusr ORDER BY id DESC LIMIT 1");
						while($row = $result->fetch_assoc()){
							$username=$row['usr'];{
						}
						//find client id
						$cidsql="select client_id from Login_credential where user_name='".$username."'";
						//echo $cidsql;
						$result=$conn->query($cidsql);
						
						while($row = $result->fetch_assoc()){
							$client_id=$row['client_id'];{
						}
						$sql="select ticker_name,ticker_size,price from holdings where client_id='".$client_id."'";
						$result=$conn->query($sql);
						
						if ($result->num_rows > 0) {
						    // output data of each row
						    while($row = $result->fetch_assoc())
							echo "
							<div style=\"border: 2px solid black;
								margin: 9px;
								width:24%;
								height: 24%;
								padding:5px;
								overflow: hidden;
								float: left;\" id=\"order\" style=\"margin: 20px\">
								
				            	<label for=\"order-stock\">Stock Name: </label>".$row['ticker_name']."<br>
				            	<label for=\"order-stocksize\">Size: </label>".$row['ticker_size']."<br>
								<label for=\"order-stockprice\">Price: </label>".$row['price']."<br>
							</div>
						";
				    }
				 else {
				    echo "<div id=\"order\" style=\"margin: 20px\">No Orders yet...</div>";
				}
								$conn->close();
		            	
		            }}
            		?>
            	</div>
        </div>


        <div id="neworder" class="tab-pane fade">
            <div class="container login-container">
				
		

	            <div class="form-group" style="margin: 20px;width: 20%">
					
				
								
					<form action="neworder.php" method="POST">
	
		            	<label for="stock">Select Stock to order:</label>
						<select class="form-control" id="sel1" name="stock">
							<option>RIL</option>
							<option>TCS</option>
							<option>INFY</option>
							<option>ZEE</option>
							<option>HDFC</option>
						</select>
						<label for="stocksize">Select Stock Size:</label>
						<input type="text" name="stocksize" placeholder="Enter Stock Size" class="form-control stocksize">
						<label for="stocksize">Select MIS or Delivery:</label>
						<div class="radio">
							<label><input type="radio" name="position-type" value=0>MIS</label>
							<label><input type="radio" name="position-type" value=1>Delivery</label>
						</div>
						<label for="stocksize">Select Market or Limit Order:</label>
						<div class="radio">
							<label><input type="radio" name="order-type" value=0 onclick="hideprice();">Market</label>
							<label><input type="radio" name="order-type" value=1 onclick="showprice();">Limit</label>
						</div>
						<div id="price" style="display: none">
							<label for="price">Enter Stock Price:</label>
							<input type="text" name="stockprice" placeholder="Enter Stock Price" class="form-control stockprice">
						</div>
						<div class="col-sm-10" style="width:20%">
							
							<br><input class="btn btn-primary" type="submit" value="Submit">
						</div>

						

					</form>
					
					
				</div>
            </div>

		</div>

		<div id="watchlist" class="tab-pane fade">
            <div class="container login-container">
				<div class="form-group" style="margin: 20px;width: 20%">

					<form method="post" action="test1.php">
						<p style="font-size:160%;"><b>Symbol: </b><input type="text" name="name" placeholder="Enter Symbol"  >
						<input type="submit" name="submit" value="Add Symbol">
					</form>
					</p>	

				</div>
			</div>
		</div>
					
		
		

    </div>

</div>
</body>
</html> 

<script type="text/javascript">
	function hideprice(){
	  document.getElementById('price').style.display ='none';
	}
	function showprice(){
	  document.getElementById('price').style.display = 'block';
	}
</script>                           