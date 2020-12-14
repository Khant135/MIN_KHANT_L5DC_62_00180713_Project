<?php
	include('Connect.php');
	if(isset($_REQUEST['StaffID']))
	{
		$StaffID=$_REQUEST['StaffID'];
		$Delete="DELETE from Staff WHERE StaffID='$StaffID'";
		$query=mysqli_query($connection,$Delete);
		if($query)
		{
			echo "<script>
				alert('Staff Delete Successful')
				window.location='Staff.php'
				</script>";
		}
	}
?>