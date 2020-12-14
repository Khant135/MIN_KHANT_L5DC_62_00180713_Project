<?php 
	session_start();
	include('Connect.php');
	if(isset($_POST['btnlogin']))
	{
		$StaffGrade=$_POST['cboStaffGrade'];
		$Email=$_POST['txtEmail'];
		$Password=$_POST['txtPFL'];

	   $query="SELECT * FROM Staff s,StaffGrade sd 
		where 
		sd.StaffGradeID=s.StaffGradeID AND
		 s.StaffEmail='$Email' and
		 s.PasswordForLogIn='$Password'";
		$ret=mysqli_query($connection,$query);
		$count=mysqli_num_rows($ret);
		$data=mysqli_fetch_array($ret);
		$staffgrade=$data['StaffGrade'];
		if($count>0)
		{

			if($staffgrade=='Library Assistant')
			{

				$_SESSION['StaffGrade']=$staffgrade;
				$_SESSION['Email']=$Email;
				$_SESSION['Password']=$Password;
				$_SESSION['StaffID']=$data['StaffID'];
				$_SESSION['StaffName']=$data['StaffName'];
				
				echo" 
				<script>
					alert('Login Successful!!')
					window.location='Home.php';
				</script>";
			}
			else if($staffgrade=='Database Administrator' or $staffgrade=='Library Manager')
			{
				$_SESSION['StaffGrade']=$staffgrade;
				$_SESSION['Email']=$Email;
				$_SESSION['Password']=$Password;
				$_SESSION['StaffID']=$data['StaffID'];
				$_SESSION['StaffName']=$data['StaffName'];

				echo" 
				<script>
					alert('Login Successful!!')
					window.location='Home.php';
				</script>";
			}

		}
		else
		{
			echo" 
			  <script>
			  		alert('Try Again');
			  </script>";
		}
	}
	include('Header.php');
?>

<html>
<head>
	<title></title>
</head>
<body>
	<form action="Login.php" method="POST">
	<section class="ftco-section contact-section ftco-degree-bg">
      <div class="container">
        <div class="row block-9">
          <div class="col-md-6 pr-md-5">
          	<h4 class="mb-4">LogIn</h4>
	

              <div class="form-group">
                <select name="cboStaffGrade" class="form-control">
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
                <input type="email" class="form-control" name="txtEmail" placeholder="Enter Email" required>
              </div>
              <div class="form-group">
                <input type="password" class="form-control" name="txtPFL" placeholder="Enter Password" required>
              </div>	
			<div class="form-group">
                <input type="submit" value="LogIn" class="btn btn-primary py-3 px-4" name="btnlogin">
                <input type="reset" value="Cancel" class="btn btn-primary py-3 px-4" name="btnCancel">
              </div>

				</table>

	
	</div>

        </div>
          </div>
	</section >
      </form>
</body>
</html>
<?php 
  include('Footer.php');
?>