<?php
session_start();
	include('Connect.php');
	include('Header.php');
  	include('AutoID_Functions.php');

  	if (isset($_POST['btnSave'])) 
  	{
  		$DLID=$_POST['txtDLID'];
  		$MemberID=$_POST['cboMemberID'];
  		$BookID=$_POST['cboBookID'];
  		$Status=$_POST['cboStatus'];
  		$Description=$_POST['txtDescription'];
  		$Amount=$_POST['txtAmount'];

  		$insert="INSERT INTO DamageLost(DLID,MemberID,ProductID,Status,Description,AmountToPay)
  					Values ('$DLID','$MemberID','$BookID','$Status','$Description',$Amount)";
  		$query=mysqli_query($connection,$insert);
  		if($query>0)
	    {

	    	$update="UPDATE Product
	    	Set Quantity=Quantity-1
	    	Where ProductID='$BookID'";
	    	$updatequery=mysqli_query($connection,$update);

	    	$update1="UPDATE BorrowDetail
	    	Set Status='$Status'
	    	Where ProductID='$BookID'";
	    	$updatequery1=mysqli_query($connection,$update1);

        $update2="update Product
                           set OnDisplay=OnDisplay+1
                           where ProductID='$BookID'";
                           $pupdate=mysqli_query($connection,$update2);

	      echo '<script>window.alert("Damage&Lost Register Successfully!")</script>';
	      echo '<script>window.location="Damage&Lost.php"</script>';
	    }
	    else
	    {
	      echo "<p>Something went wrong.".mysqli_error($connection)."</p>";
	    }
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
          text-align: left;
          padding: 8px;
        }


      </style>
</head>
<body>
	<form action="Damage&Lost.php" method="POST">
<section class="ftco-section contact-section ftco-degree-bg">
      <div class="container">

        <div class="row block-9">
          <div class="col-md-6 pr-md-5">
          	<h4 class="mb-4">Damage&Lost</h4>
            
              <div class="form-group">
                  <input type="text" class="form-control" name="txtDLID" value="<?php echo AutoID('DamageLost','DLID','DL-',6) ?>" readonly/>
              </div>
              <div class="form-group">				
          		<select name="cboMemberID" class="form-control">
		            <option>Select Member</option>
		            <?php
		            $select="SELECT m.*,bd.BorrowID,bd.Status,b.BorrowID,b.MemberID
		            From Member m,BorrowDetail bd,Borrow b
                Where m.MemberID=b.MemberID AND bd.BorrowID=b.BorrowID AND bd.Status='Pending'";
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
          		<select name="cboBookID" class="form-control">
		            <option>Select BookName</option>
		            <?php
		            $select="SELECT p.*,bd.ProductID,bd.Status
		            From Product p,BorrowDetail bd
		            Where p.ProductID=bd.ProductID AND bd.Status='Pending'";
		            $ret=mysqli_query($connection,$select);
		            $rowcount=mysqli_num_rows($ret);

		            for($i=0;$i<$rowcount;$i++)
		            {
		              $row=mysqli_fetch_array($ret);
		              $BookID=$row['ProductID'];
		              $BookName=$row['ProductName'];
		              echo "<option value='$BookID'>$BookID - $BookName</option>";
		            }
		          ?>
		      	</select>
		    </div>
		    <div class="form-group">
		    	<select name="cboStatus" class="form-control">
		    		<option>Select Status</option>
		    		<option>Damage</option>
		    		<option>Lost</option>
		    	</select>
		    </div>
		    <div class="form-group">
		    	<textarea type="text" id="" cols="30" rows="7" class="form-control" name="txtDescription" placeholder="Enter Description" required></textarea>
		    </div>
		    <div class="form-group">
		    	<input type="text" class="form-control" name="txtAmount" placeholder="Enter Amount to Pay" required>
		    </div>
              <div class="form-group">
                <input type="submit" value="Save" class="btn btn-primary py-3 px-5" name="btnSave">
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
      <legend>Damage&Lost List:</legend>
      <?php
        $query="SELECT dl.*,p.ProductID,p.ProductName,m.MemberID,m.MemberName
        From DamageLost dl,Product p,Member m
        Where dl.ProductID=p.ProductID AND dl.MemberID=m.MemberID
        ORDER BY dl.DLID DESC" ;
        $ret=mysqli_query($connection,$query);
        $count=mysqli_num_rows($ret);
        if($count==0)
        {
          echo "<p>No Damage&Lost Record Found.</p>";
          exit();
        }
      ?>
      
      <table border="1px">
        <tr>
          <td>DLID</td>
          <td>MemberID</td>
          <td>MemberName</td>
          <td>BookID</td>
          <td>BookName</td>
          <td>Status</td>
          <td>Description</td>
          <td>AmountToPay</td>
        </tr>
        <?php
        for ($i=0; $i < $count ; $i++) 
        { 
          $data=mysqli_fetch_array($ret);
          $DLID=$data['DLID'];
          $MemberID=$data['MemberID'];
          $MemberName=$data['MemberName'];
          $BookID=$data['ProductID'];
          $BookName=$data['ProductName'];
          $Status=$data['Status'];
          $Description=$data['Description'];
          $AmountToPay=$data['AmountToPay'];

          echo "<tr>";
          echo "<td>$DLID</td>";
          echo "<td>$MemberID</td>";
          echo "<td>$MemberName</td>";
          echo "<td>$BookID</td>";
          echo "<td>$BookName</td>";
          echo "<td>$Status</td>";
          echo "<td>$Description</td>";
          echo "<td>$AmountToPay</td>";
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