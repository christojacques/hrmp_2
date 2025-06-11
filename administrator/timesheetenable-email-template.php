<?php
include_once 'private/email_function.php';
$get = "SELECT `ws`.`ws_id`, `ws`.`employee_id`,`ws`.`ws_start_date`, `ws`.`ws_end_date`, `e`.`fname`,`e`.`lname`,`e`.`email` FROM `week_submission` AS `ws` JOIN `employees` AS `e` ON `e`.`eid`=`ws`.`employee_id` WHERE `ws_id`=?";
$query = $db->prepare($get);
$query->bind_param('i',$subweekid);
$query->execute();
$data= $query->get_result();
$result = $data->fetch_assoc();

$to=$result["email"];
$subject="📨 Possibilité d’ajustements de votre feuille de temps";
$msg='<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Possibilité d’ajustements de votre feuille de temps</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            color: #333;
            background-color: #f4f4f4;
            padding: 0;
            margin: 0;
        }
        .container {
            max-width: 600px;
            margin: 30px auto;
            background-color: #ffffff;
            padding: 20px 30px;
            border-radius: 8px;
            box-shadow: 0 2px 6px rgba(0,0,0,0.1);
        }
        .header {
            text-align: center;
            font-size: 22px;
            font-weight: bold;
            color: #2c3e50;
            margin-bottom: 20px;
        }
        .section {
            font-size: 16px;
            line-height: 1.6;
        }
        .important {
            background-color: #fff3cd;
            border-left: 5px solid #ffc107;
            padding: 10px 15px;
            margin: 20px 0;
        }
        .steps {
            margin-top: 15px;
            padding-left: 20px;
        }
        .footer {
            margin-top: 30px;
            font-size: 14px;
            color: #777;
            text-align: center;
        }
        .emoji {
            font-size: 18px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">📨 Possibilité d’ajustements de votre feuille de temps</div>

        <div class="section">
            Bonjour <strong>'.$result["fname"].' '.$result["lname"].'</strong>,<br><br>
            Votre responsable vous a accordé la possibilité d’ajuster votre feuille de temps pour la semaine du <strong>'.date("d-M-Y",strtotime($result["ws_start_date"])).' au '.date("d-M-Y",strtotime($result["ws_end_date"])).'</strong>.
        </div>

        <div class="important">
            <strong>⛔ Important :</strong><br>
            Vous ne pourrez pas modifier les entrées déjà soumises, mais vous pouvez ajouter des tâches complémentaires si certaines ont été oubliées.
        </div>

        <div class="section">
            <strong>📌 Comment procéder ?</strong>
            <ol class="steps">
                <li>Connectez-vous à votre espace collaborateur.</li>
                <li>Accédez à l’onglet « Feuilles de temps ».</li>
                <li>Cliquez sur le symbole ➕ vert en haut à droite pour ajouter les tâches manquantes à la semaine concernée.</li>
            </ol>
            Nous vous invitons à compléter ces ajouts dès que possible.<br><br>
            Merci de votre réactivité.
        </div>

        <div class="footer">
           © 2025 Infinity Group Solutions – Tous droits réservés.
        </div>
    </div>
</body>
</html>';


smtp_mailer($to, $subject, $msg);

?>