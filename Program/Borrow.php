<?php
session_start();
	include ('Header.php');
	include('AutoID_Functions.php');
	include('Connect.php');
  include('Borrow_Functions.php');


  if (isset($_POST['btnSave'])) 
  {
    $BorrowID=$_POST['txtBorrowID'];
    $BorrowDate=date('Y-m-d');
    $MemberID=$_POST['cboMemberID'];
    $TotalBook=totalbook();
    $Status="Pending";

    //$query="SELECT OnDisplay FROM Product WHERE ProductID='$BookName'";
    //$result=mysqli_query($connection,$query);
    //$count=mysqli_num_rows($result);


    $insert="INSERT into Borrow(BorrowID,MemberID,BorrowDate,TotalBookQty) 
    values('$BorrowID','$MemberID','$BorrowDate','$TotalBook')";
    $ret=mysqli_query($connection,$insert);

    if ($ret)
    {
      for ($i=0; $i< count($_SESSION['BorrowFunctions']) ; $i++) 
      { 

          $BookName=$_SESSION['BorrowFunctions'][$i]['BookID'];
          $ReturnDate=$_SESSION['BorrowFunctions'][$i]['ReturnDate'];
          $BorrowDetailID=AutoID('BorrowDetail','BorrowDetailID','BD_',6);
         $insert_detail="INSERT into BorrowDetail(BorrowDetailID,ProductID,BorrowID,ReturnDate,Status) 
         values('$BorrowDetailID','$BookName','$BorrowID','$ReturnDate','$Status')";

         $detail_run=mysqli_query($connection,$insert_detail);

      $update="UPDATE Product
                SET OnDisplay=OnDisplay-1 
                WHERE ProductID='$BookName'";
      $run=mysqli_query($connection,$update);
      if($run)
      {
        echo"<script>
      window.alert('Borrow Submitted');
      window.location='Borrow.php';
      </script>";
      }
      else
      {
        echo "<script>window.alert('Try Again')</script>";
      }
      
      }
      ClearBookingList();

      

     
    }
  }



  if(isset($_POST['btnAdd']))
{
  

  $BookName=$_POST['cboBookName'];
  $ReturnDate=$_POST['txtReturnDate'];


  AddBorrow($BookName,$ReturnDate);
}

if(isset($_GET['Action'])) 
{
  $Action=$_GET['Action'];

  if($Action==="Remove") 
  {
    $BookName=$_GET['BookName'];
    RemoveBorrow($BookName);
  }
  elseif($Action==="ClearAll") 
  {
    ClearAll();
  }
}

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
	<form action="Borrow.php" method="POST">

    <section class="ftco-section contact-section ftco-degree-bg">
      <div class="container">
        <div class="row block-9">
          <div class="col-md-6 pr-md-5">
          	<h4 class="mb-4">Borrow Section</h4>
          		<div class="form-group">
					<input type="text" class="form-control" name="txtBorrowID" value="<?php echo AutoID('Borrow','BorrowID','BO-',6) ?>" readonly/>
				</div>
              	<div class="form-group">
                <select name="cboBookName" class="form-control">
		            <option>Select BookName</option>
		            <?php
		            $select="SELECT p.*,it.ItemTypeID,it.AllowlanceDays from Product p,ItemType it 
                          where p.ItemTypeID=it.ItemTypeID AND p.OnDisplay>0";
		            $ret=mysqli_query($connection,$select);
		            $rowcount=mysqli_num_rows($ret);

		            for($i=0;$i<$rowcount;$i++)
		            {
		              $row=mysqli_fetch_array($ret);
		              $BookID=$row['ProductID'];
		              $BookName=$row['ProductName'];
                  $AllowlanceDays=$row['AllowlanceDays'];
		              echo"<option value='$BookID'>".$BookName.' - '.$AllowlanceDays."</option>";
		            }
		          ?>
		        </select>
              	</div>
              	
              	<div class="form-group">
                  	*Due Date*<input type="date" class="form-control" name="txtReturnDate">
              	</div>
              	<div class="form-group">
                	<input type="submit" value="Add" class="btn btn-primary py-3 px-5" name="btnAdd">
                	<input type="reset" value="Cancel" class="btn btn-primary py-3 px-5" name="btnCancel">
              	</div>
          </div>

          <div class="col-md-6 pr-md-5">
              <fieldset>
      <legend>Confirm  List:</legend>
      <?php
        if(!isset($_SESSION['BorrowFunctions'])) 
          {
            echo "<p>No Borrow Information Found.</p>";
            
          }
        else
          {
      ?>
      <div style="overflow-x:auto;">
      <table border="1px">
        <tr>
          

          <th>BookName</th>
          <th>DueDate</th>
          

          
          <th>Action</th>
        </tr>

        <?php
        $size=count($_SESSION['BorrowFunctions']);

        for($i=0;$i<$size;$i++) 
        { 
          
          //$MemberID=$_SESSION['BorrowFunctions'][$i]['MemberID'];
          //$MemberName=$_SESSION['BorrowFunctions'][$i]['MemberName'];
          //$MemberType=$_SESSION['BorrowFunctions'][$i]['MemberType'];
          $BookName=$_SESSION['BorrowFunctions'][$i]['BookID'];
          //$BookName=$_SESSION['BorrowFunctions'][$i]['ProductName'];
          //$BorrowDate=$_SESSION['BorrowFunctions'][$i]['BorrowDate'];
          $ReturnDate=$_SESSION['BorrowFunctions'][$i]['ReturnDate'];


          
          echo "<tr>";
          //echo "<td>$BorrowID</td>";
          //echo "<td>$MemberID</td>";
          //echo "<td>$MemberName</td>";
          //echo "<td>$MemberType</td>";
          //echo "<td>$BookID</td>";
          echo "<td>$BookName</td>";
          //echo "<td>$BorrowDate</td>";
          echo "<td>$ReturnDate</td>";
          echo "<td>
      <a href='Borrow.php?BookName=$BookName&Action=Remove'>Remove</a>
      </td>";
          
          echo "</tr>";
          
        }
        ?>
        <tr>
          <td colspan="7" align="right">
          Choose Member :
          <select name="cboMemberID">
          <option>-Choose Member-</option>
          <?php  
          $query="SELECT * FROM Member";
          $ret=mysqli_query($connection,$query);
          $count=mysqli_num_rows($ret);

          for($i=0;$i<$count;$i++)
          { 
            $row=mysqli_fetch_array($ret);
            $MemberID=$row['MemberID'];
            $MemberName=$row['MemberName'];

            echo "<option value='$MemberID'>$MemberID - $MemberName</option>";
          }
          ?>
          </select>
          |
          <input type="submit"  name="btnSave" value="Save"/>
          |
          <a href="Purchase_Order.php?Action=ClearAll">Clear All</a>
          </td>
        </tr>

      </table>
      </div>
      <?php  
        }
      ?>
    </fieldset>
          
      </div>
          
        </div>
      </div>
    </section>

    <section class="ftco-section contact-section ftco-degree-bg">
        <div class="container">
          <div class="row d-flex justify-content-center">
              <fieldset>
      <legend>Borrow List:</legend>
      <?php
        $query="SELECT b.*,m.MemberID,m.MemberName,m.MemberTypeID,mt.MemberTypeID,mt.MemberType,p.ProductID,p.ProductName,bd.BorrowID,bd.ProductID,bd.ReturnDate,bd.Status
        FROM Borrow b,Member m,Product p,MemberType mt,BorrowDetail bd
        WHERE b.MemberID=m.MemberID AND b.BorrowID=bd.BorrowID
              AND bd.ProductID=p.ProductID AND m.MemberTypeID=mt.MemberTypeID AND bd.Status='Pending'
        ORDER BY b.BorrowID DESC";
        $ret=mysqli_query($connection,$query);
        $count=mysqli_num_rows($ret);
        if($count==0)
        {
          echo "<p>No Borrow Record Found.</p>";
          
        }
      ?>
      <table border="1px">
        <tr>
          <td>BorrowID</td>
          <td>MemberID</td>
          <td>MemberName</td>
          <td>MemberType</td>
          <td>BookID</td>
          <td>BookName</td>
          <td>BorrowDate</td>
          <td>DueDate</td>

        </tr>

        <?php
        for ($i=0; $i < $count ; $i++) 
        { 
          $data=mysqli_fetch_array($ret);
          $BorrowID=$data['BorrowID'];
          $MemberID=$data['MemberID'];
          $MemberName=$data['MemberName'];
          $MemberType=$data['MemberType'];
          $BookID=$data['ProductID'];
          $BookName=$data['ProductName'];
          $BorrowDate=$data['BorrowDate'];
          $ReturnDate=$data['ReturnDate'];
          echo "<tr>";
          echo "<td>$BorrowID</td>";
          echo "<td>$MemberID</td>";
          echo "<td>$MemberName</td>";
          echo "<td>$MemberType</td>";
          echo "<td>$BookID</td>";
          echo "<td>$BookName</td>";
          echo "<td>$BorrowDate</td>";
          echo "<td>$ReturnDate</td>";
          /*echo "<td>
              <a href='DeleteCategory.php ?CategoryID=$CategoryID'>Delete</a>|
              <a href='UpdateCategory.php ?CategoryID=$CategoryID'>Update</a>
              </td>";
          echo "</tr>";*/
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