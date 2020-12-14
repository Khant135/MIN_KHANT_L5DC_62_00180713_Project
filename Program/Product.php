<?php
session_start();
include('Connect.php');
include('AutoID_Functions.php');
if (isset($_POST['btnRegister']))
{
  $ProductID=$_POST['txtProductID'];

  $PImage=$_FILES['imgPImage']['name'];
  $folder="Image/";
  if($PImage)
  {
    $filename=$folder."_".$PImage;
    $copied=copy($_FILES['imgPImage']['tmp_name'],$filename);
    if(!$copied)
    {
      echo"<script>window.alert('Can't Upload Product Image')</script>";
    }
  }
  ///////Image///////

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
  

    $insert="insert into Product(ProductID,ProductImage,ProductName,Author,Language,Edition,Publisher,ISBN,NumberOfPages,OnDisplay,Quantity,CategoryID,ItemTypeID)
    values('$ProductID','$filename','$ProductName','$Author','$Language','$Edition','$Publisher','$ISBN','$NumberOfPages','$OnDisplay','$Quantity','$Category','$ItemType')";
    $ret=mysqli_query($connection,$insert);
    if($ret>0)
    {
      echo '<script>window.alert("Product Register Successfully!")</script>';
      echo '<script>window.location="Product.php"</script>';
    }
    else
    {
      echo "<p>Something went wrong.".mysqli_error($connection)."</p>";
    }
  }
  include('Header.php');
?>

<html>
<head>
  
</head>
<body>

    <form action="Product.php" method="POST" enctype="multipart/form-data">
    <section class="ftco-section contact-section ftco-degree-bg">
      <div class="container">
        <div class="row block-9">
          <div class="col-md-6 pr-md-5">
          	<h4 class="mb-4">Product</h4>
            
              <div class="form-group">
                  <input type="text" class="form-control" name="txtProductID" value="<?php echo AutoID('Product','ProductID','P-',6) ?>" readonly/>
              </div>
              <div class="form-group">
                <input type="file" class="form-control" name="imgPImage" required>
              </div>
              <div class="form-group">
                <input type="text" class="form-control" name="txtProductName" placeholder="Enter Product Name" required>
              </div>
              <div class="form-group">
                <input type="text" class="form-control" name="txtAuthor" placeholder="Enter Author" required>
              </div>
              <div class="form-group">
                <input type="text" class="form-control" name="txtLanguage" placeholder="Enter Language" required>
              </div>
              <div class="form-group">
                <input type="text" class="form-control" name="txtEdition" placeholder="Enter Edition" required>
              </div>
              <div class="form-group">
                <input type="text" class="form-control" name="txtPublisher" placeholder="Enter Publisher" required>
              </div>
              <div class="form-group">
                <input type="text" class="form-control" name="txtISBN" placeholder="Enter ISBN" >
              </div>
              
              <div class="form-group">
                <input type="text" class="form-control" name="txtNumberOfPages" placeholder="Enter Number Of Pages" required>
              </div>
              <div class="form-group">
                <input type="text" class="form-control" name="txtOnDisplay" placeholder="Enter Amount to Display" >
              </div>
              <div class="form-group">
                <input type="number" class="form-control" name="txtQuantity" placeholder="Enter Quantity" required>
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
                <input type="submit" value="Register" class="btn btn-primary py-3 px-4" name="btnRegister">
                <input type="submit" value="Cancel" class="btn btn-primary py-3 px-4" name="btnCancel">
              </div>

            
          </div>
        </div>
      </div>
    </section>


<section class="ftco-section contact-section ftco-degree-bg">
      
        <div class="container">
          <div class="row d-flex justify-content-center">
            
              <fieldset>
      <legend>Product List:</legend>
      <?php
        $query="SELECT p.*,c.CategoryID,c.CategoryName,it.ItemTypeID,it.ItemType,it.AllowlanceDays,it.AmountOfFine
        From Product p,Category c,ItemType it
        Where p.CategoryID=c.CategoryID AND p.ItemTypeID=it.ItemTypeID
        ORDER BY ProductID DESC" ;
        $ret=mysqli_query($connection,$query);
        $count=mysqli_num_rows($ret);
        if($count==0)
        {
          echo "<p>No Product Record Found.</p>";
          exit();
        }
      ?>
      <style>
        table {
          border-collapse: collapse;
          width: 100%;   
        }

        tr, td {
          text-align: left;
          padding: 8px;
        }

        tr:nth-child(even){background-color: #f2f2f2}


      </style>
      
      <div style="overflow-x:auto;">
      <table border="1px">
        <tr>
          <td>ProductID</td>
          <td>ProductImage</td>
          <td>ProductName</td>
          <td>Author</td>
          <td>Language</td>
          <td>Edition</td>
          <td>Publisher</td>
          <td>ISBN</td>
          <td>NumberOfPages</td>
          <td>OnDisplay</td>
          <td>Quantity</td>
          <td>AllowlanceDays</td>
          <td>AmountOfFine</td>
          <td>Category Name</td>
          <td>ItemType Name</td>
          <td>Action</td>
        </tr>
        <?php
        for ($i=0; $i < $count ; $i++) 
        { 
          $data=mysqli_fetch_array($ret);
          $ProductID=$data['ProductID'];
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
          $AllowlanceDays=$data['AllowlanceDays'];
          $AmountOfFine=$data['AmountOfFine'];
          $CategoryID=$data['CategoryID'];
          $Category=$data['CategoryName'];
          $ItemTypeID=$data['ItemTypeID'];
          $ItemType=$data['ItemType'];

          echo "<tr>";
          echo "<td>$ProductID</td>";
          echo "<td><img src='$PImage' width='100px' height='100px'></td>";
          echo "<td>$ProductName</td>";
          echo "<td>$Author</td>";
          echo "<td>$Language</td>";
          echo "<td>$Edition</td>";
          echo "<td>$Publisher</td>";
          echo "<td>$ISBN</td>";
          echo "<td>$NumberOfPages</td>";
          echo "<td>$OnDisplay</td>";
          echo "<td>$Quantity</td>";
          echo "<td>$AllowlanceDays</td>";
          echo "<td>$AmountOfFine</td>";
          echo "<td>$Category </td>";
          echo "<td>$ItemType </td>";





          echo "<td>
              <a href='DeleteProduct.php ?ProductID=$ProductID'>Delete</a>|
              <a href='UpdateProduct.php ?ProductID=$ProductID'>Update</a>
              </td>";
          echo "</tr>";
        }
          
        ?>
      </table>
      </div>
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



    
  

