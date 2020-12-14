<?php  
function AddBorrow($BookName,$ReturnDate)
{
	include('Connect.php');
	$select="SELECT * from Product p,Member m,MemberType mt
				WHERE m.MemberTypeID=m.MemberTypeID and p.ProductID='$BookName'";
	$ret=mysqli_query($connection,$select);
	$row=mysqli_fetch_array($ret);

	if (!isset($_SESSION['BorrowFunctions']))
		{
			$_SESSION['BorrowFunctions']=array();
			
			$_SESSION['BorrowFunctions'][0]['BookID']=$BookName;
			
			$_SESSION['BorrowFunctions'][0]['ReturnDate']=$ReturnDate;
		}
	else
		{
			$count=count($_SESSION['BorrowFunctions']);
			if ($count==0) 
			{
				$_SESSION['BorrowFunctions']=array();
				
				$_SESSION['BorrowFunctions'][0]['BookID']=$BookName;
				
				$_SESSION['BorrowFunctions'][0]['ReturnDate']=$ReturnDate;
			}
			else
			{
				$check=IndexOf($BookName);
				if($check==-1)
				{
					$lastindex=count($_SESSION['BorrowFunctions']);
					
					$_SESSION['BorrowFunctions'][$lastindex]['BookID']=$BookName;
					
					$_SESSION['BorrowFunctions'][$lastindex]['ReturnDate']=$ReturnDate;

				}
			}
		}
		
		echo "<script>window.alert('Borrow is Listed')</script>";
		echo "<script>window.location='Borrow.php'</script>";
}
function RemoveBorrow($BookName)
{
	$index=SearchBookID($BookName);

	if($index == -1) 
	{
		echo "<script>window.alert('Book Cannot Remove!')</script>";
		echo "<script>window.location='Borrow.php'</script>";
	}

	unset($_SESSION['BorrowFunctions'][$index]);
	$_SESSION['BorrowFunctions']=array_values($_SESSION['BorrowFunctions']);
	echo "<script>window.location='Borrow.php'</script>";
}

function ClearAll()
{
	unset($_SESSION['BorrowFunctions']);
	echo "<script>window.location='Borrow.php'</script>";
}

function IndexOf($BookName)
	{
		$count=count($_SESSION['BorrowFunctions']);
		for ($i=0; $i <$count; $i++) 
		{ 
			if($BookName==$_SESSION['BorrowFunctions'][$i]['BookName'])
			{
				return $i;//Add into the old one
			}
		}
		return -1;//Add the new line
	}
function SearchBookID($BookName)
{
	if(!isset($_SESSION['BorrowFunctions']))
	{
		return -1;
	}

	$size=count($_SESSION['BorrowFunctions']);

	if($size < 1) 
	{
		return -1;
	}
	
	for($i=0;$i<$size;$i++) 
	{ 
		if($BookName == $_SESSION['BorrowFunctions'][$i]['BookID'])
		{
			return $i;
		}
	}
	return -1;
}

function totalbook()
	{
		$totalbook=count($_SESSION['BorrowFunctions']);
		return $totalbook;
	}
function ClearBookingList()
	{
		unset($_SESSION['BorrowFunctions']);
		
	}
?>