<?php
ob_start();
$path = basename($_SERVER['PHP_SELF'], ".php");
include 'db_connection.php';
include 'Navbar.php';
include 'Dentist.php';

?>
<html>

<head>
    <title> Attending Patient </title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
    <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <!-- Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
    <style>
        p,
        td {
            font-family: garamond;
            font-size: 14pt;
        }

        td,
        th {
            border: 1px solid #ddd;
        }

        table {
            width: 50%;
            background-color: white;
            text-align: left;
        }

        .center {
            text-align: center;
        }

        .errorMsg {
            color: red;
        }

        .button {
            position: absolute;
            left: 100px;
            top: 100px;
            background-color: #9E989B;
            border: none;
            color: white;
            padding: 15px 32px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            margin: 4px 2px;
            cursor: pointer;
        }

        .button {
            border-radius: 12px;
        }

        body {
            background-image: url('img/AdminBackground.png');
            background-repeat: no-repeat;
            background-attachment: fixed;
            background-size: cover;
        }

        .form-outline {
            background-color: white;

        }

        .topnav input[type=text] {
            border: 5px solid #ccc;
        }

        .content-wrapper {
            transition: all 0.3s ease;
            margin-left: 288px;
        }

        .list-group-item {
            background-color: transparent;
            color: #fff;
            border: 1px solid #ddd;
            width: 18rem;
        }

        .accPassword {
            -webkit-text-security: disc;
        }

        .tab-pane {
            background-color: white;
            border-left: 1px solid #ddd;
            border-right: 1px solid #ddd;
            border-bottom: 1px solid #ddd;
            border-radius: 0px 0px 5px 5px;
            padding: 10px;
        }
        .diagram {

            width: 100%;
    height: 15vw;
    object-fit: cover;

        }
    </style>
</head>

<body>
    <div id="content-wrapper" class="content-wrapper">
        <div class="row p-3">
            <div class="col-4">
                <div class="card">
                    <div class="card-header">
                        <h5><u>Treatment Record</u></h5>
                    </div>
                    <div class="card-body">
                        <form class="needs-validation" method="POST" novalidate>
                            <div class="mb-3">
                                <label class="form-label" hidden>Appointment ID</label>
                                <input type="text" class="form-control" name="Appt_ID" id="Appt_ID" hidden readonly>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Date of treatment</label>
                                <input type="date" class="form-control" name="aTDate" id="aTDate" value="<?php echo date('Y-m-d'); ?>" readonly>
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
                                <label class="form-label">Dentist/Assistant associated with treatment 1</label>
                                <select name="aDA1" class="form-select" id="aDA1" required>
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
                                    Please choose a Dentist/Assistant.
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Dentist/Assistant associated with treatment 2 (Write "Nil" if none)</label>
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
                                <div class="collapse mt-3" id="multiCollapseExample1">
                                    <img class = "diagram" width="685" height="400" class="imgMain" src="img/Teeth/TeethDiagram.png" draggable="false" ondragstart="event.dataTransfer.setData('text/plain', 'hello')" />
                                    <!-- <img class="img1" src="img/Teeth/UpperTeeth.png" draggable="true" ondragstart="event.dataTransfer.setData('text/plain', 'Right Molar 1')" />
                                    <img class="img2" src="img/Teeth/UpperTeeth2.png" draggable="true" ondragstart="event.dataTransfer.setData('text/plain', 'Right Molar 2')" />
                                    <img class="img3" src="img/Teeth/UpperTeeth3.png" draggable="true" ondragstart="event.dataTransfer.setData('text/plain', 'Right Molar 3')" />
                                    <img class="img4" src="img/Teeth/UpperTeeth4.png" draggable="true" ondragstart="event.dataTransfer.setData('text/plain', 'Right Premolar 1')" />
                                    <img class="img5" src="img/Teeth/UpperTeeth5.png" draggable="true" ondragstart="event.dataTransfer.setData('text/plain', 'Right Premolar 2')" />
                                    <img class="img6" src="img/Teeth/UpperTeeth6.png" draggable="true" ondragstart="event.dataTransfer.setData('text/plain', 'Right Canine 1')" />
                                    <img class="img7" src="img/Teeth/UpperTeeth7.png" draggable="true" ondragstart="event.dataTransfer.setData('text/plain', 'Incisors 1')" />
                                    <img class="img8" src="img/Teeth/UpperTeeth8.png" draggable="true" ondragstart="event.dataTransfer.setData('text/plain', 'Incisors 2')" />
                                    <img class="img9" src="img/Teeth/UpperTeeth9.png" draggable="true" ondragstart="event.dataTransfer.setData('text/plain', 'Incisors 3')" />
                                    <img class="img10" src="img/Teeth/UpperTeeth10.png" draggable="true" ondragstart="event.dataTransfer.setData('text/plain', 'Incisors 4')" />
                                    <img class="img11" src="img/Teeth/UpperTeeth11.png" draggable="true" ondragstart="event.dataTransfer.setData('text/plain', 'Left Canine 1')" />
                                    <img class="img12" src="img/Teeth/UpperTeeth12.png" draggable="true" ondragstart="event.dataTransfer.setData('text/plain', 'Left Premolar 1')" />
                                    <img class="img13" src="img/Teeth/UpperTeeth13.png" draggable="true" ondragstart="event.dataTransfer.setData('text/plain', 'Left Premolar 2')" />
                                    <img class="img14" src="img/Teeth/UpperTeeth14.png" draggable="true" ondragstart="event.dataTransfer.setData('text/plain', 'Left Molar 1')" />
                                    <img class="img15" src="img/Teeth/UpperTeeth15.png" draggable="true" ondragstart="event.dataTransfer.setData('text/plain', 'Left Molar 2')" />
                                    <img class="img16" src="img/Teeth/UpperTeeth16.png" draggable="true" ondragstart="event.dataTransfer.setData('text/plain', 'Left Molar 3')" />
                                    <img class="img17" src="img/Teeth/LowerTeeth1.png" draggable="true" ondragstart="event.dataTransfer.setData('text/plain', 'Lower Right Molar 1')" />
                                    <img class="img18" src="img/Teeth/LowerTeeth2.png" draggable="true" ondragstart="event.dataTransfer.setData('text/plain', 'Lower Right Molar 2')" />
                                    <img class="img19" src="img/Teeth/LowerTeeth3.png" draggable="true" ondragstart="event.dataTransfer.setData('text/plain', 'Lower Right Molar 3')" />
                                    <img class="img20" src="img/Teeth/LowerTeeth4.png" draggable="true" ondragstart="event.dataTransfer.setData('text/plain', 'Lower Right Premolar 1')" />
                                    <img class="img21" src="img/Teeth/LowerTeeth5.png" draggable="true" ondragstart="event.dataTransfer.setData('text/plain', 'Lower Right Premolar 2')" />
                                    <img class="img22" src="img/Teeth/LowerTeeth6.png" draggable="true" ondragstart="event.dataTransfer.setData('text/plain', 'Lower Right Canine 1')" />
                                    <img class="img23" src="img/Teeth/LowerTeeth7.png" draggable="true" ondragstart="event.dataTransfer.setData('text/plain', 'Lower Right Incisors 1')" />
                                    <img class="img24" src="img/Teeth/LowerTeeth8.png" draggable="true" ondragstart="event.dataTransfer.setData('text/plain', 'Lower Right Incisors 2')" />
                                    <img class="img25" src="img/Teeth/LowerTeeth9.png" draggable="true" ondragstart="event.dataTransfer.setData('text/plain', 'Lower Left Incisors 2')" />
                                    <img class="img26" src="img/Teeth/LowerTeeth10.png" draggable="true" ondragstart="event.dataTransfer.setData('text/plain', 'Lower Left Incisors 1')" />
                                    <img class="img27" src="img/Teeth/LowerTeeth11.png" draggable="true" ondragstart="event.dataTransfer.setData('text/plain', 'Lower Left Canine 1')" />
                                    <img class="img28" src="img/Teeth/LowerTeeth12.png" draggable="true" ondragstart="event.dataTransfer.setData('text/plain', 'Lower Left Premolar 2')" />
                                    <img class="img29" src="img/Teeth/LowerTeeth13.png" draggable="true" ondragstart="event.dataTransfer.setData('text/plain', 'Lower Left Premolar 1')" />
                                    <img class="img30" src="img/Teeth/LowerTeeth14.png" draggable="true" ondragstart="event.dataTransfer.setData('text/plain', 'Lower Left Molar 3')" />
                                    <img class="img31" src="img/Teeth/LowerTeeth15.png" draggable="true" ondragstart="event.dataTransfer.setData('text/plain', 'Lower Left Molar 2')" />
                                    <img class="img32" src="img/Teeth/LowerTeeth16.png" draggable="true" ondragstart="event.dataTransfer.setData('text/plain', 'Lower Left Molar 1')" /> -->
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
            <div class="col-8">
                <div class="card text-center">
                    <div class="card-header">
                        <h5><u>Patient Information</u></h5>
                    </div>
                    <ul class="nav nav-tabs" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" data-bs-toggle="tab" href="#details">Personal Details</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab" href="#medicalInfo">Medical Information</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab" href="#treatment">Treatment History</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab" href="#emergency">Emergency Contact</a>
                        </li>
                    </ul>
                    <?php
                    if (isset($attendPatientInfo)) {
                        echo
                        '
                    <div class="tab-content">
                        <div id="details" class="tab-pane active"><br>
                            <div class="row g-4">
                                <div class="col-3">
                                    <label class="label fw-light">First Name:</label>
                                    <p>' . $attendPatientInfo[0]['First_Name'] . '</p>
                                </div>
                                <div class="col-3">
                                    <label class="label fw-light">Last Name:</label>
                                    <p>' . $attendPatientInfo[0]['Last_Name'] . '</p>
                                </div>
                                <div class="col-3">
                                    <label class="label fw-light">NRIC/Passport No.:</label>
                                    <p>' . $attendPatientInfo[0]['NRIC_PNum'] . '</p>
                                </div>
                                <div class="col-3">
                                    <label class="label fw-light">Date of Birth:</label>
                                    <p>' . $attendPatientInfo[0]['Birth_Date'] . '</p>
                                </div>
                                <div class="col-3">
                                    <label class="label fw-light">Gender:</label>
                                    <p>' . $attendPatientInfo[0]['Gender'] . '</p>
                                </div>
                                <div class="col-3">
                                    <label class="label fw-light">Mobile Number:</label>
                                    <p>' . $attendPatientInfo[0]['Phone_Num'] . '</p>
                                </div>
                                <div class="col-3">
                                    <label class="label fw-light">Email:</label>
                                    <p>' . $attendPatientInfo[0]['Email'] . '</p>
                                </div>
                                <div class="col-3">
                                </div>
                            </div>
                        </div>
                        <div id="medicalInfo" class="tab-pane fade"><br>
                            <div class="row g-3">
                                <div class="col-6">
                                    <label class="title-label fw-light">Smoker?</label>
                                    <p>' . $attendPatientInfo[0]['Smoker'] . '</p>
                                </div>
                                <div class="col-6">
                                    <label class="title-label fw-light">Any allergies?</label>
                                    <p>' . (!empty($attendPatientInfo[0]['Allergies']) ? $attendPatientInfo[0]['Allergies'] : "N/A") . '</p>
                                </div>
                                <div class="col-6">
                                    <label class="title-label fw-light">Any long term medications?:</label>
                                    <p>' . (!empty($attendPatientInfo[0]['Long_term_med']) ? $attendPatientInfo[0]['Long_term_med'] : "N/A") . '</p>
                                </div>
                                <div class="col-6">
                                    <label class="title-label fw-light">Any existing medication conditions?:</label>
                                    <p>' . (!empty($attendPatientInfo[0]['Existing_Med_Conds']) ? $attendPatientInfo[0]['Existing_Med_Conds'] : "N/A") . '</p>
                                </div>
                            </div>
                        </div>
                        ';
                        echo
                        '
                        <div id="treatment" class="tab-pane fade"><br>';
                        if (isset($patientHistoryRec)) {
                            foreach ($patientHistoryRec as $records) {
                                echo
                                '
                                <label class="fs-5 float-start">Record ID: ' . $records['Record_ID'] . '</label>
                                <div class="row row-cols-7 mb-3">
                                    <div class="col">
                                        <label class="title-label fw-light">Date of treatment:</label>
                                        <p>' . $records['Treatment_Date'] . '</p>
                                    </div>
                                    <div class="col">
                                        <label class="title-label fw-light">Type of service:</label>
                                        <p>' . $records['Treatment_type'] . '</p>
                                    </div>
                                    <div class="col">
                                        <label class="title-label fw-light">Treatment Description:</label>
                                        <p>' . $records['Treatment_details'] . '</p>
                                    </div>
                                    <div class="col">
                                        <label class="title-label fw-light">Clinic Name:</label>
                                        <p>' . $records['Company'] . '</p>
                                    </div>
                                    <div class="col">
                                        <label class="title-label fw-light">Treated by:</label>
                                        <p>' . $records['Doctor/Assistant 1'] . '</p>
                                    </div>
                                    <div class="col">
                                        <label class="title-label fw-light">Assisted by:</label>
                                        <p>' . $records['Doctor/Assistant 2'] . '</p>
                                    </div>
                                    <div class="col">
                                        <label class="title-label fw-light">Remarks:</label>
                                        <p>' . (!empty($records['Remarks']) ? $records['Remarks'] : "N/A") . '</p>
                                    </div>
                                </div>
                                <hr>
                            ';
                            }
                            echo
                            '</div>';
                        } else {
                            echo '<label class="fs-5 float-start"> No records available.</label>';
                            echo
                            '</div>';
                        }
                        echo
                        '
                        <div id="emergency" class="tab-pane fade"><br>
                            <div class="row g-3">
                                <div class="col-4">
                                    <label class="title-label fw-light">Full Name:</label>
                                    <p>' . $attendPatientInfo[0]['Emer_Name'] . '</p>
                                </div>
                                <div class="col-4">
                                    <label class="title-label fw-light">Mobile Number:</label>
                                    <p>' . $attendPatientInfo[0]['Emer_Contact'] . '</p>
                                </div>
                                <div class="col-4">
                                    <label class="title-label fw-light">Relation:</label>
                                    <p>' . $attendPatientInfo[0]['Emer_relation'] . '</p>
                                </div>
                            </div>
                        </div>
                        ';
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</body>
<script>
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

</html>