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

			$query="SELECT b.*,m.MemberID,m.MemberName,bd.BorrowID,bd.ProductID,bd.Status,bd.ReturnDate,p.ProductID,p.ProductName
					FROM Borrow b,BorrowDetail bd,Member m,Product p
					WHERE b.BorrowID=bd.BorrowID AND b.MemberID=m.MemberID AND bd.ProductID=p.ProductID AND ProductName='$BookName'
					ORDER BY b.BorrowID DESC";
			$result=mysqli_query($connection,$query);
		}
		elseif ($rdoSearchType == 2) 
		{
			$MemberName=$_POST['cboMemberName'];

			$query="SELECT b.*,m.MemberID,m.MemberName,bd.BorrowID,bd.ProductID,bd.Status,bd.ReturnDate,p.ProductID,p.ProductName
					FROM Borrow b,BorrowDetail bd,Member m,Product p
					WHERE b.BorrowID=bd.BorrowID AND b.MemberID=m.MemberID AND bd.ProductID=p.ProductID AND MemberName='$MemberName'
					ORDER BY b.BorrowID DESC";
			$result=mysqli_query($connection,$query);
		}
		elseif ($rdoSearchType == 3)
		{
			$Status=$_POST['cboStatus'];

			$query="SELECT b.*,m.MemberID,m.MemberName,bd.BorrowID,bd.ProductID,bd.Status,bd.ReturnDate,p.ProductID,p.ProductName
					FROM Borrow b,BorrowDetail bd,Member m,Product p
					WHERE b.BorrowID=bd.BorrowID AND b.MemberID=m.MemberID AND bd.ProductID=p.ProductID AND Status='$Status'
					ORDER BY b.BorrowID DESC";
			$result=mysqli_query($connection,$query);
		}
	}
	elseif (isset($_POST['btnShowAll'])) 
	{
		$query="SELECT b.*,m.MemberID,m.MemberName,bd.BorrowID,bd.ProductID,bd.Status,bd.ReturnDate,p.ProductID,p.ProductName
					FROM Borrow b,BorrowDetail bd,Member m,Product p
					WHERE b.BorrowID=bd.BorrowID AND b.MemberID=m.MemberID AND bd.ProductID=p.ProductID
					ORDER BY b.BorrowID DESC";
		$result=mysqli_query($connection,$query);
	}
	else
	{
		$query="SELECT b.*,m.MemberID,m.MemberName,bd.BorrowID,bd.ProductID,bd.Status,bd.ReturnDate,p.ProductID,p.ProductName
					FROM Borrow b,BorrowDetail bd,Member m,Product p
					WHERE b.BorrowID=bd.BorrowID AND b.MemberID=m.MemberID AND bd.ProductID=p.ProductID AND Status='Pending'
					ORDER BY b.BorrowID DESC";
		$result=mysqli_query($connection,$query);
	}
?>
<html>
<head>
	<title></title>
</head>
<body>

	<form action="BorrowSearch.php" method="post">
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
	<td>
		<div class="form-group">
		<p><input type="radio" name="rdoSearchType" value="3"/>Search By Status</p>
		<select name="cboStatus" class="form-control">
            <option>Pending</option>
            <option>Returned</option>
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
<legend>Borrow List :</legend>
<?php  
	$count=mysqli_num_rows($result);


if($count < 1)
{
	echo "<p>No Borrow Record Found!</p>";
	
}
else
{
?>

<table border="1" cellpadding="5px">
<tr>
	<th>BorrowID</th>
	<th>MemberID</th>
	<th>MemberName</th>
	<th>BookID</th>
	<th>BookName</th>
	<th>BorrowDate</th>
	<th>DueDate</th>
	<th>Status</th>
</tr>


<?php 
} 
for ($i=0;$i<$count;$i++) 
{ 
	$row=mysqli_fetch_array($result);
	$BorrowID=$row['BorrowID'];
	$MemberID=$row['MemberID'];
	$MemberName=$row['MemberName'];
	$BookID=$row['ProductID'];
	$BookName=$row['ProductName'];
	$BorrowDate=$row['BorrowDate'];
	$ReturnDate=$row['ReturnDate'];
	$Status=$row['Status'];

	echo "<tr>";
	echo "<td>" . $row['BorrowID'] . "</td>";
	echo "<td>" . $row['MemberID'] . "</td>";
	echo "<td>" . $row['MemberName'] . "</td>";
	echo "<td>" . $row['ProductID'] . "</td>";
	echo "<td>" . $row['ProductName'] . "</td>";
	echo "<td>" . $row['BorrowDate'] . "</td>";
	echo "<td>" . $row['ReturnDate'] . "</td>";
	echo "<td>" . $row['Status'] . "</td>";
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