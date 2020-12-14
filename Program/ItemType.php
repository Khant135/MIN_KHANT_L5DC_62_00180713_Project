<?php 
session_start();
include('Connect.php');
if (isset($_POST['btnRegister']))
{
  $ItemType=$_POST['txtItemType'];
  $AllowlanceDays=$_POST['txtAllowlanceDays'];
  $AmountOfFine=$_POST['txtAmountOfFine'];
  
  $select="select * from ItemType Where ItemType='$ItemType'";
  $ret=mysqli_query($connection,$select);
  $count=mysqli_num_rows($ret);
  if($count>0)
  {
    echo '<script>window.alert("ItemType Already Exists")</script>';
    echo '<script>window.location="ItemType.php"</script>';
  }
  else
  {
    $insert="insert into ItemType(ItemType,AllowlanceDays,AmountOfFine)
    values('$ItemType','$AllowlanceDays','$AmountOfFine')";
    $ret=mysqli_query($connection,$insert);
    if($ret>0)
    {
      echo '<script>window.alert("ItemType Register Successfully!")</script>';
      echo '<script>window.location="ItemType.php"</script>';
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

    <form action="ItemType.php" method="POST">
    <section class="ftco-section contact-section ftco-degree-bg">
      <div class="container">

        <div class="row block-9">
          <div class="col-md-6 pr-md-5">
          	<h4 class="mb-4">ItemType</h4>
            
              <table>
              <div class="form-group">
                  <input type="text" class="form-control" name="txtItemType" placeholder="Enter ItemType" required>
              </div>
              <div class="form-group">
                <input type="text" class="form-control" name="txtAllowlanceDays" placeholder="Enter Allowlance Days" required>
              </div>
              <div class="form-group">
                <input type="text" class="form-control" name="txtAmountOfFine" placeholder="Enter Amount Of Fine" required>
              </div>
              <div class="form-group">
                <input type="submit" value="Register" class="btn btn-primary py-3 px-5" name="btnRegister">
                <input type="reset" value="Cancel" class="btn btn-primary py-3 px-5" name="btnCancel">
              </div>
              </table>
            </form>
          </div>
        </div>
      </div>
    </section>

    <section class="ftco-section contact-section ftco-degree-bg">
      
        <div class="container">
          <div class="row d-flex justify-content-center">

              <fieldset>
      <legend>ItemType List:</legend>
      <?php
        $query="SELECT * from ItemType ORDER BY ItemTypeID DESC" ;
        $ret=mysqli_query($connection,$query);
        $count=mysqli_num_rows($ret);
        if($count==0)
        {
          echo "<p>No ItemType Record Found.</p>";
          exit();
        }
      ?>
      
      <table border="1px">
        <tr>
          <td>ItemTypeID</td>
          <td>ItemType</td>
          <td>AllowlanceDays</td>
          <td>AmountOfFine</td>
          <td>Action</td>
        </tr>
        <?php
        for ($i=0; $i < $count ; $i++) 
        { 
          $data=mysqli_fetch_array($ret);
          $ItemTypeID=$data['ItemTypeID'];
          $ItemType=$data['ItemType'];
          $AllowlanceDays=$data['AllowlanceDays'];
          $AmountOfFine=$data['AmountOfFine'];

          echo "<tr>";
          echo "<td>$ItemTypeID</td>";
          echo "<td>$ItemType</td>";
          echo "<td>$AllowlanceDays</td>";
          echo "<td>$AmountOfFine</td>";
          echo "<td>
              <a href='DeleteItemType.php ?ItemTypeID=$ItemTypeID'>Delete</a>|
              <a href='UpdateItemType.php ?ItemTypeID=$ItemTypeID'>Update</a>
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



    
  

