<?php
session_start();
	include('Connect.php');
	include('header.php');
  include('AutoID_Functions.php');

  if (isset($_POST['btnSearch']))  
                {
                  $MemberID=$_POST['cboMemberID'];

                  $query="SELECT b.*,m.MemberID,m.MemberName,p.ProductID,p.ProductName,p.ItemTypeID,bd.ProductID,bd.BorrowID,bd.ReturnDate,bd.DueDate,bd.Status,bd.TotalAmount,it.ItemTypeID,it.ItemType,it.AmountOfFine
                              FROM Borrow b,Member m,Product p,BorrowDetail bd,ItemType it
                              WHERE b.BorrowID=bd.BorrowID 
                              AND m.MemberID=b.MemberID 
                              AND it.ItemTypeID=p.ItemTypeID
                              AND p.ProductID=bd.ProductID
                              AND b.MemberID='$MemberID'
                              AND bd.Status='Pending'";
                              $result=mysqli_query($connection,$query);
                }

   elseif  (isset($_POST['btnReturn'])) 
    {
      $BorrowDetailID=$_POST['cboBorrowDetailID'];
      $ReturnID=AutoID('Returns','ReturnID','R_',6);
      $ReturnDate=date('Y-m-d');

       $select="SELECT b.*,bd.BorrowID,bd.ReturnDate,bd.TotalAmount,bd.ProductID,p.ProductID,p.ProductName,m.MemberID
                FROM Borrow b,BorrowDetail bd,Product p,Member m
                WHERE b.BorrowID=bd.BorrowID AND b.MemberID=m.MemberID AND bd.ProductID=p.ProductID
                and bd.BorrowDetailID='$BorrowDetailID'";
                $result=mysqli_query($connection,$select);
                $row=mysqli_fetch_array($result);

                  $TotalAmount=$row['TotalAmount'];
                  $MemberID=$row['MemberID'];
                  $BookID=$row['ProductID'];
                  //$AmountOfFine=$row['AmountOfFine'];
                  //$BorrowDate=$row['BorrowDate'];
                  //$Returndate=$row['ReturnDate'];
                  //$DueDate=$row['DueDate'];
                  //$TotalAmount=$row['TotalAmount'];
                

      $insert="INSERT INTO Returns(ReturnID,ReturnDate,TotalAmount,BorrowDetailID)
                Values ('$ReturnID','$ReturnDate','$TotalAmount','$BorrowDetailID')";
                $ret=mysqli_query($connection,$insert);

                $update="UPDATE BorrowDetail
                            SET Status='Returned'
                            WHERE BorrowDetailID='$BorrowDetailID'";
                  $bdupdate=mysqli_query($connection,$update);

               if($bdupdate)
                {
                   $update="update Product
                           set OnDisplay=OnDisplay+1
                           where ProductID='$BookID'";
                           $pupdate=mysqli_query($connection,$update);
                  echo '<script>window.alert("Return Process Successfully!")</script>';
                  echo '<script>window.location="Return.php"</script>';
                }
                else
                {
                  echo "<p>Something went wrong.".mysqli_error($connection)."</p>";
                }

                  
    }
    else
    {

                  $query="SELECT b.*,m.MemberID,m.MemberName,p.ProductID,p.ProductName,p.ItemTypeID,bd.BorrowID,bd.ReturnDate,bd.DueDate,bd.Status,bd.TotalAmount,it.ItemTypeID,it.ItemType,it.AmountOfFine
                              FROM Borrow b,Member m,Product p,BorrowDetail bd,ItemType it
                              WHERE b.BorrowID=bd.BorrowID AND m.MemberID=b.MemberID 
                              AND it.ItemTypeID=p.ItemTypeID AND p.ProductID=bd.ProductID AND bd.Status='Pending'
                              ORDER BY b.BorrowID DESC";
                              $result=mysqli_query($connection,$query);
    }


?>
<html>
<head>
	<title></title>
	<style>
        table {
          border-collapse: collapse;
          width: 100%;
        }

        th, td {
          text-align: center;
          padding: 8px;
        }
        .td1
        {
        	text-align: right;

        }



      </style>
</head>
<body>
	<form action="Return.php" method="POST">
    <section class="ftco-section contact-section ftco-degree-bg">
      <div class="container">
        <div class="row block-9">
          <div class="col-md-6 pr-md-5">
          	<h4 class="mb-4">Return</h4>
          	<div class="form-group">				
          		<select name="cboMemberID" class="form-control">
		            <option>Select Member</option>
		            <?php
		            $select="select * from Member";
		            $ret=mysqli_query($connection,$select);
		            $rowcount=mysqli_num_rows($ret);

		            for($i=0;$i<$rowcount;$i++)
		            {
		              $row=mysqli_fetch_array($ret);
		              $MemberID=$row['MemberID'];
		              $MemberName=$row['MemberName'];
		              echo "<option value='$MemberID'>$MemberID - $MemberName</option>";
		            }
		          ?>
		      	</select>
		    </div>
		    <div class="form-group">
		    	<input type="submit" value="Search" class="btn btn-primary py-3 px-5" name="btnSearch">
		    </div>
		  </div>
			</div>
		</div>
	</section>

	<section class="ftco-section contact-section ftco-degree-bg">
        <div class="container">
          <div class="row d-flex justify-content-center">
          	<fieldset>
          		<legend>Books List:</legend>
              <?php
                
                $count=mysqli_num_rows($result);

                if($count < 1)
                {
                  echo "<p>No Record Found.</p>";
                  
                }
                else
                {

              ?>
          		<table border="1px">
          			<tr>	
          				
          				<td>BorrowID</td>
          				<td>MemberName</td>
          				<td>BookName</td>
          				<td>AmountOfFine</td>
          				<td>BorrowDate</td>
          				<td>DueDate</td>
          				<td>AmountofDueDate</td>
          				<td>TotalAmount</td>
                  <td>Status</td>
                  <td>Action</td>
          			</tr>
          			<?php
              }
                for ($i=0; $i < $count ; $i++) 
                { 
                  $row=mysqli_fetch_array($result);

                  $BorrowID=$row['BorrowID'];
                  $today=date('Y-m-d');
                  $RDate=$row['ReturnDate'];
                  $BookID=$row['ProductID'];
                  $AmountOfFine=$row['AmountOfFine'];



                  echo "<tr>";
                  //echo "<td><input type='checkbox' name='check'></td>";
                  echo "<td>" . $row['BorrowID'] . "</td>";
                  echo "<td>" . $row['MemberName'] . "</td>";
                  echo "<td>" . $row['ProductName'] . "</td>";
                  echo "<td>" . $row['AmountOfFine'] . "</td>";
                  echo "<td>" . $row['BorrowDate'] . "</td>";
                  echo "<td>" . $row['ReturnDate'] . "</td>";
                  echo "<td>" . $row['DueDate'] . "</td>";
                  echo "<td>" . $row['TotalAmount'] . "</td>";
                  echo "<td>".$row['Status']."</td>";
                  echo "<td>
                      <a href='CalculateDueDate.php ?BorrowID=$BorrowID&TodayDate=$today&ReturnDate=$RDate&BookID=$BookID&AmountOfFine=$AmountOfFine'>CalculateDueDate</a>
                      </td>";
                  echo "</tr>";
                }

                ?>
          			<tr>
                  <td colspan="10" align="right">
                  Choose BorrowID :
                  <select name="cboBorrowDetailID">
                  <option>-Choose BorrowID-</option>
                  <?php  
                      $MemberID=$row['MemberID'];
                      $query="SELECT b.*,bd.BorrowDetailID,m.MemberID,m.MemberName,p.ProductID,p.ProductName,p.ItemTypeID,bd.BorrowID,bd.ReturnDate,bd.DueDate,bd.Status,bd.TotalAmount,it.ItemTypeID,it.ItemType,it.AmountOfFine
                              FROM Borrow b,Member m,Product p,BorrowDetail bd,ItemType it
                              WHERE b.BorrowID=bd.BorrowID 
                              AND m.MemberID=b.MemberID 
                              AND it.ItemTypeID=p.ItemTypeID
                              AND p.ProductID=bd.ProductID
                              AND b.MemberID='$MemberID' AND bd.Status='Pending'";
                  $ret=mysqli_query($connection,$query);
                  $count=mysqli_num_rows($ret);

                  for($i=0;$i<$count;$i++)
                  { 
                    $row=mysqli_fetch_array($ret);
                    $BorrowDetailID=$row['BorrowDetailID'];
                    $BorrowID=$row['BorrowID'];
                    $BookID=$row['ProductID'];
                    $BookName=$row['ProductName'];

                    echo "<option value='$BorrowDetailID'>$BorrowID - $BookName</option>";
                  }
                  ?>
                  </select>
                  |
                  <input type="submit"  name="btnReturn" value="Return" class="btn btn-primary py-3 px-5"/>
                  
                  </td>
                </tr>
          		</table>
          	</fieldset>
          </div>
      </div>
	</section>


</form>
</body>
</html>
<?php
	include('footer.php');
?>