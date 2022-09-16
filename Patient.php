<?php
ob_start();
$db = new DB_Connect();

if (!isset($_SESSION['Patient_ID']) && empty($_SESSION['Patient_ID'])) {
    header("Location: index.php");
} else {
    //$path = basename($_SERVER['PHP_SELF'], ".php");
    if ($path == "PProfile") {
        $ID = $_SESSION['Patient_ID'];
        
        if (isset($_POST["update"])) {
            $fname = $_POST['FName'];
            $lname = $_POST['LName'];
            $Email = $_POST['Email'];
            $PNum = $_POST['PNum'];
            $Address = $_POST['Address'];
            $PostalCode = $_POST['PostalCode'];


            $stmt = $db->connectWix()->prepare("UPDATE `wixPatients` set `First_Name` = ?, `Last_Name` = ?, `Email` = ?, `Phone_Num` = 
            ?, `Address` = ?, `postal_code` = ? where `Patient_ID` = ?");
            $stmt->execute([$fname,$lname,$Email,$PNum,$Address,$PostalCode,$ID]);
            if ($stmt->rowCount() > 0) {
                $_SESSION['alert'] = '<div class="alert alert-success" role="alert-msg" id="alert">Your information has been successfully updated! <i class="bi bi-person-check"></i></div>';
                //echo '<meta http-equiv="refresh" content="1">';
            } else {
                $_SESSION['alert'] = '<div class="alert alert-danger" role="alert-msg">Error! Please try again <i class="bi bi-person-check"></i></div>';
            }
        }

        $stmt = $db->connectWix()->prepare("SELECT * FROM wixPatients where Patient_ID = ?");
        // print_r($stmt);
        $stmt->execute([$ID]);

        if ($stmt->rowCount() > 0) {
            $patientInfo = $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
    }
    if ($path == "PatientDashboard") {
        $stmt = $db->connect()->prepare("SELECT user_table.First_Name, user_table.Last_Name, user_table.Specialization, user_table.Company, user_table.Emp_ID, wixClients.clinic_address, wixClients.postal_code FROM dentianDatabase.user_table inner join wixDatabase.wixClients on user_table.Company = wixClients.clinic_name where user_table.Role = 'Dentist';");
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $schedules = $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
    }
    if ($path == "calendar") {
        function build_calendar($month, $year)
        {
            $db = new DB_Connect();
            $dentistID = $_GET['DentistID'];
            $patID = $_SESSION['Patient_ID'];

            $stmt = $db->connect()->prepare("SELECT * from appointment_table where MONTH(appt_date) = $month and YEAR(appt_date) = $year and patient_id = $patID");

            $bookings = array();

            if ($stmt->execute()) {
                if ($stmt->rowCount() > 0) {
                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        $bookings[] = $row['appt_date'];
                    }
                }
            }
            $daysofWeek = array('Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday');
            // what is the first day of the month in question
            $firstDayofMonth = mktime(0, 0, 0, $month, 1, $year);
            // how many days does this month contain
            $numberDays = date('t', $firstDayofMonth);

            // retrieve some info about the first day of the month
            $dateComponents = getdate($firstDayofMonth);

            // what is the name of the month in question
            $monthName = $dateComponents['month'];

            // what is the index value of the first day of the month
            $dayofWeek = $dateComponents['wday'];

            //getting the current date
            $dateToday = date('Y-m-d');

            // create the html table
            $calendar = "<table class='table table-bordered' style='background-color:#fff;'>";
            $calendar .= "<center><h2>$monthName $year</h2>";
            $calendar .= "<a class='btn btn-xs btn-primary' href='?DentistID=" . $dentistID . "&month=" . date('m', mktime(0, 0, 0, $month - 1, 1, $year)) . "&year=" . date('Y', mktime(0, 0, 0, $month - 1, 1, $year)) . "'>Previous Month</a> ";
            $calendar .= " <a class='btn btn-xs btn-primary' href='?DentistID=" . $dentistID . "&month=" . date('m') . "&year=" . date('Y') . "'>Current Month</a> ";
            $calendar .= "<a class='btn btn-xs btn-primary' href='?DentistID=" . $dentistID . "&month=" . date('m', mktime(0, 0, 0, $month + 1, 1, $year)) . "&year=" . date('Y', mktime(0, 0, 0, $month + 1, 1, $year)) . "'>Next Month</a></center><br>";

            $calendar .= "<tr>";

            // creating the calendar headers
            foreach ($daysofWeek as $day) {
                $calendar .= "<th class = 'header' style='background-color:#464545; color:#fff;'>$day</th>";
            }
            $calendar .= "</tr><tr>";
            $currentDay = 1;

            if ($dayofWeek > 0) {
                for ($k = 0; $k < $dayofWeek; $k++) {
                    $calendar .= "<td class='empty'></td>";
                }
            }
            $month = str_pad($month, 2, "0", STR_PAD_LEFT);
            while ($currentDay <= $numberDays) {
                if ($dayofWeek == 7) {
                    $dayofWeek = 0;
                    $calendar .= "</tr><tr>";
                }
                $currentDayRel = str_pad($currentDay, 2, "0", STR_PAD_LEFT);
                $date = "$year-$month-$currentDayRel";
                $dayname = strtolower(date('l', strtotime($date)));
                $eventNum = 0;
                $today = $date == date('Y-m-d') ? "today" : "";
                $stmt = $db->connect()->prepare("SELECT schedule_start_time, schedule_end_time, avg_consult_time from `dentist_schedule` where schedule_date = '$date' and dentist_id = '$dentistID'");
                $stmt->execute();

                if ($stmt->rowCount() == 0) {
                    $calendar .= "<td><h4>$currentDay</h4> <button class='btn btn-info btn-xs'>Off day</button>";
                } else if ($stmt->rowCount() >= 1) {
                    if ($date < date('Y-m-d')) {
                        $calendar .= "<td><h4>$currentDay</h4> <button class='btn btn-secondary btn-xs'>N/A</button>";
                    } else if (in_array($date, $bookings)) {
                        $calendar .= "<td><h4>$currentDay</h4> <a class='btn btn-danger btn-xs'>Already Booked</button>";
                    } else {
                        $calendar .= "<td class='$today'><h4>$currentDay</h4> <a href='book.php?DentistID=" . $dentistID . "&date=" . $date . "' class='btn btn-success btn-xs'>Book</a>";
                    }
                } //else if ($stmt->rowCount() > 1) {
                //     if ($date < date('Y-m-d')) {
                //         $calendar .= "<td><h4>$currentDay</h4> <button class='btn btn-secondary btn-xs'>N/A</button>";
                //     } else if (in_array($date, $bookings)) {
                //         $calendar .= "<td><h4>$currentDay</h4> <a class='btn btn-danger btn-xs'>Already Booked</button>";
                //     } else {
                //         $calendar .= "<td class='$today'><h4>$currentDay</h4> <a href='book.php?DentistID=" . $dentistID . "&date=" . $date . "' class='btn btn-success btn-xs'>Book</a>";
                //     }
                // }
                $calendar .= "</td>";
                //increment counters
                $currentDay++;
                $dayofWeek++;
            }

            if ($dayofWeek != 7) {
                $remainingDays = 7 - $dayofWeek;
                for ($l = 0; $l < $remainingDays; $l++) {
                    $calendar .= "<td class = 'empty'></td>";
                }
            }
            $calendar .= "</tr>";
            $calendar .= "</table>";
            return $calendar;
        }
        function checkSlots($date)
        {
            $db = new DB_Connect();

            $stmt = $db->connect()->prepare("SELECT * from appointment_table where appt_date = '$date'");
            $totalbooking = 0;

            if ($stmt->execute()) {
                if ($stmt->rowCount() > 0) {
                    while ($stmt->fetch(PDO::FETCH_ASSOC)) {
                        $totalbooking++;
                    }
                }
            }
            return $totalbooking;
        }
    }
    if ($path == "book") {
        // fill for modal
        $ID = $_SESSION['Patient_ID'];
        $stmt = $db->connectWix()->prepare("SELECT * FROM wixPatients where Patient_ID = $ID");
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $patientInfo = $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        function timeslots($duration, $cleanup, $start, $end)
        {
            $start = new DateTime($start);
            $end = new DateTime($end);
            $interval = new DateInterval("PT" . $duration . "M");
            $cleanupInterval = new DateInterval("PT" . $cleanup . "M");
            $slots = array();

            for ($intStart = $start; $intStart < $end; $intStart->add($interval)->add($cleanupInterval)) {
                $endPeriod = clone $intStart;
                $endPeriod->add($interval);
                if ($endPeriod > $end) {
                    break;
                }

                $slots[] = $intStart->format("H:i") . "-" . $endPeriod->format("H:i");
            }

            return $slots;
        }
        if (isset($_GET['date'])) {
            $date = $_GET['date'];
            $dentistID = $_GET['DentistID'];

            $stmt = $db->connect()->prepare("SELECT * from appointment_table where `appt_date` = '$date'");
            $bookings = array();
            $stmt->execute();
            if ($stmt->execute()) {
                if ($stmt->rowCount() > 0) {
                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        $bookings[] = $row['appt_time'];
                    }
                }
            }
            $stmt1 = $db->connect()->prepare("SELECT user_table.First_Name, user_table.Last_Name, dentist_schedule.schedule_id, dentist_schedule.schedule_start_time, dentist_schedule.schedule_end_time, dentist_schedule.avg_consult_time, dentist_schedule.Company from `dentist_schedule` inner join user_table on user_table.Emp_ID = dentist_schedule.dentist_id where schedule_date = '$date' and dentist_id = '$dentistID'");
            $stmt1->execute();
            if ($stmt1->rowCount() > 0) {
                $schedule_info = $stmt1->fetchAll(PDO::FETCH_ASSOC);
                $cleanup = 0;
                $schedules = array();
                foreach ($schedule_info as $schedule_info) {
                    // print_r($schedule_info);
                    $start = $schedule_info['schedule_start_time'];
                    $end = $schedule_info['schedule_end_time'];
                    $temp = $schedule_info['avg_consult_time'];
                    $duration = explode(" ", $temp)[0];
                    array_push($schedules, timeslots($duration, $cleanup, $start, $end));
                }
                // print_r($schedules);

                $dentist_Name = $schedule_info['First_Name'] . " " . $schedule_info['Last_Name'];
                $schID = $schedule_info['schedule_id'];
                $company = $schedule_info['Company'];
                // $start = $schedule_info['schedule_start_time'];
                // $end = $schedule_info['schedule_end_time'];
                // $temp = $schedule_info['avg_consult_time'];
                // $duration = explode(" ", $temp)[0];
            } else {
                $schedule_info = $stmt1->fetch(PDO::FETCH_ASSOC);
                $start = "0:00";
                $end = "0:00";
                $duration = 0;
                $cleanup = 0;
            }
        }

        if (isset($_POST['BookBtn'])) {
            $stmt0 = $db->connect()->prepare("SELECT MAX(appointment_id) from appointment_table");
            $stmt0->execute();
            $apptID = $stmt0->fetch()[0] + 1;
            $apptNum = $apptID + 999;
            $patientID = $_SESSION['Patient_ID'];
            $day = date('l', strtotime($date));
            $timeslot = $_POST['timeslot'];
            // $timeslot = explode("PM-", $temp)[0];
            $reason = $_POST['reason_for_appointment'];
            $stmt = $db->connect()->prepare("SELECT * from appointment_table where `appt_date` = '$date' and `appt_time` = '$timeslot'");
            // print_r($stmt);
            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                $msg = '<div class="alert alert-danger" role="alert-msg" id="alert">Already booked! <i class="bi bi-person-check"></i></div>';
            } else {
                $stmt1 = $db->connect()->prepare("INSERT into `appointment_table` values ('$apptID', '$dentistID', '$dentist_Name', '$patientID', '$schID', '$apptNum', '$reason', '$date', '$day', '$timeslot', 'Booked', '', ?)");
                // print_r($stmt);
                $stmt1->execute([$company]);
                if ($stmt1->rowCount() > 0) {
                    $msg = '<div class="alert alert-success" role="alert-msg" id="alert">Appointment has been successfully booked! <i class="bi bi-person-check"></i></div>';
                    $bookings[] = $timeslot;
                } else {
                    $msg = '<div class="alert alert-danger" role="alert-msg" id="alert">Error! Please try again <i class="bi bi-person-check"></i></div>';
                }
            }
        }
        
    }
}
?>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.min.js" integrity="sha384-j0CNLUeiqtyaRmlzUHCPZ+Gy5fQu0dQ6eZ/xAww941Ai1SxSY+0EQqNXNE6DZiVc" crossorigin="anonymous"></script>
<script>
    $(document).ready(function() {
        setTimeout(function() {
            $(".alert").alert('close');
        }, 3000);
    });

    $(document).on('click', '.viewSchedule', function() {
        $dentist_ID = $(this).closest('tr').find('td:nth-child(7)').text();
        window.location = 'calendar.php?DentistID=' + $dentist_ID;
    });

    $(document).on('click', '.bookAppt', function() {
        $('#patientBookAppt').modal('show'); //load modal
        var timeslot = $(this).attr('data-timeslot');
        $("#slot").html(timeslot);
        $("#timeslot").val(timeslot);

    });

    function refreshPage() {
        window.location.reload();
    }
</script>