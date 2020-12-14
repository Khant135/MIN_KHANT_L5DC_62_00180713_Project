<?php
	include('Connect.php');
	if(isset($_REQUEST['ProductID']))
	{
		$ProductID=$_REQUEST['ProductID'];
		$Delete="DELETE from Product WHERE ProductID='$ProductID'";
		$query=mysqli_query($connection,$Delete);
		if($query)
		{
			echo "<script>
				alert('Product Delete Successful')
				window.location='Product.php'
				</script>";
		}
	}
?>