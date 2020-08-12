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

        $conn = new mysqli("localhost", "root", "", "test");
        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }else{//echo "Connected successfully";  
            } 

        session_start();
        use PHPMailer\PHPMailer\PHPMailerAutoload;

        if ( isset($_POST['send']) )
        {
            $mailto = $_POST['email'];
            $mailSub = "OTP To Create New Password";

            if($mailto==='')
            {
              echo "Please Enter Your Mail Id First !!";
          //echo "reached!";
            }
            else
            {
                $existing_result=$conn->query("select client_id from Email where email = '$mailto'");
                #echo "string";
                $row = $existing_result->fetch_assoc();
                if($row === null)
                {
                    echo "<script type=\"text/javascript\"> alert('Invalid Email Id');
                           window.location = 'forgetPassword.php'</script>";
                }
                else
                {
                    $id = $row['client_id'];
                    $mail = $_SESSION['user_email']= $mailto;
                    #echo $mail;
                    $existing_result = $conn->query("select user_name from Login_credential where client_id = '$id'");
                    $row = $existing_result->fetch_assoc();
                    $u_name = $row['user_name'];
                    #echo "\r\n";
                    $otp = (rand(1000,9999));

                    $msg = "Hello '$u_name. \r\n Your OTP is '$otp'.";
                    
                    #echo $msg;


                    require 'phpmailer/PHPMailerAutoload.php';
                     $mail = new PHPMailer;

                     $mail ->IsSmtp();
                     $mail ->Host = "smtp.gmail.com";
                     $mail ->SMTPAuth = true;
                     $mail ->Username = "kanjariamihir24@gmail.com"; 
                     $mail ->Password = "yoyomihir";
                     $mail ->Port = 587; // or 587
                     $mail ->SMTPSecure = 'tls'; //tls
                    
                     #$mail ->SMTPDebug = 0;
                     $mail ->isHTML(true);
                     $mail ->SetFrom("kanjariamihir24@gmail.com");
                     $mail ->Subject = $mailSub;
                     $mail ->Body = $msg;
                     $mail ->addAddress($mailto);

                     

                     if($mail->Send())
                     {
                          setcookie('otp', $otp);
                          echo "OTP successfully send..";
                     }
                     else
                     {
                         echo "Mail could not be sent !!"; 
                     }   
                }
                    
            }
        }
        if(isset($_POST['verifyotp'])) 
        { 
            $otp = $_POST['otp'];
            if($otp==='')
            {
              echo "Enter OTP First";
              $mailto = $_POST['email'];
          //echo "reached!";
            }
            else
            {
                #$_GET['email'] = $mailto;
                if($_COOKIE['otp'] == $otp) 
                {
                    echo "Congratulation, Your OTP is verified.";
                    echo "<script type=\"text/javascript\"> alert('OTP is Verified!!!');
                                   window.location = 'createNewPassword.php'</script>";
                }
                else
                {
                    echo "Please enter correct otp.";
                    $mailto = $_POST['email'];
                    
                }
            }
        }
        
    ?>
    </div>
    <p style="font-size: 50px;font-family: Arial;margin: 20px">Brokerage</p>
	<div class="container login-container">
        <div class="col-md-6 login-form">
            <h3>Forgot Password</h3>
            <form method="post"><!-- action="send_mail.php"> -->
                <div class="form-group">
                    <input type="text" id="email" name="email" class="form-control username" placeholder="Your Email id" value="<?php echo (isset($mailto))?$mailto:'';?>"/>
                </div>
                <div class="form-group">
                    <input type="text" id="otp" name="otp" class="form-control username" placeholder="Enter OTP" value=""/>
                </div>
                <div class="form-group">
                	<button class="btn btn-primary" type="submit" name="send">Send Email</button>
                    <button class="btn btn-primary" type="submit" name="verifyotp" style="float: right">verify</button>
                </div>                           
            </form>
        </div>
    </div>
</body>
</html>
