<?php
session_start();
	include('Connect.php');
	if(isset($_REQUEST['SupplierID']))
	{
		$SupplierID=$_REQUEST['SupplierID'];
		$select="SELECT * FROM Supplier WHERE SupplierID='$SupplierID'";
		$query=mysqli_query($connection,$select);
		$data=mysqli_fetch_array($query);
		$SupplierName=$data['SupplierName'];
		$SupplierEmail=$data['SupplierEmail'];
		$SupplierAddress=$data['SupplierAddress'];
		$SupplierPhone=$data['SupplierPhone'];
	}
	if(isset($_POST['btnUpdate']))
	{
		$SupplierName=$_POST['txtSupplierName'];
		$SupplierEmail=$_POST['txtSupplierEmail'];
		$SupplierAddress=$_POST['txtSupplierAddress'];
		$SupplierPhone=$_POST['txtSupplierPhone'];
		$SupplierID=$_POST['txtSupplierID'];

		$Update="UPDATE Supplier SET SupplierName='$SupplierName' , SupplierEmail='$SupplierEmail' , SupplierAddress='$SupplierAddress' , SupplierPhone='$SupplierPhone'
		Where SupplierID='$SupplierID'";
		$query=mysqli_query($connection,$Update);
		
		if ($query>0)
		{
			echo "<script>alert('Update Supplier Successful.')
			window.location='Supplier.php'
			</script>";
		}
	}
	include('Header.php');
?>
<html>
<head>
	
</head>
<body>
	<form action="UpdateSupplier.php" method="POST">
	<section class="ftco-section contact-section ftco-degree-bg">
      <div class="container">
        <div class="row block-9">
          <div class="col-md-6 pr-md-5">
          	<h4 class="mb-4">Supplier</h4>
            
            	<input type="hidden" value="<?php echo $SupplierID ?>" name="txtSupplierID">
              <div class="form-group">
                  <input type="text" class="form-control" name="txtSupplierName" value='<?php echo $SupplierName ?>' placeholder="Enter Supplier Name" required>
              </div>
              <div class="form-group">
                  <input type="text" class="form-control" name="txtSupplierEmail" value='<?php echo $SupplierEmail ?>' placeholder="Enter SupplierEmail" required>
              </div>
              <div class="form-group">
                  <input type="text" class="form-control" name="txtSupplierAddress" value='<?php echo $SupplierAddress ?>' placeholder="Enter Supplier Address" required>
              </div>
              <div class="form-group">
                  <input type="text" class="form-control" name="txtSupplierPhone" value='<?php echo $SupplierPhone ?>' placeholder="Enter Supplier Phone" required>
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
