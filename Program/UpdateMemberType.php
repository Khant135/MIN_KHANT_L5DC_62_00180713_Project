<?php
session_start();
	include('Connect.php');
	if(isset($_REQUEST['MemberTypeID']))
	{
		$MemberTypeID=$_REQUEST['MemberTypeID'];
		$select="SELECT * FROM MemberType WHERE MemberTypeID='$MemberTypeID'";
		$query=mysqli_query($connection,$select);
		$data=mysqli_fetch_array($query);
		$MemberType=$data['MemberType'];
		$AllowlanceItemAmount=$data['AllowlanceItemAmount'];
		$CardCost=$data['CardCost'];
	}
	if(isset($_POST['btnUpdate']))
	{
		$MemberType=$_POST['txtMemberType'];
		$AllowlanceItemAmount=$_POST['txtAllowlanceItemAmount'];
		$CardCost=$_POST['txtCardCost'];
		$MemberTypeID=$_POST['txtMemberTypeID'];

		$Update="UPDATE MemberType SET MemberType='$MemberType', AllowlanceItemAmount='$AllowlanceItemAmount', CardCost='$CardCost'
		Where MemberTypeID='$MemberTypeID'";
		$query=mysqli_query($connection,$Update);
		
		if ($query>0)
		{
			echo "<script>alert('Update MemberType Successful.')
			window.location='MemberType.php'
			</script>";
		}
	}
	include('Header.php');
?>
<html>
<head>

</head>
<body>
	<form action="UpdateMemberType.php" method="POST">
	<section class="ftco-section contact-section ftco-degree-bg">
      <div class="container">
        <div class="row block-9">
          <div class="col-md-6 pr-md-5">
          	<h4 class="mb-4">MemberType</h4>
            
            	<input type="hidden" value="<?php echo $MemberTypeID ?>" name="txtMemberTypeID">
              <div class="form-group">
                  <input type="text" class="form-control" name="txtMemberType" value='<?php echo $MemberType ?>' placeholder="Enter MemberType" required>
              </div>
              <div class="form-group">
                  <input type="text" class="form-control" name="txtAllowlanceItemAmount" value='<?php echo $AllowlanceItemAmount ?>' placeholder="Enter AllowlanceItemAmount" required>
              </div>
              <div class="form-group">
                  <input type="text" class="form-control" name="txtCardCost" value='<?php echo $CardCost ?>' placeholder="Enter CardCost" required>
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
