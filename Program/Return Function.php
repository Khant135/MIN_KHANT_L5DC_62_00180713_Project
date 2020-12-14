<?php
function AddReturn($BookID,$DueDate,$Amount)
{
	include('Connect.php');
	$select="SELECT b.*,p.ProductID,p.ProductName,p.ItemTypeID,bd.DueDate,it.AmountOfFine,it.ItemTypeID
	FROM Borrow b,Product p,BorrowDetail bd,ItemType it
	WHERE b.BorrowID=bd.BorrowID AND bd.ProductID=p.ProductID AND p.ItemTypeID=it.ItemTypeID AND p.ProductID='$BookID'";
	$ret=mysqli_query($connection,$select);
	$row=mysqli_fetch_array($ret);
	if (!isset($_SESSION['ReturnFunctions']))
		{
			$_SESSION['ReturnFunctions']=array();
			
			$_SESSION['ReturnFunctions'][0]['BookID']=$BookID;
			
			$_SESSION['ReturnFunctions'][0]['DueDate']=$DueDate;

			$_SESSION['ReturnFunctions'][0]['AmountOfFine']=$Amount;
		}
	else
		{
			$count=count($_SESSION['ReturnFunctions']);
			if ($count==0) 
			{
				$_SESSION['ReturnFunctions']=array();
				
				$_SESSION['ReturnFunctions'][0]['BookID']=$BookID;
			
				$_SESSION['ReturnFunctions'][0]['DueDate']=$DueDate;

				$_SESSION['ReturnFunctions'][0]['AmountOfFine']=$Amount;
			}
			else
			{
				$check=IndexOf($BookID);
				if($check==-1)
				{
					$lastindex=count($_SESSION['ReturnFunctions']);
					
					$_SESSION['ReturnFunctions'][$lastindex]['BookID']=$BookID;
			
				$_SESSION['ReturnFunctions'][$lastindex]['DueDate']=$DueDate;

				$_SESSION['ReturnFunctions'][$lastindex]['AmountOfFine']=$Amount;

				}
			}
		}
		
		echo "<script>window.alert('Return is Listed')</script>";
		echo "<script>window.location='Return.php'</script>";
}
function RemoveReturn($BookID)
{
	$index=SearchBookID($BookID);

	if($index == -1) 
	{
		echo "<script>window.alert('Book Cannot Remove!')</script>";
		echo "<script>window.location='Return.php'</script>";
	}

	unset($_SESSION['ReturnFunctions'][$index]);
	$_SESSION['ReturnFunctions']=array_values($_SESSION['ReturnFunctions']);
	echo "<script>window.location='Return.php'</script>";
}

function ClearAll()
{
	unset($_SESSION['ReturnFunctions']);
	echo "<script>window.location='Return.php'</script>";
}

function IndexOf($BookID)
	{
		$count=count($_SESSION['ReturnFunctions']);
		for ($i=0; $i <$count; $i++) 
		{ 
			if($BookID==$_SESSION['ReturnFunctions'][$i]['BookID'])
			{
				return $i;//Add into the old one
			}
		}
		return -1;//Add the new line
	}
function SearchBookID($BookID)
{
	if(!isset($_SESSION['ReturnFunctions']))
	{
		return -1;
	}

	$size=count($_SESSION['ReturnFunctions']);

	if($size < 1) 
	{
		return -1;
	}
	
	for($i=0;$i<$size;$i++) 
	{ 
		if($BookID == $_SESSION['ReturnFunctions'][$i]['BookID'])
		{
			return $i;
		}
	}
	return -1;
}

function totalbook()
	{
		$totalbook=count($_SESSION['ReturnFunctions']);
		return $totalbook;
	}
function ClearBookingList()
	{
		unset($_SESSION['ReturnFunctions']);
		
	}
?>