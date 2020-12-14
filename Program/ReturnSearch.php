<?php
session_start();
	include('Connect.php');
	include('Header.php');

	if (isset($_POST['btnSearch'])) 
	{
		$rdoSearchType=$_POST['rdoSearchType'];
		if ($rdoSearchType == 1) 
		{
			$BookName=$_POST['cboBookName'];

			$query="SELECT b.*,m.MemberID,m.MemberName,bd.BorrowDetailID,bd.BorrowID,bd.ProductID,bd.DueDate,p.ProductID,p.ProductName,r.BorrowDetailID,r.ReturnDate,bd.TotalAmount,r.ReturnID
					FROM Borrow b,BorrowDetail bd,Member m,Product p,Returns r
					WHERE b.BorrowID=bd.BorrowID AND b.MemberID=m.MemberID AND bd.ProductID=p.ProductID AND bd.BorrowDetailID=r.BorrowDetailID AND ProductName='$BookName'
					ORDER BY r.ReturnID DESC";
			$result=mysqli_query($connection,$query);
		}
		elseif ($rdoSearchType == 2) 
		{
			$MemberName=$_POST['cboMemberName'];

			$query="SELECT b.*,m.MemberID,m.MemberName,bd.BorrowDetailID,bd.BorrowID,bd.ProductID,bd.DueDate,p.ProductID,p.ProductName,r.BorrowDetailID,r.ReturnDate,bd.TotalAmount,r.ReturnID
					FROM Borrow b,BorrowDetail bd,Member m,Product p,Returns r
					WHERE b.BorrowID=bd.BorrowID AND b.MemberID=m.MemberID AND bd.ProductID=p.ProductID AND bd.BorrowDetailID=r.BorrowDetailID AND MemberName='$MemberName'
					ORDER BY r.ReturnID DESC";
			$result=mysqli_query($connection,$query);
		}
	}
	elseif (isset($_POST['btnShowAll'])) 
	{
		$query="SELECT b.*,m.MemberID,m.MemberName,bd.BorrowDetailID,bd.BorrowID,bd.ProductID,bd.DueDate,p.ProductID,p.ProductName,r.BorrowDetailID,r.ReturnDate,bd.TotalAmount,r.ReturnID
					FROM Borrow b,BorrowDetail bd,Member m,Product p,Returns r
					WHERE b.BorrowID=bd.BorrowID AND b.MemberID=m.MemberID AND bd.ProductID=p.ProductID AND bd.BorrowDetailID=r.BorrowDetailID
					ORDER BY r.ReturnID DESC";
		$result=mysqli_query($connection,$query);
	}
	else
	{
		$query="SELECT b.*,m.MemberID,m.MemberName,bd.BorrowDetailID,bd.BorrowID,bd.ProductID,bd.DueDate,p.ProductID,p.ProductName,r.BorrowDetailID,r.ReturnDate,bd.TotalAmount,r.ReturnID
					FROM Borrow b,BorrowDetail bd,Member m,Product p,Returns r
					WHERE b.BorrowID=bd.BorrowID AND b.MemberID=m.MemberID AND bd.ProductID=p.ProductID AND bd.BorrowDetailID=r.BorrowDetailID
					ORDER BY r.ReturnID DESC";
		$result=mysqli_query($connection,$query);
	}
?>
<html>
<head>
	<title></title>
</head>
<body>

	<form action="ReturnSearch.php" method="post">
<section class="ftco-section contact-section ftco-degree-bg">
        <div class="container">

<fieldset>
<legend align="center" ><h3 class="mb-4">Search Books:</h3></legend>


<table cellpadding="8px" align="center">
<tr>
	<td>
		<div class="form-group">
		<p><input type="radio" name="rdoSearchType" value="1">Search By BookName</p>
		<select name="cboBookName" class="form-control">
            <option>Select BookName</option>
            <?php
            $select="SELECT * FROM Product";
            $ret=mysqli_query($connection,$select);
            $rowcount=mysqli_num_rows($ret);

            for($i=0;$i<$rowcount;$i++)
            {
              $row=mysqli_fetch_array($ret);
              $BookID=$row['ProductID'];
              $BookName=$row['ProductName'];
              echo"<option value='$BookName'>".$BookName."</option>";
            }
          ?>
          </select>
		</div>
	</td>
	<td>
		<div class="form-group">
		<p><input type="radio" name="rdoSearchType" value="2">Search By MemberName</p>
		<select name="cboMemberName" class="form-control">
            <option>Select MemberName</option>
            <?php
            $select="SELECT * FROM Member";
            $ret=mysqli_query($connection,$select);
            $rowcount=mysqli_num_rows($ret);

            for($i=0;$i<$rowcount;$i++)
            {
              $row=mysqli_fetch_array($ret);
              $MemberID=$row['MemberID'];
              $MemberName=$row['MemberName'];
              echo"<option value='$MemberName'>".$MemberName."</option>";
            }
          ?>
          </select>
		</div>
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
<legend>Return List :</legend>
<?php  
	$count=mysqli_num_rows($result);


if($count < 1)
{
	echo "<p>No Return Record Found!</p>";
	
}
else
{
?>

<table border="1" cellpadding="5px">
<tr>
	<th>ReturnID</th>
	<th>MemberID</th>
	<th>MemberName</th>
	<th>BookID</th>
	<th>BookName</th>
	<th>ActualReturnDate</th>
	<th>DueDate</th>
	<th>TotalAmountOfFine</th>
</tr>


<?php 
} 
for ($i=0;$i<$count;$i++) 
{ 
	$row=mysqli_fetch_array($result);
	$ReturnID=$row['ReturnID'];
	$MemberID=$row['MemberID'];
	$MemberName=$row['MemberName'];
	$BookID=$row['ProductID'];
	$BookName=$row['ProductName'];
	$ActualReturnDate=$row['ReturnDate'];
	$DueDate=$row['DueDate'];
	$TotalAmountOfFine=$row['TotalAmount'];


	echo "<tr>";
	echo "<td>" . $row['ReturnID'] . "</td>";
	echo "<td>" . $row['MemberID'] . "</td>";
	echo "<td>" . $row['MemberName'] . "</td>";
	echo "<td>" . $row['ProductID'] . "</td>";
	echo "<td>" . $row['ProductName'] . "</td>";
	echo "<td>" . $row['ReturnDate'] . "</td>";
	echo "<td>" . $row['DueDate'] . "</td>";
	echo "<td>" . $row['TotalAmount'] . "</td>";

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