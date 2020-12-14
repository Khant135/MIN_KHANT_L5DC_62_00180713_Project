<?php
	include('Connect.php');
	if(isset($_REQUEST['ItemTypeID']))
	{
		$ItemTypeID=$_REQUEST['ItemTypeID'];
		$Delete="DELETE from ItemType WHERE ItemTypeID='$ItemTypeID'";
		$query=mysqli_query($connection,$Delete);
		if($query)
		{
			echo "<script>
				alert('ItemType Delete Successful')
				window.location='ItemType.php'
				</script>";
		}
	}
?>