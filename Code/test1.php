<?php
  
  $servername = "localhost";
  $username = "root";
  $password = "";
  $dbname = "test";
?>
<?php
  # Create connection.
  $conn = mysqli_connect($servername, $username, $password);
  # Check connection.
  if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
  }
  # Create database.
  $sql = "use test";
  if (mysqli_query($conn, $sql)) {
    #echo "Database selected successfully";
  } else {
    # echo "Error creating database: " . mysqli_error($conn);
  }
  # Close our connection
  mysqli_close($conn);
?>
<?php
  # Create usr_stock_detail table if not already created.
  # Create connection.
  $conn = new mysqli($servername, $username, $password, $dbname);
  # Check connection.
  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }

  # sql to create table with 1 column
  $sql = "CREATE TABLE IF NOT EXISTS `usr_stock_detail` (
    `ticker_name` VARCHAR(18) NOT NULL,
    PRIMARY KEY (`ticker_name`)
  )";

  # Check that we actually created table.
  if ($conn->query($sql) === TRUE) {
    #echo "Table usr_stock_detail created successfully";
  } else {
    #echo "Error creating table: " . $conn->error;
  }
  #safely close our connection.
  $conn->close();
?>
<?php
 // Create connection
  $conn = new mysqli($servername, $username, $password, $dbname);
 // Check connection
  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }

  $nameErr = ""; # Hold our error code.
  $name = ""; # Hold our ticker_name.

 # wait until button is press then process data into database.
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    # Check that textfield is not empty.
    if (empty($_POST["name"])) {
      $nameErr = "ticker_name is required";
    } else {
      # grab our ticker_name from HTML page.
      $name = test_input($_POST["name"]);
      # Convert ticker_name to uppercase to check sql db.
      $name = strtoupper($name);
      # Query our stock_detail DB to make sure that ticker_name is available.
      $sql = "SELECT 1 FROM stock_detail WHERE ticker_name = '" . $name . "'";
      $result = $conn->query($sql);
      # if ticker_name available Query usr_stock_detail to make sure its not already there.
      if ($result->num_rows > 0) {
        # echo "Found";
        $sql = "SELECT 1 FROM usr_stock_detail WHERE ticker_name = '" . $name . "'";
        $result = $conn->query($sql);
        # If already in watchlist alert the user that its already there.
        if ($result->num_rows > 0) {
          echo "<script language='javascript'>alert('This ticker_name has already been added to the watchlist.');</script>";;
        } else {
          # if not in the watchlist add to database table.
         // echo $name;
          $sql = "INSERT INTO usr_stock_detail(ticker_name) VALUES(" . "'" . $name . "'" . " )";
          $result = $conn->query($sql);
        }
      } else{
        # if not in stock_detail table alert the user that the ticker_name does not exist.
       echo "<script language='javascript'>alert('Error: The given ticker_name does not exist.');</script>";
      }
      # Safely close our connection.
      $conn->close();
      # make sure only letters used.
      if (!preg_match("/^[a-zA-Z ]*$/",$name)) {
        $nameErr = "Only letters and white space allowed";
      }
    }
  }

# Test correct input
  function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
  }

?>
<?php
 # Stay alert to see if user wants to delete item from watchlist.
  $conn = new mysqli($servername, $username, $password, $dbname);
  # Check connection.
  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }
  # If we passed a ticker_name to be deleted perform removal query.
  if(isset($_GET['del'])){
    $ticker_name = $_GET['del'];
    $removeQuery = "DELETE FROM usr_stock_detail WHERE ticker_name = '{$ticker_name}'";
    $result = $conn->query($removeQuery);
    
    # make sure query got executed.
    if($result) {
      echo "Done";
      #echo "<a href='google.com'>Google</a>";
    } else{
      echo "fail";
    }
  }
  # safely close our connection.
  $conn->close();
?>

<html>
  <head>
    <!--  Import our javascript file-->
    <script type="text/javascript" src="mainJS.js"></script>
  </head>
    <style>
      table {
        border-collapse: collapse;
        width: 80%;
      }
      th, td {
        text-align: left;
        padding: 8px;
      }
      tr:nth-child(even){background-color: #f2f2f2}
      th {
        background-color: #000000;
        color: white;
      }

      input[type = text]{
        border-radius: 4px;
        height: 35px;
        font-size: 14px;
      }

      input[type = submit]{
        background: #000000; /* Green */
        border: none;
        color: white;
        padding: 15px 32px;
        text-align: center;
        text-decoration: none;
        display: inline-block;
        font-size: 16px;
        margin: 4px 2px;
        border-radius: 4px;
      }

      a{
        text-decoration:none;
      }
      a.underlined{
        text-decoration:underline;
      }
    </style>
    <body>
        <!-- Create our form and set to post to PHP for varification  -->
          
        


        <?php

            #echo $_POST["name"];
            $name = $_POST["name"];
            echo "<a href='dash.php' class='button' > Back</a>";
          # Populate our watchlist table with our elements from usr_stock_detail table
            $conn = new mysqli($servername, $username, $password, $dbname);
            # Check connection
            if ($conn->connect_error) {
              die("Connection failed: " . $conn->connect_error);
            }
            # Reduce redundancy by joining two tables using ticker_names as key
            $sql = "SELECT * FROM stock_detail JOIN usr_stock_detail ON stock_detail.ticker_name = usr_stock_detail.ticker_name";
            $result = $conn->query($sql);

            # Display table
            if ($result->num_rows > 0) {
              echo "<table id=\"myStocks\"><tr>";
              echo "
              <th onclick=\"sortTable(0)\">ticker_name</th>
              <th onclick =\"sortTable(2)\"> price</th>
              <th> Delete</th>
              ";

              # output data for each row
              # want to pass ticker_name for delete button since we want to keep track
              # of what element to delete
              while($row = $result->fetch_assoc()) {
                echo "<tr><td>" . $row["ticker_name"]. "</td><td>" . $row["price"]. "</td><td> <a href='test1.php?del=".$row['ticker_name']."' class='btn btn btn-danger'
                aria-label='Left Align' name='remove' value='remove'>X</button></td></tr>";
              }
              echo "</table>";
            } else {
              echo "<h1>There are no ticker_names in your watchlist, please add one.<h1>";
            }
            $conn->close();
          ?>
    
      </body>
</html>