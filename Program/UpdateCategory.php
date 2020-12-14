<?php
session_start();
	include('Connect.php');
	if(isset($_REQUEST['CategoryID']))
	{
		$CategoryID=$_REQUEST['CategoryID'];
		$select="SELECT * FROM Category WHERE CategoryID='$CategoryID'";
		$query=mysqli_query($connection,$select);
		$data=mysqli_fetch_array($query);
		$Category=$data['CategoryName'];
	}
	if(isset($_POST['btnUpdate']))
	{
		$CategoryName=$_POST['txtCategory'];
		$CategoryID=$_POST['txtCategoryID'];

		$Update="UPDATE Category SET CategoryName='$CategoryName'
		Where CategoryID='$CategoryID'";
		$query=mysqli_query($connection,$Update);
		
		if ($query>0)
		{
			echo "<script>alert('Update Category Successful.')
			window.location='Category.php'
			</script>";
		}
	}
	include('Header.php');
?>
<html>
<head>

</head>
<body>
	<form action="UpdateCategory.php" method="POST">
	<section class="ftco-section contact-section ftco-degree-bg">
      <div class="container">
        <div class="row block-9">
          <div class="col-md-6 pr-md-5">
          	<h4 class="mb-4">Category</h4>
            
            	<input type="hidden" value="<?php echo $CategoryID ?>" name="txtCategoryID">
              <div class="form-group">
                  <input type="text" class="form-control" name="txtCategory" value='<?php echo $Category ?>' placeholder="Enter Category Name" required>
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
