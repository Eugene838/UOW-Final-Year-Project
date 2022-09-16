<?php
$db = new DB_Connect();
$company = $_SESSION['Company'];
if (!isset($_SESSION['Role']) && empty($_SESSION['Role'])) {
    header("Location: index.php");
    exit();
} else {
    if($path == "viewRecords" || $path == "SuperAdmin") {
        if (!isset($_SESSION['dapatientrecords']) && empty($_SESSION['dapatientrecords'])) {
            $db = new DB_Connect();
            //$company = $_SESSION['Company'];

            $stmt = $db->connect()->prepare("SELECT r.Record_ID, profile.First_Name, profile.Last_Name, profile.NRIC_PNum, profile.Birth_Date, 
            r.Treatment_Date, r.Treatment_Type, r.Treatment_details, r.Material_used, `Doctor/Assistant 1`, `Doctor/Assistant 2` FROM dentianDatabase.patient_record 
            as r INNER JOIN wixDatabase.wixPatients as profile on profile.Patient_ID = r.Patient_ID WHERE r.Company = ? order by r.Treatment_Date DESC");
            $stmt->execute([$company]);
            // $errormsg = '';
            // $rowCount = '';
            if ($stmt->rowCount() > 0) {
                $da_patient_records = $stmt->fetchAll(PDO::FETCH_ASSOC);
            }
        } else {
            $da_patient_records = $_SESSION['dapatientrecords'];
            // $errormsg = $_SESSION['errorMsg'];
            // $rowCount = $_SESSION['rowCount'];
        }
        // Search - see all records
        if (isset($_POST["allRecords"])) {
            unset($_SESSION['dapatientrecords']);
            $db = new DB_Connect();
            $company = $_SESSION['Company'];

            $stmt = $db->connect()->prepare("SELECT r.Record_ID, profile.First_Name, profile.Last_Name, profile.NRIC_PNum, profile.Birth_Date, 
            r.Treatment_Date, r.Treatment_Type, r.Treatment_details, r.Material_used, `Doctor/Assistant 1`, `Doctor/Assistant 2` FROM dentianDatabase.patient_record  as
            r INNER JOIN wixDatabase.wixPatients as profile on profile.Patient_ID = r.Patient_ID WHERE r.Company = ? order by r.Treatment_Date DESC");
            $stmt->execute([$company]);

            if ($stmt->rowCount() > 0) {
                $da_patient_records = $stmt->fetchAll(PDO::FETCH_ASSOC);
                $errormsg = '';
                $rowCount = '';
            }
        }
    }
    if($path == "viewPatients" || $path == "SuperAdmin") {
        if (!isset($_SESSION['patientprof']) && empty($_SESSION['patientprof'])) {
            $stmt = $db->connectWix()->prepare("SELECT * FROM wixPatients");
            $stmt->execute();
            if ($stmt->rowCount() > 0) {
                $da_patients_profile = $stmt->fetchAll(PDO::FETCH_ASSOC);
            }
        } else {
            $da_patients_profile =  $_SESSION['patientprof'];
            // $errormsg = $_SESSION['errorMsg'];
            // $rowCount = $_SESSION['rowCount'];
        }
        if (isset($_POST["allPatients"])) {
            unset($_SESSION['patientprof']);
            $db = new DB_Connect();
            $company = $_SESSION['Company'];

            $stmt = $db->connectWix()->prepare("SELECT * FROM wixPatients");
            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                $da_patient_records = $stmt->fetchAll(PDO::FETCH_ASSOC);
                // $errormsg = '';
                // $rowCount = '';
            }
        }
    }
}

?>
<!-- View Treatment Modal -->
<div class="modal fade" id="viewAcc" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
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
                    <input type="text" class="form-control" name="recID" id="recID" readonly>
                </div>
                <div class="mb-3">
                    <label class="form-label">First Name</label>
                    <input type="text" class="form-control" name="fname" id="fname" readonly>
                </div>
                <div class="mb-3">
                    <label class="form-label">Last Name</label>
                    <input type="text" class="form-control" name="lname" id="lname" readonly>
                </div>
                <div class="mb-3">
                    <label class="form-label">NRIC/Passport No.</label>
                    <input type="text" class="form-control" name="view_nric" id="view_nric" readonly>
                </div>
                <!-- <div class="mb-3">
                            <label class="form-label">Phone Number</label>
                            <input type="text" class="form-control" pattern="[8-9]{1}[0-9]{7}" name="view_mobileNum" id="view_mobileNum" readonly>
                        </div> -->
                <div class="mb-3">
                    <label class="form-label">Visit date</label>
                    <input type="date" class="form-control" name="dateVisit" id="dateVisit" readonly>
                </div>
                <div class="mb-3">
                    <label class="form-label">Treatment Type</label>
                    <input type="text" class="form-control" name="Treatment_type" id="Treatment_type" readonly>
                </div>
                <div class="mb-3">
                    <label class="form-label">Treatment Details</label>
                    <textarea class="form-control" name="Treatment_details" id="Treatment_details" readonly></textarea>
                </div>
                <div class="mb-3">
                    <label class="form-label">Materials Used</label>
                    <textarea class="form-control" name="view_Materials" id="view_Materials" readonly></textarea>
                </div>
                <div class="mb-3">
                    <label class="form-label">Dentist Involved</label>
                    <input type="text" class="form-control" name="view_Den" id="view_Den" readonly>
                </div>
                <div class="mb-3">
                    <label class="form-label">Dentist Assistant Involved</label>
                    <input type="text" class="form-control" name="view_Ass" id="view_Ass" readonly>
                </div>
                <!-- </form> -->
            </div>
        </div>
    </div>
</div>

<!-- View Patient Modal -->
<div class="modal fade" id="viewPatientProfile" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Patient's details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- <form class="needs-validation" method="POST" novalidate> -->
                <!-- <div class="mb-3">
                    <label class="form-label">Patient ID</label>
                    <input type="text" class="form-control" name="view_pID" id="view_pID" readonly>
                </div> -->
                <div class="mb-3">
                    <label class="form-label">First Name</label>
                    <input type="text" class="form-control" name="view_fname" id="view_fname" readonly>
                </div>
                <div class="mb-3">
                    <label class="form-label">Last Name</label>
                    <input type="text" class="form-control" name="view_lname" id="view_lname" readonly>
                </div>
                <div class="mb-3">
                    <label class="form-label">NRIC/Passport No.</label>
                    <input type="text" class="form-control" name="view_nric" id="view_nric" readonly>
                </div>
                <div class="mb-3">
                    <label class="form-label">Date of Birth</label>
                    <input type="date" class="form-control" name="view_dob" id="view_dob" readonly>
                </div>
                <div class="mb-3">
                    <label class="form-label">Gender</label>
                    <input type="text" class="form-control" name="view_gender" id="view_gender" readonly>
                </div>
                <div class="mb-3">
                    <label class="form-label">Phone Number</label>
                    <input type="text" class="form-control" name="view_mobileNum" id="view_mobileNum" readonly>
                </div>
                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="text" class="form-control" name="view_email" id="view_email" readonly>
                </div>
                <div class="mb-3">
                    <label class="form-label">Marital Status</label>
                    <input type="text" class="form-control" name="view_marital" id="view_marital" readonly>
                </div>
                <div class="mb-3">
                    <label class="form-label">Occupation</label>
                    <input type="text" class="form-control" name="view_occupation" id="view_occupation" readonly>
                </div>
                <div class="mb-3">
                    <label class="form-label">Smoker?</label>
                    <input type="text" class="form-control" name="view_smoker" id="view_smoker" readonly>
                </div>
                <div class="mb-3">
                    <label class="form-label">Allergies?</label>
                    <textarea class="form-control" name="view_allergies" id="view_allergies" readonly></textarea>
                </div>
                <div class="mb-3">
                    <label class="form-label">Long Term Medications?</label>
                    <textarea class="form-control" name="view_ltm" id="view_ltm" readonly></textarea>
                </div>
                <div class="mb-3">
                    <label class="form-label">Exisiting Medication Conditions?</label>
                    <textarea class="form-control" name="view_existmed" id="view_existmed" readonly></textarea>
                </div>
                <div class="mb-3">
                    <label class="form-label">Emergency Contact Name</label>
                    <input type="text" class="form-control" name="view_emername" id="view_emername" readonly>
                </div>
                <div class="mb-3">
                    <label class="form-label">Emergency Contact Number</label>
                    <input type="text" class="form-control" name="view_emernum" id="view_emernum" readonly>
                </div>
                <div class="mb-3">
                    <label class="form-label">Emergency Contact Relation</label>
                    <input type="text" class="form-control" name="view_emerrs" id="view_emerrs" readonly>
                </div>
                <!-- </form> -->
            </div>
        </div>
    </div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.min.js" integrity="sha384-j0CNLUeiqtyaRmlzUHCPZ+Gy5fQu0dQ6eZ/xAww941Ai1SxSY+0EQqNXNE6DZiVc" crossorigin="anonymous"></script>
<script>
    $('document').ready(function() {
        $('.viewRecBtn').click(function() {
            $rID = $(this).closest('tr').find('th:nth-child(1)').text().trim();
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


            $('#recID').val($rID);
            $('#fname').val($first);
            $('#lname').val($last);
            $('#view_nric').val($nric);
            // $('#view_mobileNum').val($hp);
            $('#dateVisit').val($dov[2] + '-' + $dov[1] + '-' + $dov[0]);
            $('#Treatment_type').val($treat_type);
            $('#Treatment_details').val($treat_dets);
            $('#view_Materials').val($materials);
            $('#view_Den').val($dentists);
            $('#view_Ass').val($assists);
        });
    });
</script>