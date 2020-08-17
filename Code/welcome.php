<!DOCTYPE html>
<html>
<head>
	<title>Brokerage Mgmt</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />  
           <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>  
           <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script> 
</head>
<body>

    <p style="font-size: 50px;font-family: Arial;margin: 20px">Brokerage</p>
	<div class="container login-container">
            	<form  action="oauth.php" method="post">
            		
                <div class="col-md-6 login-form">
                    <h3>Login</h3>
                    
                        <div class="form-group">
                            <input type="text" id="username" name="username" class="form-control username" placeholder="Your Username" value="" />
                        </div>
                        <div class="form-group">
                            <input type="password"id="password" name="password" class="form-control password" placeholder="Your Password" value="" />
                        </div>
                        <div class="form-group">
                        	<input class="btn btn-primary" type="submit" name="submit" value="Login">
                             <a href="http://localhost/forgetPassword.php" style="float: right;">Forgot Password</a> 
                        </div>
                        <div class="form-group">
                        	<input class="btn btn-primary" type="button" onclick="location.href='register.php';" value="Register" />
                        </div>
                        <!-- <div class="form-group"> -->
                            <!-- <input class="btn btn-primary" type="button" onclick="location.href='forgetPassword.php';"      value="Forget Password" />  -->
  
                </div>
            	</form>
                
            
        </div>


</body>
</html>