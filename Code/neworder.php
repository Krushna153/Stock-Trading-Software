<?php 

	// Create connection
	$conn = new mysqli("localhost", "root", "", "test");
	// Check connection
	if ($conn->connect_error) {
	    die("Connection failed: " . $conn->connect_error);
	}
	else{
			//echo "Connected successfully";
		} 
	//-----
	//find last id entered
	$lastsql="select client_id FROM Client ORDER BY client_id DESC LIMIT 1";
	$lastid=0;
	$result=$conn->query($lastsql);
	if(mysqli_num_rows($result)>0){
		while($row = $result->fetch_assoc()){
			$lastid=$row['client_id'];
		}
		$lastid=$lastid+1;
	}
	else{
		$lastid=0;
	}
	//
	//find last orderid
	$lastordsql="select order_id FROM Orders ORDER BY order_id DESC LIMIT 1";
	$lastordid=0;
	$result=$conn->query($lastordsql);
	if(mysqli_num_rows($result)>0){
		while($row = $result->fetch_assoc()){
			$lastordid=$row['order_id'];
		}
		$lastordid=$lastordid+1;
	}
	else{
		$lastordid=0;
	}
	//echo $lastordid;
	//--
	//echo $lastid+1;
	//-----
	$stockprice='NULL';

	$client_id="";
	$tickername=$_POST['stock'];
	$stocksize=$_POST['stocksize'];
	$ordertype=$_POST['order-type'];
	$positiontype=$_POST['position-type'];
	$stockprice=$_POST['stockprice'];
	if($tickername===''||$stocksize===''||$ordertype===''||$positiontype==''){
		echo "<script type=\"text/javascript\"> alert('Please fill all details');
		window.location = 'dash.php</script>";
	}
	if ($ordertype===0) {
		$stockprice=$_POST['stockprice'];
		
	}else{

	$stockprice='NULL';

	}
	//echo $stockprice;


	$result=$conn->query("select usr from curusr ORDER BY id DESC LIMIT 1");
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

	$sql="insert into Orders (order_id,client_id,order_type,position_type,ticker_name,ticker_size,price,status) values('".$lastordid."','".$client_id."',$ordertype,$positiontype,'".$tickername."',$stocksize,$stockprice,\"Pending\")";
	//echo $sql;
	//	echo "string";
	if ($conn->query($sql) === TRUE) {
	    echo "added!";
	} else {
	    //echo "Error: " . $sql1 . "<br>" . $conn->error;
	}
	$sql2="select Orders.status from Orders where order_id= '".$lastordid."'";
	$result=$conn->query($sql2);
	$state="";
	if(mysqli_num_rows($result)>0){
		while($row = $result->fetch_assoc()){
			$state=$row['status'];
		}
	}
	if($state==="Failed"){
		$msg="Buy Order failed due to insufficient funds!";
	}else{
		$msg="Buy Order placed successfully!";
	}
		echo "<script type='text/javascript'>alert('$msg');window.location = 'dash.php'</script>";
		$conn->close();
		
}}	?>