<?php 
include_once 'employee/private/db.php';
$gmodulessql=mysqli_query($db,"SELECT * FROM `modules` WHERE `mf_id`=1");
if (mysqli_num_rows($gmodulessql)>0) {
    $gfetchmodule=mysqli_fetch_assoc($gmodulessql);
}

$emodulessql=mysqli_query($db,"SELECT * FROM `modules` WHERE `mf_id`=6");
if (mysqli_num_rows($emodulessql)>0) {
    $efetchmodule=mysqli_fetch_assoc($emodulessql);
}

 ?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HR Management System</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f8f9fa;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0;
        }
        .login-container {
            width: 100%;
            max-width: 400px;
            padding: 20px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
            background-color: white;
            text-align: center;
        }
        .login-container h1 {
            margin-bottom: 30px;
            font-size: 28px;
        }
        .login-btn {
            width: 100%;
            margin: 10px 0;
        }
    </style>
</head>
<body>
<div class="login-container">
    <h1>Sélectionner votre profil</h1>
    <h1>Main Page</h1>
    <?php 
    if ($gfetchmodule['module_status']!='0') {
        echo '<a href="guard/index" class="btn btn-warning login-btn" >Gardien</a>';
    }
    if ($efetchmodule['module_status']!='0') {
        echo ' <a href="employee/index" class="btn btn-primary login-btn" >Collaborateur</a>';
    }
    ?>
    <a href="administrator/index" class="btn btn-success login-btn">Administrateur</a>
</div>

</body>
</html>