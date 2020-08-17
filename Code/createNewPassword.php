<!DOCTYPE html>
<html>
<head>
	<title>Brokerage Mgmt</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />  
           <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>  
           <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script> 
</head>
<body>

    <div class="row">
    <div class="col-md-9 col-md-offset-2">

    <?php

        session_start();
        $u_email =  $_SESSION['user_email'];
        #echo $u_email;
        $conn = new mysqli("localhost", "root", "", "test");
        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }else{//echo "Connected successfully";  
            } 
   
        $existing_result = $conn->query("select client_id from Email where email = '$u_email'");
        $row = $existing_result->fetch_assoc();
        $id = $row['client_id'];

        if(isset($_POST['submit']))
        {
            if($_POST['newpass'] === '' || $_POST['rnewpass'] === '' || $_POST['newpass'] !== $_POST['rnewpass'])
            {
                echo $_POST['newpass'];
                echo $_POST['rnewpass'];
                echo "Enter both the fields properly. !!" ;
            }
            else
            {
                $newPassword = $_POST['newpass'];
                $sql1 = "update Login_credential SET Password='$newPassword' where client_id='$id'";
                if ($conn->query($sql1) === TRUE) {
                    echo "Password Changed Successfully !!";//echo "added!";
                    echo "<script type=\"text/javascript\"> alert('Password Changed Successfully !!');
                                   window.location = 'welcome.php'</script>";
                }
                
            }
        }
        
    ?>
    </div>

    <p style="font-size: 50px;font-family: Arial;margin: 20px">Brokerage</p>
	<div class="container login-container">
        <div class="col-md-6 login-form">
            <h3>Create New Password</h3>
            <form method="post">
                <div class="form-group">
                    <input type="password" id="newpass" name="newpass" class="form-control password" placeholder="Enter New Password" value="" />
                </div>
                <div class="form-group">
                    <input type="password" id="rnewpass" name="rnewpass" class="form-control password" placeholder="Re-Enter New Password" value="" />
                </div>   
                 <div class="form-group">
                    <button class="btn btn-primary" type="submit" name="submit" style="float: right">Submit</button>
                </div>             
            </form>
        </div>
    </div>
</body>
</html>
