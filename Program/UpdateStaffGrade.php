<?php
session_start();
	include('Connect.php');
	if(isset($_REQUEST['StaffGradeID']))
	{
		$StaffGradeID=$_REQUEST['StaffGradeID'];
		$select="SELECT * FROM StaffGrade WHERE StaffGradeID='$StaffGradeID'";
		$query=mysqli_query($connection,$select);
		$data=mysqli_fetch_array($query);
		$StaffGrade=$data['StaffGrade'];
		$Salary=$data['Salary'];
	}
	if(isset($_POST['btnUpdate']))
	{
		$StaffGrade=$_POST['txtStaffGrade'];
		$Salary=$_POST['txtSalary'];
		$StaffGradeID=$_POST['txtStaffGradeID'];

		$Update="UPDATE StaffGrade SET StaffGrade='$StaffGrade' , Salary='$Salary'
		Where StaffGradeID='$StaffGradeID'";
		$query=mysqli_query($connection,$Update);
		
		if ($query>0)
		{
			echo "<script>alert('Update StaffGrade Successful.')
			window.location='StaffGrade.php'
			</script>";
		}
	}
	include('Header.php');
?>
<html>
<head>
	
</head>
<body>
	<form action="UpdateStaffGrade.php" method="POST">
	<section class="ftco-section contact-section ftco-degree-bg">
      <div class="container">
        <div class="row block-9">
          <div class="col-md-6 pr-md-5">
          	<h4 class="mb-4">Staff Grade</h4>
            	<input type="hidden" value="<?php echo $StaffGradeID ?>" name="txtStaffGradeID">
              <div class="form-group">
                  <input type="text" class="form-control" name="txtStaffGrade" value='<?php echo $StaffGrade ?>' placeholder="Enter Staff Grade" required>
              </div>
              <div class="form-group">
                <input type="text" class="form-control" name="txtSalary" value='<?php echo $Salary ?>' placeholder="Enter Salary" required>
              </div>
              <div class="form-group">
                <input type="submit" value="Update" class="btn btn-primary py-3 px-4" name="btnUpdate">

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
