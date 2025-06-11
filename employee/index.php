<?php
include_once 'header.php';
include_once 'private/timesheet_function.php';
include_once 'private/weekly-apporved.php';
if ($ts_module==0) {
echo '<script>window.location.href="vacation-calendar";</script>';
}
?>
<div class="main-panel">
  <div class="content-wrapper">
    
    <div class="row">
      <div class="col-md-12 grid-margin">
        <div class="d-flex justify-content-between flex-wrap">
          <div class="d-flex flex-wrap">
            <div class="me-md-3 me-xl-5">
              <h2>Bienvenue, <?=$fetch_employee['fname'].' '.$fetch_employee['lname'];?></h2>
              
            </div>
            
          </div>
          <?php if ($ts_module!=0) {?>
          <div class="d-flex justify-content-between align-items-end flex-wrap">
            
            <button type="button" class="" data-bs-toggle="modal" data-bs-target="#basicModal" style="    padding: 0px;margin: 0px;border: none;">
            <i class="mdi mdi-plus-box btn-icon-prepend"style="font-size: 60px;color:green;"></i>
            </button>
          </div>
          <?php } ?>
        </div>
      </div>
    </div>
    <?php 
      if ($ts_module!=0) {
     ?>
    <div class="row">
      <div class="col-md-12">
        <div class="card table-responsive">
          <div class="card-body">
            <?php
            $clickCount = isset($_SESSION['clickCount']) ? $_SESSION['clickCount'] : 0;
            // Check if the button is clicked
            if (isset($_POST['increament'])) {
            // Increment the click count
            $clickCount++;
            // Update the session variable
            $_SESSION['clickCount'] = $clickCount;
            }
            if (isset($_POST['decriment'])) {
            // Decrement the click count only if it's greater than 0
            $clickCount--;
            // Update the session variable
            $_SESSION['clickCount'] = $clickCount;
            }

            $presentDate = date('Y-m-d');
            $currentDate2 = new DateTime();
            $currentDate3 = new DateTime();
            $currentDate = new DateTime();
            $currentDate->modify('this week');
            $currentDate2->modify('this week');
            $currentDate3->modify('this week');
            
            
            if (isset($_SESSION['clickCount'])) {
            if ($_SESSION['clickCount']>0) {
            $currentDate->modify(($clickCount >= 0 ? '+' : '') . $clickCount . ' week');
             $currentDate2->modify(($clickCount >= 0 ? '+' : '') . $clickCount . ' week');
             $currentDate3->modify(($clickCount >= 0 ? '+' : '') . $clickCount . ' week');
            }else{
            $currentDate->modify(($clickCount >= 0 ? '-' : '') . $clickCount . ' week');
             $currentDate2->modify(($clickCount >= 0 ? '-' : '') . $clickCount . ' week');
             $currentDate3->modify(($clickCount >= 0 ? '-' : '') . $clickCount . ' week');
            }
            }
             //echo $currentDate->format('Y-m-d');
            ?>
            <form method="post" class="mb-3">
              <div class="btn-group" role="group" aria-label="Basic example">
                <button type="submit" name="decriment" class="btn btn-outline-secondary"><i class="mdi mdi-arrow-left"></i></button>
                <button type="submit" name="increament" class="btn btn-outline-secondary"><i class="mdi mdi-arrow-right"></i></button>
                
              </div>
            </form>
            
            
            <!-- Add more tabs as needed -->
            <?php
            $totalHoursArray = array();
            $totalMinutesArray = array();
            for ($i = 0; $i < 7; $i++) {
            $result = $timesheet->weektimecounter($currentDate3);
            $dhours = $result['hours'];
            $dminutes = $result['minutes'];
            // Adjust for excess minutes
            $dhours += floor($dminutes / 60);
            $dminutes = $dminutes % 60;
            $totalHoursArray[] = $dhours;
            $totalMinutesArray[] = $dminutes;
            $currentDate3->modify('+1 day');
            }
            $weekhours = array_sum($totalHoursArray);
            $weekminutes = array_sum($totalMinutesArray);
            // Adjust for excess minutes for the week
            $weekhours += floor($weekminutes / 60);
            $weekminutes = $weekminutes % 60;
            ?>
            <h4 class="card-title" style="text-align:right;">Total des heures de travail hebdomadaire: <?=$weekhours.':'.$weekminutes;?></h4>
            
            <div class="nav-align-top mb-4">
              <?php
$daysInFrench = [
    'Mon' => 'Lun',
    'Tue' => 'Mar',
    'Wed' => 'Mer',
    'Thu' => 'Jeu',
    'Fri' => 'Ven',
    'Sat' => 'Sam',
    'Sun' => 'Dim'
];

$monthsInFrench = [
    'Jan' => 'Jan',
    'Feb' => 'Fév',
    'Mar' => 'Mar',
    'Apr' => 'Avr',
    'May' => 'Mai',
    'Jun' => 'Juin',
    'Jul' => 'Juil',
    'Aug' => 'Aoû',
    'Sep' => 'Sep',
    'Oct' => 'Oct',
    'Nov' => 'Nov',
    'Dec' => 'Déc'
];

?>

<ul class="nav nav-tabs" role="tablist" style="justify-content: space-between;">
    <?php
    for ($i = 0; $i < 7; $i++) {
        $dayEng = $currentDate->format('D'); // Get day abbreviation (e.g., "Mon")
        $monthEng = $currentDate->format('M'); // Get month abbreviation (e.g., "Jan")

        $dayFr = $daysInFrench[$dayEng] ?? $dayEng;
        $monthFr =  $monthEng;

        if ($currentDate->format('Y-m-d') == $presentDate) {
            $datastatus = "active";
        } else {
            $datastatus = "";
        }

        echo '
        <li class="nav-item">
            <button type="button" class="nav-link '.$datastatus.'" role="tab" 
                data-bs-toggle="tab" data-bs-target="#navs-top-'.$currentDate->format('D').'" 
                aria-controls="navs-top-'.$dayFr.'" aria-selected="true" 
                id="getdate" data-getdata="'.$currentDate->format('d-m-Y').'">
                '.$dayFr.', '.$currentDate->format('d').' '.$monthFr.'
            </button>
        </li>
        ';

        $currentDate->modify('+1 day');
    }
    ?>
              </ul>
              <form method="post">
                <input type="hidden" name="weekhours" value="<?=$weekhours;?>" hidden required>
                <input type="hidden" name="weekminutes" value="<?=$weekminutes?>" hidden required>
                <div class="tab-content">
                  <?php
                  for ($i = 0; $i < 7; $i++) {
                  if ($currentDate2->format('Y-m-d')==$presentDate) {
                  $datastatus2="active show";
                  }else{
                  $datastatus2="";
                  }
                  
                  echo '<div class="tab-pane fade '.$datastatus2.'" id="navs-top-'.$currentDate2->format('D').'" role="tabpanel">';
                    ?>
                    <table class="table table-bordered table-responsive">
                      <thead>
                        <tr>
                          <th>Titre du projet</th>
                          <th>Note de projet</th>
                          <th>Heures de travail</th>
                          <th>Action</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php
                        $tabsdate=$currentDate2->format('d-m-Y');
                        
                        echo $timesheet->showtimesheet($tabsdate);
                        ?>
                        <!-- <tr>
                          <td>This is title</td>
                          <td>this is about of note project</td>
                          <td>2:00</td>
                          <td>
                            <a href="" class="btn btn-sm btn-outline-primary">Edit</a>
                          </td>
                        </tr> -->
                      </tbody>
                    </table>
                    <?php
                  echo '</div>';
                  if ($i==0) {
                  $firstdate=$currentDate2->format('d-m-Y');
                  }
                  if ($i==6) {
                  $lastdate=$currentDate2->format('d-m-Y');
                  }
                  $currentDate2->modify('+1 day');
                  
                  }
                  $checkissub=mysqli_query($db,"SELECT * FROM `week_submission` WHERE `employee_id`='$employeeid' AND `ws_start_date`='$firstdate' AND `ws_end_date`='$lastdate'");
                  $checisit=mysqli_num_rows($checkissub);
                  if (empty($checisit)) {
                  // echo '<button type="submit" class="btn btn-primary btn-sm mt-5" name="weekapprove">Submit Week for approval</button>';
                  echo '<button type="button" class="btn btn-primary btn-sm mt-5" data-bs-toggle="modal" data-bs-target="#confirmsubmit">  Soumettre la semaine à l approbation  </button>';
                  }else{
                     $checkissub2=mysqli_query($db,"SELECT * FROM `week_submission` WHERE `employee_id`='$employeeid' AND `ws_start_date`='$firstdate' AND `ws_end_date`='$lastdate' AND  `ws_status`='DRH'");
                      
                       if (mysqli_num_rows($checkissub2)>0) {
                          echo '<button type="button" class="btn btn-primary btn-sm mt-5" data-bs-toggle="modal" data-bs-target="#confirmsubmit">  Soumettre la semaine à l approbation  </button>';
                       }

                  }
                  ?>
                  <input type="hidden" name="firstday"  value="<?=$firstdate;?>" required hidden>
                  <input type="hidden" name="lastday"  value="<?=$lastdate;?>" required hidden>
                  
                  
                </div>
                
                <div class="modal fade" id="confirmsubmit" tabindex="-1" style="display: none;" aria-hidden="ture">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel1">Êtes-vous sûr de vouloir soumettre votre demande à l'approbation ?</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                      </div>
                      <div class="modal-body">
                        <strong class="text-center">Attention :<br>
                        1.  Soumission finale : Une fois que vous avez soumis votre feuille de temps pour la semaine, vous ne pouvez plus la modifier. Assurez-vous que toutes les entrées sont complètes et exactes pour l'ensemble de la semaine (du lundi au dimanche) avant de les soumettre.<br><br>
                        2.  Moment de la fin de la semaine : Idéalement, soumettez votre feuille de temps à la fin de votre semaine de travail. Si vous la soumettez trop tôt, le suivi de vos heures hebdomadaires risque d'être incomplet.
                        <br><br>
                        N'oubliez pas que ce processus est essentiel pour une gestion précise de la charge de travail et de la rémunération. Votre diligence est appréciée.</strong>
                        
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#yessubmit">Oui</button>
                      </div>
                    </div>
                  </div>
                </div>
                 <div class="modal fade" id="yessubmit" tabindex="-1" style="display: none;" aria-hidden="ture">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel1">Souhaitez-vous toujours soumettre votre feuille de temps hebdomadaire ?</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                      </div>
                      <div class="modal-body">
                        <div class="row">
                          <div class="col-md-3"></div>
                          <div class="col-md-4">
                            <img src="images/time-sheet.png" alt="time-sheet.png" width="200">
                          </div>
                          <div class="col-md-4"></div>
                        </div>
                      </div>
                      <div class="modal-footer">
                        <button type="submit" class="btn btn-primary btn-sm" name="weekapprove">Oui, soumettre une feuille de temps</button>
                      </div>
                    </div>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
    <?php } ?>
    <div class="modal fade" id="basicModal" tabindex="-1" style="display: none;" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel1">Nouvelle saisie de temps</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <form  method="post">
              <div class="row">
                <div class="col mb-3">
                  <label for="nameBasic" class="form-label">Titre du projet / de la tâche</label>
                  <input type="text" name="title"  class="form-control" required placeholder="Type Titre du travail">
                </div>
                <div class="row">
                  <div class="col mb-3">
                    <label for="" class="form-label">Note de projet / de tâche</label>
                    <textarea  type="text" name="notes"  class="form-control" cols="50" placeholder="Type de note de travail"></textarea>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col mb-3">
                  <label for="" class="form-label">Date de travail</label>
                  <input type="text" id="datepic" class="form-control" name="date" pattern="(0[1-9]|[12][0-9]|3[01])-(0[1-9]|1[0-2])-[0-9]{4}" required>
                </div>
                <div class="col mb-3">
                  <label for="" class="form-label">Heures travaillées</label>
                  <input type="text" name="hours"  class="form-control" required pattern="([01]?[0-9]|2[0-3]):[0-5][0-9]" placeholder="00:00" title="Saisir une heure valide (par exemple, 2:0)" value="00:00">
                </div>
              </div>
              
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
               Fermer
              </button>
              <input type="submit" name="add_time" class="btn btn-primary btn-sm" value="Confirmer">
            </div>
          </form>
        </div>
      </div>
    </div>
    <div class="modal fade" id="updatetimesheet" tabindex="-1" style="display: none;" aria-hidden="ture">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel1">Mettez à jour votre feuille de temps</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body" id="editmodel">
            
          </div>
        </div>
      </div>
    </div>
    <style>
    .form-control {
    background: #ddddddb5;
    border-radius: 5px;
    border: 1px solid #ddddddb5;
    }
    .tab-content > .active{
    border: 1px solid #ddddddb5;
    /*     background: #ddddddb5; */
    }
    .nav-tabs .nav-item .nav-link.active {
    border: 1px solid #ddddddb5;
    border-bottom: none;
    /*     background: #ddddddb5; */
    
    }
    /*   ul.nav.nav-tabs li {
    margin-right: 8px;
    } */
    </style>
    <!-- content-wrapper ends -->
    <script type="text/javascript" src="https://code.jquery.com/jquery-3.7.0.js"></script>
    <script type="text/javascript" src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>
    <script type="text/javascript">
    $(".btn-close").on('click', function() {
    $("#updatetimesheet").hide();
    });
    $(document).on("click", "#edit-time",function() {
    $("#updatetimesheet").show();
    var timesid=$(this).data("edit");
    $.ajax({
    url: 'edit-timesheet.php',
    type: 'post',
    data: {timeid: timesid},
    success: function (data) {
    //console.log(data)
    $("#editmodel").html(data);
    }
    });
    });
    $(document).on('click', '#getdate', function() {
      var dateget=$(this).data("getdata");
      $("#datepic").val(dateget);
      //console.log(dateget);
    });
    $.noConflict();
    jQuery(document).ready(function($) {
    $("#datepic").datepicker({
    dateFormat: "dd-mm-yy"
    });
    });


    $(document).on('click', '#getdate', function() {
    var dayFr = $(this).data('bs-target').split('-')[3]; // Extract the day abbreviation (Lun, Mar, etc.)
    var tabId = '#navs-top-' + dayFr;  // Create the tab id
    console.log(tabId);  // For testing, you can log the ID
    
    // Now you can access the tab or its content by id
    var tabContent = $(tabId);  // Access the tab content
    console.log(tabContent);  // You can perform any other operations here

    // Optionally, show the tab
    $(tabId).tab('show');
});

    </script>


    <script>
    // Add event listener to the delete links
    const deleteLinks = document.querySelectorAll('.delete-link');
    deleteLinks.forEach(link => {
        link.addEventListener('click', function(event) {
            event.preventDefault(); // Prevent default link behavior (i.e., navigating to the URL)

            const gid = this.getAttribute('data-ltid'); // Retrieve the 'gid' attribute value

            // Display SweetAlert confirmation dialog
            Swal.fire({
                title: "Confirmation de suppression Êtes-vous sûr de vouloir supprimer votre demande ? Cette action est irréversible.",
                showCancelButton: true,
                confirmButtonText: "Confirmer",
                cancelButtonText: "Annuler",
                icon: "warning",
                dangerMode: true,
            }).then((result) => {
                if (result.isConfirmed) {
                    // If user confirms deletion, proceed with navigating to the deletion URL
                    window.location.href = this.href + "&gid=" + gid;
                } else {
                    // If user cancels deletion, do nothing
                    // Alternatively, you can display a message or perform other actions
                }
            });
        });
    });
</script>
</div>
    <?php include_once 'footer.php'; ?>