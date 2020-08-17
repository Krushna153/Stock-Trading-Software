<?php
    //include('db.php');

    // Create connection
    $conn = new mysqli("localhost", "root", "", "test");

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    } 

    session_start();
    $user_check=$_SESSION['login_user'];

    $ses_sql=("select * FROM login_credential where user_name='$user_check'");   //login_credential
    $result=$conn->query($ses_sql);
    //$row=mysqli_fetch_array($ses_sql,MYSQLI_ASSOC);

    
        $row = $result->fetch_assoc();
        $client_id = $row['client_id'];

        $ses_sql1=("select * FROM bank_account_detail where client_id='$client_id'"); //bank_account_detail
        $result1=$conn->query($ses_sql1);
        $row1 = $result1->fetch_assoc();
        $bank_acc_no = $row1['bank_acc_no'];
        $balance = $row1['balance'];
        $bank_name = $row1['bank_name'];

        $ses_sql2=("select * FROM mobile_number where client_id='$client_id'"); //mobile_number
        $result2=$conn->query($ses_sql2);
        $row2 = $result2->fetch_assoc();
        $mobile_number = $row2['mobile_number'];

        $ses_sql3=("select * FROM client where client_id='$client_id'");    //client
        $result3=$conn->query($ses_sql3);
        $row3 = $result3->fetch_assoc();
        $pan_number = $row3['pan_number'];
        $city = $row3['city'];

        $ses_sql4=("select * FROM email where client_id='$client_id'");     //email
        $result4=$conn->query($ses_sql4);
        $row4 = $result4->fetch_assoc();
        $email = $row4['email'];
        
        $ses_sql5=("select * FROM kyc_detail where pan_number='$pan_number'");   //kyc detail
        $result5=$conn->query($ses_sql5);
        $row5 = $result5->fetch_assoc();
        $f_name = $row5['f_name'];
        $m_name = $row5['m_name'];
        $l_name = $row5['l_name'];
        $gender = $row5['gender'];

        $ses_sql6=("select * FROM demate_account where client_id='$client_id'");  //demat_account
        $result6 = $conn->query($ses_sql6);
        $row6 = $result6->fetch_assoc();
        $demate_acc_no = $row6['demate_acc_no'];

        $ses_sql7=("select * FROM demate_account_balance_detail where account_no='$demate_acc_no'"); //demat_account_balance_detail
        $result7 = $conn->query($ses_sql7);
        $row7 = $result7->fetch_assoc();
        $fund = $row7['fund'];

    
    
    //$conn->close();

    if(isset($_POST['close']))
    {
        //$conn->close();
        header("Location: dash.php", true, 301);
        //header("Location:dash.php");
    }
    if(isset($_POST['logout']))
    {
        //$conn->close();
        header("Location: welcome.php", true, 301);
        //header("Location:dash.php");
    }
?>

<!DOCTYPE html>
<html>
    <head>
        <title>User Profile</title>
        <meta charset="utf-8" />
        <link rel="stylesheet" type="text/css" href="css/form.css" />   
        <style>
         th, td {
            border: 1px solid black;
         }
      </style>
    </head>
    <body>
    <form method = "POST">
        <div id="profile">

        <!--<center><img src="index.jpeg" alt="Image" height="62" width="62"></center>-->
        <center><h3>Welcome User </h3></center>
        <table style="width:350px; border: 3px solid black" align = "center" cellpadding="4" cellspacing="5">
        <th>Your Details</th>
            <tr id="lg-2">
                <td class="tl-1"> <div align="left" id="tb-name">First Name:</div> </td>
                <td class="tl-12"><?php echo $f_name; ?></td>
            </tr>
                <tr id="lg-1">
                <td class="tl-1"><div align="left" id="tb-name">Middle Name:</div></td>
                <td class="tl-12"><?php echo $m_name; ?></td>
            </tr>
                <tr id="lg-1">
                <td class="tl-1"><div align="left" id="tb-name">Last Name:</div></td>
                <td class="tl-12"><?php echo $l_name; ?></td>
            </tr>
                <tr id="lg-1">
                <td class="tl-1"><div align="left" id="tb-name">Email id:</div></td>
                <td class="tl-12"><?php echo $email; ?></td>
            </tr>
                <tr id="lg-1">
                <td class="tl-1"><div align="left" id="tb-name">Mobile number:</div></td>
                <td class="tl-12"><?php echo $mobile_number; ?></td>
            </tr>
                <tr id="lg-1">
                <td class="tl-1"><div align="left" id="tb-name">City:</div></td>
                <td class="tl-12"><?php echo $city; ?></td>
            </tr>
                <tr id="lg-1">
                <td class="tl-1"> <div align="left" id="tb-name">Client ID:</div> </td>
                <td class="tl-12"><?php echo $client_id; ?></td>
            </tr>
                <tr id="lg-1">
                <td class="tl-1"><div align="left" id="tb-name">Demate Account Number:</div></td>
                <td class="tl-12"><?php echo $demate_acc_no; ?></td>
            </tr>
                <tr id="lg-1">
                <td class="tl-1"><div align="left" id="tb-name">Pan Number:</div></td>
                <td class="tl-12"><?php echo $pan_number; ?></td>
            </tr>
                <tr id="lg-1">
                <td class="tl-1"><div align="left" id="tb-name">Funds:</div></td>
                <td class="tl-12"><?php echo $fund; ?></td>
            </tr>


           

        <th>Bank Details</th>
            
                <tr id="lg-1">
                <td class="tl-1"><div align="left" id="tb-name">Bank Account Number:</div></td>
                <td class="tl-12"><?php echo $bank_acc_no; ?></td>
            </tr>
                
                <tr id="lg-1">
                <td class="tl-1"><div align="left" id="tb-name">Bank Name:</div></td>
                <td class="tl-12"><?php echo $bank_name; ?></td>
            </tr>
                
        </table> <br>
        
        
        <div class="form-group" style="text-align: center">
            <button class="btn btn-primary" type="submit" name="close">close</button>
        </div> <br>
        <div class="form-group" style="text-align: center">
            <button class="btn btn-primary" type="submit" name="logout">Logout</button>
        </div>
        
        </div>

        
        </form>
    </body>
    
</html>

