<!DOCTYPE html>
<html>
	<head>
		<title>Registration</title>	
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />  
           <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>  
           <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script> 
	</head>
	<body>
		<p style="font-size: 50px;font-family: Arial;margin: 20px">Brokerage</p>
		<div class="container login-container">
			<form class="form-horizontal" action="reg.php" method="POST">
				<div class="form-group">
					<div class="col-sm-10" style="width:50%">
					<label>Username:</label>
						<input type="text" name="regusername" placeholder="Choose Username *" class="form-control username" />  
		            <label>Password:</label>
						<input type="password" name="regpassword" placeholder="Choose Password *" class="form-control password" />  
		            </div>
		        </div><br>
		        <label style="font-size:20px">Personal Information: </label><br>
		        <div class="form-group">
					<div class="col-sm-10" style="width:50%">
						<label>First Name:</label>
						<input type="text" name="fname" placeholder="First Name *" class="form-control fname" />  
		            	<label>Middle Name:</label>
						<input type="text" name="mname" placeholder="Middle Name" class="form-control mname" />  
		            	<label>Last Name:</label>
						<input type="text" name="lname" placeholder="Last Name *" class="form-control lname" /> 
						<label>Gender:</label>
						<div class="radio">
							<label><input type="radio" name="gender" checked>Male</label>
						</div>
						<div class="radio">
							<label><input type="radio" name="gender" checked>Female</label>
						</div>
						<div class="radio">
							<label><input type="radio" name="gender" checked>Other</label>
						</div><br>
						<label>Phone No.:</label>
						<input type="text" name="phone" placeholder="Phone Number *" class="form-control phone" /> 
						<label>Phone No. 2:</label>
						<input type="text" name="phone2" placeholder="Phone Number 2" class="form-control phone2" /> 
						<label>Email Address:</label>
						<input type="text" name="email" placeholder="Email Address *" class="form-control email" />
						<label>Pan Number:</label>
						<input type="text" name="pan" placeholder="Pan number *" class="form-control pan" /> 
						<label>City:</label>
						<input type="text" name="city" placeholder="City *" class="form-control city" /> 
						
					</div>
		        </div>
		        <label style="font-size:20px">Bank Information: </label><br>
		        <div class="form-group">
					<div class="col-sm-10" style="width:50%">
		            	<table class="table table-bordered" id="dynamic_field">  
							<tr>
								<label>Bank Name:</label>
								<input type="text" name="bank_name" placeholder="Enter your Bank Name *" class="form-control name_list" />
							</tr> 
							<tr>
								<label>Bank Account Number:</label>
								<input type="text" name="bank_acc_no" placeholder="Enter your Bank Account Number *" class="form-control name_list" />
							</tr>  
			                <!--    <tr><button type="button" name="add" id="add" class="btn btn-success">Add More</button>  
		                    </tr> --> 
		                </table>
						
			            
		            </div>
		                
		        </div>
		         <div class="form-group">
					<div class="col-sm-10" style="width:20%">
						<input class="btn btn-primary" type="submit" value="Submit">
					</div>
				</div>
			</form>
		</div>
	</body>
</html>
<script>  
 $(document).ready(futhentication and authorization on the Internet. OAuth, which is pronounced "oh-aunction(){  
      var i=1;  
      //problem here
      $('#add').click(function(){  
           i++;  
           $('#dynamic_field').append('<tr id="row'+i+'"><input type="text" name="bank_name[]" placeholder="Enter your Name" class="form-control name_list" /></tr><tr id="row'+i+'"><input type="text" name="bank_acc_no[]" placeholder="Enter your Name" class="form-control name_list" /><td><button type="button" name="remove" id="'+i+'" class="btn btn-danger btn_remove">X</button></td></tr>');  
      });  
      $(document).on('click', '.btn_remove', function(){  
           var button_id = $(this).attr("id");   
           $('#row'+button_id+'').remove();$('#row'+button_id+'').remove(); 
      });  
      $('#submit').click(function(){            
           $.ajax({  
                url:"name.php",  
                method:"POST",  
                data:$('#add_name').serialize(),  
                success:function(data)  
                {  
                     alert(data);  
                     $('#add_name')[0].reset();  
                }  
           });  
      });  
 });  
 </script>

<!--
sign up


client
	client_id
	pan no
	city
kyc detail
	pan no
	fname
	mname
	lname
	gender
Mobile no
email id

Bank acc
	client_id
	bank_acc_no
	balance
	bank name
	primary/ not primary
-->