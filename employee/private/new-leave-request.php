<?php 
$getdhr=mysqli_query($this->db,"SELECT * FROM `employees` WHERE `employee_role`='DRH'");
if (mysqli_num_rows($getdhr)>0) {

    while ($fetch_drh=mysqli_fetch_assoc($getdhr)) {
        $gettype=mysqli_query($this->db,"SELECT * FROM `leave_type` WHERE `lt_id`='$type'");
        if (mysqli_num_rows($gettype)>0) {
           $fetch_type=mysqli_fetch_assoc($gettype);
        }




if ($Whenstart=="Morning") {
    $strtwhen="Matin";
}elseif($Whenstart=="Afternoon"){
    $strtwhen="Après-midi";
}
if ($whenend=="Lunchtime") {
    $endwhen="Heure du déjeuner";
}elseif($whenend=="End Of Day"){
    $endwhen="Fin de journée";
}

$to=$fetch_drh['email'];
$subject="📅 Nouvelle Demande de Congé";
 $msg='<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Nouvelle Demande de Congé</title>
    <style>
        body {
            font-family: "Arial", sans-serif;
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
            color: #2c3e50;
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
        .footer, .copyright {
            margin-top: 30px;
            font-size: 14px;
            color: #666;
        }
        .copyright {
            font-size: 13px;
            text-align: center;
            color: #999;
            margin-top: 40px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="title">📅 Nouvelle Demande de Congé</div>

        <div class="content">
            Cher(e) <strong>'.$fetch_drh["fname"].' '.$fetch_drh["lname"].'</strong>,<br><br>

            Nous vous informons que <strong>'.$_SESSION["employeeFname"].' '.$_SESSION["employeeLname"].'</strong> a introduit(e) une nouvelle demande de congé. En voici les détails :
        </div>

        <div class="highlight">
            ● <strong>Type de congé :</strong> '.$fetch_type["leave_name"].'<br>
            ● <strong>Durée du congé :</strong> du '.$start.' / '.$strtwhen.' au '.$end.' / '.$endwhen.'
        </div>

        <div class="content">
            <strong>Action requise :</strong><br>
            Veuillez examiner cette demande et prendre les mesures nécessaires en vous rendant dans la section 
            <strong>« Gérer les vacances » → « Demandes de congé »</strong> de votre panel d\'administration.<br><br>

            Nous vous remercions de l’attention que vous porterez à cette demande.
        </div>

        <div class="footer">
            Je vous prie d’agréer, Madame, Monsieur, l’expression de mes salutations distinguées.
        </div>

        <div class="copyright">
            © 2025 Infinity Group Solutions – Tous droits réservés.
        </div>
    </div>
</body>
</html>';

$send=smtp_mailer($to,$subject, $msg);
        
    }


}


