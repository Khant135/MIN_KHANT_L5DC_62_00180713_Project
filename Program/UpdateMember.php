<?php
session_start();
	include('Connect.php');
	if(isset($_REQUEST['MemberID']))
	{
		$MemberID=$_REQUEST['MemberID'];
		$select="SELECT * FROM Member WHERE MemberID='$MemberID'";
		$query=mysqli_query($connection,$select);
		$data=mysqli_fetch_array($query);
		$MemberName=$data['MemberName'];
		$MemberEmail=$data['MemberEmail'];
    $MemberAddress=$data['MemberAddress'];
    $NRC=$data['NRC'];
    $Age=$data['Age'];
    $PhoneNumber=$data['PhoneNumber'];
    $RegisterDate=$data['RegisterDate'];
    $ExpireDate=$data['ExpireDate'];
    $MemberType=$data['MemberTypeID'];
        
	}
	if(isset($_POST['btnUpdate']))
	{
		$MemberName=$_POST['txtMemberName'];
		$MemberEmail=$_POST['txtMemberEmail'];
		$MemberAddress=$_POST['txtMemberAddress'];
    $NRC=$_POST['txtNRC'];
		$Age=$_POST['txtAge'];
		$PhoneNumber=$_POST['txtPhoneNumber'];
    $RegisterDate=$_POST['txtRegisterDate'];
    $ExpireDate=$_POST['txtExpireDate'];
    $MemberType=$_POST['cboMemberType'];
		$MemberID=$_POST['txtMemberID'];

		$Update="UPDATE Member SET MemberName='$MemberName' , MemberEmail='$MemberEmail' , MemberAddress='$MemberAddress' , NRC='$NRC',Age='$Age' , PhoneNumber='$PhoneNumber',RegisterDate='$RegisterDate',ExpireDate='$ExpireDate',MemberTypeID='$MemberType' 		
    Where MemberID='$MemberID'";
		$query=mysqli_query($connection,$Update);
		
		if ($query>0)
		{
			echo "<script>alert('Update Member Successful.')
			window.location='Member.php'
			</script>";
		}
	}
	include('Header.php');
?>
<html>
<head>

</head>
<body>
  <form action="UpdateMember.php" method="POST">
	<section class="ftco-section contact-section ftco-degree-bg">
      <div class="container">
        <div class="row block-9">
          <div class="col-md-6 pr-md-5">
          	<h4 class="mb-4">Member</h4>
            
            	<input type="hidden" value="<?php echo $MemberID ?>" name="txtMemberID">
              <div class="form-group">
                  <input type="text" class="form-control" name="txtMemberName" value='<?php echo $MemberName ?>' placeholder="Enter MemberName" required>
              </div>
              <div class="form-group">
                <input type="email" class="form-control" name="txtMemberEmail" value='<?php echo $MemberEmail ?>' placeholder="Enter MemberEmail Email" required>
              </div>
              <div class="form-group">
                <textarea type="text" id="" cols="30" rows="7" class="form-control" name="txtMemberAddress"  placeholder="Enter Member Address" required><?php echo $MemberAddress ?></textarea>
              </div>
              <div class="form-group">
                <input type="text" id="" cols="30" rows="7" class="form-control" name="txtNRC" value='<?php echo $NRC ?>' placeholder="Enter NRC" required>
              </div>
              <div class="form-group">
                <input type="text" id="" cols="30" rows="7" class="form-control" name="txtAge" value='<?php echo $Age ?>' placeholder="Enter Age" required>
              </div>
              <div class="form-group">
                <input type="text" id="" cols="30" rows="7" class="form-control" name="txtPhoneNumber" value='<?php echo $PhoneNumber ?>' placeholder="Enter PhoneNumber" required>
              </div>
              <div class="form-group">
                *Register Date*<input type="date" id="" cols="30" rows="7" class="form-control" name="txtRegisterDate" value='<?php echo $RegisterDate ?>' placeholder="Enter RegisterDate" required>
              </div>
              <div class="form-group">
                *Expire Date*<input type="date" id="" cols="30" rows="7" class="form-control" name="txtExpireDate" value='<?php echo $ExpireDate ?>' placeholder="Enter ExpireDate" required>
              </div>
              <div class="form-group">
                <select name="cboMemberType" class="form-control" >
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
                  <?php echo $MemberType ?> </select>

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
