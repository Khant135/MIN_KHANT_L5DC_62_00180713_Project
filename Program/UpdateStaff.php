<?php
session_start();
	include('Connect.php');
	if(isset($_REQUEST['StaffID']))
	{
		$StaffID=$_REQUEST['StaffID'];
		$select="SELECT * FROM Staff WHERE StaffID='$StaffID'";
		$query=mysqli_query($connection,$select);
		$data=mysqli_fetch_array($query);
		$StaffName=$data['StaffName'];
		$StaffEmail=$data['StaffEmail'];
    $StaffAddress=$data['StaffAddress'];
    $StaffGrade=$data['StaffGradeID'];
    $PasswordForLogIn=$data['PasswordForLogIn'];
    $StaffPhone=$data['StaffPhone'];
        
	}
	if(isset($_POST['btnUpdate']))
	{
		$StaffName=$_POST['txtStaffName'];
		$StaffEmail=$_POST['txtStaffEmail'];
		$StaffAddress=$_POST['txtStaffAddress'];
    $StaffGrade=$_POST['cboStaffGrade'];
		$PasswordForLogIn=$_POST['txtPasswordForLogIn'];
		$StaffPhone=$_POST['txtStaffPhone'];
		$StaffID=$_POST['txtStaffID'];

		$Update="UPDATE Staff SET StaffName='$StaffName' , StaffEmail='$StaffEmail' , StaffAddress='$StaffAddress' , StaffGradeID='$StaffGrade',PasswordForLogIn='$PasswordForLogIn' , StaffPhone='$StaffPhone' 		
    Where StaffID='$StaffID'";
		$query=mysqli_query($connection,$Update);
		
		if ($query>0)
		{
			echo "<script>alert('Update Staff Successful.')
			window.location='Staff.php'
			</script>";
		}
	}
	include('Header.php');
?>
<html>
<head>

</head>
<body>
  <form action="UpdateStaff.php" method="POST">
	<section class="ftco-section contact-section ftco-degree-bg">
      <div class="container">
        <div class="row block-9">
          <div class="col-md-6 pr-md-5">
          	<h4 class="mb-4">Staff</h4>
            
            	<input type="hidden" value="<?php echo $StaffID ?>" name="txtStaffID">
              <div class="form-group">
                  <input type="text" class="form-control" name="txtStaffName" value='<?php echo $StaffName ?>' placeholder="Enter StaffName" required>
              </div>
              <div class="form-group">
                <input type="email" class="form-control" name="txtStaffEmail" value='<?php echo $StaffEmail ?>' placeholder="Enter Staff Email" required>
              </div>
              <div class="form-group">
                <textarea type="text" id="" cols="30" rows="7" class="form-control" name="txtStaffAddress"  placeholder="Enter Staff Address" required><?php echo $StaffAddress ?></textarea>
              </div>
              <div class="form-group">
                <select name="cboStaffGrade" class="form-control" >
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
                  <?php echo $StaffGrade ?> </select>

              </div>
              <div class="form-group">
                <input type="password" class="form-control" name="txtPasswordForLogIn" value='<?php echo $PasswordForLogIn ?>' placeholder="Enter Password" required>
              </div>
              <div class="form-group">
                <input type="text" class="form-control" name="txtStaffPhone" value='<?php echo $StaffPhone ?>' placeholder="Enter Phone Number" required>
              </div>
              <div class="form-group">
                <input type="submit" value="Update" class="btn btn-primary py-3 px-5" name="btnUpdate">
              </div>

          </div>
        </div>
      </div>
    </section>
    </form>
</body>
</html>
<?php 
  include('Footer.php');
?>		
