<?php 
session_start();
include('Connect.php');
if (isset($_POST['btnRegister']))
{
  $SupplierName=$_POST['txtSupplierName'];
  $SupplierEmail=$_POST['txtSupplierEmail'];
  $SupplierAddress=$_POST['txtSupplierAddress'];
  $SupplierPhone=$_POST['txtSupplierPhone'];

  
  $select="select * from Supplier Where SupplierEmail='$SupplierEmail'";
  $ret=mysqli_query($connection,$select);
  $count=mysqli_num_rows($ret);
  if($count>0)
  {
    echo '<script>window.alert("Supplier Email Already Exists")</script>';
    echo '<script>window.location="Supplier.php"</script>';
  }
  else
  {
    $insert="insert into Supplier(SupplierName,SupplierEmail,SupplierAddress,SupplierPhone)
    values('$SupplierName','$SupplierEmail','$SupplierAddress','$SupplierPhone')";
    $ret=mysqli_query($connection,$insert);
    if($ret>0)
    {
      echo '<script>window.alert("Supplier Register Successfully!")</script>';
      echo '<script>window.location="Supplier.php"</script>';
    }
    else
    {
      echo "<p>Something went wrong.".mysqli_error($connection)."</p>";
    }
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

        tr:nth-child(even){background-color: #f2f2f2}
  </style>

</head>
<body>
  <form action="Supplier.php" method="POST">
    <section class="ftco-section contact-section ftco-degree-bg">
      <div class="container">
        <div class="row block-9">
          <div class="col-md-6 pr-md-5">
          	<h4 class="mb-4">Supplier</h4>
              <div class="form-group">
                  <input type="text" class="form-control" name="txtSupplierName" placeholder="Enter Supplier Name" required>
              </div>

              <div class="form-group">
                <input type="email" class="form-control" name="txtSupplierEmail" placeholder="Enter Supplier Email" required>
              </div>
              <div class="form-group">
                <textarea type="text" id="" cols="30" rows="7" class="form-control" name="txtSupplierAddress" placeholder="Enter Supplier Address" required></textarea>
              </div>
              <div class="form-group">
                <input type="text" class="form-control" name="txtSupplierPhone" placeholder="Enter Supplier Phone" required>
              </div>
              <div class="form-group">
                <input type="submit" value="Register" class="btn btn-primary py-3 px-4" name="btnRegister">
                <input type="reset" value="Cancel" class="btn btn-primary py-3 px-4" name="btnCancel">
              </div>

            
          </div>
        </div>
      </div>
    </section>

    <section class="ftco-section contact-section ftco-degree-bg">
        <div class="container">
          <div class="row d-flex justify-content-center">

              <fieldset>
      <legend>Supplier List:</legend>
      <?php
        $query="SELECT * from Supplier ORDER BY SupplierID DESC" ;
        $ret=mysqli_query($connection,$query);
        $count=mysqli_num_rows($ret);
        if($count==0)
        {
          echo "<p>No Supplier Record Found.</p>";
          exit();
        }
      ?>
      <table border="1px">
        <tr>
          <td>SupplierID</td>
          <td>SupplierName</td>
          <td>SupplierEmail</td>
          <td>SupplierAddress</td>
          <td>SupplierPhone</td>
          <td>Action</td>
        </tr>
        <?php
        for ($i=0; $i < $count ; $i++) 
        { 
          $data=mysqli_fetch_array($ret);
          $SupplierID=$data['SupplierID'];
          $SupplierName=$data['SupplierName'];
          $SupplierEmail=$data['SupplierEmail'];
          $SupplierAddress=$data['SupplierAddress'];
          $SupplierPhone=$data['SupplierPhone'];

          echo "<tr>";
          echo "<td>$SupplierID</td>";
          echo "<td>$SupplierName</td>";
          echo "<td>$SupplierEmail</td>";
          echo "<td>$SupplierAddress</td>";
          echo "<td>$SupplierPhone</td>";
          echo "<td>
              <a href='DeleteSupplier.php ?SupplierID=$SupplierID'>Delete</a>|
              <a href='UpdateSupplier.php ?SupplierID=$SupplierID'>Update</a>
              </td>";
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



    
  

