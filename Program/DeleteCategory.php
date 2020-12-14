<?php
	include('Connect.php');
	if(isset($_REQUEST['CategoryID']))
	{
		$CategoryID=$_REQUEST['CategoryID'];
		$Delete="DELETE from Category WHERE CategoryID='$CategoryID'";
		$query=mysqli_query($connection,$Delete);
		if($query)
		{
			echo "<script>
				alert('Category Delete Successful')
				window.location='Category.php'
				</script>";
		}
	}
?>