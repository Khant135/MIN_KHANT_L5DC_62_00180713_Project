<?php  
session_start(); 
include('Connect.php');
include('AutoID_Functions.php');
include('Purchase_Order_Functions.php');
include('Header.php');

if(isset($_POST['btnSearch'])) 
{
	$rdoSearchType=$_POST['rdoSearchType'];

	if ($rdoSearchType == 1) 
	{
		$PurchaseOrderID=$_POST['ddlPOID'];

		$query="SELECT po.*,s.SupplierID,s.SupplierName 
				FROM purchase po, Supplier s
				WHERE po.SupplierID=s.SupplierID 
				AND po.PurchaseOrderID='$PurchaseOrderID'
				ORDER BY PurchaseOrderID DESC";
		$result=mysqli_query($connection,$query);
	}
	elseif ($rdoSearchType == 2) 
	{
		$From=date('Y-m-d',strtotime($_POST['txtFrom']));
		$To=date('Y-m-d',strtotime($_POST['txtTo']));

		$query="SELECT po.*,s.SupplierID,s.SupplierName
				FROM purchase po, Supplier s
				WHERE po.SupplierID=s.SupplierID 
				AND po.PurchaseOrderDate BETWEEN '$From' AND '$To'
				ORDER BY PurchaseOrderID DESC";
		$result=mysqli_query($connection,$query);
	}
	elseif ($rdoSearchType== 3) 
	{
		$Status=$_POST['cboStatus'];

		$query="SELECT po.*,s.SupplierID,s.SupplierName 
				FROM purchase po, Supplier s
				WHERE po.SupplierID=s.SupplierID 
				AND po.Status='$Status'
				ORDER BY PurchaseOrderID DESC";
		$result=mysqli_query($connection,$query);

	}
	else
	{
		$query="SELECT po.*,s.SupplierID,s.SupplierName 
				FROM purchase po, Supplier s
				WHERE po.SupplierID=s.SupplierName 
				ORDER BY PurchaseOrderID DESC";
		$result=mysqli_query($connection,$query);
	}
}
elseif (isset($_POST['btnShowAll'])) 
{
	$query="SELECT po.*,s.SupplierID,s.SupplierName 
		FROM purchase po, Supplier s
		WHERE po.SupplierID=s.SupplierID 
		ORDER BY PurchaseOrderID DESC";
	$result=mysqli_query($connection,$query);
}
else
{
	$today=date('Y-m-d');

	 $query="SELECT po.*,s.SupplierID,s.SupplierName 
		FROM purchase po, Supplier s
		WHERE po.SupplierID=s.SupplierID 
		AND po.PurchaseOrderDate='$today'
		ORDER BY PurchaseOrderID DESC";
	$result=mysqli_query($connection,$query);
}

	
?>



<html>
<head>
	
</head>
<body>

<form action="Purchase_Order_Report.php" method="post">
<section class="ftco-section contact-section ftco-degree-bg">
        <div class="container">

<fieldset>
<legend align="center" ><h3 class="mb-4">Search Criteria:</h3></legend>


<table cellpadding="8px" align="center">
<tr>
	<td>
		
		<input type="radio" name="rdoSearchType" value="1" checked/>Search By PO_ID <br/>
		<input list="PurchaseOrderID" class="form-control" name="ddlPOID">
		<datalist id="PurchaseOrderID">
		<?php  
		$query="SELECT * FROM Purchase";
		$ret=mysqli_query($connection,$query);
		$count=mysqli_num_rows($ret);

		for($i=0;$i<$count;$i++) 
		{ 
			$row=mysqli_fetch_array($ret);
			$PurchaseOrderID=$row['PurchaseOrderID'];
			echo "<option value='$PurchaseOrderID'>";
		}
		?>
		</datalist>
	
	</td>
	<td>
		
		<input type="radio" name="rdoSearchType" value="2"/>Search By Date <br/>


		From :
		<input type="text" name="txtFrom" class="form-control" value="<?php echo date('Y-m-d') ?>" onClick="showCalender(calender,this)" readonly/>
		To :
		<input type="text" name="txtTo" class="form-control" value="<?php echo date('Y-m-d') ?>" onClick="showCalender(calender,this)" readonly/>
	
	</td>
	<td>
		
		<input type="radio" name="rdoSearchType" value="3"/>Search By Status <br/>
		<select name="cboStatus" class="form-control">
			<option>Pending</option>
			<option>Confirmed</option>

		</select>
	
	</td>
	<tr>
	<td>
		<input type="submit" name="btnSearch" value="Search"/>
	</td>
	<td>
		<input type="submit" name="btnShowAll" value="Show All"/>
	</td>
	<td>
		<input type="reset" value="Clear"/>
	</td>
	</tr>
</tr>
</table>
</fieldset>
</div>
</section>



<section class="ftco-section contact-section ftco-degree-bg">
        <div class="container">
          <div class="row d-flex justify-content-center">


<fieldset>
<legend>Purchase Order List :</legend>
<?php  
$count=mysqli_num_rows($result);

if($count < 1) 
{
	echo "<p>No Purchase Order Record Found!</p>";
	
}
else
{
?>



<table border="1" cellpadding="5px">
<tr>
	<th>PurchaseOrderID</th>
	<th>PO_Date</th>
	<th>SupplierName</th>
	<th>TotalQuantity</th>
	<th>GrandTotal</th>
	<th>Status</th>
	<th>Action</th>
</tr>


<?php 
} 
for ($i=0;$i<$count;$i++) 
{ 
	$row=mysqli_fetch_array($result);
	$PurchaseOrderID=$row['PurchaseOrderID'];

	echo "<tr>";
	echo "<td>" . $row['PurchaseOrderID'] . "</td>";
	echo "<td>" . $row['PurchaseOrderDate'] . "</td>";
	echo "<td>" . $row['SupplierName'] . "</td>";
	echo "<td>" . $row['TotalQuantity'] . "</td>";
	echo "<td>" . $row['GrandTotal'] . "</td>";
	echo "<td>" . $row['Status'] . "</td>";
	echo "<td><a href='Purchase_Order_Detail.php?PurchaseOrderID=$PurchaseOrderID'>Details</a></td>";
	echo "</tr>";
}
?>
</table>
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