<?php
session_start();
	include('Connect.php');
	if(isset($_REQUEST['ItemTypeID']))
	{
		$ItemTypeID=$_REQUEST['ItemTypeID'];
		$select="SELECT * FROM ItemType WHERE ItemTypeID='$ItemTypeID'";
		$query=mysqli_query($connection,$select);
		$data=mysqli_fetch_array($query);
		$ItemType=$data['ItemType'];
		$AllowlanceDays=$data['AllowlanceDays'];
		$AmountOfFine=$data['AmountOfFine'];
	}
	if(isset($_POST['btnUpdate']))
	{
		$ItemType=$_POST['txtItemType'];
		$AllowlanceDays=$_POST['txtAllowlanceDays'];
  		$AmountOfFine=$_POST['txtAmountOfFine'];
		$ItemTypeID=$_POST['txtItemTypeID'];

		$Update="UPDATE ItemType 
				SET ItemType='$ItemType' 
				, AllowlanceDays='$AllowlanceDays' 
				, AmountOfFine='$AmountOfFine'
				Where ItemTypeID='$ItemTypeID'";
		$query=mysqli_query($connection,$Update);
		
		if ($query>0)
		{
			echo "<script>alert('Update ItemType Successful.')
			window.location='ItemType.php'
			</script>";
		}
	}
	include('Header.php');
?>
<html>
<head>
	
</head>
<body>
	<form action="UpdateItemType.php" method="POST">
	<section class="ftco-section contact-section ftco-degree-bg">
      <div class="container">
        <div class="row block-9">
          <div class="col-md-6 pr-md-5">
          	<h4 class="mb-4">ItemType</h4>
            
            	<input type="hidden" value="<?php echo $ItemTypeID ?>" name="txtItemTypeID">
             <div class="form-group">
                  <input type="text" class="form-control" name="txtItemType" value='<?php echo $ItemType ?>' placeholder="Enter ItemType" required>
              </div>
              <div class="form-group">
                <input type="text" class="form-control" name="txtAllowlanceDays" value='<?php echo $AllowlanceDays ?>' placeholder="Enter Allowlance Days" required>
              </div>
              <div class="form-group">
                <input type="text" class="form-control" name="txtAmountOfFine" value='<?php echo $AmountOfFine ?>' placeholder="Enter Amount Of Fine" required>
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
