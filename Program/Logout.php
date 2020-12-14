<?php 
	session_start();
	session_destroy();
	echo" 
        <script>
          alert('LogOut Successful!!')
          window.location='Login.php';
        </script>";

 ?>