<?php  
session_start(); 
include('Connect.php');
include('AutoID_Functions.php');
include('Purchase_Order_Functions.php');

if(isset($_POST['btnSave'])) 
{
	$PurchaseOrderID=$_POST['txtPurchaseOrderID'];
	$PurchaseDate=date('Y-m-d',strtotime($_POST['txtPurchaseDate']));
	$TotalAmount=$_POST['txtTotalAmount'];
	$GrandTotal=$_POST['txtGrandTotal'];
	$VAT=$_POST['txtVAT'];
	$TotalQuantity=$_POST['txtTotalQuantity'];
	$SupplierID=$_POST['cboSupplier'];
	$StaffID=$_SESSION['StaffID'];
	$Staff=$_SESSION['StaffName'];
	$Status="Pending";

	$Insert1="INSERT INTO `purchase`
			  (`PurchaseOrderID`, `PurchaseOrderDate`, `TotalAmount`, `GrandTotal`,`TaxAmount`, `TotalQuantity` ,`SupplierID`,  `StaffID`, `Status`) 
			  VALUES
			  ('$PurchaseOrderID','$PurchaseDate','$TotalAmount','$GrandTotal','$VAT','$TotalQuantity','$SupplierID','$StaffID','$Status')
			  ";
	$result=mysqli_query($connection,$Insert1);

	//Insert in Dummy Table---------------------------------------------

	$size=count($_SESSION['PurchaseFunctions']);

	for($i=0;$i<$size;$i++)
	{

		$ProductID=$_SESSION['PurchaseFunctions'][$i]['ProductID'];

		$PurchasePrice=$_SESSION['PurchaseFunctions'][$i]['PurchasePrice'];
		$PurchaseQty=$_SESSION['PurchaseFunctions'][$i]['PurchaseQuantity'];

		$Insert2="INSERT INTO `purchasedetail`
				  (`PurchaseOrderID`,`ProductID`, `PurchaseQuantity`, `PurchasePrice`)
				  VALUES
				  ('$PurchaseOrderID','$ProductID','$PurchaseQty','$PurchasePrice')
				  ";
		$result=mysqli_query($connection,$Insert2);
	}

	if($result) 
	{
		unset($_SESSION['PurchaseFunctions']);
		echo "<script>window.alert('Purchase Order Process Completed.')</script>";
		echo "<script>window.location='Purchase_Order.php'</script>";
	}
	else
	{
		echo "<p>Something wrong in Purchase_Order :" . mysqli_error($connection) . "</p>";
	}
}

if(isset($_POST['btnAdd']))
{
	
	$ProductID=$_POST['cboProduct'];
	$PurchasePrice=$_POST['txtPurchasePrice'];
	$PurchaseQty=$_POST['txtPurchaseQty'];

	AddProduct($ProductID,$PurchasePrice,$PurchaseQty);
}

if(isset($_GET['Action'])) 
{
	$Action=$_GET['Action'];

	if($Action==="Remove") 
	{
		$ProductID=$_GET['ProductID'];
		RemoveProduct($ProductID);
	}
	elseif($Action==="ClearAll") 
	{
		ClearAll();
	}
}
include('Header.php');

?>
<html>
<head>
	<style>
        table {
          border-collapse: collapse;
          width: 100%;
        }

        th, td {
          text-align: left;
          padding: 8px;
        }
</style>

</head>
<body>

<form action="Purchase_Order.php" method="post">
<section class="ftco-section contact-section ftco-degree-bg">
      <div class="container">
        <div class="row block-9">
          <div class="col-md-6 pr-md-5">
          	<h4 class="mb-4">Product</h4>
<fieldset>
<table cellpadding="8px">
	<tr>
		<td>PurchaseOrderID:</td>
		<td>
			<div class="form-group">
			<input type="text" class="form-control" name="txtPurchaseOrderID" value="<?php echo AutoID('Purchase','PurchaseOrderID','PO-',6) ?>" readonly/>
			</div>
		</td>
	</tr>
	<tr>
		<td>PurchaseDate:</td>
		<td>
			<div class="form-group">
			<input type="text" class="form-control" name="txtPurchaseDate" value="<?php echo date('Y-M-d') ?>" onClick="showCalender(calender,this)" readonly/>
			</div>
		</td>
	</tr>
	<tr>
		<td>TotalAmount:</td>
		<td>
			<div class="form-group">
			<input type="number" class="form-control" name="txtTotalAmount" value="<?php echo CalculateTotalAmount() ?>" readonly/> 
			</div>
		</td>
		<td>MMK</td>
	</tr>
	<tr>
		<td>GrandTotal:</td>
		<td>
			<div class="form-group">
			<input type="number" class="form-control" name="txtGrandTotal" value="<?php echo CalculateTotalAmount() + CalculateVAT()?>" readonly/> 
			</div>
		</td>
		<td>MMK</td>
	</tr>
	<tr>
		<td>VAT(5%):</td>
		<td>
			<div class="form-group">
			<input type="number" class="form-control" name="txtVAT" value="<?php echo CalculateVAT() ?>" readonly/> 
			</div>
		</td>
		<td>MMK</td>
	</tr>
	<tr>
		<td>Total Quantity:</td>
		<td>
			<div class="form-group">
			<input type="number" class="form-control" name="txtTotalQuantity" value="<?php echo CalculateTotalQuantity() ?>" readonly/> 
			</div>
		</td>
		<td>pcs</td>
	</tr>
	<tr>
		<td>StaffInfo:</td>
		<td>
			<div class="form-group">
			<input type="text" class="form-control" name="txtStaffInfo" value="<?php echo $_SESSION['StaffName'] ?>" readonly>
			</div>
		</td>
	</tr>
<tr>
	<td colspan="2">
		<hr>
	</td>
</tr>
	<tr>
		<td>Product:</td>
		<td>
			<div class="form-group">
				<select name="cboProduct" class="form-control" >
				<option>-Choose ProductID-</option>
				<?php  
				$query_pro="SELECT * FROM Product";
				$ret_pro=mysqli_query($connection,$query_pro);
				$count_pro=mysqli_num_rows($ret_pro);

				for($i=0;$i<$count_pro;$i++) 
				{ 
					$row_pro=mysqli_fetch_array($ret_pro);
					$ProductID=$row_pro['ProductID'];
					$Product=$row_pro['ProductName'];

					echo "<option value='$ProductID'>$ProductID - $Product</option>";
				}
				?>
				</select>
			</div>
		</td>
	</tr>
	<tr>
		<td>Purchase Price:</td>
		<td>
			<div class="form-group">
			<input type="number" class="form-control" name="txtPurchasePrice" placeholder="Enter Price" /> 
			</div>
		</td>
		<td>MMK</td>
	</tr>
	<tr>
		<td>Purchase Quantity:</td>
		<td>
			<div class="form-group">
			<input type="number" class="form-control" name="txtPurchaseQty" placeholder="Enter Quantity" /> 
			</div>
		</td>
		<td>pcs</td>
	</tr>	
	<tr>
		<td>
			<div class="form-group">
				<input type="submit" class="btn btn-primary py-3 px-4" name="btnAdd" value="Add"/>
			</div>
		</td>
		<td>
			<div class="form-group">
				<input type="reset" class="btn btn-primary py-3 px-4" value="Clear"/>
			</div>
		</td>
	</tr>
</table>	
</fieldset>
</div>
</div>
</div>
</section>

<section class="ftco-section contact-section ftco-degree-bg">
        <div class="container">
          <div class="row d-flex justify-content-center">
<fieldset>
<legend>Purchase Order Details :</legend>
<?php  
if(!isset($_SESSION['PurchaseFunctions'])) 
{
	echo "<p>No Product Information Found.</p>";


}

else
{
?>

<table border="1">
<tr>
	<th>ProductID</th>
	<th>Product</th>
	<th>Purchase_Price</th>
	<th>Product_Qty</th>
	<th>Sub_Total</th>
	<th>Action</th>
</tr>
<?php
$size=count($_SESSION['PurchaseFunctions']);

for($i=0;$i<$size;$i++) 
{ 
	

	$ProductID=$_SESSION['PurchaseFunctions'][$i]['ProductID'];
	$Product=$_SESSION['PurchaseFunctions'][$i]['ProductName'];
	$PurchasePrice=$_SESSION['PurchaseFunctions'][$i]['PurchasePrice'];
	$PurchaseQty=$_SESSION['PurchaseFunctions'][$i]['PurchaseQuantity'];
	$Sub_Total=$PurchasePrice * $PurchaseQty;

	echo "<tr>";
	

	echo "<td>$ProductID</td>";
	echo "<td>$Product</td>";
	echo "<td>$PurchasePrice MMK</td>";
	echo "<td>$PurchaseQty pcs</td>";
	echo "<td>$Sub_Total MMK</td>";
	echo "<td>
			<a href='Purchase_Order.php?ProductID=$ProductID&Action=Remove'>Remove</a>
		  </td>";
	echo "</tr>";
}
?>
<tr>
	<td colspan="7" align="right">
	Choose SupplierID :
	<select name="cboSupplier">
	<option>-Choose SupplierID-</option>
	<?php  
	$query="SELECT * FROM Supplier";
	$ret=mysqli_query($connection,$query);
	$count=mysqli_num_rows($ret);

	for($i=0;$i<$count;$i++)
	{ 
		$row=mysqli_fetch_array($ret);
		$SupplierID=$row['SupplierID'];
		$SupplierName=$row['SupplierName'];

		echo "<option value='$SupplierID'>$SupplierID - $SupplierName</option>";
	}
	?>
	</select>
	|
	<input type="submit"  name="btnSave" value="Save"/>
	|
	<a href="Purchase_Order.php?Action=ClearAll">Clear All</a>
	</td>
</tr>

</table>

<?php  
}
?>
</fieldset>
         </div>
        </div>
    </section>
	</form>
    </body>
</html>

<?php
include('Footer.php');
?>