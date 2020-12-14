<?php  
function AddProduct($ProductID,$PurchasePrice,$PurchaseQty)
{
	include ('Connect.php');
	$query="SELECT * from Product 
			WHERE ProductID='$ProductID'";
	$ret=mysqli_query($connection,$query);
	$count=mysqli_num_rows($ret);

	if($count < 1) 
	{
		echo "<p>No Product Found.</p>";
		exit();
	}

	$Product_Arr=mysqli_fetch_array($ret);

	$Product=$Product_Arr['ProductName'];

	if(isset($_SESSION['PurchaseFunctions'])) 
	{
		$Index=SearchProductID($ProductID);

		echo $Index;

		if($Index==-1) 
		{
			$size=count($_SESSION['PurchaseFunctions']);

			

			$_SESSION['PurchaseFunctions'][$size]['ProductID']=$ProductID;
			$_SESSION['PurchaseFunctions'][$size]['ProductName']=$Product;
			$_SESSION['PurchaseFunctions'][$size]['PurchasePrice']=$PurchasePrice;
			$_SESSION['PurchaseFunctions'][$size]['PurchaseQuantity']=$PurchaseQty;
		}
		else
		{
			$_SESSION['PurchaseFunctions'][$Index]['PurchaseQuantity']+=$PurchaseQty;
		}
	}
	else
	{
		$_SESSION['PurchaseFunctions']=array();

		

		$_SESSION['PurchaseFunctions'][0]['ProductID']=$ProductID;
		$_SESSION['PurchaseFunctions'][0]['ProductName']=$Product;
		$_SESSION['PurchaseFunctions'][0]['PurchasePrice']=$PurchasePrice;
		$_SESSION['PurchaseFunctions'][0]['PurchaseQuantity']=$PurchaseQty;
	}
	echo "<script>window.location='Purchase_Order.php'</script>";
}
function RemoveProduct($ProductID)
{
	$index=SearchProductID($ProductID);

	if($index == -1) 
	{
		echo "<script>window.alert('Product Cannot Remove!')</script>";
		echo "<script>window.location='Purchase_Order.php'</script>";
	}

	unset($_SESSION['PurchaseFunctions'][$index]);
	$_SESSION['PurchaseFunctions']=array_values($_SESSION['PurchaseFunctions']);
	echo "<script>window.location='Purchase_Order.php'</script>";
}

function ClearAll()
{
	unset($_SESSION['PurchaseFunctions']);
	echo "<script>window.location='Purchase_Order.php'</script>";
}

function CalculateTotalAmount()
{
	$TotalAmount=0;
	$size=count($_SESSION['PurchaseFunctions']);

	for($i=0;$i<$size;$i++) 
	{ 
		$P_Price=$_SESSION['PurchaseFunctions'][$i]['PurchasePrice'];
		$P_Qty=$_SESSION['PurchaseFunctions'][$i]['PurchaseQuantity'];
		$TotalAmount+=($P_Price * $P_Qty);
	}
	return $TotalAmount;
}

function CalculateTotalQuantity()
{
	$TotalQuantity=0;
	$size=count($_SESSION['PurchaseFunctions']);

	for($i=0;$i<$size;$i++) 
	{ 
		$P_Qty=$_SESSION['PurchaseFunctions'][$i]['PurchaseQuantity'];
		$TotalQuantity+=$P_Qty;
	}
	return $TotalQuantity;
}

function CalculateVAT()
{
	$TotalAmount=CalculateTotalAmount();
	$GovTax=$TotalAmount * 0.05;
	
	return $GovTax;
}
function SearchProductID($ProductID)
{
	if(!isset($_SESSION['PurchaseFunctions']))
	{
		return -1;
	}

	$size=count($_SESSION['PurchaseFunctions']);

	if($size < 1) 
	{
		return -1;
	}
	
	for($i=0;$i<$size;$i++) 
	{ 
		if($ProductID == $_SESSION['PurchaseFunctions'][$i]['ProductID'])
		{
			return $i;
		}
	}
	return -1;
}
?>