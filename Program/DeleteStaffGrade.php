<?php
	include('Connect.php');
	if(isset($_REQUEST['StaffGradeID']))
	{
		$StaffGradeID=$_REQUEST['StaffGradeID'];
		$Delete="DELETE from StaffGrade WHERE StaffGradeID='$StaffGradeID'";
		$query=mysqli_query($connection,$Delete);
		if($query)
		{
			echo "<script>
				alert('StaffGrade Delete Successful')
				window.location='StaffGrade.php'
				</script>";
		}
	}
?>