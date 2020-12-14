<?php
	session_start();
	include('Connect.php');
	include('Header.php');

if(isset($_POST['btnSearch']))
{
	$rdoSearchType=$_POST['rdoSearchType'];

	if ($rdoSearchType == 1)
	{
		$BookID=$_POST['txtBookID'];

		$query="SELECT p.*,c.CategoryID,c.CategoryName,it.ItemTypeID,it.AllowlanceDays,it.AmountOfFine
		From Product p,Category c,ItemType it
		Where p.CategoryID=c.CategoryID AND p.ItemTypeID=it.ItemTypeID AND ProductID='$BookID'
		ORDER BY p.ProductID DESC";
		$result=mysqli_query($connection,$query);
	}
	elseif ($rdoSearchType == 2) 
	{
		$BookName=$_POST['txtBookName'];

		$query="SELECT p.*,c.CategoryID,c.CategoryName,it.ItemTypeID,it.AllowlanceDays,it.AmountOfFine
		From Product p,Category c,ItemType it
		Where p.CategoryID=c.CategoryID AND p.ItemTypeID=it.ItemTypeID AND ProductName='$BookName'
		ORDER BY p.ProductID DESC";
		$result=mysqli_query($connection,$query);
	}
	elseif ($rdoSearchType == 3) 
	{
		$Category=$_POST['cboCategory'];

		$query="SELECT p.*,c.CategoryID,c.CategoryName,it.ItemTypeID,it.AllowlanceDays,it.AmountOfFine
		From Product p,Category c,ItemType it
		Where p.CategoryID=c.CategoryID AND p.ItemTypeID=it.ItemTypeID AND CategoryName='$Category'
		ORDER BY p.ProductID DESC";
		$result=mysqli_query($connection,$query);
	}

}
elseif (isset($_POST['btnShowAll'])) 
{
		$query="SELECT p.*,c.CategoryID,c.CategoryName,it.ItemTypeID,it.AllowlanceDays,it.AmountOfFine
		From Product p,Category c,ItemType it
		Where p.CategoryID=c.CategoryID AND p.ItemTypeID=it.ItemTypeID
		ORDER BY p.ProductID DESC";
		$result=mysqli_query($connection,$query);
}
	else
	{
		$query="SELECT p.*,c.CategoryID,c.CategoryName,it.ItemTypeID,it.AllowlanceDays,it.AmountOfFine
		From Product p,Category c,ItemType it
		Where p.CategoryID=c.CategoryID AND p.ItemTypeID=it.ItemTypeID 
		ORDER BY p.ProductID DESC";
		$result=mysqli_query($connection,$query);
	}
?>

<html>
<head>
	
</head>
<body>

	<form action="Home.php" method="post">
<section class="ftco-section contact-section ftco-degree-bg">
        <div class="container">

<fieldset>
<legend align="center" ><h3 class="mb-4">Search Books:</h3></legend>


<table cellpadding="8px" align="center">
<tr>
	<td>
		<div class="form-group">
		<p><input type="radio" name="rdoSearchType" value="1">Search By BookID</p>
		<input type="text" name="txtBookID" class="form-control" value='P-'>
		</div>
	</td>
	<td>
		<div class="form-group">
		<p><input type="radio" name="rdoSearchType" value="2">Search By BookName</p>
		<input type="text" name="txtBookName" class="form-control">
		</div>
	</td>
	<td>
		<div class="form-group">
		<p><input type="radio" name="rdoSearchType" value="3"/>Search By Category</p>
		<select name="cboCategory" class="form-control">
            <option>Select Category</option>
            <?php
            $select="select * from Category";
            $ret=mysqli_query($connection,$select);
            $rowcount=mysqli_num_rows($ret);

            for($i=0;$i<$rowcount;$i++)
            {
              $row=mysqli_fetch_array($ret);
              $CategoryID=$row['CategoryID'];
              $Category=$row['CategoryName'];
              echo"<option value='$Category'>".$Category."</option>";
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
<legend>Book List :</legend>
<?php  

		
		$count=mysqli_num_rows($result);


if($count < 1)
{
	echo "<p>No Books Record Found!</p>";
	
}
else
{
?>

<table border="1" cellpadding="5px">
<tr>
	<th>BookID</th>
	<th>BookName</th>
	<th>CategoryName</th>
	<th>Language</th>
	<th>NumberofPages</th>
	<th>AllowlanceDays</th>
	<th>AvailableBooks</th>
</tr>


<?php 
} 
for ($i=0;$i<$count;$i++) 
{ 
	$row=mysqli_fetch_array($result);
	$BookID=$row['ProductID'];

	echo "<tr>";
	echo "<td>" . $row['ProductID'] . "</td>";
	echo "<td>" . $row['ProductName'] . "</td>";
	echo "<td>" . $row['CategoryName'] . "</td>";
	echo "<td>" . $row['Language'] . "</td>";
	echo "<td>" . $row['NumberOfPages'] . "</td>";
	echo "<td>" . $row['AllowlanceDays'] . "</td>";
	echo "<td>" . $row['OnDisplay'] . "</td>";
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