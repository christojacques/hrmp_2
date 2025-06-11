<?php
include_once 'email_function.php';
$getdrhid=mysqli_query($this->db,"SELECT * FROM `employees` WHERE `employee_role`='DRH'");
if (mysqli_num_rows($getdrhid)>0) {
	while($fetch_drh=mysqli_fetch_assoc($getdrhid)){
	$to=$fetch_drh['email'];
	$subject="Demande d’accès collaborateur";
	$msg='<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Demande d’accès collaborateur</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background-color: #f4f6f8;
      margin: 0;
      padding: 0;
      color: #333;
    }
    .container {
      max-width: 600px;
      margin: 40px auto;
      background-color: #ffffff;
      padding: 30px;
      border-radius: 8px;
      box-shadow: 0 2px 6px rgba(0,0,0,0.1);
    }
    .header {
      background-color: #004085;
      color: #ffffff;
      padding: 20px;
      border-radius: 8px 8px 0 0;
      text-align: center;
      font-size: 18px;
      font-weight: bold;
    }
    .content {
      padding: 20px;
      line-height: 1.6;
    }
    
    .footer {
      font-size: 12px;
      color: #777;
      text-align: center;
      padding: 20px 0 0;
    }
  </style>
</head>
<body>
  <div class="container">
    <div class="header">
      Demande d’accès collaborateur
    </div>
    <div class="content">
      <p>Bonjour <strong>'.$fetch_drh["fname"].' '.$fetch_drh["lname"].'</strong>,</p>
      <p><strong>'.$fname.' '.$lname.'</strong> vient de soumettre une demande pour rejoindre votre structure via la plateforme Ressources Humaines.</p>
      <p>Pour consulter les informations soumises et valider (ou refuser) cette demande, veuillez vous rendre dans :</p>
      <p><strong>Votre espace Administrateur → Collaborateurs → Gérer les collaborateurs</strong></p>
      <p>Le collaborateur apparaîtra avec le statut <strong>“En attente”</strong>.</p>
      <p>Merci de traiter cette demande dans les plus brefs délais.</p>
    </div>
    <div class="footer">
      © 2025 Infinity Group Solutions. Tous droits réservés.
    </div>
  </div>
</body>
</html>';



smtp_mailer($to,$subject, $msg);


}
}
?>