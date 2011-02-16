<!DOCTYPE html>
<html lang="en" >

<head>
  <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
  <style>
#customers {
  font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
  border-collapse: collapse;
  width: 100%;
}

#customers td, #customers th {
  border: 1px solid #ddd;
  padding: 8px;
}

#customers tr:nth-child(even){background-color: #f2f2f2;}
#customers tr:nth-child(odd){background-color: #f2f2f2;}
#customers tr:hover {background-color: #ddd;}

#customers th {
  padding-top: 12px;
  padding-bottom: 12px;
  text-align: left;
  background-color: #4CAF50;
  color: white;
}
.block {
  display: block;
  width: 100%;
  border: none;
  background-color: #4CAF50;
  color: white;
  padding: 14px 28px;
  font-size: 16px;
  cursor: pointer;
  text-align: center;
}

.block:hover {
  background-color: #ddd;
  color: black;
}
</style>
  <meta charset="UTF-8">
  <title>REPORTS LIST</title>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/modernizr/2.8.3/modernizr.min.js" type="text/javascript"></script>


    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css">

  
      <link rel="stylesheet" href="css/style.css">

  
</head>

<body>
 <form action = "#" method="POST"> 
          <div class="w3-show-inline-block">
          <div class="w3-bar">
            <center>
  <a class="w3-button w3-black"  href="https://majorcc.shop/21232f297a57a5a743894a0e4a801fc3/">RETURN TO ADMIN PANEL</a>  
    <a class="w3-button w3-black"  href="https://majorcc.shop/support/feedback/admin/downloadpdf.php">DOWNLOAD PDF</a>  

            </center>
        </div>
        </div>  
  </form>
   <form action = "logout.php" method="POST"> 
          <div class="w3-show-inline-block">
          <div class="w3-bar">
            <center>
              <input type="submit" value="LogOut" name="logout" class="w3-btn w3-black">
            </center>
        </div>
        </div>  
  </form>



  <?php 
  session_start();
  require 'config.php';
   if (isset($_SESSION['login_user'])) {
          $userLoggedIn = $_SESSION['login_user'];
          $result = mysqli_query($con,"SELECT * FROM poll");

            echo "<table border='1' id='customers'>
            <tr>
            <th>ID</th>
            <th>Departement</th>
            <th>Subject</th>
            <th>Details</th>
            <th>User</th>
            <th>Email</th>
            </tr>";

            while($row = mysqli_fetch_array($result))
            {
            echo "<tr>";
            echo "<td>" . $row['id'] . "</td>";
            echo "<td>" . $row['feedback'] . "</td>";
            echo "<td>" . $row['phone'] . "</td>";
            echo "<td>" . $row['suggestions'] . "</td>";
            echo "<td>" . $row['name'] . "</td>";
            echo "<td>" . $row['email'] . "</td>";
            echo "</tr>";
            }
            echo "</table>";                                                                    
}
  else {
  //header("Location: index.php");
  }




   ?>
    
  <script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
  
  
</body>

</html>
