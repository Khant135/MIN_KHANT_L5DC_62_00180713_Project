<?php
	include('Connect.php');
	if(isset($_REQUEST['SupplierID']))
	{
		$SupplierID=$_REQUEST['SupplierID'];
		$Delete="DELETE from Supplier WHERE SupplierID='$SupplierID'";
		$query=mysqli_query($connection,$Delete);
		if($query)
		{
			echo "<script>
				alert('Supplier Delete Successful')
				window.location='Supplier.php'
				</script>";
		}
	}
?>