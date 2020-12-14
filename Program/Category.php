<?php 
session_start();
include('Connect.php');
if (isset($_POST['btnRegister']))
{
  $CategoryName=$_POST['txtCategory'];
  
  $select="select * from Category Where CategoryName='$CategoryName'";
  $ret=mysqli_query($connection,$select);
  $count=mysqli_num_rows($ret);
  if($count>0)
  {
    echo '<script>window.alert("Category Already Exists")</script>';
    echo '<script>window.location="Cateogry.php"</script>';
  }
  else
  {
    $insert="INSERT into Category(CategoryName)
    values('$CategoryName')";
    $ret=mysqli_query($connection,$insert);
    if($ret>0)
    {
      echo '<script>window.alert("Category Register Successfully!")</script>';
      echo '<script>window.location="Category.php"</script>';
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
  <form action="Category.php" method="POST">
    <section class="ftco-section contact-section ftco-degree-bg">
      <div class="container">
        <div class="row block-9">
          <div class="col-md-6 pr-md-5">
          	<h4 class="mb-4">Category</h4>
            
              <div class="form-group">
                  <input type="text" class="form-control" name="txtCategory" placeholder="Enter Category Name" required>
              </div>
              <div class="form-group">
                <input type="submit" value="Register" class="btn btn-primary py-3 px-5" name="btnRegister">
                <input type="reset" value="Cancel" class="btn btn-primary py-3 px-5" name="btnCancel">
              </div>
            
          </div>
        </div>
      </div>
    </section>

    <section class="ftco-section contact-section ftco-degree-bg">
        <div class="container">
          <div class="row d-flex justify-content-center">
              <fieldset>
      <legend>Category List:</legend>
      <?php
        $query="SELECT * from Category ORDER BY CategoryID DESC" ;
        $ret=mysqli_query($connection,$query);
        $count=mysqli_num_rows($ret);
        if($count==0)
        {
          echo "<p>No Category Record Found.</p>";
          exit();
        }
      ?>
      <table border="1px">
        <tr>
          <td>CategoryID</td>
          <td>CategoryName</td>
          <td>Action</td>
        </tr>

        <?php
        for ($i=0; $i < $count ; $i++) 
        { 
          $data=mysqli_fetch_array($ret);
          $CategoryID=$data['CategoryID'];
          $CategoryName=$data['CategoryName'];
          echo "<tr>";
          echo "<td>$CategoryID</td>";
          echo "<td>$CategoryName</td>";
          echo "<td>
              <a href='DeleteCategory.php ?CategoryID=$CategoryID'>Delete</a>|
              <a href='UpdateCategory.php ?CategoryID=$CategoryID'>Update</a>
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



    
  

