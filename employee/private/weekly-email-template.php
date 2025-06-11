<?php
include_once 'email_function.php';
$getdrhid=mysqli_query($this->db,"SELECT * FROM `employees` WHERE `employee_role`='DRH'");
if (mysqli_num_rows($getdrhid)>0) {
	while($fetch_drh=mysqli_fetch_assoc($getdrhid)){
	$to=$fetch_drh['email'];
	$empname=$_SESSION['employeeFname']." ".$_SESSION['employeeLname'];
	$subject="Soumission des feuilles de temps hebdomadaires par ".$empname;
	$msg='
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Soumission des feuilles de temps hebdomadaires</title>
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
            background-color: #f0f8ff;
            padding: 12px 15px;
            border-left: 4px solid #3498db;
            margin: 20px 0;
        }
        ol {
            padding-left: 20px;
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
        .emoji {
            font-size: 17px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="title">📝 Soumission des feuilles de temps hebdomadaires</div>

        <div class="content">
            Cher(e) <strong>'.$fetch_drh["fname"].' '.$fetch_drh["lname"].'</strong>,<br><br>

            La présente a pour but de vous informer que la feuille de temps de 
            <strong>'.$_SESSION["employeeFname"].' '.$_SESSION["employeeLname"].'</strong> a été soumise pour la semaine se terminant le <strong>'.$lastday.'</strong>.<br><br>

            Veuillez vous assurer que cette feuille de temps reflète correctement toutes les heures que ce/cette collaborateur(-trice) a travaillées au cours de cette période.
        </div>

        <div class="highlight">
            ● <strong>Date de début et de fin de la semaine :</strong> du '.$firstday.' au '.$lastday.'<br>
            ● <strong>Temps total enregistré :</strong>'.$toweekhours.' heure '.$toweekminute.' minute.
        </div>

        <div class="content">
            <strong>🔎 Où consulter cette feuille de temps ?</strong>
            <ol>
                <li>Accédez à la section « Collaborateurs » de votre panel d’administration.</li>
                <li>Cliquez sur « Rapport hebdomadaire ».</li>
                <li>Dans le calendrier, sélectionnez la semaine concernée : <strong>du '.$firstday.' au '.$lastday.'</strong>.</li>
                <li>Cliquez sur le nom de <strong>'.$fetch_drh["fname"].' '.$fetch_drh["lname"].'</strong> pour accéder à sa feuille de temps détaillée.</li>
            </ol>
        </div>

        <div class="highlight">
            <strong>Remarques importantes :</strong><br>
            ● Veuillez relancer les collaborateur(-trice)s dont les feuilles de temps sont en attente afin de garantir une soumission dans les délais.
            
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



smtp_mailer($to,$subject, $msg);


}
}
?>