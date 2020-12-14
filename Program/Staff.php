<?php
session_start();
include('Connect.php');
if (isset($_POST['btnRegister']))
{

  $StaffName=$_POST['txtStaffName'];
  $StaffEmail=$_POST['txtStaffEmail'];
  $StaffAddress=$_POST['txtStaffAddress'];
  $StaffGrade=$_POST['cboStaffGrade'];
  $PasswordForLogIn=$_POST['txtPFL'];
  $StaffPhone=$_POST['txtStaffPhone'];

  
  $select="select * from Staff 
          Where StaffEmail='$StaffEmail'";
  $ret=mysqli_query($connection,$select);
  $count=mysqli_num_rows($ret); 
  if($count>0)
  {
    echo '<script>window.alert("Staff Email Already Exists")</script>';
    echo '<script>window.location="Staff.php"</script>';
  }
  else
  {
    $insert="INSERT INTO Staff( `StaffName`, `StaffEmail`, `StaffAddress`, `PasswordForLogIn`, `StaffPhone`, `StaffGradeID`)
    VALUES('$StaffName','$StaffEmail','$StaffAddress','$PasswordForLogIn','$StaffPhone','$StaffGrade')";
    $ret=mysqli_query($connection,$insert);
    if($ret>0)
    {
      echo '<script>window.alert("Staff Register Successfully!")</script>';
      echo '<script>window.location="Staff.php"</script>';
    }
    else
    {
      echo "<p>Something went wrong.".mysqli_error($connection)."</p>";
    }
  }
}

  include('Header.php');
?>

<html>
<head>
  <style>
        table {
          border-collapse: collapse;
          width: 100%;
        }

        th, td {
          text-align: left;
          padding: 8px;
        }

        tr:nth-child(even){background-color: #f2f2f2}


      </style>
</head>
<body>
  <form action="Staff.php" method="POST">
    <section class="ftco-section contact-section ftco-degree-bg">
      <div class="container">
        <div class="row block-9">
          <div class="col-md-6 pr-md-5">
          	<h4 class="mb-4">Staff</h4>
              <div class="form-group">
                  <input type="text" class="form-control" name="txtStaffName" placeholder="Enter StaffName" required>
              </div>
              <div class="form-group">
                <input type="email" class="form-control" name="txtStaffEmail" placeholder="Enter Staff Email" required>
              </div>
              <div class="form-group">
                <textarea type="text" id="" cols="30" rows="7" class="form-control" name="txtStaffAddress" placeholder="Enter Staff Address" required></textarea>
              </div>
              <div class="form-group">
                <select name="cboStaffGrade" class="form-control" required>
                  <option>Select StaffGrade</option>
                    <?php
                      $select="select * from StaffGrade";
                      $ret=mysqli_query($connection,$select);
                      $rowcount=mysqli_num_rows($ret);

                      for($i=0;$i<$rowcount;$i++)
                      {
                        $row=mysqli_fetch_array($ret);
                        $StaffGradeID=$row['StaffGradeID'];
                        $StaffGrade=$row['StaffGrade'];
                        echo"<option value='$StaffGradeID'>".$StaffGrade."</option>";
                      }
                    ?>
              </select>
              </div>
              <div class="form-group">
                <input type="password" class="form-control" name="txtPFL" placeholder="Enter Password" required>
              </div>
              <div class="form-group">
                <input type="text" class="form-control" name="txtStaffPhone" placeholder="Enter Phone Number" required>
              </div>
              <div class="form-group">
                <input type="submit" value="Register" class="btn btn-primary py-3 px-4" name="btnRegister">
                <input type="reset" value="Cancel" class="btn btn-primary py-3 px-4" name="btnCancel">
              </div>

            
          </div>
        </div>
      </div>
    </section>

    <section class="ftco-section contact-section ftco-degree-bg">
      
        <div class="container">
          <div class="row d-flex justify-content-center">

              <fieldset>
      <legend>Staff List:</legend>
      <?php
        $query="SELECT * from Staff ORDER BY StaffID DESC" ;
        $ret=mysqli_query($connection,$query);
        $count=mysqli_num_rows($ret);
        if($count==0)
        {
          echo "<p>No Staff Record Found.</p>";
          exit();
        }
      ?>
      
      <table border="1px">
        <tr>
          <td>StaffID</td>
          <td>StaffName</td>
          <td>StaffEmail</td>
          <td>StaffAddress</td>
          <td>PasswordForLogIn</td>
          <td>StaffPhone</td>
          <td>StaffGradeID</td>
          <td>Action</td>
        </tr>
        <?php
        for ($i=0; $i < $count ; $i++) 
        { 
          $data=mysqli_fetch_array($ret);
          $StaffID=$data['StaffID'];
          $StaffName=$data['StaffName'];
          $StaffEmail=$data['StaffEmail'];
          $StaffAddress=$data['StaffAddress'];
          $PasswordForLogIn=$data['PasswordForLogIn'];
          $StaffPhone=$data['StaffPhone'];
          $StaffGradeID=$data['StaffGradeID'];

          echo "<tr>";
          echo "<td>$StaffID</td>";
          echo "<td>$StaffName</td>";
          echo "<td>$StaffEmail</td>";
          echo "<td>$StaffAddress</td>";
          echo "<td>$PasswordForLogIn</td>";
          echo "<td>$StaffPhone</td>";
          echo "<td>$StaffGradeID</td>";

          echo "<td>
              <a href='DeleteStaff.php ?StaffID=$StaffID'>Delete</a>|
              <a href='UpdateStaff.php ?StaffID=$StaffID'>Update</a>
              </td>";
          echo "</tr>";
        }
          
        ?>
      </table>
    </fieldset>
          </div>
        </div>
    </section>
    </form>
</body>
</html>

<?php 
  include('Footer.php');
?>		



    
  

