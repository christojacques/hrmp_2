<?php 
include 'private/db.php';
include_once 'private/email_function.php';

function sendWeeklySubmissionAlert() {
    global $db;

    // Check if the module is active
    $modulesquery = mysqli_query($db, "SELECT * FROM `modules` WHERE `mf_id` = 8");
    $fetc_mod = mysqli_fetch_assoc($modulesquery);

    if ($fetc_mod['module_status'] != 0) {

        // Fetch active employees excluding CEO
        $sql = "SELECT `fname`, `lname`, `email` FROM `employees` WHERE `account_status` = 'active' AND `employee_role` != 'CEO'";
        $stmt = $db->prepare($sql);
        $stmt->execute();
        $data = $stmt->get_result();
        $result = $data->fetch_all(MYSQLI_ASSOC);

        // Get start and end of current week
        $weekInfo = getCurrentWeekStartAndEndDate();

        // Loop through employees
        foreach ($result as $employee) {
            $to = $employee['email'];
            $subject = "Rappel – Merci de compléter votre feuille de temps cette semaine";

            $msg = '
            <!DOCTYPE html>
            <html lang="fr">
            <head>
              <meta charset="UTF-8">
              <title>' . $subject . '</title>
            </head>
            <body style="font-family: Arial, sans-serif; background-color: #f9f9f9; padding: 20px; color: #333;">
              <table width="100%" cellpadding="0" cellspacing="0" style="max-width: 600px; margin: auto; background-color: #ffffff; border-radius: 8px; box-shadow: 0 2px 5px rgba(0,0,0,0.1);">
                <tr>
                  <td style="padding: 20px;">
                    <h2 style="color: #4CAF50;">📌 ' . $subject . '</h2>
                    <p>Bonjour <strong>' . htmlspecialchars($employee['fname']) . ' ' . htmlspecialchars($employee['lname']) . '</strong>,</p>
                    <p>Ceci est un rappel automatique : merci de compléter votre feuille de temps pour la semaine en cours <strong>du ' . $weekInfo["start"] . ' au ' . $weekInfo["end"] . '</strong>.</p>

                    <h3 style="color: #4CAF50;">📌 Comment faire ?</h3>
                    <ol>
                      <li>Connectez-vous à votre espace collaborateur sur la plateforme.</li>
                      <li>Accédez à l’onglet <strong>« Feuilles de temps »</strong>.</li>
                      <li>Cliquez sur le symbole <strong>➕</strong> vert en haut à droite pour ajouter vos tâches.</li>
                    </ol>

                    <p>Pensez à détailler correctement les tâches effectuées et à valider votre saisie avant la fin de la journée.</p>
                    <p>Merci de votre rigueur – cela nous permet de garantir une gestion efficace et transparente du temps de travail et de la paie.</p>
                    <p style="margin-top: 30px;">Bien cordialement,</p>
                    <p>L’équipe RH</p>
                  </td>
                </tr>
              </table>
            </body>
            </html>';

            smtp_mailer($to, $subject, $msg);
        }

        return "Emails sent.";
    } else {
        return "Module inactive.";
    }
}

// Helper function to get current week range
function getCurrentWeekStartAndEndDate() {
    $today = new DateTime();
    $week = $today->format("W");
    $year = $today->format("o");

    $dto = new DateTime();
    $dto->setISODate($year, $week);
    $start = $dto->format('d-m-Y');
    $dto->modify('+6 days');
    $end = $dto->format('d-m-Y');

    return ['start' => $start, 'end' => $end, 'week' => $week, 'year' => $year];
}

// Only run on Friday at 10:05
$time = date('H:i');
$daynm = date('D');

if ($time === '10:05' && $daynm === 'Fri') {
    echo sendWeeklySubmissionAlert();
}elseif($time === '14:05' && $daynm === 'Fri'){
    echo sendWeeklySubmissionAlert();
}
?>
