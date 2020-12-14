<?php
  session_start();
  include('Connect.php');
  include('Header.php');
  include('AutoID_Functions.php');

  if (isset($_POST['btnRegister']))
{
  $MemberID=$_POST['txtMemberID'];
  $MemberName=$_POST['txtMemberName'];
  $MemberEmail=$_POST['txtMemberEmail'];
  $MemberAddress=$_POST['txtMemberAddress'];
  $NRC=$_POST['txtNRC'];
  $Age=$_POST['txtAge'];
  $PhoneNumber=$_POST['txtPhoneNumber'];
  $RegisterDate=$_POST['txtRegisterDate'];
  $ExpireDate=$_POST['txtExpireDate'];
  $MemberType=$_POST['cboMemberType'];
  
  $select="select * from Member Where MemberEmail='$MemberEmail'";
  $ret=mysqli_query($connection,$select);
  $count=mysqli_num_rows($ret);
  if($count>0)
  {
    echo '<script>window.alert("Member Already Exists")</script>';
    echo '<script>window.location="Member.php"</script>';
  }
  else
  {
    $insert="INSERT into Member(MemberID,MemberName,MemberEmail,MemberAddress,NRC,Age,PhoneNumber,RegisterDate,ExpireDate,MemberTypeID)
    values('$MemberID','$MemberName','$MemberEmail','$MemberAddress','$NRC','$Age','$PhoneNumber','$RegisterDate','$ExpireDate','$MemberType')";
    $ret=mysqli_query($connection,$insert);
    if($ret>0)
    {
      echo '<script>window.alert("Member Register Successfully!")</script>';
      echo '<script>window.location="Member.php"</script>';
    }
    else
    {
      echo "<p>Something went wrong.".mysqli_error($connection)."</p>";
    }
  }
}
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

<form action="Member.php" method="POST">
<section class="ftco-section contact-section ftco-degree-bg">
      <div class="container">

        <div class="row block-9">
          <div class="col-md-6 pr-md-5">
          	<h4 class="mb-4">MemberRegister</h4>
            
              <div class="form-group">
                  <input type="text" class="form-control" name="txtMemberID" value="<?php echo AutoID('Member','MemberID','M-',6) ?>" readonly/>
              </div>
              <div class="form-group">
                  <input type="text" class="form-control" name="txtMemberName" placeholder="Enter MemberName" required>
              </div>
              <div class="form-group">
                  <input type="email" class="form-control" name="txtMemberEmail" placeholder="Enter Email" required>
              </div>
              <div class="form-group">
                  <input type="text" class="form-control" name="txtMemberAddress" placeholder="Enter Address" required>
              </div>
              <div class="form-group">
                  <input type="text" class="form-control" name="txtNRC" placeholder="Enter NRC" required>
              </div>
              <div class="form-group">
                  <input type="text" class="form-control" name="txtAge" placeholder="Enter Age" required>
              </div>
              <div class="form-group">
                  <input type="text" class="form-control" name="txtPhoneNumber" placeholder="Enter PhoneNumber" required>
              </div>
              <div class="form-group">
                  *Register Date*<input type="date" class="form-control" name="txtRegisterDate" placeholder="Enter RegisterDate" required>
              </div>
              <div class="form-group">
                  *Expire Date*<input type="date" class="form-control" name="txtExpireDate" placeholder="Enter ExpireDate" required>
              </div>
              <div class="form-group">
                <select name="cboMemberType" class="form-control">
            <option>Select MemberType</option>
            <?php
            $select="select * from MemberType";
            $ret=mysqli_query($connection,$select);
            $rowcount=mysqli_num_rows($ret);

            for($i=0;$i<$rowcount;$i++)
            {
              $row=mysqli_fetch_array($ret);
              $MemberTypeID=$row['MemberTypeID'];
              $MemberType=$row['MemberType'];
              echo"<option value='$MemberTypeID'>".$MemberType."</option>";
            }
          ?>
          </select>
              </div>
              <div class="form-group">
                <input type="submit" value="Register" class="btn btn-primary py-3 px-5" name="btnRegister">
                <input type="reset" value="Cancel" class="btn btn-primary py-3 px-5" name="btnCancel">
              </div>
            
          </div>
        </div>
      </div>
    </section>

    <section class="ftco-section contact-section ftco-degree-bg">
        <div class="container">
          <div class="row d-flex justify-content-center">
              <fieldset>
      <legend>Member List:</legend>
      <?php
        $query="SELECT * from Member ORDER BY MemberID DESC" ;
        $ret=mysqli_query($connection,$query);
        $count=mysqli_num_rows($ret);
        if($count==0)
        {
          echo "<p>No Member Record Found.</p>";
          exit();
        }
      ?>
      <table border="1px">
        <tr>
          <td>MemberID</td>
          <td>MemberName</td>
          <td>MemberEmail</td>
          <td>MemberAddress</td>
          <td>NRC</td>
          <td>Age</td>
          <td>PhoneNumber</td>
          <td>RegisterDate</td>
          <td>ExpireDate</td>
          <td>MemberType</td>
          <td>Action</td>
        </tr>

        <?php
        for ($i=0; $i < $count ; $i++) 
        { 
          $data=mysqli_fetch_array($ret);
          $MemberID=$data['MemberID'];
          $MemberName=$data['MemberName'];
          $MemberEmail=$data['MemberEmail'];
          $MemberAddress=$data['MemberAddress'];
          $NRC=$data['NRC'];
          $Age=$data['Age'];
          $PhoneNumber=$data['PhoneNumber'];
          $RegisterDate=$data['RegisterDate'];
          $ExpireDate=$data['ExpireDate'];
          $MemberTypeID=$data['MemberTypeID'];
          echo "<tr>";
          echo "<td>$MemberID</td>";
          echo "<td>$MemberName</td>";
          echo "<td>$MemberEmail</td>";
          echo "<td>$MemberAddress</td>";
          echo "<td>$NRC</td>";
          echo "<td>$Age</td>";
          echo "<td>$PhoneNumber</td>";
          echo "<td>$RegisterDate</td>";
          echo "<td>$ExpireDate</td>";
          echo "<td>$MemberTypeID</td>";


          echo "<td>
              <a href='DeleteMember.php ?MemberID=$MemberID'>Delete</a>|
              <a href='UpdateMember.php ?MemberID=$MemberID'>Update</a>
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