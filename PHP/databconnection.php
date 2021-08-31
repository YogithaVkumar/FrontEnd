<?php
    $server = "localhost";
    $username = "Learn";
    $password = "phphost1234";
    $db = "learn_php";
    $conn= mysqli_connect( $server,$username,$password,$db);
?>
<html>
<head>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KyZXEAg3QhqLMpG8r+8fhAXLRk2vvoC2f3B09zVXn8CA5QIVfZOJ3BCsw2P0p/We" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-U1DAWAznBHeqEIlVSCgzq+c9gqGAJn5c/t99JyeKa9xxaYpSvHU5awsuZVVFIhvj" crossorigin="anonymous"></script>
      <title>DB Connection</title>
</head>
<body>
    <div class="container">
    <div class="container-fluid text-sm-center p-5 bg-light">
        <h2>Simple CRUD(PHP with MySQL)</h2>
    </div>
    <?php
      if(isset($_GET['Edit_ID'])){ 
          $sql="SELECT * FROM Users WHERE ID='$_GET[Edit_ID]'";
          $run= mysqli_query($conn,$sql);
          while($rows=mysqli_fetch_assoc($run)){
                 $user=$rows['Name'];
                 $email=$rows['Email'];
                 $password=$rows['Password'];
                 $date=$rows['Date'];
                 $contact_number=$rows['Contact_Number'];
          }
          ?>
      <h2>Edit User</h2>
      <form class="col-md-6"  action="databconnection.php" method="post">
         <div class="form-group">
             <label>Username</label>
             <input type="text" name="edit_user" value="<?php echo $user;?>" class="form-control" required>
         </div>
         <div class="form-group">
             <label>Email Address</label>
             <input type="text" name="edit_email" value="<?php echo $email;?>"class="form-control" required>
         </div>
         <div class="form-group">
             <label>Password</label>
             <input type="password" name="edit_password" value="<?php echo $password;?>" class="form-control" required>
         </div>
         <div class="form-group">
             <label>Date</label>
             <input type="date" name="edit_date" value="<?php echo $date;?>"class="form-control">
         </div>
         <div class="form-group">
             <label>Contact Number</label>
             <input type="text" name="edit_contact_number" value="<?php echo $contact_number;?>" class="form-control">
         </div>
         <br>
         <div class="form-group">
             <input type="hidden" value="<?php echo $_GET['Edit_ID']?>" name="edit_user_id">
             <input type="submit" value="Done Editing" name="edit" class="btn btn-primary">
         </div>
    </form>
   <?php  } else{?>
       <h2> Insert New User</h2>
       <form class="col-md-6"  action="databconnection.php" method="post">
            <div class="form-group">
                <label>Username</label>
                <input type="text" name="user" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Email Address</label>
                <input type="text" name="email" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Date</label>
                <input type="date" name="date" class="form-control">
            </div>
            <div class="form-group">
                <label>Contact Number</label>
                <input type="text" name="contact_number" class="form-control">
            </div>
            <br>
            <div class="form-group">
                <input type="submit"  name="submit" class="btn btn-primary">
            </div>
       </form>
   <?php  }
        $sql = "SELECT * FROM Users";
        $run = mysqli_query($conn,$sql);
        /*while ( $rows = mysqli_fetch_assoc($run)){
            echo $rows['Name'];
            echo '<br>';
            echo $rows['Email'];
            echo '<br>';
            echo $rows['Date'];
            echo '<br>';
            echo $rows['Contact_Number'];
            }*/
   echo "
       <table class='table'>
             <thead>
                   <tr>
                      <th>S.No</th>
                      <th>Name</th>
                      <th>Email</th>
                      <th>Password</th>
                      <th>Date</th>
                      <th>Contact Number</th>
                      <th>Edit</th>
                      <th>Delete</th>
                   <tr>
             <thead>
             <tbody>
";
$c=1;
while ( $rows = mysqli_fetch_assoc($run)){
        echo" 
            <tr>
                <td>$c</td>
                <td>$rows[Name]</td>
                <td>$rows[Email]</td>
                <td>$rows[Password]</td>
                <td>$rows[Date]</td>
                <td>$rows[Contact_Number]</td>
                <td><a href='databconnection.php?Edit_ID=$rows[ID]' class='btn btn-success'>Edit</a></td>
                <td><a href='databconnection.php?Del_ID=$rows[ID]'class='btn btn-danger'>Delete</a></td>
                
            </tr>    
    ";
$c++;
}

?>
    </div>
</body>
</html>

<?php
     //Inserting New User
    if($_SERVER['REQUEST_METHOD'] == "POST"){
        $user=mysqli_real_escape_string($conn,strip_tags($_POST['user']));
        $email=mysqli_real_escape_string($conn,strip_tags($_POST['email']));
        $password=mysqli_real_escape_string($conn,strip_tags($_POST['password']));
        if(isset($_POST['date'])){
         $date=mysqli_real_escape_string($conn,strip_tags($_POST['date']));
        }
        if(isset($_POST['contact_number'])){
         $contact_number=mysqli_real_escape_string($conn,strip_tags($_POST['contact_number']));
        }
        //$date= date('Y-m-d'); Automatic date
        $ins_sql="INSERT INTO Users (Name,Email,Password,Date,Contact_Number) VALUES ('$user','$email','$password',
        '$date',' $contact_number')";

        if(mysqli_query($conn,$ins_sql))
        { 
            ?>
            <script>window.location="databconnection.php";</script>
        <?php
        }   
        }
    //Deleting user
    if(isset($_GET['Del_ID'])){
        $del_sql="DELETE FROM Users WHERE ID='$_GET[Del_ID]' ";
        if(mysqli_query($conn, $del_sql)){ ?>
            <script>window.location="databconnection.php";</script>
            <?php
        }
    }
    //Editing an Existing User
    if(isset($_POST['edit_user'])){
        $edit_user= mysqli_real_escape_string ($conn,strip_tags($_POST['edit_user']));
        $edit_email= mysqli_real_escape_string ($conn,strip_tags($_POST['edit_email']));
        $edit_password= mysqli_real_escape_string ($conn,strip_tags($_POST['edit_password']));
        $edit_date= mysqli_real_escape_string ($conn,strip_tags($_POST['edit_date']));
        $edit_contact_number= mysqli_real_escape_string ($conn,strip_tags($_POST['edit_contact_number']));
        $Edit_ID=$_POST['edit_user_id'];
        $edit_sql="UPDATE Users SET Name='$edit_user', Email ='$edit_email', Password='$edit_password',Date='$edit_date', Contact_Number='$edit_contact_number' WHERE ID='$Edit_ID'";
        if(mysqli_query($conn,$edit_sql)){
            ?>
             <script>window.location="databconnection.php";</script>
             <?php
        }
    }
?>
