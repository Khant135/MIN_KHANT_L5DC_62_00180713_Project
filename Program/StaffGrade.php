<?php
session_start();
include('Connect.php');
if (isset($_POST['btnRegister']))
{
  $StaffGrade=$_POST['txtStaffGrade'];
  $Salary=$_POST['txtSalary'];

  
  $select="SELECT * from StaffGrade 
          WHERE StaffGrade='$StaffGrade'";
  $ret=mysqli_query($connection,$select);
  $count=mysqli_num_rows($ret);
  if($count>0)
  {
    echo '<script>window.alert("Staff Grade Already Exists")</script>';
    echo '<script>window.location="StaffGrade.php"</script>';
  }
  else
  {
    $insert="INSERT INTO StaffGrade(StaffGrade,Salary)
            VALUES ('$StaffGrade','$Salary')";
    $ret=mysqli_query($connection,$insert);
    if($ret>0)
    {
      echo '<script>window.alert("Staff Grade Register Successfully!")</script>';
      echo '<script>window.location="StaffGrade.php"</script>';
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

    <form action="StaffGrade.php" method="POST">
    <section class="ftco-section contact-section ftco-degree-bg">
      <div class="container">

        <div class="row block-9">
          <div class="col-md-6 pr-md-5">
          	<h4 class="mb-4">Staff Grade</h4>
              <div class="form-group">
                  <input type="text" class="form-control" name="txtStaffGrade" placeholder="Enter Staff Grade" required>
              </div>
              <div class="form-group">
                <input type="text" class="form-control" name="txtSalary" placeholder="Enter Salary" required>
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
      <legend>StaffGrade List:</legend>
      <?php
        $query="SELECT * from StaffGrade ORDER BY StaffGradeID DESC" ;
        $ret=mysqli_query($connection,$query);
        $count=mysqli_num_rows($ret);
        if($count==0)
        {
          echo "<p>No StaffGrade Record Found.</p>";
          exit();
        }
      ?>
      
      <table border="1px">
        <tr>
          <td>StaffGradeID</td>
          <td>StaffGrade</td>
          <td>Salary</td>
          <td>Action</td>
        </tr>
        <?php
        for ($i=0; $i < $count ; $i++) 
        { 
          $data=mysqli_fetch_array($ret);
          $StaffGradeID=$data['StaffGradeID'];
          $StaffGrade=$data['StaffGrade'];
          $Salary=$data['Salary'];

          echo "<tr>";
          echo "<td>$StaffGradeID</td>";
          echo "<td>$StaffGrade</td>";
          echo "<td>$Salary</td>";
          echo "<td>
              <a href='DeleteStaffGrade.php ?StaffGradeID=$StaffGradeID'>Delete</a>|
              <a href='UpdateStaffGrade.php ?StaffGradeID=$StaffGradeID'>Update</a>
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