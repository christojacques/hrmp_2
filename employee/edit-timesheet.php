<?php 
include_once 'private/protection.php';
$timeids=$_POST['timeid'];
$edittimequery=mysqli_query($db,"SELECT * FROM `daliy_timesheet` WHERE `ts_id`='$timeids'");

if (mysqli_num_rows($edittimequery)>0) {
	$fetch_timede=mysqli_fetch_assoc($edittimequery);


	


echo '<form  method="post">
              <div class="row">
                <div class="col mb-3">
                  <label for="nameBasic" class="form-label">Titre du projet / de la tâche</label>
                  <input type="text" name="title"  class="form-control" required placeholder="Type Titre du travail" value="'.$fetch_timede["project_title"].'">
                  <input type="hidden" name="timesheetid" value="'.$fetch_timede["ts_id"].'" hidden>
                </div>
                <div class="row">
                  <div class="col mb-3">
                    <label for="" class="form-label">Note de projet / de tâche</label>
                    <textarea  type="text" name="notes"  class="form-control" cols="50" placeholder="Type de note de travail">'.$fetch_timede["project_note"].'</textarea>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col mb-3">
                  <label for="" class="form-label">Heures de travail</label>
                  <input type="text" name="hours"  class="form-control" required  value="'.$fetch_timede["working_hours"].'"  pattern="([01]?[0-9]|2[0-3]):[0-5][0-9]" placeholder="0:00" title="Saisir une heure valide (par exemple, 2:0)">
                </div>
              </div>
              
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
              Fermer
              </button>
              <input type="submit" name="update_time" class="btn btn-primary btn-sm" value="Confirmer">
            </div>
          </form>';


}
 ?>