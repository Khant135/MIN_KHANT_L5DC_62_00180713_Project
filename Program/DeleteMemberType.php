<?php
	include('Connect.php');
	if(isset($_REQUEST['MemberTypeID']))
	{
		$MemberTypeID=$_REQUEST['MemberTypeID'];
		$Delete="DELETE from MemberType WHERE MemberTypeID='$MemberTypeID'";
		$query=mysqli_query($connection,$Delete);
		if($query)
		{
			echo "<script>
				alert('MemberType Delete Successful')
				window.location='MemberType.php'
				</script>";
		}
	}
?>