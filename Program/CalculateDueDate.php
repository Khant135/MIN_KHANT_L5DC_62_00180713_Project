<?php
session_start();
include('Connect.php');
include('Header.php');

if (isset($_REQUEST['BorrowID'])) 
	{
		$BorrowID=$_REQUEST['BorrowID'];
		$todaydate=$_REQUEST['TodayDate'];
		$returndate=$_REQUEST['ReturnDate'];
		$BookID=$_REQUEST['BookID'];
		$AmountOfFine=$_REQUEST['AmountOfFine'];
	    
	    echo $start=strtotime($returndate);
	    echo "<br>";
	    echo $end=strtotime($todaydate);
	    echo "<br>";
	    if($end>$start)
	    {
          echo $diff=($end-$start)/60/60/24;
          $update="UPDATE BorrowDetail 
          			set DueDate='$diff' 
          			where BorrowID='$BorrowID' and ProductID='$BookID'";
          $query=mysqli_query($connection,$update);
	    
	    if ($query)
		{
			$totalamt=$AmountOfFine*$diff;
			$tupdate="UPDATE BorrowDetail
						set TotalAmount='$totalamt'
						where BorrowID='$BorrowID' and ProductID='$BookID'";
			$query1=mysqli_query($connection,$tupdate);

			echo "<script>alert('Calculation Of DueDate Successful.')
			window.location='Return.php'
			</script>";

		}
	}
   else
   {
   	  echo "<script>alert(' DueDate is zero .')
			window.location='Return.php'
			</script>";
   }
	  


	}

?>
<?php
include('Footer.php');
?>