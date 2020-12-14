<?php
session_start();
	include('Connect.php');
	if(isset($_REQUEST['ProductID']))
	{
		$ProductID=$_REQUEST['ProductID'];
		$select="SELECT * FROM Product WHERE ProductID='$ProductID'";
		$query=mysqli_query($connection,$select);
		$data=mysqli_fetch_array($query);
		$PImage=$data['ProductImage'];
		$ProductName=$data['ProductName'];
		$Author=$data['Author'];
		$Language=$data['Language'];
		$Edition=$data['Edition'];
		$Publisher=$data['Publisher'];
    $ISBN=$data['ISBN'];
		$NumberOfPages=$data['NumberOfPages'];
    $OnDisplay=$data['OnDisplay'];
    $Quantity=$data['Quantity'];
		$Category=$data['CategoryID'];
		$ItemType=$data['ItemTypeID'];
	}
	if(isset($_POST['btnUpdate']))
	{
    $PImage=$_FILES['imgPImage']['name'];
  $folder="Image/";
  if($PImage)
  {
    $filename=$folder."_".$PImage;
    $copied=copy($_FILES['imgPImage']['tmp_name'],$filename);
    if(!$copied)
    {
      echo"<script>window.alert('Can't Upload Product Image.)</script>";
    }
  }
  ///////Image///////
		// $PImage=$_POST['imgPImage'];
		$ProductName=$_POST['txtProductName'];
		$Author=$_POST['txtAuthor'];
		$Language=$_POST['txtLanguage'];
		$Edition=$_POST['txtEdition'];
		$Publisher=$_POST['txtPublisher'];
    $ISBN=$_POST['txtISBN'];
		$NumberOfPages=$_POST['txtNumberOfPages'];
    $OnDisplay=$_POST['txtOnDisplay'];
    $Quantity=$_POST['txtQuantity'];
		$Category=$_POST['cboCategory'];
		$ItemType=$_POST['cboItemType'];

		$ProductID=$_POST['txtProductID'];


		$Update="UPDATE Product 
            SET ProductImage='$filename' , 
            ProductName='$ProductName' , 
            Author='$Author' , 
            Language='$Language' , 
            Edition='$Edition' , 
            Publisher='$Publisher' , 
            ISBN='$ISBN',
            NumberOfPages='$NumberOfPages' , 
            OnDisplay='$OnDisplay',
            Quantity='$Quantity',
            CategoryID='$Category' , 
            ItemTypeID='$ItemType'
		Where ProductID='$ProductID'";
		$query=mysqli_query($connection,$Update);
		
		if ($query>0)
		{
			echo "<script>alert('Update Product Successful.')
			window.location='Product.php'
			</script>";
		}
	}
	include('Header.php');
?>
<html>
<head>
	
</head>
<body>
  <form action="UpdateProduct.php" method="POST" enctype="multipart/form-data">
	<section class="ftco-section contact-section ftco-degree-bg">
      <div class="container">
        <div class="row block-9">
          <div class="col-md-6 pr-md-5">
          	<h4 class="mb-4">Product</h4>
            
            	<input type="hidden" value="<?php echo $ProductID ?>" name="txtProductID">
              <div class="form-group">
                <input type="file" class="form-control" name="imgPImage" value='<?php echo $PImage ?>' >
              </div>
              <div class="form-group">
                <input type="text" class="form-control" name="txtProductName" value='<?php echo $ProductName ?>' placeholder="Enter Product Name" required>
              </div>
              <div class="form-group">
                <input type="text" class="form-control" name="txtAuthor" value='<?php echo $Author ?>' placeholder="Enter Author" required>
              </div>
              <div class="form-group">
                <input type="text" class="form-control" name="txtLanguage" value='<?php echo $Language ?>' placeholder="Enter Language" required>
              </div>
              <div class="form-group">
                <input type="text" class="form-control" name="txtEdition" value='<?php echo $Edition ?>' placeholder="Enter Edition" required>
              </div>
              <div class="form-group">
                <input type="text" class="form-control" name="txtPublisher" value='<?php echo $Publisher ?>' placeholder="Enter Publisher" required>
              </div>
              <div class="form-group">
                <input type="text" class="form-control" name="txtISBN" value='<?php echo $ISBN ?>' placeholder="Enter ISBN">
              </div>
              <div class="form-group">
                <input type="text" class="form-control" name="txtNumberOfPages" value='<?php echo $NumberOfPages ?>' placeholder="Enter Number Of Pages" required>
              </div>
              <div class="form-group">
                <input type="text" class="form-control" name="txtOnDisplay" value='<?php echo $OnDisplay ?>' placeholder="Enter Amount Of Book To Display" required>
              </div>
              <div class="form-group">
                <input type="text" class="form-control" name="txtQuantity" value='<?php echo $Quantity ?>' placeholder="Enter Quantity" required>
              </div>
               <div class="form-group">
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
              echo"<option value='$CategoryID'>".$Category."</option>";
            }
          ?>
          </select>
              </div>

              
              <div class="form-group">
                <select name="cboItemType" class="form-control">
            <option>Select ItemType</option>
            <?php
            $select="select * from ItemType";
            $ret=mysqli_query($connection,$select);
            $rowcount=mysqli_num_rows($ret);

            for($i=0;$i<$rowcount;$i++)
            {
              $row=mysqli_fetch_array($ret);
              $ItemTypeID=$row['ItemTypeID'];
              $ItemType=$row['ItemType'];
              echo"<option value='$ItemTypeID'>".$ItemType."</option>";
            }
          ?>
          </select>
              </div>
    
              <div class="form-group">
                <input type="submit" value="Update" class="btn btn-primary py-3 px-5" name="btnUpdate">

              </div>

          </div>
        </div>
      </div>
    </section>
    </form>
</body>
</html>
<?php 

  include('Footer.php');
?>		
