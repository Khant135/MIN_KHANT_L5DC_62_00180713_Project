<?php
  session_start();
  include('Connect.php');
  include('Header.php');

  if (isset($_POST['btnRegister']))
{
  $MemberType=$_POST['txtMemberType'];
  $AllowlanceItemAmount=$_POST['txtAllowlanceItemAmount'];
  $CardCost=$_POST['txtCardCost'];
  
  $select="select * from MemberType Where MemberType='$MemberType'";
  $ret=mysqli_query($connection,$select);
  $count=mysqli_num_rows($ret);
  if($count>0)
  {
    echo '<script>window.alert("MemberType Already Exists")</script>';
    echo '<script>window.location="MemberType.php"</script>';
  }
  else
  {
    $insert="INSERT into MemberType(MemberType,AllowlanceItemAmount,CardCost)
    values('$MemberType','$AllowlanceItemAmount','$CardCost')";
    $ret=mysqli_query($connection,$insert);
    if($ret>0)
    {
      echo '<script>window.alert("MemberType Register Successfully!")</script>';
      echo '<script>window.location="MemberType.php"</script>';
    }
    else
    {
      echo "<p>Something went wrong.".mysqli_error($connection)."</p>";
    }
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

<form action="MemberType.php" method="POST">
<section class="ftco-section contact-section ftco-degree-bg">
      <div class="container">

        <div class="row block-9">
          <div class="col-md-6 pr-md-5">
          	<h4 class="mb-4">MemberType</h4>
            
              <div class="form-group">
                  <input type="text" class="form-control" name="txtMemberType" placeholder="Enter MemberType" required>
              </div>
              <div class="form-group">
                  <input type="text" class="form-control" name="txtAllowlanceItemAmount" placeholder="Enter AllowlanceItemAmount" required>
              </div>
              <div class="form-group">
                  <input type="text" class="form-control" name="txtCardCost" placeholder="Enter CardCost" required>
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
      <legend>MemberType List:</legend>
      <?php
        $query="SELECT * from MemberType ORDER BY MemberTypeID DESC" ;
        $ret=mysqli_query($connection,$query);
        $count=mysqli_num_rows($ret);
        if($count==0)
        {
          echo "<p>No MemberType Record Found.</p>";
          exit();
        }
      ?>
      <table border="1px">
        <tr>
          <td>MemberTypeID</td>
          <td>MemberType</td>
          <td>AllowlanceItemAmount</td>
          <td>CardCost</td>
          <td>Action</td>
        </tr>

        <?php
        for ($i=0; $i < $count ; $i++) 
        { 
          $data=mysqli_fetch_array($ret);
          $MemberTypeID=$data['MemberTypeID'];
          $MemberType=$data['MemberType'];
          $AllowlanceItemAmount=$data['AllowlanceItemAmount'];
          $CardCost=$data['CardCost'];
          echo "<tr>";
          echo "<td>$MemberTypeID</td>";
          echo "<td>$MemberType</td>";
          echo "<td>$AllowlanceItemAmount</td>";
          echo "<td>$CardCost</td>";
          echo "<td>
              <a href='DeleteMemberType.php ?MemberTypeID=$MemberTypeID'>Delete</a>|
              <a href='UpdateMemberType.php ?MemberTypeID=$MemberTypeID'>Update</a>
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