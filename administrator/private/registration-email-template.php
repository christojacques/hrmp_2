<?php
include_once 'email_function.php';
$get = "SELECT eid,fname,lname,email,account_status FROM `employees` WHERE `account_status` = '' AND `eid` = ?";
$query = $this->db->prepare($get);
$query->bind_param('i',$emid);
$query->execute();
$data= $query->get_result();
$result = $data->fetch_assoc();

if ($result && $result['account_status'] == '') {
$fullname = $result['fname'] . ' ' . $result['lname'];
$to = $result['email'];
if ($status == 'active') {
$subject = "Votre compte a été validé – Bienvenue sur la plateforme";
$msg = '
<!DOCTYPE html>
<html lang="fr">
  <head>
    <meta charset="UTF-8">
    <title>Votre compte a été validé</title>
    <style>
    body { font-family: "Segoe UI", sans-serif; background-color: #f2f4f7; margin: 0; padding: 0; color: #333; }
    .container { max-width: 600px; margin: 40px auto; background-color: #ffffff; border-radius: 8px; box-shadow: 0 4px 10px rgba(0,0,0,0.05); overflow: hidden; }
    .header { background-color: #28a745; color: #ffffff; padding: 20px; text-align: center; font-size: 20px; font-weight: bold; }
    .content { padding: 30px 20px; line-height: 1.7; }
    .footer { text-align: center; font-size: 12px; color: #888; padding: 20px; }
    </style>
  </head>
  <body>
    <div class="container">
      <div class="header">✅ Votre compte a été validé – Bienvenue sur la plateforme</div>
      <div class="content">
        <p>Bonjour <strong>' . $fullname . '</strong>,</p>
        <p>Bonne nouvelle ! Votre demande d’inscription a été validée par votre responsable.</p>
        <p>Votre compte est désormais <strong>actif</strong>. Vous pouvez vous connecter à la plateforme à l’aide de l’adresse email utilisée lors de l’inscription, ainsi que du mot de passe que vous avez créé au moment du remplissage du formulaire.</p>
        <p>Si vous avez oublié votre mot de passe, vous pouvez utiliser la fonction <strong>« Mot de passe oublié »</strong> sur la page de connexion.</p>
        <p>Bienvenue sur la plateforme !</p>
      </div>
      <div class="footer">© 2025 Infinity Group Solutions – Tous droits réservés.</div>
    </div>
  </body>
</html>';
} elseif ($status == 'inactive') {
$subject = "Votre demande d’accès à la plateforme a été refusée";
$msg = '
<!DOCTYPE html>
<html lang="fr">
  <head>
    <meta charset="UTF-8">
    <title>Demande d’accès refusée</title>
    <style>
    body { font-family: "Segoe UI", sans-serif; background-color: #f2f4f7; margin: 0; padding: 0; color: #333; }
    .container { max-width: 600px; margin: 40px auto; background-color: #ffffff; border-radius: 8px; box-shadow: 0 4px 12px rgba(0,0,0,0.05); overflow: hidden; }
    .header { background-color: #dc3545; color: #ffffff; padding: 20px; text-align: center; font-size: 20px; font-weight: bold; }
    .content { padding: 30px 20px; line-height: 1.7; }
    .footer { text-align: center; font-size: 12px; color: #888; padding: 20px; }
    </style>
  </head>
  <body>
    <div class="container">
      <div class="header">❌ Votre demande d’accès à la plateforme a été refusée</div>
      <div class="content">
        <p>Bonjour <strong>' . $fullname . '</strong>,</p>
        <p>Nous vous informons que votre demande d’inscription à la plateforme a été <strong>refusée</strong> par votre responsable.</p>
        <p>Pour toute précision ou pour connaître les raisons de ce refus, nous vous invitons à contacter directement votre responsable RH ou l’administrateur de la structure.</p>
        <p>Merci de votre compréhension.</p>
      </div>
      <div class="footer">© 2025 Infinity Group Solutions – Tous droits réservés.</div>
    </div>
  </body>
</html>';
}
// Send the email
smtp_mailer($to, $subject, $msg);
}
?>