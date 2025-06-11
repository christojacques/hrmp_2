<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>PHP Calendar</title>
        
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    </head>
    <body>
        <?php
        // Initialize $monthCount and $currentYear if they're not set in the session
        $monthCount = isset($_SESSION['monthCount']) ? $_SESSION['monthCount'] : date("m");
        $currentYear = isset($_SESSION['year']) ? $_SESSION['year'] : date("Y");
        // Handle increment and decrement actions
        if (isset($_POST['increment'])) {
        $monthCount++;
        if ($monthCount > 12) {
        $monthCount = 1;
        $currentYear++;
        }
        } elseif (isset($_POST['decrement'])) {
        $monthCount--;
        if ($monthCount == 0) {
        $monthCount = 12;
        $currentYear--;
        }
        }
        // Update session variables
        $_SESSION['monthCount'] = $monthCount;
        $_SESSION['year'] = $currentYear;
        //echo $_SESSION['monthCount'];
        // Update session with the latest value
        date_default_timezone_set('Africa/Kinshasa');
        $currentDate = date('Y-m-D');
        //echo $currentDate;
        //$year=date("Y");
        $year=isset($_SESSION['year']) ? $_SESSION['year'] : date("Y");
        // echo '<br>';
        //$totalday=date("t");
        //$month=date("m");
        $today=date("d");
        $todayname=date("D");
        $month=$_SESSION['monthCount'];
        echo $today.'-'.$month.'-'.$year;
        $totalDays = cal_days_in_month(CAL_GREGORIAN, $month, $year);
        
        
        ?>
        <div class="container">
            <div class="row">
                <form method="post" class="mb-3">
                    <div class="btn-group" role="group" aria-label="Basic example">
                        <button type="submit" name="decrement" class="btn btn-outline-secondary"><i class="mdi mdi-arrow-left"></i></button>
                        <button type="submit" name="increment" class="btn btn-outline-secondary"><i class="mdi mdi-arrow-right"></i></button>
                        
                    </div>
                </form>
                
                <div class="col-md-12">
                    <div class="card table-responsive">
                        <div class="card-body">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Employee Name</th>
                                        <?php  for ($i =1; $i <= $totalDays ; ++$i) {
                                        $currentDate = date("D", strtotime("$year-$month-$i"));
                                        echo '<th>'.$currentDate.'</th>';
                                        }
                                        ?>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $employee=["Nazmul1","Nazmul2","Nazmul3","Nazmul4","Nazmul5"];
                                    foreach ($employee as $value) {?>
                                    <tr>
                                        <td><?=$value;?></td>
                                        <?php  for ($i =1; $i <= $totalDays ; ++$i) {
                                        $currentDate = date("D", strtotime("$year-$month-$i"));
                                        if ($currentDate=="Sat") {
                                        echo '<td style="background: #ddd;">'.$i.'</td>';
                                        }elseif ($currentDate=="Sun") {
                                        echo '<td style="background: #ddd;">'.$i.'</td>';
                                        }else{
                                        echo '<td>'.$i.'</td>';
                                        }
                                        }
                                        ?>
                                    </tr>
                                    <?php  }?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
        
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    </body>
</html>
<style>
body{
padding:10px;
}
table{
font-size: 15px;
text-align: center;
}
table tr th{
padding: 0px !important;
}
table tr td{
padding: 0px !important;
}
</style>