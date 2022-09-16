<?php
ob_start();
$db = new DB_Connect();
$company = $_SESSION['Company'];

if (!isset($_SESSION['Role']) && empty($_SESSION['Role'])) {
    header("Location: index.php");
} else {
    $stmt1 = $db->connect()->prepare("SELECT concat(First_Name,' ',Last_Name) AS FullName FROM user_table where (Role = 'Dentist' or Role = 'Dentist Assistant') and Company = ?");
    $stmt1->execute([$company]);

    if ($stmt1->rowCount() > 0) {
        $resultforDA1 = $stmt1->fetchAll(PDO::FETCH_ASSOC);
    }

    if ($path == "DentistDashboard") {
        if (isset($_POST["cancelYes"])) {
            $aPID = $_POST['cancelPID'];
            $aApptID = $_POST['cancelApptID'];
            $stmt = $db->connect()->prepare("UPDATE `appointment_table` SET `status`='Cancelled' WHERE `patient_id`=? AND `appointment_id`=?");
            $stmt->execute([$aPID, $aApptID]);

            if ($stmt->rowCount() > 0) {
                $_SESSION['alert'] = '<div class="alert alert-danger" role="alert-msg" id="alert">Appointment cancelled <i class="bi bi-person-x"></i></div>';
            }
        }
    }
    if ($path == "AttendPatient") {
        $patient_id = $_GET['patient_id'];
        $stmt = $db->connectWix()->prepare("SELECT * from wixPatients where Patient_ID = '$patient_id'");
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $attendPatientInfo = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $stmt = $db->connect()->prepare("SELECT * from patient_record where Patient_ID = '$patient_id'");
            $stmt->execute();
            $patientHistoryRec = $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        //Attend Patient Create Record
        if (isset($_POST["attendBtn"])) {
            $appt_id = $_GET['appointment_id'];
            $stmt = $db->connect()->prepare("SELECT MAX(Record_ID) from patient_record");
            $stmt->execute();
            $recordID = $stmt->fetch()[0] + 1;
            // $apptID = $_POST['Appt_ID'];
            $TDate = $_POST['aTDate'];
            $serviceType = $_POST['attendServiceType'];
            $cMat = $_POST['aMat'];
            $cDA1 = $_POST['aDA1'];
            $cDA2 = $_POST['aDA2'];
            $cDescription = $_POST['attendDescription'];
            $remarks = '';

            $stmt1 = $db->connect()->prepare("INSERT INTO `patient_record` VALUES (?,?,?,?,?,?,?,?,?,?)");
            $stmt1->execute([$recordID, $patient_id, $TDate, $serviceType, $cDescription, $cMat, $cDA1, $cDA2, $company, $remarks]);

            if ($stmt1->rowCount() > 0) {
                $stmt = $db->connect()->prepare("UPDATE `appointment_table` SET `status`='Completed' WHERE `patient_id`=? AND `appointment_id`=?");
                $stmt->execute([$patient_id, $appt_id]);
                $_SESSION['alert'] = '<div class="alert alert-success" role="alert-msg" id="alert">Treatment record has been successfully created! <i class="bi bi-clipboard-check"></i></div>';
                //$alertMsg = '<div class="alert alert-success" role="alert-msg" id="alert">Treatment record has been successfully created! <i class="bi bi-clipboard-check"></i></div>';
                header("Location: DentistDashboard.php");
            } else {
                $_SESSION['alert'] = '<div class="alert alert-danger" role="alert-msg" id="alert">Error! Please try again <i class="bi bi-exclamation-circle"></i></div>';
                //$alertMsg = '<div class="alert alert-danger" role="alert-msg" id="alert">Error! Please try again <i class="bi bi-exclamation-circle"></i></div>';
            }
        }
    }
    if ($path == "DentistPatient" || $path == "SuperAdmin") {
        //Manually Create Patient Record
        if (isset($_POST["dentist_createBtn"])) {
            $stmt = $db->connect()->prepare("SELECT MAX(Record_ID) from patient_record");
            $stmt->execute();
            $recordID = $stmt->fetch()[0] + 1;
            $pID = $_POST['cPatient_ID'];
            $TDate = $_POST['cTDate'];
            $serviceType = $_POST['createServiceType'];
            $cMat = $_POST['cMat'];
            $cDA1 = $_POST['cDA1'];
            $cDA2 = $_POST['cDA2'];
            $cDescription = $_POST['createDescription'];
            $addRemarks = '';

            $stmt1 = $db->connect()->prepare("INSERT INTO `patient_record` VALUES (?,?,?,?,?,?,?,?,?,?)");
            $stmt1->execute([$recordID, $pID, $TDate, $serviceType, $cDescription, $cMat, $cDA1, $cDA2, $company, $addRemarks]);

            if ($stmt1->rowCount() > 0) {
                $_SESSION['alert'] = '<div class="alert alert-success" role="alert-msg" id="alert">Treatment record has been successfully created! <i class="bi bi-clipboard-check"></i></div>';
            } else {
                $_SESSION['alert'] = '<div class="alert alert-danger" role="alert-msg" id="alert">Error! Please try again <i class="bi bi-exclamation-circle"></i></div>';
            }
        }
        if (isset($_POST["allPatients"])) {
            unset($_SESSION['patients']);
            $db = new DB_Connect();

            $stmt = $db->connectWix()->prepare("SELECT * FROM wixPatients");
            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                $dentist_patient_profile = $stmt->fetchAll(PDO::FETCH_ASSOC);
            }
        }
        if (!isset($_SESSION['patients']) && empty($_SESSION['patients'])) {
            $db = new DB_Connect();
            $stmt = $db->connectWix()->prepare("SELECT * FROM wixPatients");
            $stmt->execute();
            if ($stmt->rowCount() > 0) {
                $dentist_patient_profile = $stmt->fetchAll(PDO::FETCH_ASSOC);
            }
        } else {
            $dentist_patient_profile = $_SESSION['patients'];
        }
    }
    if ($path == "PatientRecords" || $path == "SuperAdmin") {
        if (isset($_POST["dentist_editBtn"])) {
            //echo $company;
            $rID = $_POST['rID'];
            $TDate = $_POST['Date'];
            $serviceType = $_POST['editServiceType'];
            $Mat = $_POST['mat'];
            $DA1 = $_POST['DA1'];
            $DA2 = $_POST['DA2'];
            $cDescription = $_POST['updateDescription'];
            $remarks = $_POST['updateRemarks'];

            $stmt = $db->connect()->prepare("UPDATE `patient_record` set `Treatment_Date` = ?, `Treatment_type` = ?, `Treatment_details` = ?,
                 `Material_used` = ?, `Doctor/Assistant 1` = ?, `Doctor/Assistant 2` = ?, `Remarks` = ? where `Record_ID` = ? ");
            //print_r($stmt);
            $stmt->execute([$TDate, $serviceType, $cDescription, $Mat, $DA1, $DA2, $remarks, $rID]);

            if ($stmt->rowCount() > 0) {   
                $stmt = $db->connect()->prepare("SELECT wixPatients.First_Name, wixPatients.Last_Name, patient_record.* FROM dentianDatabase.patient_record left join wixDatabase.wixPatients on patient_record.Patient_ID = wixPatients.Patient_ID where patient_record.Record_ID = ?");
                $stmt->execute([$rID]);
                $_SESSION['dentistpatientrecords'] = $stmt->fetchAll(PDO::FETCH_ASSOC);
                $_SESSION['alert'] = '<div class="alert alert-success" role="alert-msg" id="alert">Treatment record has been updated! <i class="bi bi-clipboard-check"></i></div>';
            } else {
                $_SESSION['alert'] = '<div class="alert alert-danger" role="alert-msg" id="alert">Error! Please try again <i class="bi bi-exclamation-circle"></i></div>';
            }
        }

        if (isset($_POST["allRecords"])) {
            //unset($_SESSION['patients']);
            unset($_SESSION['dentistpatientrecords']);
            $db = new DB_Connect();

            $stmt = $db->connect()->prepare("SELECT wixPatients.First_Name, wixPatients.Last_Name, patient_record.* FROM dentianDatabase.patient_record right join wixDatabase.wixPatients on patient_record.Patient_ID = wixPatients.Patient_ID WHERE patient_record.Company = ? order by patient_record.Treatment_Date DESC");
            $stmt->execute([$company]);

            if ($stmt->rowCount() > 0) {
                $dentist_patient_records = $stmt->fetchAll(PDO::FETCH_ASSOC);
            }
        }
        if (!isset($_SESSION['dentistpatientrecords']) && empty($_SESSION['dentistpatientrecords'])) {
            $stmt = $db->connect()->prepare("SELECT wixPatients.First_Name, wixPatients.Last_Name, patient_record.* FROM dentianDatabase.patient_record left join wixDatabase.wixPatients on patient_record.Patient_ID = wixPatients.Patient_ID WHERE patient_record.Company = ? order by patient_record.Treatment_Date DESC");

            $stmt->execute([$company]);
            //echo $company;
            if ($stmt->rowCount() > 0) {
                $dentist_patient_records = $stmt->fetchAll(PDO::FETCH_ASSOC);
            }
        }
    }
    if ($path == "DentistSchedule" || $path == "SuperAdmin") {
        $id = $_SESSION['Emp_ID'];

        $stmt = $db->connect()->prepare("SELECT dentist_schedule.* FROM `dentist_schedule` inner join user_table on user_table.Emp_ID = dentist_id where dentist_id = $id and DAY(schedule_date) > DAY(CURRENT_DATE) and MONTH(schedule_date) = MONTH(CURRENT_DATE) order by dentist_schedule.schedule_date asc;");

        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            $schedule = $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
    }
}

?>
<!-- Attend Patient Treatment Record form -->
<div class="modal fade " id="attendBtn" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form class="needs-validation" method="POST" novalidate>
                    <div class="mb-3">
                        <label class="form-label">Name of patient</label>
                        <input type="text" class="form-control" name="PName" id="PName" readonly>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" hidden>Patient ID</label>
                        <input type="text" class="form-control" name="Patient_ID" id="Patient_ID" hidden readonly>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" hidden>Appointment ID</label>
                        <input type="text" class="form-control" name="Appt_ID" id="Appt_ID" hidden readonly>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Date of treatment</label>
                        <input type="date" class="form-control" name="aTDate" id="aTDate" required>
                        <div class="invalid-feedback">
                            Please select a date.
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Type of service</label>
                        <select class="form-select" aria-label="Default select example" name="attendServiceType" id="attendServiceType" required>
                            <option selected value="">Type of service</option>
                            <option value="General Consultation">General Consultation</option>
                            <option value="Extraction, Anterior">Extraction, Anterior</option>
                            <option value="Extraction, Posterior">Extraction, Posterior</option>
                            <option value="Filling, simple">Filling, simple</option>
                            <option value="Filling, complex">Filling, complex</option>
                            <option value="Removable Denture, Complete(Upper or Lower">Removable Denture, Complete(Upper or Lower</option>
                            <option value="Removable Denture, Partial, Simple">Removable Denture, Partial, Simple</option>
                            <option value="Removable Denture, Partial, Complex">Removable Denture, Partial, Complex</option>
                            <option value="Denture Reline/Repair (Upper or Lower)">Denture Reline/Repair (Upper or Lower)</option>
                            <option value="Permanent Crown">Permanent Crown</option>
                            <option value="Root Canal Treatment (Anterior)">Root Canal Treatment (Anterior)</option>
                            <option value="Root Canal Treatment (Molar)">Root Canal Treatment (Molar)</option>
                            <option value="Root Canal Treatment (Pre-Molar)">Root Canal Treatment (Pre-Molar)</option>
                            <option value="Polishing">Polishing</option>
                            <option value="Scaling">Scaling</option>
                            <option value="Tropical Fluoride">Tropical Fluoride</option>
                            <option value="X-Ray">X-Ray</option>
                        </select>
                        <div class="invalid-feedback">
                            Please choose a type of service.
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Dentist/ Assistant Name</label>
                        <select name="aDA1" class="form-select" id="aDA1" required>
                            <?php
                            if (isset($resultforDA1)) {
                                foreach ($resultforDA1 as $row) {
                                    echo '<option value="' . $row["FullName"] . '">' . $row["FullName"] . '</option>';
                                }
                            } else {
                                echo '<option value="">Error!</option>';
                            }
                            ?>
                        </select>
                        <div class="invalid-feedback">
                            Please choose a Dentist / Assistant.
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Dentist/ Assistant Name (Write "Nil" if none)</label>
                        <select name="aDA2" class="form-select" id="aDA2" required>
                            <option value="NIL">Nil</option>
                            <?php
                            if (isset($resultforDA1)) {
                                foreach ($resultforDA1 as $row) {
                                    echo '<option value="' . $row["FullName"] . '">' . $row["FullName"] . '</option>';
                                }
                            } else {
                                echo '<option value="">Error!</option>';
                            }
                            ?>
                        </select>
                        <div class="invalid-feedback">
                            Please choose a Dentist/Assistant/NIL.
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Material used</label>
                        <textarea type="text" class="form-control" name="aMat" id="aMat" required></textarea>
                        <div class="invalid-feedback">
                            Please enter material used.
                        </div>
                    </div>
                    <div class="col-md-12 pt-3">
                        <div>
                            <a class="btn btn-primary" data-bs-toggle="collapse" href="#multiCollapseExample1" role="button" aria-expanded="false" aria-controls="multiCollapseExample1">Diagram</a>
                        </div>
                        <div class="collapse " id="multiCollapseExample1">
                            <img  class = "diagram"width="725" height="400" class="imgMain" src="img/Teeth/TeethDiagram.png" draggable="false" ondragstart="event.dataTransfer.setData('text/plain', 'hello')" />
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <textarea rows="8" type="text" class="form-control" name="attendDescription" id="attendDescription" required></textarea>
                        <div class="invalid-feedback">
                            Please enter description.
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary" name="attendBtn">Create</button>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Create Patient Treatment Record form -->
<div class="modal fade " id="createBtn" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form class="needs-validation" method="POST" novalidate>
                    <div class="mb-3">
                        <label class="form-label">Name of patient</label>
                        <input type="text" class="form-control" name="cPName" id="cPName" readonly>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" hidden>Patient ID</label>
                        <input type="text" class="form-control" name="cPatient_ID" id="cPatient_ID" hidden readonly>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Date of treatment</label>
                        <input type="date" class="form-control" name="cTDate" id="cTDate" required>
                        <div class="invalid-feedback">
                            Please select a date.
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Type of service</label>
                        <select class="form-select" aria-label="Default select example" name="createServiceType" id="createServiceType" required>
                        <option value="General Consultation">General Consultation</option>
                            <option value="Extraction, Anterior">Extraction, Anterior</option>
                            <option value="Extraction, Posterior">Extraction, Posterior</option>
                            <option value="Filling, simple">Filling, simple</option>
                            <option value="Filling, complex">Filling, complex</option>
                            <option value="Removable Denture, Complete(Upper or Lower">Removable Denture, Complete(Upper or Lower</option>
                            <option value="Removable Denture, Partial, Simple">Removable Denture, Partial, Simple</option>
                            <option value="Removable Denture, Partial, Complex">Removable Denture, Partial, Complex</option>
                            <option value="Denture Reline/Repair (Upper or Lower)">Denture Reline/Repair (Upper or Lower)</option>
                            <option value="Permanent Crown">Permanent Crown</option>
                            <option value="Root Canal Treatment (Anterior)">Root Canal Treatment (Anterior)</option>
                            <option value="Root Canal Treatment (Molar)">Root Canal Treatment (Molar)</option>
                            <option value="Root Canal Treatment (Pre-Molar)">Root Canal Treatment (Pre-Molar)</option>
                            <option value="Polishing">Polishing</option>
                            <option value="Scaling">Scaling</option>
                            <option value="Tropical Fluoride">Tropical Fluoride</option>
                            <option value="X-Ray">X-Ray</option>
                        </select>
                        <div class="invalid-feedback">
                            Please choose a type of service.
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Dentist/ Assistant Name</label>
                        <select name="cDA1" class="form-select" id="cDA1" required>
                            <?php
                            if (isset($resultforDA1)) {
                                foreach ($resultforDA1 as $row) {
                                    echo '<option value="' . $row["FullName"] . '">' . $row["FullName"] . '</option>';
                                }
                            } else {
                                echo '<option value="">Error!</option>';
                            }
                            ?>
                        </select>
                        <div class="invalid-feedback">
                            Please choose a Dentist/Assistant.
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Dentist/ Assistant Name (Write "Nil" if none)</label>
                        <select name="cDA2" class="form-select" id="cDA2" required>
                            <option value="NIL">Nil</option>
                            <?php
                            if (isset($resultforDA1)) {
                                foreach ($resultforDA1 as $row) {
                                    echo '<option value="' . $row["FullName"] . '">' . $row["FullName"] . '</option>';
                                }
                            } else {
                                echo '<option value="">Error!</option>';
                            }
                            ?>
                        </select>
                        <div class="invalid-feedback">
                            Please choose Dentist/Assistant/NIL.
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Material used</label>
                        <textarea type="text" class="form-control" name="cMat" id="cMat" required></textarea>
                        <div class="invalid-feedback">
                            Please enter material used.
                        </div>
                    </div>
                    <div class="col-md-12 pt-3">
                        <div>
                            <a class="btn btn-primary" data-bs-toggle="collapse" href="#multiCollapseExample1" role="button" aria-expanded="false" aria-controls="multiCollapseExample1">Diagram</a>
                        </div>
                        <div class="collapse " id="multiCollapseExample1">
                            <img width="760" height="400" class="imgMain" src="img/Teeth/TeethDiagram.png" draggable="false" ondragstart="event.dataTransfer.setData('text/plain', 'hello')" />
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <textarea rows="8" type="text" class="form-control" name="createDescription" id="createDescription" required></textarea>
                        <div class="invalid-feedback">
                            Please enter description.
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary" name="dentist_createBtn">Create</button>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Cancel Patient Appointment Modal -->
<div class="modal fade" id="cancelModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Cancel Appointment</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST">
                <div class="modal-body">
                    <input class="form-label" name="cancelPID" id="cancelPID" hidden>
                    <input class="form-label" name="cancelApptID" id="cancelApptID" hidden>
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
<!-- Edit Records Modal -->
<div class="modal fade" id="editRecordsModal" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Treatment details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form class="needs-validation" method="POST" novalidate>
                    <div class="mb-3">
                        <label class="form-label">Record ID:</label>
                        <input type="text" class="form-control" name="rID" id="rID" readonly>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Name of patient:</label>
                        <input type="text" class="form-control" name="name" id="name" readonly>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Date:</label>
                        <input type="date" class="form-control" name="Date" id="Date" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Type of service:</label>
                        <select class="form-select" aria-label="Default select example" name="editServiceType" id="editServiceType" required>
                        <option value="General Consultation">General Consultation</option>
                            <option value="Extraction, Anterior">Extraction, Anterior</option>
                            <option value="Extraction, Posterior">Extraction, Posterior</option>
                            <option value="Filling, simple">Filling, simple</option>
                            <option value="Filling, complex">Filling, complex</option>
                            <option value="Removable Denture, Complete(Upper or Lower">Removable Denture, Complete(Upper or Lower</option>
                            <option value="Removable Denture, Partial, Simple">Removable Denture, Partial, Simple</option>
                            <option value="Removable Denture, Partial, Complex">Removable Denture, Partial, Complex</option>
                            <option value="Denture Reline/Repair (Upper or Lower)">Denture Reline/Repair (Upper or Lower)</option>
                            <option value="Permanent Crown">Permanent Crown</option>
                            <option value="Root Canal Treatment (Anterior)">Root Canal Treatment (Anterior)</option>
                            <option value="Root Canal Treatment (Molar)">Root Canal Treatment (Molar)</option>
                            <option value="Root Canal Treatment (Pre-Molar)">Root Canal Treatment (Pre-Molar)</option>
                            <option value="Polishing">Polishing</option>
                            <option value="Scaling">Scaling</option>
                            <option value="Tropical Fluoride">Tropical Fluoride</option>
                            <option value="X-Ray">X-Ray</option>
                        </select>
                        <div class="invalid-feedback">
                            Please select a type of service.
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Material used:</label>
                        <textarea type="text" class="form-control" name="mat" id=mat pattern="^([A-Za-z]+[,.]?[ ]?|[A-Za-z]+['-]?)+$" required></textarea>
                        <div class="invalid-feedback">
                            Please enter material used.
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Description:</label>
                        <textarea type="text" class="form-control" name="updateDescription" id=updateDescription required></textarea>
                        <div class="invalid-feedback">
                            Please enter description.
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Dentist/Assistant 1:</label>
                        <select class="form-select" id="DA1" name="DA1" required>
                            <option value="NIL">NIL</option>
                            <?php
                            if (isset($resultforDA1)) {
                                foreach ($resultforDA1 as $row) {
                                    echo '<option value="' . $row["FullName"] . '">' . $row["FullName"] . '</option>';
                                }
                            } else {
                                echo '<option value="">Error!</option>';
                            }
                            ?>
                        </select>
                        <div class="invalid-feedback">
                            Please choose a Dentist/Assistant.
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Dentist/Assistant associated with treatment 2 (Select "Nil" if none)</label>
                        <select class="form-select" id="DA2" name="DA2" required>
                            <option value="NIL">NIL</option>
                            <?php
                            if (isset($resultforDA1)) {
                                foreach ($resultforDA1 as $row) {
                                    echo '<option value="' . $row["FullName"] . '">' . $row["FullName"] . '</option>';
                                }
                            } else {
                                echo '<option value="">Error!</option>';
                            }
                            ?>
                        </select>
                        <div class="invalid-feedback">
                            Please choose a Dentist/Assistant.
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Remarks:</label>
                        <textarea type="text" class="form-control" name="updateRemarks" id=updateRemarks required></textarea>
                        <div class="invalid-feedback">
                            Please add remarks.
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary float-end" name="dentist_editBtn">Edit</button>
                </form>
            </div>
        </div>
    </div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.min.js" integrity="sha384-j0CNLUeiqtyaRmlzUHCPZ+Gy5fQu0dQ6eZ/xAww941Ai1SxSY+0EQqNXNE6DZiVc" crossorigin="anonymous"></script>

<script>
    $('document').ready(function() {

        var newDate = new Date();
        var day = newDate.getDate();
        var month = newDate.getMonth() + 1;
        var year = newDate.getFullYear();
        if (month < 10) month = "0" + month;
        if (day < 10) day = "0" + day;
        var curDate = year + "-" + month + "-" + day;

        $('.attendBtn').click(function() {
            $apptID = $(this).closest('tr').find('td:nth-child(1)').text();
            $pID = $(this).closest('tr').find('td:nth-child(3)').text();
            $name = $(this).closest('tr').find('td:nth-child(4)').text();
            $('#aTDate').val(curDate);
            $('#Appt_ID').val($apptID);
            $('#PName').val($name);
            $('#Patient_ID').val($pID);
        });

        $('.createBtn').click(function() {
            $pID = $(this).closest('tr').find('td:nth-child(1)').text();
            $name = $(this).closest('tr').find('td:nth-child(2)').text();
            $('#cTDate').val(curDate);
            $('#cPName').val($name);
            $('#cPatient_ID').val($pID);
        });

        $('.editBtn').click(function() {
            $rID = $(this).closest('tr').find('td:nth-child(1)').text().trim();
            $name = $(this).closest('tr').find('td:nth-child(3)').text().trim();
            $splitName = $name.split(" ");
            $('#rID').val($rID);
            $('#name').val($name);
            $Date = $(this).closest('tr').find('td:nth-child(4)').text().trim();
            $service = $(this).closest('tr').find('td:nth-child(5)').text().trim();
            $DA1 = $(this).closest('tr').find('td:nth-child(9)').text().trim();
            $DA2 = $(this).closest('tr').find('td:nth-child(10)').text().trim();
            $mat = $(this).closest('tr').find('td:nth-child(7)').text().trim();
            $description = $(this).closest('tr').find('td:nth-child(6)').text().trim();
            $remarks = $(this).closest('tr').find('td:nth-child(11)').text().trim();
            // console.log($remarks);
            $('#Date').val($Date);
            $('#editServiceType').val($service);
            $('#DA1').val($DA1);
            $('#DA2').val($DA2);
            $('#mat').val($mat);
            $('#updateDescription').val($description);
            $('#updateRemarks').val($remarks);
        });
        $('.cancelBtn').click(function() {
            $apptID = $(this).closest('tr').find('td:nth-child(1)').text();
            $pID = $(this).closest('tr').find('td:nth-child(3)').text();
            $('#cancelPID').val($pID);
            $('#cancelApptID').val($apptID);
        });
    });
</script>
<script>
    function refreshPage() {
        window.location.reload();
    }
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