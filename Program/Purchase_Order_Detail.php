<?php  
session_start(); 
include('Connect.php');
include('AutoID_Functions.php');
include('Purchase_Order_Functions.php');

if(isset($_GET['PurchaseOrderID'])) 
{
	$PurchaseOrderID=$_GET['PurchaseOrderID'];

	//Part A
	 $query1="SELECT po.*,sup.SupplierID,sup.SupplierName,st.StaffID,st.StaffName 
			 FROM purchase po,supplier sup,staff st
			 WHERE po.PurchaseOrderID='$PurchaseOrderID'
			 AND po.SupplierID=sup.SupplierID
			 AND po.StaffID=st.StaffID
			 ";
	$result1=mysqli_query($connection,$query1);
	$row1=mysqli_fetch_array($result1);
	//print_r($row1);

	//Part B
  $query2="SELECT po.*,pod.*,pro.ProductID,pro.ProductName
			 FROM purchase po,purchasedetail pod,product pro
			 WHERE po.PurchaseOrderID='$PurchaseOrderID'
			 AND po.PurchaseOrderID=pod.PurchaseOrderID
			 AND pod.ProductID=pro.ProductID
			 ";
	$result2=mysqli_query($connection,$query2);
	$count=mysqli_num_rows($result2);
}
else
{
	$PurchaseOrderID="";
}
if(isset($_POST['btnSubmit'])) 
{
	$txtPurchaseOrderID=$_POST['txtPurchaseOrderID'];

	// echo $query="SELECT * FROM purchasedetail
	// WHERE PurchaseOrderID='$txtPurchaseOrderID'";
	$check_PO=mysqli_query($connection,"SELECT * FROM purchasedetail
							WHERE PurchaseOrderID='$txtPurchaseOrderID'");

	
	while($row=mysqli_fetch_array($check_PO)) 
	{
		$ProductID=$row['ProductID'];
		$Quantity=$row['PurchaseQuantity'];

		$updateQty="UPDATE product
					SET Quantity= Quantity + '$Quantity'
					WHERE ProductID='$ProductID'
					";
		$ret=mysqli_query($connection,$updateQty);
	}

	$updateStatus="UPDATE purchase 
				   SET Status='Confirmed'
				   WHERE PurchaseOrderID='$txtPurchaseOrderID'
				   ";
	$ret=mysqli_query($connection,$updateStatus);
	
	if($ret) 
	{
		echo "<script>window.alert('Purchase Order is successfully confirmed by Admin.')</script>";
		echo "<script>window.location='Purchase_Order_Report.php'</script>";
	}
	else
	{
		echo "<p>Error in PurchaseOrder Confirmation: " . mysqli_error($connection) . "</p>";
	}

}
include('Header.php');
?>

<section class="ftco-section contact-section ftco-degree-bg">
      <div class="parallax-img d-flex align-items-center">
        <div class="container">
          <div class="row d-flex justify-content-center">


<form action="Purchase_Order_Detail.php" method="post">
<fieldset>
<legend>Detail Report for PurchaseOrder ID : <?php echo $PurchaseOrderID ?></legend>

<style>
        table {
          border-collapse: collapse;
          width: 100%;
        }

        th, td {

          padding: 8px;
        }




      </style>

<table align="center" cellpadding="5px">
<tr>
	<tr>
		<td align="center">
			<h3>Shine Library</h3>
			<small>Yangon</small>
		</td>
	</tr>
	<td>
		<table border="1" cellpadding="8px">
		<tr>	
			<td>PurchaseOrderID : </td>
			<td><b><?php echo $PurchaseOrderID ?></b></td>
			<td>SupplierName :</td>
			<td><b><?php echo $row1['SupplierName'] ?></b></td>
		</tr>
		<tr>
			<td>PurchaseOrderDate : </td>
			<td><b><?php echo $row1['PurchaseOrderDate'] ?></b></td>
			<td>ReportDate :</td>
			<td><b><?php echo date('d-M-Y') ?></b></td>
		</tr>
		<tr>
			<td>Status : </td>
			<td><b><?php echo $row1['Status'] ?></b></td>
			<td>StaffName :</td>
			<td><b><?php echo $row1['StaffName'] ?></b></td>
		</tr>

		</table>
	</td>
</tr>
<tr>
	<td>
		<table border="1" width="100%">
		<tr>
			<th>ProductID</th>
			<th>Description</th>
			<th>Qty (pcs)</th>
			<th>Price (MMK)</th>
			<th>SubTotal (MMK)</th>
		</tr>
		<?php  
		for ($i=0;$i<$count;$i++) 
		{ 
			$row2=mysqli_fetch_array($result2);
			echo "<tr>";
			echo "<td>" . $row2['ProductID'] . "</td>";
			echo "<td>" . $row2['ProductName'] . "</td>";
			echo "<td>" . $row2['PurchaseQuantity'] . " X </td>";
			echo "<td>" . $row2['PurchasePrice'] . "</td>";
			echo "<td>" . $row2['PurchaseQuantity'] * $row2['PurchasePrice'] . "</td>";
			echo "</tr>";
		}
		?>
		<tr>
			<td colspan="5" align="right">
			TotalAmount : &nbsp;&nbsp;&nbsp; <b><?php echo $row1['TotalAmount'] ?>MMK</b> <br/>
			VAT (5%) : &nbsp;&nbsp;&nbsp;<b><?php echo $row1['TaxAmount'] ?> MMK</b> <br/>
			GrandTotal : &nbsp;&nbsp;&nbsp;<b><?php echo $row1['GrandTotal'] ?> MMK</b> <br/>
			TotalQty : &nbsp;&nbsp;&nbsp;<b><?php echo $row1['TotalQuantity'] ?> pcs</b> <br/>
			</td>
		</tr>	
		</table>
		<hr>
		<input type="hidden" name="txtPurchaseOrderID" value="<?php echo $PurchaseOrderID ?>"/>
		<?php  
		if($row1['Status'] === "Pending") 
		{
			echo "<input type='submit' name='btnSubmit' value='Confirm'/>";
		}
		else
		{
			echo "<input type='submit' name='btnSubmit' value='Confirm' disabled/>";
		}
		?>
		|
		<script>var pfHeaderImgUrl = '';var pfHeaderTagline = 'Order%20Report';var pfdisableClickToDel = 0;var pfHideImages = 0;var pfImageDisplayStyle = 'right';var pfDisablePDF = 0;var pfDisableEmail = 0;var pfDisablePrint = 0;var pfCustomCSS = '';var pfBtVersion='1';(function(){var js, pf;pf = document.createElement('script');pf.type = 'text/javascript';if('https:' == document.location.protocol){js='https://pf-cdn.printfriendly.com/ssl/main.js'}else{js='http://cdn.printfriendly.com/printfriendly.js'}pf.src=js;document.getElementsByTagName('head')[0].appendChild(pf)})();</script>
	<a href="http://www.printfriendly.com" style="color:#6D9F00;text-decoration:none;" class="printfriendly" onClick="window.print();return false;" title="Printer Friendly and PDF"><img style="border:none;-webkit-box-shadow:none;box-shadow:none;" src="http://cdn.printfriendly.com/button-print-grnw20.png" alt="Print Friendly and PDF"/></a>
	</td>
</tr>
</table>
<hr/>
</fieldset>
</form>
</div>
</div>
</div>
</section>

<?php
include('Footer.php');
?>