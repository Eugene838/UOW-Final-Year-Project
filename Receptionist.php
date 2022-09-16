<?php
$db = new DB_Connect();
$company = $_SESSION['Company'];

if (!isset($_SESSION['Role']) && empty($_SESSION['Role'])) {
    header("Location: index.php");
    exit();
} else {
    if ($path == "ReceptionistDashboard") {
        if (isset($_POST["cancelYes"])) {
            $aPID = $_POST['cArriveID'];
            $stmt = $db->connect()->prepare("UPDATE `appointment_table` SET `status`='Cancelled' WHERE `appointment_id`=$aPID");
            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                $_SESSION['alert'] = '<div class="alert alert-danger" role="alert">Appointment cancelled. <i class="bi bi-exclamation-circle"></i></div>';
            }
        }

        if (isset($_POST["setArrive"])) {
            $aPID = $_POST['arriveID'];
            $aApptID = $_POST['arriveApptID'];

            $stmt = $db->connect()->prepare("UPDATE `appointment_table` SET `status`='In Queue' WHERE `patient_id`=$aPID AND `appointment_id`=$aApptID");
            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                $_SESSION['alert'] = '<div class="alert alert-success" role="alert-msg" id="alert">Patient has been added to the queue. <i class="bi bi-person-check"></i></div>';
            } else {
                $_SESSION['alert'] = '<div class="alert alert-danger" role="alert">Error! Unable to set patient in queue. <i class="bi bi-exclamation-circle"></i></div>';
            }
        }
    }
    if ($path == "view_products" || $path == "SuperAdmin") {
        // $db = new DB_Connect();

        if (isset($_POST["createBtn"])) {
            $product_name = $_POST['p_name'];
            $product_price = $_POST['p_price'];
            $product_quantity = $_POST['quantity'];

            // $db = new DB_Connect();
            $stmt = $db->connect()->prepare("SELECT MAX(product_id) from product_table");
            $stmt->execute();
            $product_id = $stmt->fetch()[0] + 1;

            $stmt1 = $db->connect()->prepare("INSERT INTO `product_table` VALUES (?, ?, ?, ?, ?)");
            $stmt1->execute([$product_id,$product_name,$product_price,$product_quantity,$company]);
            if ($stmt1->rowCount() > 0) {
                $_SESSION['alert'] = '<div class="alert alert-success" role="alert-msg" id="alert">Successfully added product! <i class="bi bi-shop"></i></div>';
            } else {
                $_SESSION['alert'] = '<div class="alert alert-danger" role="alert">Error! Unable to add product. <i class="bi bi-exclamation-circle"></i></div>';
            }
        }
        if (isset($_POST["edit_btn"])) {
            $e_productID = $_POST['e_pID'];
            $e_product_name = $_POST['e_pName'];
            $e_product_price = $_POST['e_pPrice'];
            $e_product_quantity = $_POST['e_quantity'];

            $db = new DB_Connect();
            $stmt = $db->connect()->prepare("UPDATE product_table set `product_name` = ?, `product_price` = ?, `quantity` = ? where `product_id`= ?");
            $stmt->execute([$e_product_name, $e_product_price, $e_product_quantity,$e_productID]);

            // print_r($stmt1);
            if ($stmt->rowCount() > 0) {
                $_SESSION['alert'] = '<div class="alert alert-success" role="alert-msg" id="alert">Product details successfully updated! <i class="bi bi-shop"></i></div>';
            } else {
                $_SESSION['alert'] = '<div class="alert alert-danger" role="alert">Error! Unable to update product details. <i class="bi bi-exclamation-circle"></i></div>';
            }
        }
        if (isset($_POST["cancel_btn"])) {
            $id = $_POST['dpID'];

            $db = new DB_Connect();
            $stmt = $db->connect()->prepare("Delete from product_table where `product_id` = ?");
            $stmt->execute([$id]);
            if ($stmt->rowCount() > 0) {
                $_SESSION['alert'] = '<div class="alert alert-success" role="alert-msg" id="alert">Product successfully deleted! <i class="bi bi-trash"></i></div>';
            }
        }
        $stmt = $db->connect()->prepare("SELECT * FROM product_table where Company = ?");
        $stmt->execute([$company]);
        if ($stmt->rowCount() > 0) {
            $products_list = $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
    }
    if ($path == "ViewPatientProfile" || $path == "SuperAdmin") {
        if (!isset($_SESSION['patientprof']) && empty($_SESSION['patientprof'])) {
            $company = $_SESSION['Company'];
            $stmt = $db->connectWix()->prepare("SELECT * FROM wixPatients");
            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                $recept_patients_profile = $stmt->fetchAll(PDO::FETCH_ASSOC);
            }
        } else {
            $recept_patients_profile =  $_SESSION['patientprof'];
        }
    }
    if ($path == "CreatePatientProfile" || $path == "SuperAdmin") {
        if (isset($_POST["addPatientProfileBtn"])) {
            $db = new DB_Connect();
            $firstname = $_POST['firstName'];
            $lastname = $_POST['lastName'];
            $nric_pnum = $_POST['nric_pnum'];
            $nationality = $_POST['nationality'];
            $gender = $_POST['gender'];
            $phoneNum = $_POST['phoneNum'];
            $dob = $_POST['birthDate'];
            $address = $_POST['address'];
            $email = $_POST['email'];
            $marital = $_POST['maritalStatus'];
            $occupation = $_POST['occupation'];
            $smoker = $_POST['smoker'];
            $emer_name = $_POST['emerName'];
            $emer_phone = $_POST['emerPhoneNum'];
            $emer_rs = $_POST['emerRs'];
            $allergies = $_POST['allergies'];
            if ($allergies == "Yes") {
                $allergyList = $_POST['allergyList'];
            } else {
                $allergyList = "NULL";
            }

            $ltm = $_POST['ltm'];
            if ($ltm == "Yes") {
                $ltmList = $_POST['ltmList'];
            } else {
                $ltmList = "NULL";
            }

            $eMeds = $_POST['existMeds'];
            if ($eMeds == "Yes") {
                $eMedList = $_POST['eMedList'];
            } else {
                $eMedList = "NULL";
            }

            $referral = $_POST['referBy'];
            if ($referral == "Yes") {
                $referredBy = $_POST['referredBy'];
                $referredMemo = $_POST['referredMemo'];
            } else {
                $referredBy = "NULL";
                $referredMemo = "NULL";
            }

            $subsidy = $_POST['subsidy'];

            $stmt = $db->connectWix()->prepare("SELECT MAX(Patient_ID) from wixPatients");
            $stmt->execute();
            $maxempID = $stmt->fetch()[0];
            $newID = $maxempID + 1;

            $stmt = $db->connectWix()->prepare("INSERT INTO `wixPatients`(`Patient_ID`, `First_Name`, `Last_Name`, `NRIC_PNum`, `Gender`, `Birth_Date`, `Address`, `Nationality`, `Phone_Num`, `Email`, `Marital_Status`, `Occupation`, `Smoker`, `Allergies`, `Long_term_med`, `Existing_Med_Conds`, `Referred_by_clinic`, `Referred_memo`, `Emer_Name`, `Emer_Contact`, `Emer_relation`, `Subsidies`) 
            VALUES ('$newID','$firstname','$lastname','$nric_pnum','$gender','$dob','$address','$nationality','$phoneNum','$email','$marital','$occupation','$smoker','$allergyList','$ltmList','$eMedList','$referredBy','$referredMemo','$emer_name','$emer_phone','$emer_rs','$subsidy')");
            $stmt->execute();
            if ($stmt->rowCount() > 0) {
                $_SESSION['alert'] = '<div class="alert alert-success" role="alert-msg">New patient profile successfully created! <i class="bi bi-person-check"></i></div>';
            } else {
                $_SESSION['alert'] = '<div class="alert alert-danger" role="alert-msg">Error. Unable to create patient profile! <i class="bi bi-exclamation-circle"></i></div>';
            }
        }
    }
    if ($path == "Schedule" || $path == "SuperAdmin") {
        $stmt1 = $db->connect()->prepare("SELECT First_Name, Last_Name FROM user_table where Role = 'Dentist' and `Company` = ?");
        $stmt1->execute([$company]);
        if ($stmt1->rowCount() > 0) {
            $allDentists = $stmt1->fetchAll(PDO::FETCH_ASSOC);
        }
        if (isset($_POST["addBtn"])) {
            // get max schedule id 
            $stmt0 = $db->connect()->prepare("SELECT MAX(schedule_id) from dentist_schedule");
            $stmt0->execute();
            $schID = $stmt0->fetch()[0] + 1;

            // get emp_id from name
            $name = $_POST['dentist_name'];
            $temp = explode(" ", $name);
            $first_name = $temp[0];
            $last_name = $temp[1];
            $stmt2 = $db->connect()->prepare("SELECT Emp_ID from user_table where `First_Name` = '$first_name' and `Last_Name` LIKE '$last_name%'");
            $stmt2->execute();
            $id =  $stmt2->fetch()[0];

            // rest of data from post
            $month = $_POST['add_sch_month'];
            // month = 2022-07
            $first_day = date("Y-m-01", strtotime($month));
            // print_r($month);
            $last_day = date("Y-m-t", strtotime($month));

            $weekday = $_POST['schedule_day'];

            $tempDate = array();
            $starttime = array();
            $endtime = array();
            $time = array();
            $days = array();
            $consults = array();
            $filter = array();

            foreach ($weekday as $day) {
                switch ($day) {
                    case "Monday":
                        $stmt4 = $db->connect()->prepare("select * from 
                            (select adddate('1970-01-01',t4*10000 + t3*1000 + t2*100 + t1*10 + t0) selected_date from
                            (select 0 t0 union select 1 union select 2 union select 3 union select 4 union select 5 union select 6 union select 7 union select 8 union select 9) t0,
                            (select 0 t1 union select 1 union select 2 union select 3 union select 4 union select 5 union select 6 union select 7 union select 8 union select 9) t1,
                            (select 0 t2 union select 1 union select 2 union select 3 union select 4 union select 5 union select 6 union select 7 union select 8 union select 9) t2,
                            (select 0 t3 union select 1 union select 2 union select 3 union select 4 union select 5 union select 6 union select 7 union select 8 union select 9) t3,
                            (select 0 t4 union select 1 union select 2 union select 3 union select 4 union select 5 union select 6 union select 7 union select 8 union select 9) t4) v
                            where selected_date between '$first_day' and '$last_day'
                            and dayname(selected_date) in ('Monday');");
                        $stmt4->execute();
                        $dates = $stmt4->fetchAll(PDO::FETCH_COLUMN, 0);
                        sort($dates);

                        $start = $_POST['start_time_mon'];
                        $end = $_POST['end_time_mon'];
                        $consult = $_POST['consult_time_mon'];
                        if (isset($_POST['workingoffmon'])) {
                            $workingoff = $_POST['workingoffmon'];
                            if ($workingoff == "Working") {
                                foreach ($dates as $date) {
                                    $days[] = $day;
                                    $tempDate[] = $date;
                                    $starttime[] =  $start;
                                    $endtime[] = $end;
                                    $consults[] = $consult;
                                }
                            } else {
                                $workingoff = "NULL";
                            }
                        }

                        break;
                    case "Tuesday":
                        $stmt4 = $db->connect()->prepare("select * from 
                                (select adddate('1970-01-01',t4*10000 + t3*1000 + t2*100 + t1*10 + t0) selected_date from
                                (select 0 t0 union select 1 union select 2 union select 3 union select 4 union select 5 union select 6 union select 7 union select 8 union select 9) t0,
                                (select 0 t1 union select 1 union select 2 union select 3 union select 4 union select 5 union select 6 union select 7 union select 8 union select 9) t1,
                                (select 0 t2 union select 1 union select 2 union select 3 union select 4 union select 5 union select 6 union select 7 union select 8 union select 9) t2,
                                (select 0 t3 union select 1 union select 2 union select 3 union select 4 union select 5 union select 6 union select 7 union select 8 union select 9) t3,
                                (select 0 t4 union select 1 union select 2 union select 3 union select 4 union select 5 union select 6 union select 7 union select 8 union select 9) t4) v
                                where selected_date between '$first_day' and '$last_day'
                                and dayname(selected_date) in ('Tuesday');");
                        $stmt4->execute();
                        $dates = $stmt4->fetchAll(PDO::FETCH_COLUMN, 0);
                        sort($dates);
                        $start = $_POST['start_time_tue'];
                        $end = $_POST['end_time_tue'];
                        $consult = $_POST['consult_time_tue'];
                        if (isset($_POST['workingofftue'])) {
                            $workingoff = $_POST['workingofftue'];
                            if ($workingoff == "Working") {
                                foreach ($dates as $date) {
                                    $days[] = $day;
                                    $tempDate[] = $date;
                                    $starttime[] =  $start;
                                    $endtime[] = $end;
                                    $consults[] = $consult;
                                }
                            } else {
                                $workingoff = "NULL";
                            }
                        }

                        break;


                    case "Wednesday":
                        $stmt4 = $db->connect()->prepare("select * from 
                                (select adddate('1970-01-01',t4*10000 + t3*1000 + t2*100 + t1*10 + t0) selected_date from
                                (select 0 t0 union select 1 union select 2 union select 3 union select 4 union select 5 union select 6 union select 7 union select 8 union select 9) t0,
                                (select 0 t1 union select 1 union select 2 union select 3 union select 4 union select 5 union select 6 union select 7 union select 8 union select 9) t1,
                                (select 0 t2 union select 1 union select 2 union select 3 union select 4 union select 5 union select 6 union select 7 union select 8 union select 9) t2,
                                (select 0 t3 union select 1 union select 2 union select 3 union select 4 union select 5 union select 6 union select 7 union select 8 union select 9) t3,
                                (select 0 t4 union select 1 union select 2 union select 3 union select 4 union select 5 union select 6 union select 7 union select 8 union select 9) t4) v
                                where selected_date between '$first_day' and '$last_day'
                                and dayname(selected_date) in ('Wednesday');");
                        $stmt4->execute();
                        $dates = $stmt4->fetchAll(PDO::FETCH_COLUMN, 0);
                        sort($dates);
                        $start = $_POST['start_time_wed'];
                        $end = $_POST['end_time_wed'];
                        $consult = $_POST['consult_time_wed'];
                        if (isset($_POST['workingoffwed'])) {
                            $workingoff = $_POST['workingoffwed'];
                            if ($workingoff == "Working") {
                                foreach ($dates as $date) {
                                    $days[] = $day;
                                    $tempDate[] = $date;
                                    $starttime[] =  $start;
                                    $endtime[] = $end;
                                    $consults[] = $consult;
                                }
                            } else {
                                $workingoff = "NULL";
                            }
                        }

                        break;

                    case "Thursday":
                        $stmt4 = $db->connect()->prepare("select * from 
                                (select adddate('1970-01-01',t4*10000 + t3*1000 + t2*100 + t1*10 + t0) selected_date from
                                (select 0 t0 union select 1 union select 2 union select 3 union select 4 union select 5 union select 6 union select 7 union select 8 union select 9) t0,
                                (select 0 t1 union select 1 union select 2 union select 3 union select 4 union select 5 union select 6 union select 7 union select 8 union select 9) t1,
                                (select 0 t2 union select 1 union select 2 union select 3 union select 4 union select 5 union select 6 union select 7 union select 8 union select 9) t2,
                                (select 0 t3 union select 1 union select 2 union select 3 union select 4 union select 5 union select 6 union select 7 union select 8 union select 9) t3,
                                (select 0 t4 union select 1 union select 2 union select 3 union select 4 union select 5 union select 6 union select 7 union select 8 union select 9) t4) v
                                where selected_date between '$first_day' and '$last_day'
                                and dayname(selected_date) in ('Thursday');");
                        $stmt4->execute();
                        $dates = $stmt4->fetchAll(PDO::FETCH_COLUMN, 0);
                        sort($dates);
                        $start = $_POST['start_time_thu'];
                        $end = $_POST['end_time_thu'];
                        $consult = $_POST['consult_time_thu'];
                        if (isset($_POST['workingoffthu'])) {
                            $workingoff = $_POST['workingoffthu'];
                            if ($workingoff == "Working") {
                                foreach ($dates as $date) {
                                    $days[] = $day;
                                    $tempDate[] = $date;
                                    $starttime[] =  $start;
                                    $endtime[] = $end;
                                    $consults[] = $consult;
                                }
                            } else {
                                $workingoff = "NULL";
                            }
                        }
                        break;

                    case "Friday":
                        $stmt4 = $db->connect()->prepare("select * from 
                                (select adddate('1970-01-01',t4*10000 + t3*1000 + t2*100 + t1*10 + t0) selected_date from
                                (select 0 t0 union select 1 union select 2 union select 3 union select 4 union select 5 union select 6 union select 7 union select 8 union select 9) t0,
                                (select 0 t1 union select 1 union select 2 union select 3 union select 4 union select 5 union select 6 union select 7 union select 8 union select 9) t1,
                                (select 0 t2 union select 1 union select 2 union select 3 union select 4 union select 5 union select 6 union select 7 union select 8 union select 9) t2,
                                (select 0 t3 union select 1 union select 2 union select 3 union select 4 union select 5 union select 6 union select 7 union select 8 union select 9) t3,
                                (select 0 t4 union select 1 union select 2 union select 3 union select 4 union select 5 union select 6 union select 7 union select 8 union select 9) t4) v
                                where selected_date between '$first_day' and '$last_day'
                                and dayname(selected_date) in ('Friday');");
                        $stmt4->execute();
                        $dates = $stmt4->fetchAll(PDO::FETCH_COLUMN, 0);
                        sort($dates);
                        $start = $_POST['start_time_fri'];
                        $end = $_POST['end_time_fri'];
                        $consult = $_POST['consult_time_fri'];
                        if (isset($_POST['workingofffri'])) {
                            $workingoff = $_POST['workingofffri'];
                            if ($workingoff == "Working") {
                                foreach ($dates as $date) {
                                    $days[] = $day;
                                    $tempDate[] = $date;
                                    $starttime[] =  $start;
                                    $endtime[] = $end;
                                    $consults[] = $consult;
                                }
                            } else {
                                $workingoff = "NULL";
                            }
                        }
                        break;

                    case "Saturday":
                        $stmt4 = $db->connect()->prepare("select * from 
                                (select adddate('1970-01-01',t4*10000 + t3*1000 + t2*100 + t1*10 + t0) selected_date from
                                (select 0 t0 union select 1 union select 2 union select 3 union select 4 union select 5 union select 6 union select 7 union select 8 union select 9) t0,
                                (select 0 t1 union select 1 union select 2 union select 3 union select 4 union select 5 union select 6 union select 7 union select 8 union select 9) t1,
                                (select 0 t2 union select 1 union select 2 union select 3 union select 4 union select 5 union select 6 union select 7 union select 8 union select 9) t2,
                                (select 0 t3 union select 1 union select 2 union select 3 union select 4 union select 5 union select 6 union select 7 union select 8 union select 9) t3,
                                (select 0 t4 union select 1 union select 2 union select 3 union select 4 union select 5 union select 6 union select 7 union select 8 union select 9) t4) v
                                where selected_date between '$first_day' and '$last_day'
                                and dayname(selected_date) in ('Saturday');");
                        $stmt4->execute();
                        $dates = $stmt4->fetchAll(PDO::FETCH_COLUMN, 0);
                        sort($dates);
                        $start = $_POST['start_time_sat'];
                        $end = $_POST['end_time_sat'];
                        $consult = $_POST['consult_time_sat'];
                        if (isset($_POST['workingoffsat'])) {
                            $workingoff = $_POST['workingoffsat'];
                            if ($workingoff == "Working") {
                                foreach ($dates as $date) {
                                    $days[] = $day;
                                    $tempDate[] = $date;
                                    $starttime[] =  $start;
                                    $endtime[] = $end;
                                    $consults[] = $consult;
                                }
                            } else {
                                $workingoff = "NULL";
                            }
                        }
                        break;
                    case "Sunday":
                        $stmt4 = $db->connect()->prepare("select * from 
                                (select adddate('1970-01-01',t4*10000 + t3*1000 + t2*100 + t1*10 + t0) selected_date from
                                (select 0 t0 union select 1 union select 2 union select 3 union select 4 union select 5 union select 6 union select 7 union select 8 union select 9) t0,
                                (select 0 t1 union select 1 union select 2 union select 3 union select 4 union select 5 union select 6 union select 7 union select 8 union select 9) t1,
                                (select 0 t2 union select 1 union select 2 union select 3 union select 4 union select 5 union select 6 union select 7 union select 8 union select 9) t2,
                                (select 0 t3 union select 1 union select 2 union select 3 union select 4 union select 5 union select 6 union select 7 union select 8 union select 9) t3,
                                (select 0 t4 union select 1 union select 2 union select 3 union select 4 union select 5 union select 6 union select 7 union select 8 union select 9) t4) v
                                where selected_date between '$first_day' and '$last_day'
                                and dayname(selected_date) in ('Sunday');");
                        $stmt4->execute();
                        $dates = $stmt4->fetchAll(PDO::FETCH_COLUMN, 0);
                        sort($dates);
                        $start = $_POST['start_time_sun'];
                        $end = $_POST['end_time_sun'];
                        $consult = $_POST['consult_time_sun'];
                        if (isset($_POST['workingoffsun'])) {
                            $workingoff = $_POST['workingoffsun'];
                            if ($workingoff == "Working") {
                                foreach ($dates as $date) {
                                    $days[] = $day;
                                    $tempDate[] = $date;
                                    $starttime[] =  $start;
                                    $endtime[] = $end;
                                    $consults[] = $consult;
                                }
                            } else {
                                $workingoff = "NULL";
                            }
                        }
                        break;
                }
            }

            foreach ($tempDate as $index => $value) {
                $schedule_date = ($value);
                $schedule_day = ($days[$index]);
                $schedule_start = ($starttime[$index]);
                $schedule_end = ($endtime[$index]);
                $schedule_consult = ($consults[$index]);
                $filter[] = "('$schID', '$id', '$schedule_date','$schedule_day','$schedule_start', '$schedule_end','$schedule_consult', 'Active', :company)";
                $schID++;
            }

            $stmt1 = $db->connect()->prepare("INSERT into dentist_schedule VALUES " . implode(", ", $filter));
            $stmt1->bindParam(':company', $company, PDO::PARAM_STR);
            $stmt1->execute();
            if ($stmt1->rowCount() > 0) {
                $_SESSION['alert'] = '<div class="alert alert-success" role="alert-msg">New schedule successfully added! <i class="bi bi-calendar-check"></i></div>';
            } else {
                $_SESSION['alert'] = '<div class="alert alert-danger" role="alert-msg">Error. Unable to add schedule! <i class="bi bi-exclamation-circle"></i></div>';
            }
        }
        if (isset($_POST["editBtn"])) {
            $edit_schid = $_POST['edit_sch_id'];
            $edit_scheduledate = $_POST['edit_sch_date'];
            $stmt0 = $db->connect()->prepare("SELECT DAYNAME('$edit_scheduledate')");
            $stmt0->execute();
            $edit_day = $stmt0->fetch()[0];
            $edit_starttime = $_POST['edit_start_time'];
            $edit_endtime = $_POST['edit_end_time'];
            $edit_consult = $_POST['edit_consult_time'];

            $stmt = $db->connect()->prepare("UPDATE `dentist_schedule` SET `schedule_date`= '$edit_scheduledate',
                `schedule_day`='$edit_day',`schedule_start_time`='$edit_starttime',`schedule_end_time`='$edit_endtime',`avg_consult_time`='$edit_consult' WHERE `schedule_id`= $edit_schid");
            $stmt->execute();
            if ($stmt->rowCount() > 0) {
                $_SESSION['alert'] = '<div class="alert alert-success" role="alert-msg">Schedule has been successfully updated! <i class="bi bi-calendar-check"></i></div>';
            } else {
                $_SESSION['alert'] = '<div class="alert alert-danger" role="alert-msg">Error. Unable to update schedule! <i class="bi bi-exclamation-circle"></i></div>';
            }
        }
        if (isset($_POST["deleteBtn"])) {
            $schID = $_POST['dSchID'];

            $stmt = $db->connect()->prepare("DELETE FROM `dentist_schedule` WHERE `schedule_id`= $schID");
            $stmt->execute();
            if ($stmt->rowCount() > 0) {
                $_SESSION['alert'] = '<div class="alert alert-success" role="alert-msg">Schedule has been delete! <i class="bi bi-trash"></i></div>';
            } else {
                $_SESSION['alert'] = '<div class="alert alert-danger" role="alert-msg">Error. Unable to delete schedule! <i class="bi bi-exclamation-circle"></i></div>';
            }
        }
        if (!isset($_SESSION['dr_schedule']) && empty($_SESSION['dr_schedule'])) {
            $db = new DB_Connect();
            $id = $_SESSION['Emp_ID'];

            $stmt = $db->connect()->prepare("SELECT user_table.First_Name, user_table.Last_Name, dentist_schedule.* FROM `dentist_schedule` inner join user_table on user_table.Emp_ID = dentist_id where dentist_schedule.Company = ? and DAY(schedule_date) > DAY(CURRENT_DATE) and MONTH(schedule_date) = MONTH(CURRENT_DATE) order by dentist_schedule.schedule_date asc;");
            $stmt->execute([$company]);
            if ($stmt->rowCount() > 0) {
                $schedules = $stmt->fetchAll(PDO::FETCH_ASSOC);
            } 
        }
    }
    if ($path == "ReceptionistViewRecords" || $path == "SuperAdmin") {
        $stmt = $db->connect()->prepare("SELECT r.Record_ID, profile.First_Name, profile.Last_Name, profile.NRIC_PNum, profile.Birth_Date, 
            r.Treatment_Date, r.Treatment_Type, r.Treatment_details, r.Material_used, `Doctor/Assistant 1`, `Doctor/Assistant 2` FROM dentianDatabase.patient_record 
            as r INNER JOIN wixDatabase.wixPatients as profile on profile.Patient_ID = r.Patient_ID WHERE r.Company = ? order by r.Treatment_Date DESC");
        $stmt->execute([$company]);
        if ($stmt->rowCount() > 0) {
            $recept_patient_records = $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
    }
}
?>

<!-- Patient Arrive Modal -->
<div class="modal fade" id="patientArriveModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Has the patient arrived?</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST">
                <div class="modal-body row">
                    <p class="fw-bold">Please verify with the patient on their details.</p>
                    <input class="form-label" name="arriveID" id="arriveID" hidden>
                    <input class="form-label" name="arriveApptID" id="arriveApptID" hidden>
                    <div class="col-5">
                        <label class="form-label fw-bold">Appointment ID:</label>
                    </div>
                    <div class="col-7">
                        <label class="form-label text-nowrap" id="arriveApptID"></label>
                    </div>
                    <div class="col-5">
                        <label class="form-label fw-bold">Full Name:</label>
                    </div>
                    <div class="col-7">
                        <label class="form-label text-nowrap" id="arriveName"></label>
                    </div>
                    <div class="col-5">
                        <label class="form-label fw-bold">NRIC/Passport No:</label>
                    </div>
                    <div class="col-7">
                        <label class="form-label text-nowrap" id="arriveNRIC"></label>
                    </div>
                    <div class="col-5">
                        <label class="form-label fw-bold">Phone Number:</label>
                    </div>
                    <div class="col-7">
                        <label class="form-label text-nowrap" id="arrivePN"></label>
                    </div>
                    <div class="col-5">
                        <label class="form-label fw-bold">Address:</label>
                    </div>
                    <div class="col-7">
                        <label class="form-label" id="arriveAdd"></label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-lg btn-danger" data-bs-dismiss="modal">No</button>
                    <button type="submit" class="btn btn-lg btn-success" name="setArrive">Yes</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Cancel Patient In Queue Modal -->
<div class="modal fade" id="cancelModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Cancel Appointment</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST">
                <div class="modal-body">
                    <input class="form-label" name="cArriveID" id="cArriveID" hidden>
                    <p class="fw-bold">Are you sure to cancel this patient appointment?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-lg btn-danger" data-bs-dismiss="modal">No</button>
                    <button type="submit" class="btn btn-lg btn-success" name="cancelYes">Yes</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Add product modal -->
<div class="modal fade" id="addProduct" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Enter New Product details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form class="needs-validation" method="POST" novalidate>
                    <div class="mb-3">
                        <label class="form-label">Product Name</label>
                        <input type="text" class="form-control " name="p_name" id="p_name" pattern="^([A-Za-z]+[,.]?[ ]?|[A-Za-z]+['-]?)+$" required>
                        <div class="invalid-feedback">
                            Please enter product name.
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Product Price</label>
                        <input type="text" class="form-control" name="p_price" id="p_price" pattern="^\d+(\.\d{1,2})?$" required>
                        <div class="invalid-feedback">
                            Please enter valid product price.
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Quantity</label>
                        <input type="text" class="form-control" name="quantity" id="quantity" pattern="^[0-9]*$" required>
                        <div class="invalid-feedback">
                            Please enter quantity.
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary float-end" name="createBtn">Add product</button>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Edit product modal -->
<div class="modal fade" id="editProduct" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Edit Product details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form class="needs-validation" method="POST" novalidate>
                    <div class="form-group row mb-3">
                        <label for="staticID" class="col-4 col-form-label">Product ID</label>
                        <div class="col-sm-2">
                            <input type="text" class="form-control-plaintext" name="e_pID" id="e_pID" readonly>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Product Name</label>
                        <input type="text" class="form-control " name="e_pName" id="e_pName" pattern="^([A-Za-z]+[,.]?[ ]?|[A-Za-z]+['-]?)+$" required>
                        <div class="invalid-feedback">
                            Please enter product name.
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Product Price</label>
                        <input type="text" class="form-control" name="e_pPrice" id="e_pPrice" pattern="^\d+(\.\d{1,2})?$" required>
                        <div class="invalid-feedback">
                            Please enter valid product price.
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Quantity</label>
                        <input type="text" class="form-control" name="e_quantity" id="e_quantity" pattern="^[0-9]*$" required>
                        <div class="invalid-feedback">
                            Please enter quantity.
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary float-end" name="edit_btn">Edit product</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Delete product modal -->
<div class="modal fade" id="deleteProduct" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Delete Product</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST">
                    <div class="modal-body">
                        <input class="form-label" name="dpID" id="dpID" hidden>
                        <p class="fw-bold">Are you sure to remove this product from the inventory?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-lg btn-danger" data-bs-dismiss="modal">No</button>
                        <button type="submit" class="btn btn-lg btn-success" name="cancel_btn">Yes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Add schedule -->
<div class="modal fade " id="addSch" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Add Schedule</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form class="needs-validation" method="POST" novalidate>
                    <div class="mb-3">
                        <label class="form-label">Dentist Name:</label>
                        <select class="form-select" name="dentist_name" id="dentist_name" required>
                            <?php
                            if (isset($allDentists)) {
                                foreach ($allDentists as $row) {
                                    echo '<option value="' . $row["First_Name"] . " " . $row["Last_Name"] . '">' . $row["First_Name"] . " " . $row["Last_Name"] . '</option>';
                                }
                            } else {
                                echo '<option value="">Error!</option>';
                            }
                            ?>
                        </select>
                        <div class="invalid-feedback">
                            Please select dentist.
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Schedule Month</label>
                        <input type="month" class="form-control" name="add_sch_month" id="add_sch_month" required>
                        <div class="invalid-feedback">
                            Please select a month.
                        </div>
                    </div>
                    <div id="add-day" style="display:none" class="mon">
                        <div class="mb-3">
                            <label class="form-label">Schedule Day</label>
                            <!-- <select class="form-select" aria-label="Default select example" name="schedule_day[]" id="schedule_mon">
                                        <option selected="selected" value="NULL">Select Day</option>
                                        <option value="Monday">Monday</option>
                                    </select> -->
                            <input type="select" class="form-control" name="schedule_day[]" id="schedule_day" value="Monday" readonly>
                        </div>
                        <div class="pt-3">
                            <div class="form-group">
                                <label class="form-label">Working or off day?</label><br>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="workingoffmon" id="workingmon" value="Working">
                                    <label class="form-check-label" for="working">Working</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="workingoffmon" id="off" value="Off">
                                    <label class="form-check-label" for="off">Off</label>
                                </div>
                                <div class="form-check form-check-inline p-0">
                                    <input type="radio" name="workingoffmon" style="display:none">
                                    <div class="invalid-feedback">
                                        Please choose an option.
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="onshiftmon mb-3" style="display:none">
                            <label class="form-label">Start Time</label>
                            <input type="time" class="timeinfomon form-control" name="start_time_mon" id="start_time_mon">
                            <div class="invalid-feedback">
                                Please enter start time.
                            </div>
                        </div>
                        <div class="onshiftmon mb-3" style="display:none">
                            <label class="form-label">End Time</label>
                            <input type="time" class="timeinfomon form-control" name="end_time_mon" id="end_time_mon">
                            <div class="invalid-feedback">
                                Please enter end time.
                            </div>
                        </div>
                        <div class="onshiftmon mb-3" style="display:none">
                            <label class="form-label">Average consulting time</label>
                            <select class="timeinfomon form-select" aria-label="Default select example" name="consult_time_mon" id="consult_time_mon">
                                <option selected="selected" value="">Select Consulting Duration</option>
                                <option value="5 minutes">5 minutes</option>
                                <option value="10 minutes">10 minutes</option>
                                <option value="15 minutes">15 minutes</option>
                                <option value="20 minutes">20 minutes</option>
                                <option value="25 minutes">25 minutes</option>
                                <option value="30 minutes">30 minutes</option>
                                <option value="35 minutes">35 minutes</option>
                                <option value="40 minutes">40 minutes</option>
                                <option value="45 minutes">45 minutes</option>
                                <option value="50 minutes">50 minutes</option>
                                <option value="55 minutes">55 minutes</option>
                                <option value="60 minutes">60 minutes</option>
                                <option value="65 minutes">65 minutes</option>
                                <option value="70 minutes">70 minutes</option>
                                <option value="75 minutes">75 minutes</option>
                            </select>
                            <div class="invalid-feedback">
                                Please select average consulting time.
                            </div>
                        </div>
                    </div>
                    <div id="add-day" style="display:none" class="tue">
                        <div class="mb-3">
                            <label class="form-label">Schedule Day</label>
                            <!-- <select class="form-select" aria-label="Default select example" name="schedule_day[]" id="schedule_tue">
                                        <option selected="selected" value="NULL">Select Day</option>
                                        <option value="Tuesday">Tuesday</option>
                                    </select> -->
                            <input type="text" class="form-control" name="schedule_day[]" id="schedule_day" value="Tuesday" readonly>
                        </div>
                        <div class="pt-3">
                            <div class="form-group">
                                <label class="form-label">Working or off day?</label><br>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="workingofftue" id="workingtue" value="Working">
                                    <label class="form-check-label" for="working">Working</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="workingofftue" id="off" value="Off">
                                    <label class="form-check-label" for="off">Off</label>
                                </div>
                                <div class="form-check form-check-inline p-0">
                                    <input type="radio" name="workingofftue" style="display:none">
                                    <div class="invalid-feedback">
                                        Please choose an option.
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="onshifttue mb-3" style="display:none">
                            <label class="form-label">Start Time</label>
                            <input type="time" class="timeinfotue form-control" name="start_time_tue" id="start_time_tue">
                            <div class="invalid-feedback">
                                Please enter start time.
                            </div>
                        </div>
                        <div class="onshifttue mb-3" style="display:none">
                            <label class="form-label">End Time</label>
                            <input type="time" class="timeinfotue form-control" name="end_time_tue" id="end_time_tue">
                            <div class="invalid-feedback">
                                Please enter end time.
                            </div>
                        </div>
                        <div class="onshifttue mb-3" style="display:none">
                            <label class="form-label">Average consulting time</label>
                            <select class="timeinfotue form-select" aria-label="Default select example" name="consult_time_tue" id="consult_time_tue">
                                <option selected="selected" value="">Select Consulting Duration</option>
                                <option value="5 minutes">5 minutes</option>
                                <option value="10 minutes">10 minutes</option>
                                <option value="15 minutes">15 minutes</option>
                                <option value="20 minutes">20 minutes</option>
                                <option value="25 minutes">25 minutes</option>
                                <option value="30 minutes">30 minutes</option>
                                <option value="35 minutes">35 minutes</option>
                                <option value="40 minutes">40 minutes</option>
                                <option value="45 minutes">45 minutes</option>
                                <option value="50 minutes">50 minutes</option>
                                <option value="55 minutes">55 minutes</option>
                                <option value="60 minutes">60 minutes</option>
                                <option value="65 minutes">65 minutes</option>
                                <option value="70 minutes">70 minutes</option>
                                <option value="75 minutes">75 minutes</option>
                            </select>
                            <div class="invalid-feedback">
                                Please select average consulting time.
                            </div>
                        </div>
                    </div>
                    <div id="add-day" style="display:none" class="wed">
                        <div class="mb-3">
                            <label class="form-label">Schedule Day</label>
                            <!-- <select class="form-select" aria-label="Default select example" name="schedule_day[]" id="schedule_wed">
                                        <option selected="selected" value="NULL">Select Day</option>
                                        <option value="Wednesday">Wednesday</option>
                                    </select> -->
                            <input type="text" class="form-control" name="schedule_day[]" id="schedule_day" value="Wednesday" readonly>
                        </div>
                        <div class="pt-3">
                            <div class="form-group">
                                <label class="form-label">Working or off day?</label><br>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="workingoffwed" id="workingwed" value="Working">
                                    <label class="form-check-label" for="working">Working</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="workingoffwed" id="off" value="Off">
                                    <label class="form-check-label" for="off">Off</label>
                                </div>
                                <div class="form-check form-check-inline p-0">
                                    <input type="radio" name="workingoffwed" style="display:none">
                                    <div class="invalid-feedback">
                                        Please choose an option.
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="onshiftwed mb-3" style="display:none">
                            <label class="form-label">Start Time</label>
                            <input type="time" class="timeinfowed form-control" name="start_time_wed" id="start_time_wed">
                            <div class="invalid-feedback">
                                Please enter start time.
                            </div>
                        </div>
                        <div class="onshiftwed mb-3" style="display:none">
                            <label class="form-label">End Time</label>
                            <input type="time" class="timeinfowed form-control" name="end_time_wed" id="end_time_wed">
                            <div class="invalid-feedback">
                                Please enter end time.
                            </div>
                        </div>
                        <div class="onshiftwed mb-3" style="display:none">
                            <label class="form-label">Average consulting time</label>
                            <select class="timeinfowed form-select" aria-label="Default select example" name="consult_time_wed" id="consult_time_wed">
                                <option selected="selected" value="">Select Consulting Duration</option>
                                <option value="5 minutes">5 minutes</option>
                                <option value="10 minutes">10 minutes</option>
                                <option value="15 minutes">15 minutes</option>
                                <option value="20 minutes">20 minutes</option>
                                <option value="25 minutes">25 minutes</option>
                                <option value="30 minutes">30 minutes</option>
                                <option value="35 minutes">35 minutes</option>
                                <option value="40 minutes">40 minutes</option>
                                <option value="45 minutes">45 minutes</option>
                                <option value="50 minutes">50 minutes</option>
                                <option value="55 minutes">55 minutes</option>
                                <option value="60 minutes">60 minutes</option>
                                <option value="65 minutes">65 minutes</option>
                                <option value="70 minutes">70 minutes</option>
                                <option value="75 minutes">75 minutes</option>
                            </select>
                            <div class="invalid-feedback">
                                Please select average consulting time.
                            </div>
                        </div>
                    </div>
                    <div id="add-day" style="display:none" class="thu">
                        <div class="mb-3">
                            <label class="form-label">Schedule Day</label>
                            <!-- <select class="form-select" aria-label="Default select example" name="schedule_day[]" id="schedule_thu">
                                        <option selected="selected" value="NULL">Select Day</option>
                                        <option value="Thursday">Thursday</option>
                                    </select> -->
                            <input type="text" class="form-control" name="schedule_day[]" id="schedule_day" value="Thursday" readonly>
                        </div>
                        <div class="pt-3">
                            <div class="form-group">
                                <label class="form-label">Working or off day?</label><br>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="workingoffthu" id="workingthu" value="Working">
                                    <label class="form-check-label" for="working">Working</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="workingoffthu" id="off" value="Off">
                                    <label class="form-check-label" for="off">Off</label>
                                </div>
                                <div class="form-check form-check-inline p-0">
                                    <input type="radio" name="workingoffthu" style="display:none">
                                    <div class="invalid-feedback">
                                        Please choose an option.
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="onshiftthu mb-3" style="display:none">
                            <label class="form-label">Start Time</label>
                            <input type="time" class="timeinfothu form-control" name="start_time_thu" id="start_time_thu">
                            <div class="invalid-feedback">
                                Please enter start time.
                            </div>
                        </div>
                        <div class="onshiftthu mb-3" style="display:none">
                            <label class="form-label">End Time</label>
                            <input type="time" class="timeinfothu form-control" name="end_time_thu" id="end_time_thu">
                            <div class="invalid-feedback">
                                Please enter end time.
                            </div>
                        </div>
                        <div class="onshiftthu mb-3" style="display:none">
                            <label class="form-label">Average consulting time</label>
                            <select class="timeinfothu form-select" aria-label="Default select example" name="consult_time_thu" id="consult_time_thu">
                                <option selected="selected" value="">Select Consulting Duration</option>
                                <option value="5 minutes">5 minutes</option>
                                <option value="10 minutes">10 minutes</option>
                                <option value="15 minutes">15 minutes</option>
                                <option value="20 minutes">20 minutes</option>
                                <option value="25 minutes">25 minutes</option>
                                <option value="30 minutes">30 minutes</option>
                                <option value="35 minutes">35 minutes</option>
                                <option value="40 minutes">40 minutes</option>
                                <option value="45 minutes">45 minutes</option>
                                <option value="50 minutes">50 minutes</option>
                                <option value="55 minutes">55 minutes</option>
                                <option value="60 minutes">60 minutes</option>
                                <option value="65 minutes">65 minutes</option>
                                <option value="70 minutes">70 minutes</option>
                                <option value="75 minutes">75 minutes</option>
                            </select>
                            <div class="invalid-feedback">
                                Please select average consulting time.
                            </div>
                        </div>
                    </div>
                    <div id="add-day" style="display:none" class="fri">
                        <div class="mb-3">
                            <label class="form-label">Schedule Day</label>
                            <!-- <select class="form-select" aria-label="Default select example" name="schedule_day[]" id="schedule_fri">
                                        <option selected="selected" value="NULL">Select Day</option>
                                        <option value="Friday">Friday</option>
                                    </select> -->
                            <input type="text" class="form-control" name="schedule_day[]" id="schedule_day" value="Friday" readonly>
                        </div>
                        <div class="pt-3">
                            <div class="form-group">
                                <label class="form-label">Working or off day?</label><br>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="workingofffri" id="workingfri" value="Working">
                                    <label class="form-check-label" for="working">Working</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="workingofffri" id="off" value="Off">
                                    <label class="form-check-label" for="off">Off</label>
                                </div>
                                <div class="form-check form-check-inline p-0">
                                    <input type="radio" name="workingofffri" style="display:none">
                                    <div class="invalid-feedback">
                                        Please choose an option.
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="onshiftfri mb-3" style="display:none">
                            <label class="form-label">Start Time</label>
                            <input type="time" class="timeinfofri form-control" name="start_time_fri" id="start_time_fri">
                            <div class="invalid-feedback">
                                Please enter start time.
                            </div>
                        </div>
                        <div class="onshiftfri mb-3" style="display:none">
                            <label class="form-label">End Time</label>
                            <input type="time" class="timeinfofri form-control" name="end_time_fri" id="end_time_fri">
                            <div class="invalid-feedback">
                                Please enter end time.
                            </div>
                        </div>
                        <div class="onshiftfri mb-3" style="display:none">
                            <label class="form-label">Average consulting time</label>
                            <select class="timeinfofri form-select" aria-label="Default select example" name="consult_time_fri" id="consult_time_fri">
                                <option selected="selected" value="">Select Consulting Duration</option>
                                <option value="5 minutes">5 minutes</option>
                                <option value="10 minutes">10 minutes</option>
                                <option value="15 minutes">15 minutes</option>
                                <option value="20 minutes">20 minutes</option>
                                <option value="25 minutes">25 minutes</option>
                                <option value="30 minutes">30 minutes</option>
                                <option value="35 minutes">35 minutes</option>
                                <option value="40 minutes">40 minutes</option>
                                <option value="45 minutes">45 minutes</option>
                                <option value="50 minutes">50 minutes</option>
                                <option value="55 minutes">55 minutes</option>
                                <option value="60 minutes">60 minutes</option>
                                <option value="65 minutes">65 minutes</option>
                                <option value="70 minutes">70 minutes</option>
                                <option value="75 minutes">75 minutes</option>
                            </select>
                            <div class="invalid-feedback">
                                Please select average consulting time.
                            </div>
                        </div>
                    </div>



                    <div id="add-day" style="display:none" class="sat">
                        <div class="mb-3">
                            <label class="form-label">Schedule Day</label>
                            <!-- <select class="form-select" aria-label="Default select example" name="schedule_day[]" id="schedule_sat">
                                        <option selected="selected" value="NULL">Select Day</option>
                                        <option value="Saturday">Saturday</option>
                                    </select> -->
                            <input type="text" class="form-control" name="schedule_day[]" id="schedule_day" value="Saturday" readonly>
                        </div>
                        <div class="pt-3">
                            <div class="form-group">
                                <label class="form-label">Working or off day?</label><br>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="workingoffsat" id="workingsat" value="Working">
                                    <label class="form-check-label" for="working">Working</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="workingoffsat" id="off" value="Off">
                                    <label class="form-check-label" for="off">Off</label>
                                </div>
                                <div class="form-check form-check-inline p-0">
                                    <input type="radio" name="workingoffsat" style="display:none">
                                    <div class="invalid-feedback">
                                        Please choose an option.
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="onshiftsat mb-3" style="display:none">
                            <label class="form-label">Start Time</label>
                            <input type="time" class="timeinfosat form-control" name="start_time_sat" id="start_time_sat">
                            <div class="invalid-feedback">
                                Please enter start time.
                            </div>
                        </div>
                        <div class="onshiftsat mb-3" style="display:none">
                            <label class="form-label">End Time</label>
                            <input type="time" class="timeinfosat form-control" name="end_time_sat" id="end_time_sat">
                            <div class="invalid-feedback">
                                Please enter end time.
                            </div>
                        </div>
                        <div class="onshiftsat mb-3" style="display:none">
                            <label class="form-label">Average consulting time</label>
                            <select class="timeinfosat form-select" aria-label="Default select example" name="consult_time_sat" id="consult_time_sat">
                                <option selected="selected" value="">Select Consulting Duration</option>
                                <option value="5 minutes">5 minutes</option>
                                <option value="10 minutes">10 minutes</option>
                                <option value="15 minutes">15 minutes</option>
                                <option value="20 minutes">20 minutes</option>
                                <option value="25 minutes">25 minutes</option>
                                <option value="30 minutes">30 minutes</option>
                                <option value="35 minutes">35 minutes</option>
                                <option value="40 minutes">40 minutes</option>
                                <option value="45 minutes">45 minutes</option>
                                <option value="50 minutes">50 minutes</option>
                                <option value="55 minutes">55 minutes</option>
                                <option value="60 minutes">60 minutes</option>
                                <option value="65 minutes">65 minutes</option>
                                <option value="70 minutes">70 minutes</option>
                                <option value="75 minutes">75 minutes</option>
                            </select>
                            <div class="invalid-feedback">
                                Please select average consulting time.
                            </div>
                        </div>
                    </div>
                    <div id="add-day" style="display:none" class="sun">
                        <div class="mb-3">
                            <label class="form-label">Schedule Day</label>
                            <!-- <select class="form-select" aria-label="Default select example" name="schedule_day[]" id="schedule_sun">
                                        <option selected="selected" value="NULL">Select Day</option>
                                        <option value="Sunday">Sunday</option>
                                    </select> -->
                            <input type="text" class="form-control" name="schedule_day[]" id="schedule_day" value="Sunday" readonly>
                        </div>
                        <div class="pt-3">
                            <div class="form-group">
                                <label class="form-label">Working or off day?</label><br>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="workingoffsun" id="workingsun" value="Working">
                                    <label class="form-check-label" for="working">Working</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="workingoffsun" id="off" value="Off">
                                    <label class="form-check-label" for="off">Off</label>
                                </div>
                                <div class="form-check form-check-inline p-0">
                                    <input type="radio" name="workingoffsun" style="display:none">
                                    <div class="invalid-feedback">
                                        Please choose an option.
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="onshiftsun mb-3" style="display:none">
                            <label class="form-label">Start Time</label>
                            <input type="time" class="timeinfosun form-control" name="start_time_sun" id="start_time_sun">
                            <div class="invalid-feedback">
                                Please enter start time.
                            </div>
                        </div>
                        <div class="onshiftsun mb-3" style="display:none">
                            <label class="form-label">End Time</label>
                            <input type="time" class="timeinfosun form-control" name="end_time_sun" id="end_time_sun">
                            <div class="invalid-feedback">
                                Please enter end time.
                            </div>
                        </div>
                        <div class="onshiftsun mb-3" style="display:none">
                            <label class="form-label">Average consulting time</label>
                            <select class="timeinfosun form-select" aria-label="Default select example" name="consult_time_sun" id="consult_time_sun">
                                <option selected="selected" value="">Select Consulting Duration</option>
                                <option value="5 minutes">5 minutes</option>
                                <option value="10 minutes">10 minutes</option>
                                <option value="15 minutes">15 minutes</option>
                                <option value="20 minutes">20 minutes</option>
                                <option value="25 minutes">25 minutes</option>
                                <option value="30 minutes">30 minutes</option>
                                <option value="35 minutes">35 minutes</option>
                                <option value="40 minutes">40 minutes</option>
                                <option value="45 minutes">45 minutes</option>
                                <option value="50 minutes">50 minutes</option>
                                <option value="55 minutes">55 minutes</option>
                                <option value="60 minutes">60 minutes</option>
                                <option value="65 minutes">65 minutes</option>
                                <option value="70 minutes">70 minutes</option>
                                <option value="75 minutes">75 minutes</option>
                            </select>
                            <div class="invalid-feedback">
                                Please select average consulting time.
                            </div>
                        </div>
                    </div>
                    <div>
                        <label><input type="checkbox" name="mon" value="mon"> Monday</label>
                        <label><input type="checkbox" name="tues" value="tue"> Tuesday</label>
                        <label><input type="checkbox" name="weds" value="wed"> Wednesday</label>
                        <label><input type="checkbox" name="thu" value="thu"> Thursday</label>
                        <label><input type="checkbox" name="fri" value="fri"> Friday</label>
                        <label><input type="checkbox" name="sat" value="sat"> Saturday</label>
                        <label><input type="checkbox" name="sun" value="sun"> Sunday</label>
                        <button type="submit" class="btn btn-primary float-end addBtn" name="addBtn">Add Schedule</button>
                    </div>
                    <!-- <button type="button" class="btn btn-primary" id="addDay">Add for another day</button> -->
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Edit schedule -->
<div class="modal fade " id="editSch" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Edit Schedule</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form class="needs-validation" method="POST" novalidate>
                    <div class="mb-3">
                        <label class="form-label">Schedule ID</label>
                        <input type="text" class="form-control" name="edit_sch_id" id="edit_sch_id" readonly>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Schedule date</label>
                        <input type="date" class="form-control" name="edit_sch_date" id="edit_sch_date" readonly>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Start Time</label>
                        <input type="time" class="form-control" name="edit_start_time" id="edit_start_time" required>
                        <div class="invalid-feedback">
                            Please enter start time.
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">End Time</label>
                        <input type="time" class="form-control" name="edit_end_time" id="edit_end_time" required>
                        <div class="invalid-feedback">
                            Please enter end time.
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Average consulting time</label>
                        <select class="form-select" aria-label="Default select example" name="edit_consult_time" id="edit_consult_time" required>
                            <option selected="selected" value="NULL">Select Consulting Duration</option>
                            <option value="5 minutes">5 minutes</option>
                            <option value="10 minutes">10 minutes</option>
                            <option value="15 minutes">15 minutes</option>
                            <option value="20 minutes">20 minutes</option>
                            <option value="25 minutes">25 minutes</option>
                            <option value="30 minutes">30 minutes</option>
                            <option value="35 minutes">35 minutes</option>
                            <option value="40 minutes">40 minutes</option>
                            <option value="45 minutes">45 minutes</option>
                            <option value="50 minutes">50 minutes</option>
                            <option value="55 minutes">55 minutes</option>
                            <option value="60 minutes">60 minutes</option>
                            <option value="65 minutes">65 minutes</option>
                            <option value="70 minutes">70 minutes</option>
                            <option value="75 minutes">75 minutes</option>
                        </select>
                        <div class="invalid-feedback">
                            Please select average consulting time.
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary float-end" name="editBtn">Edit Schedule</button>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Edit Status Modal -->
<div class="modal fade" id="editStatus" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Change Status</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form class="form-inline" method="POST" novalidate>
                    Are you sure you want to change the status of this schedule?

                    <div class="form-group row mt-3">
                        <label for="staticID" class="col-4 col-form-label"><b>Schedule ID:</b></label>
                        <div class="col-sm-2">
                            <input type="text" class="form-control-plaintext" name="inactive_sch_id" id="inactive_sch_id" readonly>
                        </div>
                    </div>
                    <div class="form-group row mt-3">
                        <label for="staticID" class="col-4 col-form-label"><b>Schedule Date:</b></label>
                        <div class="col-sm-5">
                            <input type="date" class="form-control-plaintext" name="inactive_sch_date" id="inactive_sch_date" readonly>
                        </div>
                    </div>
                    <div class="form-group row mt-3">
                        <label for="staticID" class="col-4 col-form-label"><b>Current Status:</b></label>
                        <div class="col-sm-2">
                            <input type="text" class="form-control-plaintext" name="currentStatus" id="currentStatus" readonly>
                        </div>
                    </div>
                    <div class="form-group row mt-3">
                        <label for="staticID" class="col-4 col-form-label"><b>New Status:</b></label>
                        <div class="col-sm-5">
                            <input type="text" class="form-control-plaintext" name="newStatus" id="newStatus" readonly>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success" name="editStatusBtn">Confirm</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Delete Schedule Modal -->
<div class="modal fade" id="deleteSch" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog col-6">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Delete Schedule</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST">
                <div class="modal-body">
                    Are you sure you want to delete this schedule?
                    <div class="form-group row mt-3">
                        <label for="staticID" class="col-4 col-form-label"><b>Schedule ID:</b></label>
                        <div class="col-sm-2">
                            <input type="text" class="form-control-plaintext" name="dSchID" id="dSchID" readonly>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="staticID" class="col-4 col-form-label"><b>Schedule Date:</b></label>
                        <div class="col-sm-5">
                            <input type="text" class="form-control-plaintext" id="dSchDate" readonly>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="staticID" class="col-4 col-form-label text-nowrap"><b>Schedule Start time:</b></label>
                        <div class="col-sm-5">
                            <input type="text" class="form-control-plaintext" id="dStartTime" readonly>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="staticID" class="col-4 col-form-label text-nowrap"><b>Schedule End time:</b></label>
                        <div class="col-sm-5">
                            <input type="text" class="form-control-plaintext" id="dEndTime" readonly>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="staticID" class="col-4 col-form-label text-nowrap"><b>Consulting time:</b></label>
                        <div class="col-sm-5">
                            <input type="text" class="form-control-plaintext" id="dConTime" readonly>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-danger" name="deleteBtn">Confirm</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- View Patient Record Modal -->
<div class="modal fade" id="recept_viewPatRec" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">View Treatment details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- <form class="needs-validation" method="POST" novalidate> -->
                <div class="mb-3">
                    <label class="form-label">Record ID</label>
                    <input type="text" class="form-control" name="recept_recID" id="recept_recID" readonly>
                </div>
                <div class="mb-3">
                    <label class="form-label">First Name</label>
                    <input type="text" class="form-control" name="recept_fname" id="recept_fname" readonly>
                </div>
                <div class="mb-3">
                    <label class="form-label">Last Name</label>
                    <input type="text" class="form-control" name="recept_lname" id="recept_lname" readonly>
                </div>
                <div class="mb-3">
                    <label class="form-label">NRIC/Passport No.</label>
                    <input type="text" class="form-control" name="recept_view_nric" id="recept_view_nric" readonly>
                </div>
                <!-- <div class="mb-3">
                            <label class="form-label">Phone Number</label>
                            <input type="text" class="form-control" pattern="[8-9]{1}[0-9]{7}" name="view_mobileNum" id="view_mobileNum" readonly>
                        </div> -->
                <div class="mb-3">
                    <label class="form-label">Visit date</label>
                    <input type="date" class="form-control" name="recept_dateVisit" id="recept_dateVisit" readonly>
                </div>
                <div class="mb-3">
                    <label class="form-label">Treatment Type</label>
                    <input type="text" class="form-control" name="recept_Treatment_type" id="recept_Treatment_type" readonly>
                </div>
                <div class="mb-3">
                    <label class="form-label">Treatment Details</label>
                    <textarea class="form-control" name="recept_Treatment_details" id="recept_Treatment_details" readonly></textarea>
                </div>
                <div class="mb-3">
                    <label class="form-label">Materials Used</label>
                    <textarea class="form-control" name="recept_view_Materials" id="recept_view_Materials" readonly></textarea>
                </div>
                <div class="mb-3">
                    <label class="form-label">Dentist Involved</label>
                    <input type="text" class="form-control" name="recept_view_Den" id="recept_view_Den" readonly>
                </div>
                <div class="mb-3">
                    <label class="form-label">Dentist Assistant Involved</label>
                    <input type="text" class="form-control" name="recept_view_Ass" id="recept_view_Ass" readonly>
                </div>
                <!-- </form> -->
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.min.js" integrity="sha384-j0CNLUeiqtyaRmlzUHCPZ+Gy5fQu0dQ6eZ/xAww941Ai1SxSY+0EQqNXNE6DZiVc" crossorigin="anonymous"></script>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>


<script>
    $('document').ready(function() {
        var inputValue;
        $('.arriveBtn').click(function() {
            $aApptID = $(this).closest('tr').find('td:nth-child(1)').text();
            $aPID = $(this).closest('tr').find('td:nth-child(3)').text();
            $aName = $(this).closest('tr').find('td:nth-child(4)').text();
            $aNric = $(this).closest('tr').find('td:nth-child(5)').text();
            $aPhone = $(this).closest('tr').find('td:nth-child(6)').text();
            $aAdd = $(this).closest('tr').find('td:nth-child(7)').text();
            $('#arriveID').val($aPID);
            $('#arriveApptID').val($aApptID);
            $('#arriveApptID').text($aApptID);
            $('#arriveName').text($aName);
            $('#arriveNRIC').text($aNric);
            $('#arrivePN').text($aPhone);
            $('#arriveAdd').text($aAdd);
            //console.log('helloworld');
        });

        $('.cancelBtn').click(function() {
            $aPID = $(this).closest('tr').find('td:nth-child(1)').text();
            $('#cArriveID').val($aPID);
        });
        // edit product btn
        $('.editProductBtn').click(function() {
            $pID = $(this).closest('tr').find('td:nth-child(1)').text().trim();
            $p_Name = $(this).closest('tr').find('td:nth-child(2)').text().trim();
            $p_Price = $(this).closest('tr').find('td:nth-child(3)').text().trim();
            $split = $p_Price.split("$");
            // alert($split[1]);
            $temp = $split[1];
            $p_Quantity = $(this).closest('tr').find('td:nth-child(4)').text().trim();


            $('#e_pID').val($pID);
            $('#e_pName').val($p_Name);
            $('#e_pPrice').val($temp);
            $('#e_quantity').val($p_Quantity);

            // alert($pID);
        });
        // delete product button
        $('.delProductBtn').click(function() {
            $p_id = $(this).closest('tr').find('td:nth-child(1)').text();
            $('#dpID').val($p_id);
        });
        // view patient profile btn
        $('.editViewPatientProfileBtn').click(function() {
            $patient_id = $(this).closest('tr').find('td:nth-child(1)').text();
            window.location = 'PatientProfile.php?PatientID=' + $patient_id;
        });
        // schedule
        $('input[type="checkbox"]').change(function() {
            inputValue = $(this).attr("value");
            // console.log(inputValue);
            $("." + inputValue).toggle();
        });
        // Monday 
        $("input[name='workingoffmon']").click(function() {
            if ($("#workingmon").is(":checked")) {
                $(".onshiftmon").show();
                $('.timeinfomon').attr('required', true);
            } else {
                $(".onshiftmon").hide();
                $('.timeinfomon').attr('required', false);

            }
        });
        // Tuesday 
        $("input[name='workingofftue']").click(function() {
            if ($("#workingtue").is(":checked")) {
                $(".onshifttue").show();
                $('.timeinfotue').attr('required', true);
            } else {
                $(".onshifttue").hide();
                $('.timeinfotue').attr('required', false);

            }
        });
        // Wednesday
        $("input[name='workingoffwed']").click(function() {
            if ($("#workingwed").is(":checked")) {
                $(".onshiftwed").show();
                $('.timeinfowed').attr('required', true);
            } else {
                $(".onshiftwed").hide();
                $('.timeinfowed').attr('required', false);

            }
        });
        // Thursday
        $("input[name='workingoffthu']").click(function() {
            if ($("#workingthu").is(":checked")) {
                $(".onshiftthu").show();
                $('.timeinfothu').attr('required', true);
            } else {
                $(".onshiftthu").hide();
                $('.timeinfothu').attr('required', false);

            }
        });
        // Friday 
        $("input[name='workingofffri']").click(function() {
            if ($("#workingfri").is(":checked")) {
                $(".onshiftfri").show();
                $('.timeinfofri').attr('required', true);
            } else {
                $(".onshiftfri").hide();
                $('.timeinfofri').attr('required', false);

            }
        });
        // Saturday
        $("input[name='workingoffsat']").click(function() {
            if ($("#workingsat").is(":checked")) {
                $(".onshiftsat").show();
                $('.timeinfosat').attr('required', true);
            } else {
                $(".onshiftsat").hide();
                $('.timeinfosat').attr('required', false);

            }
        });
        // Sunday
        $("input[name='workingoffsun']").click(function() {
            if ($("#workingsun").is(":checked")) {
                $(".onshiftsun").show();
                $('.timeinfosun').attr('required', true);
            } else {
                $(".onshiftsun").hide();
                $('.timeinfosun').attr('required', false);

            }
        });


        $('.addBtn').click(function(e) {

            // monday 
            $startTempmon = $("#start_time_mon").val();
            $endTempmon = $("#end_time_mon").val();
            if ($startTempmon == "" && $endTempmon == "") {
                $startTempmon = 0;
                $endTempmon = 0;

            } else {
                $startmon = new Date("January 01, 2022 " + $startTempmon);
                $startmon = $startmon.getTime();
                $endmon = new Date("January 01, 2022 " + $endTempmon);
                $endmon = $endmon.getTime();

                console.log($startmon);
                console.log($endmon);
                if ($startmon > $endmon) {
                    console.log("monday failed");
                    e.preventDefault();
                    $("#start_time_mon").after('<span class="badge rounded-pill bg-danger">Start-time must be smaller then End-time.</span>');
                } else {
                    console.log("monday pass");
                    // $('form').submit();
                }
            }
            // tuesday 
            $startTemptue = $("#start_time_tue").val();
            $endTemptue = $("#end_time_tue").val();
            if ($startTemptue == "" && $endTemptue == "") {
                $startTemptue = 0;
                $endTemptue = 0;

            } else {
                $starttue = new Date("January 01, 2022 " + $startTemptue);
                $starttue = $starttue.getTime();
                $endtue = new Date("January 01, 2022 " + $endTemptue);
                $endtue = $endtue.getTime();

                console.log($starttue);
                console.log($endtue);
                if ($starttue > $endtue) {
                    console.log("tues failed");
                    e.preventDefault();
                    $("#start_time_tue").after('<span class="badge rounded-pill bg-danger">Start-time must be smaller then End-time.</span>');
                } else {
                    console.log("tues pass");
                    // $('form').submit();
                }
            }
            // wednesday 
            $startTempwed = $("#start_time_wed").val();
            $endTempwed = $("#end_time_wed").val();
            if ($startTempwed == "" && $endTempwed == "") {
                $startTempwed = 0;
                $endTempwed = 0;

            } else {
                $startwed = new Date("January 01, 2022 " + $startTempwed);
                $startwed = $startwed.getTime();
                $endwed = new Date("January 01, 2022 " + $endTempwed);
                $endwed = $endwed.getTime();

                console.log($startwed);
                console.log($endwed);
                if ($startwed > $endwed) {
                    console.log("wed failed");
                    e.preventDefault();
                    $("#start_time_wed").after('<span class="badge rounded-pill bg-danger">Start-time must be smaller then End-time.</span>');
                } else {
                    console.log("wed pass");
                    // $('form').submit();
                }
            }
            // thursday 
            $startTempthu = $("#start_time_thu").val();
            $endTempthu = $("#end_time_thu").val();
            if ($startTempthu == "" && $endTempthu == "") {
                $startTempthu = 0;
                $endTempthu = 0;

            } else {
                $startthu = new Date("January 01, 2022 " + $startTempthu);
                $startthu = $startthu.getTime();
                $endthu = new Date("January 01, 2022 " + $endTempthu);
                $endthu = $endthu.getTime();

                console.log($startthu);
                console.log($endthu);
                if ($startthu > $endthu) {
                    console.log("thu failed");
                    e.preventDefault();
                    $("#start_time_thu").after('<span class="badge rounded-pill bg-danger">Start-time must be smaller then End-time.</span>');
                } else {
                    console.log("thu pass");
                    // $('form').submit();
                }
            }

            // friday 
            $startTempfri = $("#start_time_fri").val();
            $endTempfri = $("#end_time_fri").val();
            if ($startTempfri == "" && $endTempfri == "") {
                $startTempfri = 0;
                $endTempfri = 0;

            } else {
                $startfri = new Date("January 01, 2022 " + $startTempfri);
                $startfri = $startfri.getTime();
                $endfri = new Date("January 01, 2022 " + $endTempfri);
                $endfri = $endfri.getTime();

                console.log($startfri);
                console.log($endfri);
                if ($startfri > $endfri) {
                    console.log("fri failed");
                    e.preventDefault();
                    $("#start_time_fri").after('<span class="badge rounded-pill bg-danger">Start-time must be smaller then End-time.</span>');
                } else {
                    console.log("fri pass");
                    // $('form').submit();
                }
            }

            // saturday 
            $startTempsat = $("#start_time_sat").val();
            $endTempsat = $("#end_time_sat").val();
            if ($startTempsat == "" && $endTempsat == "") {
                $startTempsat = 0;
                $endTempsat = 0;

            } else {
                $startsat = new Date("January 01, 2022 " + $startTempsat);
                $startsat = $startsat.getTime();
                $endsat = new Date("January 01, 2022 " + $endTempsat);
                $endsat = $endsat.getTime();

                console.log($startsat);
                console.log($endthu);
                if ($startsat > $endsat) {
                    console.log("sat failed");
                    e.preventDefault();
                    $("#start_time_sat").after('<span class="badge rounded-pill bg-danger">Start-time must be smaller then End-time.</span>');
                } else {
                    console.log("sat pass");
                    // $('form').submit();
                }
            }

            // sunday 
            $startTempsun = $("#start_time_sun").val();
            $endTempsun = $("#end_time_sun").val();
            if ($startTempsun == "" && $endTempsun == "") {
                $startTempsun = 0;
                $endTempsun = 0;

            } else {
                $startsun = new Date("January 01, 2022 " + $startTempsun);
                $startsun = $startsun.getTime();
                $endsun = new Date("January 01, 2022 " + $endTempsun);
                $endsun = $endsun.getTime();

                console.log($startsun);
                console.log($endsun);
                if ($startsun > $endsun) {
                    console.log("sun failed");
                    e.preventDefault();
                    $("#start_time_sun").after('<span class="badge rounded-pill bg-danger">Start-time must be smaller then End-time.</span>');
                } else {
                    console.log("sun pass");
                    // $('form').submit();
                }
            }
        });




        $('.editSch').click(function() {
            $schid = $(this).closest('tr').find('td:nth-child(1)').text().trim();
            $schdate = $(this).closest('tr').find('td:nth-child(3)').text().trim();
            $starttime = $(this).closest('tr').find('td:nth-child(5)').text().trim();
            $endtime = $(this).closest('tr').find('td:nth-child(6)').text().trim();
            $consulttime = $(this).closest('tr').find('td:nth-child(7)').text().trim();

            $('#edit_sch_id').val($schid);
            $('#edit_sch_date').val($schdate);
            $('#edit_start_time').val($starttime);
            $('#edit_end_time').val($endtime);
            $('#edit_consult_time').val($consulttime);
        });
        $('.editStatus').click(function() {

            $schid = $(this).closest('tr').find('td:nth-child(1)').text().trim();
            $schdate = $(this).closest('tr').find('td:nth-child(3)').text().trim();
            $status = $(this).closest('tr').find('td:nth-child(8)').text().trim();
            $('#inactive_sch_id').val($schid);
            $('#inactive_sch_date').val($schdate);
            $temp = "Active";
            if ($status == "Active") {
                $temp = "Inactive";
            }

            $('#currentStatus').val($status);
            $('#newStatus').val($temp);
            // alert($status);
        });
        $('.deleteSch').click(function() {
            $schid = $(this).closest('tr').find('td:nth-child(1)').text().trim();
            $schdate = $(this).closest('tr').find('td:nth-child(3)').text().trim();
            $starttime = $(this).closest('tr').find('td:nth-child(5)').text().trim();
            $endtime = $(this).closest('tr').find('td:nth-child(6)').text().trim();
            $consulttime = $(this).closest('tr').find('td:nth-child(7)').text().trim();

            $('#dSchID').val($schid);
            $('#dSchDate').val($schdate);
            $('#dStartTime').val($starttime);
            $('#dEndTime').val($endtime);
            $('#dConTime').val($consulttime);
        });
        $('.viewPatRecBtn').click(function() {
            $rID = $(this).closest('tr').find('td:nth-child(1)').text().trim();
            $name = $(this).closest('tr').find('td:nth-child(2)').text().trim();
            $splitName = $name.split(" ");
            $first = $splitName[0];
            $last = $splitName[1];
            $nric = $(this).closest('tr').find('td:nth-child(3)').text().trim();
            // $hp = $(this).closest('tr').find('td:nth-child(5)').text().trim();
            $dov = $(this).closest('tr').find('td:nth-child(4)').text().trim().split('-');
            $treat_type = $(this).closest('tr').find('td:nth-child(5)').text().trim();
            $treat_dets = $(this).closest('tr').find('td:nth-child(6)').text().trim();
            $materials = $(this).closest('tr').find('td:nth-child(7)').text().trim();
            $dentists = $(this).closest('tr').find('td:nth-child(8)').text().trim();
            $assists = $(this).closest('tr').find('td:nth-child(9)').text().trim();


            $('#recept_recID').val($rID);
            $('#recept_fname').val($first);
            $('#recept_lname').val($last);
            $('#recept_view_nric').val($nric);
            // $('#view_mobileNum').val($hp);
            $('#recept_dateVisit').val($dov[2] + '-' + $dov[1] + '-' + $dov[0]);
            $('#recept_Treatment_type').val($treat_type);
            $('#recept_Treatment_details').val($treat_dets);
            $('#recept_view_Materials').val($materials);
            $('#recept_view_Den').val($dentists);
            $('#recept_view_Ass').val($assists);
        });
    });

    //Allergies
    $("input[name='allergies']").click(function() {
        if ($("#allergyYes").is(":checked")) {
            $("#allergiesInfo").show();
            $('#allergyList').attr('required', true);
        } else {
            $("#allergiesInfo").hide();
            $('#allergyList').attr('required', false);

        }
    });
    //Long term Medications
    $("input[name='ltm']").click(function() {
        if ($("#ltmYes").is(":checked")) {
            $("#ltmInfo").show();
            $('#ltmList').attr('required', true);
        } else {
            $("#ltmInfo").hide();
            $('#ltmList').attr('required', false);
        }
    });
    //Existing Medications
    $("input[name='existMeds']").click(function() {
        if ($("#eMedYes").is(":checked")) {
            $("#eMedInfo").show();
            $('#eMedList').attr('required', true);
        } else {
            $("#eMedInfo").hide();
            $('#eMedList').attr('required', false);
        }
    });
    //Referred by & referred memo
    $("input[name='referBy']").click(function() {
        if ($("#referredYes").is(":checked")) {
            $("#referredInfo").show();
            $('#referredBy').attr('required', true);
            $('#referredMemo').attr('required', true);
        } else {
            $("#referredInfo").hide();
            $('#referredBy').attr('required', false);
            $('#referredMemo').attr('required', false);
        }
    });

    // input validation
    (function() {
        'use strict'

        // Fetch all the forms we want to apply custom Bootstrap validation styles to
        var forms = document.querySelectorAll('.needs-validation')

        // Loop over them and prevent submission
        Array.prototype.slice.call(forms)
            .forEach(function(form) {
                form.addEventListener('submit', function(event) {
                    if (!form.checkValidity()) {
                        event.preventDefault()
                        event.stopPropagation()
                    }

                    form.classList.add('was-validated')
                }, false)
            })
    })();
</script>