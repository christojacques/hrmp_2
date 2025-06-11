<?php 

if (isset($_POST['password']) && isset($_POST['security'])) {
	if (password_verify($_POST['password'], $_POST['security'])) {
		echo true;
	}else{
		echo false;
	}
}



 ?>