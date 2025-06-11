<?php 

$getempl=mysqli_query($this->db,"SELECT * FROM `employees` WHERE `eid`='$empid'");
$fetch_employee=mysqli_fetch_assoc($getempl);

$lrreqed=mysqli_query($this->db,"SELECT `start_date`, `end_date`, `start_part`, `end_part`, `commment`,`leave_name` FROM `leave_request` JOIN `leave_type` ON `leave_type`.`lt_id`=`leave_request`.`leave_type` WHERE `lr_id`='$lrid'");
$fetch_lrreqed=mysqli_fetch_assoc($lrreqed);
$to=$fetch_employee["email"];



$starlev=$fetch_lrreqed['start_part'];
$endlev=$fetch_lrreqed['end_part'];

if ($starlev=="Morning") {
    $strtwhen="Matin";
}elseif($starlev=="Afternoon"){
    $strtwhen="Après-midi";
}
if ($endlev=="Lunchtime") {
    $endwhen="Heure du déjeuner";
}elseif($endlev=="End Of Day"){
    $endwhen="Fin de journée";
}




if ($status1=="Approved") {
 $subject='Votre demande de congé a été approuvée 🎉';  
 $msg='<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Demande de congé approuvée</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f6f6f6;
            margin: 0;
            padding: 0;
            color: #333;
        }
        .container {
            max-width: 650px;
            margin: 30px auto;
            background-color: #ffffff;
            padding: 30px 40px;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        .title {
            font-size: 22px;
            font-weight: bold;
            color: #27ae60;
            margin-bottom: 25px;
        }
        .content {
            font-size: 16px;
            line-height: 1.7;
        }
        .highlight {
            background-color: #e9f7ef;
            padding: 12px 15px;
            border-left: 5px solid #28a745;
            margin: 20px 0;
        }
        .footer {
            margin-top: 30px;
            font-size: 14px;
            color: #666;
        }
        .hr-comment {
            background-color: #f0f0f0;
            padding: 12px;
            border-left: 4px solid #aaa;
            margin-top: 10px;
            font-style: italic;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="title">📌 Votre demande de congé a été approuvée 🎉</div>

        <div class="content">
            Bonjour <strong>'.$fetch_employee["fname"].' '.$fetch_employee["lname"].'</strong>,<br><br>
            Bonne nouvelle ! Votre demande de congé a été approuvée.<br><br>
            <strong>Voici les détails de votre congé :</strong>
        </div>

        <div class="highlight">
            ● <strong>Type de congé :</strong> '.$fetch_lrreqed["leave_name"].'<br>
            ● <strong>Durée du congé :</strong> du '.$fetch_lrreqed["start_date"].' / '.$strtwhen.' au '.$fetch_lrreqed["end_date"].' / '.$endwhen.'
        </div>

        <div class="content">
            <strong>💬 Commentaire du/de la RH :</strong>
            <div class="hr-comment">
                '.$fetch_lrreqed["commment"].'
            </div>

            Nous vous souhaitons une excellente période de repos !<br>
            À bientôt.
        </div>

        <div class="footer" style="text-align: center; margin-top: 40px; font-size: 13px; color: #999;">
            © 2025 Infinity Group Solutions – Tous droits réservés.
        </div>
    </div>
</body>
</html>';   
}elseif($status1=="Rejected"){
$subject='Votre demande de congé a été refusée';  
 $msg='<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Demande de congé refusée</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f6f6f6;
            margin: 0;
            padding: 0;
            color: #333;
        }
        .container {
            max-width: 650px;
            margin: 30px auto;
            background-color: #ffffff;
            padding: 30px 40px;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        .title {
            font-size: 22px;
            font-weight: bold;
            color: #c0392b;
            margin-bottom: 25px;
        }
        .content {
            font-size: 16px;
            line-height: 1.7;
        }
        .highlight {
            background-color: #fdecea;
            padding: 12px 15px;
            border-left: 5px solid #e74c3c;
            margin: 20px 0;
        }
        .footer {
            margin-top: 30px;
            font-size: 14px;
            color: #666;
        }
        .hr-comment {
            background-color: #fdf4f4;
            padding: 12px;
            border-left: 4px solid #e67e22;
            margin-top: 10px;
            font-style: italic;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="title">📌 Votre demande de congé a été refusée</div>

        <div class="content">
            Bonjour <strong>'.$fetch_employee["fname"].' '.$fetch_employee["lname"].'</strong>,<br><br>
            Votre demande de congé a été refusée.<br><br>
            <strong>Voici les détails de votre demande :</strong>
        </div>

        <div class="highlight">
            ● <strong>Type de congé :</strong> '.$fetch_lrreqed["leave_name"].'<br>
            ● <strong>Durée du congé :</strong> du '.$fetch_lrreqed["start_date"].' / '.$strtwhen.' au '.$fetch_lrreqed["end_date"].' / '.$endwhen.'
        </div>

        <div class="content">
            <strong>💬 Commentaire du/de la RH :</strong>
            <div class="hr-comment">
                '.$fetch_lrreqed["commment"].'
            </div><br>

            Nous vous invitons à prendre contact avec le service RH ou votre responsable pour toute précision complémentaire ou à soumettre une nouvelle demande à une autre date.<br><br>
            Merci pour votre compréhension.
        </div>

        <div class="footer" style="text-align: center; margin-top: 40px; font-size: 13px; color: #999;">
            © 2025 Infinity Group Solutions – Tous droits réservés.
        </div>
    </div>
</body>
</html>';
}




smtp_mailer($to,$subject, $msg);





 ?>