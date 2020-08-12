<?php 

	$username=$_POST['username'];
	$password=$_POST['password'];

	if($username===''||$password===''){

		echo "<script type=\"text/javascript\"> alert('Please enter Username and Password');
	    window.location = 'welcome.php'</script>";
	}

	// Create connection
	$conn = new mysqli("localhost", "root", "", "test");

	// Check connection
	if ($conn->connect_error) {
	    die("Connection failed: " . $conn->connect_error);
	} 
	//echo "Connected successfully";
	session_start();
	$sql="select password from Login_credential where user_name='$username'";
	//echo $sql;
	$result=$conn->query($sql);
	if ($result->num_rows > 0) 
	{
		while($row = $result->fetch_assoc()) {
			//echo $row['password'];
			if($row["password"]===$password)
			{							
				#echo $_SESSION['login_user'];
				//echo "logged in successfully";
				$sql1="insert into curusr (usr) values('" . $username. "')";
				
				if ($conn->query($sql1) === TRUE) {
				    //echo "added!";
				}
				$conn->close();
				$_SESSION['login_user']= $username;
				#echo "Welcome !!!";
				#echo $_SESSION['login_user'];
				header("Location: dash.php", true, 301);
				exit();
			}
			else{
				echo "alert('Invalid Username or Password');
					    window.location = 'welcome.php'";
			}
		}
	}
	else{
		echo "<script type=\"text/javascript\"> alert('Invalid Username or Password');
	    window.location = 'welcome.php'</script>";
	}
	/*
		echo $err; */

	
?>