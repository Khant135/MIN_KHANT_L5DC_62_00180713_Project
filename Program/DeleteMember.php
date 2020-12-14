<?php
	include('Connect.php');
	if(isset($_REQUEST['MemberID']))
	{
		$MemberID=$_REQUEST['MemberID'];
		$Delete="DELETE from Member WHERE MemberID='$MemberID'";
		$query=mysqli_query($connection,$Delete);
		if($query)
		{
			echo "<script>
				alert('Member Delete Successful')
				window.location='Member.php'
				</script>";
		}
	}
?>