<?php
ob_start();
include 'db_connection.php';
include 'Navbar.php';

if (!isset($_SESSION['Role']) && empty($_SESSION['Role'])) {
    header("Location: index.php");
}

if (isset($_POST["recept_updateBtn"])) {

    $db = new DB_Connect();
    $patientID = $_GET['PatientID'];
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
        $allergyList = "";
    }

    $ltm = $_POST['ltm'];
    if ($ltm == "Yes") {
        $ltmList = $_POST['ltmList'];
    } else {
        $ltmList = "";
    }

    $eMeds = $_POST['existMeds'];
    if ($eMeds == "Yes") {
        $eMedList = $_POST['eMedList'];
    } else {
        $eMedList = "";
    }

    $referral = $_POST['referBy'];
    if ($referral == "Yes") {
        $referredBy = $_POST['referredBy'];
        $referredMemo = $_POST['referredMemo'];
    } else {
        $referredBy = "";
        $referredMemo = "";
    }


    // $family = $_POST['family'];
    // if ($family == "Yes") {
    //     $famID = $_POST['familyID'];
    // } else {
    //     $famID = "N/A";
    // }
    $subsidy = $_POST['subsidy'];


    $stmt = $db->connectWix()->prepare("UPDATE `wixPatients` SET 
                `First_Name`='$firstname',
                `Last_Name`='$lastname',
                `NRIC_PNum`='$nric_pnum',
                `Nationality`='$nationality',
                `Gender`='$gender',
                `Phone_Num`='$phoneNum',
                `Birth_Date`='$dob',
                `Address`='$address',
                `Email`='$email',
                `Marital_Status`='$marital',
                `Occupation`='$occupation',
                `Smoker`='$smoker',
                `Emer_Name`='$emer_name',
                `Emer_Contact`='$emer_phone',
                `Emer_relation`='$emer_rs',
                `Allergies`='$allergyList',
                `Long_term_med`='$ltmList',
                `Existing_Med_Conds`='$eMedList',
                `Referred_by_clinic`='$referredBy',
                `Referred_memo`='$referredMemo',
                `Subsidies`='$subsidy'
                WHERE `Patient_ID`=$patientID");
    $stmt->execute();
    if ($stmt->rowCount() > 0) {
        $_SESSION['alert'] = '<div class="alert alert-success" role="alert-msg" id="alert">Patient has been successfully updated! <i class="bi bi-person-check"></i></div>';
    } else {
        $_SESSION['alert'] = '<div class="alert alert-danger" role="alert">Error! Unable to update patient profile. <i class="bi bi-exclamation-circle"></i></div>';
    }
}
$patientID = $_GET['PatientID'];
$db = new DB_Connect();
$stmt = $db->connectWix()->prepare("SELECT * FROM wixPatients WHERE Patient_ID = $patientID");
$stmt->execute();

if ($stmt->rowCount() > 0) {
    $recept_patients_profile = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>

<html>

<head>
    <title> Receptionist Page </title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
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

        .search {
            display: inline-block;
            font-weight: 400;
            line-height: 1.5;
            width: 400px;
            color: #212529;
            vertical-align: middle;
            background-color: #fff;
            background-clip: padding-box;
            border: 1px solid #ced4da;
            padding: 0.375rem 0.75rem;
            font-size: 1rem;
            border-radius: 0.25rem;
            position: relative;
            left: 25%;

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
    </style>
</head>

<body>
    <?php
    echo
    '
    <div class="container-fluid col-6 mt-4 mb-4 bg-light"> ';
    if (isset($_SESSION['alert'])) {
        echo $_SESSION['alert'];
    }
    echo'
        <!-- Content here -->
        <form class="row g-3 needs-validation" method="POST" action="PatientProfile.php?PatientID=' . $_GET['PatientID'] . '" novalidate>
            <div class="col-md-12">
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" id="editMode" name="editMode" onclick="change(); this.disabled=true;">
                    <label class="form-check-label" for="flexSwitchCheckDefault">Edit Mode</label>
                </div>
            </div>
            <div class="col-md-6">
                <label class="form-label">First Name</label>
                <input type="text" class="form-control" name="firstName" id="firstName" pattern="^([A-Za-z]+[,.]?[ ]?|[A-Za-z]+[\'-]?)+$" value="' . $recept_patients_profile[0]['First_Name'] . '" readonly>
                <div class="invalid-feedback">
                    Please enter first name.
                </div>
            </div>
            <div class="col-md-6">
                <label class="form-label">Last Name</label>
                <input type="text" class="form-control" name="lastName" id="lastName" pattern="^([A-Za-z]+[,.]?[ ]?|[A-Za-z]+[\'-]?)+$" value="' . $recept_patients_profile[0]['Last_Name'] . '" readonly>
                <div class="invalid-feedback">
                    Please enter last name.
                </div>
            </div>
            <div class="col-md-6">
                <label class="form-label">NRIC/Passport No.</label>
                <input type="text" class="form-control" name="nric_pnum" id="nric_pnum" pattern="[A-Za-z][0-9]{7}[A-Za-z]" value="' . $recept_patients_profile[0]['NRIC_PNum'] . '" readonly>
                <div class="invalid-feedback">
                    Please enter a valid NRIC/Passport No.
                </div>
            </div>
            <div class="col-md-6">
                <label class="form-label">Nationality</label>
                <select class="form-select" aria-label="Default select example" name="nationality" id="nationality" disabled>
                    <option value="">-- Select one --</option>
                    <option value="Afghan">Afghan</option>
                    <option value="Albanian">Albanian</option>
                    <option value="Algerian">Algerian</option>
                    <option value="American">American</option>
                    <option value="Andorran">Andorran</option>
                    <option value="Angolan">Angolan</option>
                    <option value="Antiguans">Antiguans</option>
                    <option value="Argentinean">Argentinean</option>
                    <option value="Armenian">Armenian</option>
                    <option value="Australian">Australian</option>
                    <option value="Austrian">Austrian</option>
                    <option value="Azerbaijani">Azerbaijani</option>
                    <option value="Bahamian">Bahamian</option>
                    <option value="Bahraini">Bahraini</option>
                    <option value="Bangladeshi">Bangladeshi</option>
                    <option value="Barbadian">Barbadian</option>
                    <option value="Barbudans">Barbudans</option>
                    <option value="Batswana">Batswana</option>
                    <option value="Belarusian">Belarusian</option>
                    <option value="Belgian">Belgian</option>
                    <option value="Belizean">Belizean</option>
                    <option value="Beninese">Beninese</option>
                    <option value="Bhutanese">Bhutanese</option>
                    <option value="Bolivian">Bolivian</option>
                    <option value="Bosnian">Bosnian</option>
                    <option value="Brazilian">Brazilian</option>
                    <option value="British">British</option>
                    <option value="Bruneian">Bruneian</option>
                    <option value="Bulgarian">Bulgarian</option>
                    <option value="Burkinabe">Burkinabe</option>
                    <option value="Burmese">Burmese</option>
                    <option value="Burundian">Burundian</option>
                    <option value="Cambodian">Cambodian</option>
                    <option value="Cameroonian">Cameroonian</option>
                    <option value="Canadian">Canadian</option>
                    <option value="Cape Verdean">Cape Verdean</option>
                    <option value="Central African">Central African</option>
                    <option value="Chadian">Chadian</option>
                    <option value="Chilean">Chilean</option>
                    <option value="Chinese">Chinese</option>
                    <option value="Colombian">Colombian</option>
                    <option value="Comoran">Comoran</option>
                    <option value="Congolese">Congolese</option>
                    <option value="Costa Rican">Costa Rican</option>
                    <option value="Croatian">Croatian</option>
                    <option value="Cuban">Cuban</option>
                    <option value="Cypriot">Cypriot</option>
                    <option value="Czech">Czech</option>
                    <option value="Danish">Danish</option>
                    <option value="Djibouti">Djibouti</option>
                    <option value="Dominican">Dominican</option>
                    <option value="Dutch">Dutch</option>
                    <option value="East Timorese">East Timorese</option>
                    <option value="Ecuadorean">Ecuadorean</option>
                    <option value="Egyptian">Egyptian</option>
                    <option value="Emirian">Emirian</option>
                    <option value="Equatorial Guinean">Equatorial Guinean</option>
                    <option value="Eritrean">Eritrean</option>
                    <option value="Estonian">Estonian</option>
                    <option value="Ethiopian">Ethiopian</option>
                    <option value="Fijian">Fijian</option>
                    <option value="Filipino">Filipino</option>
                    <option value="Finnish">Finnish</option>
                    <option value="French">French</option>
                    <option value="Gabonese">Gabonese</option>
                    <option value="Gambian">Gambian</option>
                    <option value="Georgian">Georgian</option>
                    <option value="German">German</option>
                    <option value="Ghanaian">Ghanaian</option>
                    <option value="Greek">Greek</option>
                    <option value="Grenadian">Grenadian</option>
                    <option value="Guatemalan">Guatemalan</option>
                    <option value="Guinea-Bissauan">Guinea-Bissauan</option>
                    <option value="Guinean">Guinean</option>
                    <option value="Guyanese">Guyanese</option>
                    <option value="Haitian">Haitian</option>
                    <option value="Herzegovinian">Herzegovinian</option>
                    <option value="Honduran">Honduran</option>
                    <option value="Hungarian">Hungarian</option>
                    <option value="Icelander">Icelander</option>
                    <option value="Indian">Indian</option>
                    <option value="Indonesian">Indonesian</option>
                    <option value="Iranian">Iranian</option>
                    <option value="Iraqi">Iraqi</option>
                    <option value="Irish">Irish</option>
                    <option value="Israeli">Israeli</option>
                    <option value="Italian">Italian</option>
                    <option value="Ivorian">Ivorian</option>
                    <option value="Jamaican">Jamaican</option>
                    <option value="Japanese">Japanese</option>
                    <option value="Jordanian">Jordanian</option>
                    <option value="Kazakhstani">Kazakhstani</option>
                    <option value="Kenyan">Kenyan</option>
                    <option value="Kittian and Nevisian">Kittian and Nevisian</option>
                    <option value="Kuwaiti">Kuwaiti</option>
                    <option value="Kyrgyz">Kyrgyz</option>
                    <option value="Laotian">Laotian</option>
                    <option value="Latvian">Latvian</option>
                    <option value="Lebanese">Lebanese</option>
                    <option value="Liberian">Liberian</option>
                    <option value="Libyan">Libyan</option>
                    <option value="Liechtensteiner">Liechtensteiner</option>
                    <option value="Lithuanian">Lithuanian</option>
                    <option value="Luxembourger">Luxembourger</option>
                    <option value="Macedonian">Macedonian</option>
                    <option value="Malagasy">Malagasy</option>
                    <option value="Malawian">Malawian</option>
                    <option value="Malaysian">Malaysian</option>
                    <option value="Maldivan">Maldivan</option>
                    <option value="Malian">Malian</option>
                    <option value="Maltese">Maltese</option>
                    <option value="Marshallese">Marshallese</option>
                    <option value="Mauritanian">Mauritanian</option>
                    <option value="Mauritian">Mauritian</option>
                    <option value="Mexican">Mexican</option>
                    <option value="Micronesian">Micronesian</option>
                    <option value="Moldovan">Moldovan</option>
                    <option value="Monacan">Monacan</option>
                    <option value="Mongolian">Mongolian</option>
                    <option value="Moroccan">Moroccan</option>
                    <option value="Mosotho">Mosotho</option>
                    <option value="Motswana">Motswana</option>
                    <option value="Mozambican">Mozambican</option>
                    <option value="Namibian">Namibian</option>
                    <option value="Nauruan">Nauruan</option>
                    <option value="Nepalese">Nepalese</option>
                    <option value="New Zealander">New Zealander</option>
                    <option value="Ni-Vanuatu">Ni-Vanuatu</option>
                    <option value="Nicaraguan">Nicaraguan</option>
                    <option value="Nigerien">Nigerien</option>
                    <option value="North Korean">North Korean</option>
                    <option value="Northern Irish">Northern Irish</option>
                    <option value="Norwegian">Norwegian</option>
                    <option value="Omani">Omani</option>
                    <option value="Pakistani">Pakistani</option>
                    <option value="Palauan">Palauan</option>
                    <option value="Panamanian">Panamanian</option>
                    <option value="Papua New Guinean">Papua New Guinean</option>
                    <option value="Paraguayan">Paraguayan</option>
                    <option value="Peruvian">Peruvian</option>
                    <option value="Polish">Polish</option>
                    <option value="Portuguese">Portuguese</option>
                    <option value="Qatari">Qatari</option>
                    <option value="Romanian">Romanian</option>
                    <option value="Russian">Russian</option>
                    <option value="Rwandan">Rwandan</option>
                    <option value="Saint Lucian">Saint Lucian</option>
                    <option value="Salvadoran">Salvadoran</option>
                    <option value="Samoan">Samoan</option>
                    <option value="San Marinese">San Marinese</option>
                    <option value="Sao Tomean">Sao Tomean</option>
                    <option value="Saudi">Saudi</option>
                    <option value="Scottish">Scottish</option>
                    <option value="Senegalese">Senegalese</option>
                    <option value="Serbian">Serbian</option>
                    <option value="Seychellois">Seychellois</option>
                    <option value="Sierra Leonean">Sierra Leonean</option>
                    <option value="Singaporean">Singaporean</option>
                    <option value="Slovakian">Slovakian</option>
                    <option value="Slovenian">Slovenian</option>
                    <option value="Solomon Islander">Solomon Islander</option>
                    <option value="Somali">Somali</option>
                    <option value="South African">South African</option>
                    <option value="South Korean">South Korean</option>
                    <option value="Spanish">Spanish</option>
                    <option value="Sri Lankan">Sri Lankan</option>
                    <option value="Sudanese">Sudanese</option>
                    <option value="Surinamer">Surinamer</option>
                    <option value="Swazi">Swazi</option>
                    <option value="Swedish">Swedish</option>
                    <option value="Swiss">Swiss</option>
                    <option value="Syrian">Syrian</option>
                    <option value="Taiwanese">Taiwanese</option>
                    <option value="Tajik">Tajik</option>
                    <option value="Tanzanian">Tanzanian</option>
                    <option value="Thai">Thai</option>
                    <option value="Togolese">Togolese</option>
                    <option value="Tongan">Tongan</option>
                    <option value="Trinidadian or Tobagonian">Trinidadian or Tobagonian</option>
                    <option value="Tunisian">Tunisian</option>
                    <option value="Turkish">Turkish</option>
                    <option value="Tuvaluan">Tuvaluan</option>
                    <option value="Ugandan">Ugandan</option>
                    <option value="Ukrainian">Ukrainian</option>
                    <option value="Uruguayan">Uruguayan</option>
                    <option value="Uzbekistani">Uzbekistani</option>
                    <option value="Venezuelan">Venezuelan</option>
                    <option value="Vietnamese">Vietnamese</option>
                    <option value="Welsh">Welsh</option>
                    <option value="Yemenite">Yemenite</option>
                    <option value="Zambian">Zambian</option>
                    <option value="Zimbabwean">Zimbabwean</option>
                </select>
                <div class="invalid-feedback">
                    Please select a nationality.
                </div>
            </div>
            <div class="mb-2">
                <label class="form-label">Gender</label><br>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="gender" id="genderMale" value="Male" disabled>
                    <label class="form-check-label" for="genderMale">Male</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="gender" id="genderFemale" value="Female" disabled>
                    <label class="form-check-label" for="genderFemale">Female</label>
                </div>
                <div class="form-check ps-0">
                    <input type="radio" name="gender" style="display: none;" required>
                    <div class="invalid-feedback">
                        Please choose a gender.
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <label class="form-label">Phone Number (+65)</label>
                <input type="text" class="form-control" name="phoneNum" id="phoneNum" pattern="[8-9]{1}[0-9]{7}" value="' . $recept_patients_profile[0]['Phone_Num'] . '" readonly>
                <div class="invalid-feedback">
                    Please enter a valid singapore mobile number.
                </div>
            </div>
            <div class="col-md-6">
                <label class="form-label">Birth date</label>
                <input type="date" class="form-control" name="birthDate" id="birthDate" value="' . $recept_patients_profile[0]['Birth_Date'] . '" readonly>
                <div class="invalid-feedback">
                    Please select a date.
                </div>
            </div>
            <div class="col-md-12">
                <label class="form-label">Address</label>
                <textarea class="form-control" rows="5" name="address" id="address" readonly>' . $recept_patients_profile[0]['Address'] . '</textarea>
                <div class="invalid-feedback">
                    Please enter a residential address.
                </div>
            </div>
            <div class="mb-2">
                <label class="form-label">Email Address</label>
                <input type="email" class="form-control" name="email" id="email" value="' . $recept_patients_profile[0]['Email'] . '" readonly>
                <div class="invalid-feedback">
                    Please enter a valid email address.
                </div>
            </div>
            <div class="col-md-4">
                <label class="form-label">Marital Status</label>
                <select class="form-select" aria-label="Default select example" name="maritalStatus" id="maritalStatus" disabled>
                    <option value="">-- Select one --</option>
                    <option value="Single">Single</option>
                    <option value="Married">Married</option>
                    <option value="Widowed">Widowed</option>
                    <option value="Separated">Separated</option>
                    <option value="Divorced">Divorced</option>
                </select>
                <div class="invalid-feedback">
                    Please select a marital status.
                </div>
            </div>
            <div class="col-md-4">
                <label class="form-label">Occupation</label>
                <input type="text" class="form-control" name="occupation" id="occupation" pattern="^(([A-Za-z]+)(\s[A-Za-z]+)?)$" value="' . $recept_patients_profile[0]['Occupation'] . '" readonly>
                <div class="invalid-feedback">
                    Please enter an occupation.
                </div>
            </div>
            <div class="col-md-4">
                <label class="form-label">Are you a smoker?</label>
                <select class="form-select" aria-label="Default select example" name="smoker" id="smoker" disabled>
                    <option value="">-- Select one --</option>';
                    if ($recept_patients_profile[0]['Smoker'] == "Yes") {
                        echo
                        '
                        <option value="Yes" selected>Yes</option>
                        <option value="No">No</option>
                        ';
                    } else {
                        echo
                        '
                        <option value="Yes">Yes</option>
                        <option value="No" selected>No</option>
                        ';
                }
                echo
                '
                </select>
                <div class="invalid-feedback">
                    Please choose an option.
                </div>
            </div>
            <div class="col-md-12">
                <h4><u>Emergency Contact Details</u></h4>
            </div>
            <div class="col-md-4">
                <label class="form-label">Contact Name</label>
                <input type="text" class="form-control" name="emerName" id="emerName" pattern="^([A-Za-z]+[,.]?[ ]?|[A-Za-z]+[\'-]?)+$" value="' . $recept_patients_profile[0]['Emer_Name'] . '" readonly>
                <div class="invalid-feedback">
                    Please enter the emergency contact\'s full name.
                </div>
            </div>
            <div class="col-md-4">
                <label class="form-label">Phone Number</label>
                <input type="text" class="form-control" name="emerPhoneNum" id="emerPhoneNum" pattern="[8-9]{1}[0-9]{7}" value="' . $recept_patients_profile[0]['Emer_Contact'] . '" readonly>
                <div class="invalid-feedback">
                    Please enter an valid emergency contact number.
                </div>
            </div>
            <div class="col-md-4">
                <label class="form-label">Relationship</label>
                <select class="form-select" aria-label="Default select example" name="emerRs" id="emerRs" disabled>
                    <option value="">-- Select one --</option>
                    <option value="Mother">Mother</option>
                    <option value="Father">Father</option>
                    <option value="Siblings">Siblings</option>
                    <option value="Spouse">Spouse</option>
                    <option value="Relative">Relative</option>
                    <option value="Friend">Friend</option>
                </select>
                <div class="invalid-feedback">
                    Please choose an relationship.
                </div>
            </div>';
            if (empty($recept_patients_profile[0]['Allergies'])) {
                echo
                '
                <div class="col-md-12 pt-3">
                    <label class="form-label">Do you have any allergies?</label><br>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="allergies" id="allergyYes" value="Yes" disabled>
                        <label class="form-check-label" for="allergyYes">Yes</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="allergies" id="allergyNo" value="No" checked disabled>
                        <label class="form-check-label" for="allergyNo">No</label>
                    </div>
                    <div id="allergiesInfo" style="display: none">
                        <label class="form-label">Allergies:</label><br>
                        <textarea class="form-control" rows="3" name="allergyList" id="allergyList" readonly></textarea>
                    </div>
                </div>
                ';
            } else {
                echo
                '
                <div class="col-md-12 pt-3">
                    <label class="form-label">Do you have any allergies?</label><br>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="allergies" id="allergyYes" value="Yes" checked disabled>
                        <label class="form-check-label" for="allergyYes">Yes</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="allergies" id="allergyNo" value="No" disabled>
                        <label class="form-check-label" for="allergyNo">No</label>
                    </div>
                    <div id="allergiesInfo">
                        <label class="form-label">Allergies:</label><br>
                        <textarea class="form-control" rows="3" name="allergyList" id="allergyList" readonly>' . $recept_patients_profile[0]['Allergies'] . '</textarea>
                    </div>
                </div>
                ';
            }

            if (empty($recept_patients_profile[0]['Long_term_med'])) {
                echo
                '
                <div class="col-md-12">
                    <label class="form-label">Are you on any long term medications?</label><br>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="ltm" id="ltmYes" value="Yes" disabled>
                        <label class="form-check-label" for="ltmYes">Yes</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="ltm" id="ltmNo" value="No" checked disabled>
                        <label class="form-check-label" for="ltmNo">No</label>
                    </div>
                    <div id="ltmInfo" style="display: none">
                        <label class="form-label">Long term medications:</label><br>
                        <textarea class="form-control" rows="3" name="ltmList" id="ltmList" readonly></textarea>
                    </div>
                </div>
                ';
            } else {
                echo
                '
                <div class="col-md-12">
                    <label class="form-label">Are you on any long term medications?</label><br>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="ltm" id="ltmYes" value="Yes" checked disabled>
                        <label class="form-check-label" for="ltmYes">Yes</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="ltm" id="ltmNo" value="No" disabled>
                        <label class="form-check-label" for="ltmNo">No</label>
                    </div>
                    <div id="ltmInfo">
                        <label class="form-label">Long term medications:</label><br>
                        <textarea class="form-control" rows="3" name="ltmList" id="ltmList" readonly>' . $recept_patients_profile[0]['Long_term_med'] . '</textarea>
                    </div>
                </div>
                ';
            }

            if (empty($recept_patients_profile[0]['Existing_Med_Conds'])) {
                echo
                '
                <div class="col-md-12">
                    <label class="form-label">Are you taking any medications currently?</label><br>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="existMeds" id="eMedYes" value="Yes" disabled>
                        <label class="form-check-label" for="eMedYes">Yes</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="existMeds" id="eMedNo" value="No" checked disabled>
                        <label class="form-check-label" for="eMedNo">No</label>
                    </div>
                    <div id="eMedInfo" style="display: none">
                        <label class="form-label">Existing Medications:</label><br>
                        <textarea class="form-control" rows="3" name="eMedList" id="eMedList" readonly></textarea>
                    </div>
                </div>
                ';
            } else {
                echo
                '
                <div class="col-md-12">
                <label class="form-label">Are you taking any medications currently?</label><br>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="existMeds" id="eMedYes" value="Yes" checked disabled>
                    <label class="form-check-label" for="eMedYes">Yes</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="existMeds" id="eMedNo" value="No" disabled>
                    <label class="form-check-label" for="eMedNo">No</label>
                </div>
                <div id="eMedInfo">
                    <label class="form-label">Existing Medications:</label><br>
                    <textarea class="form-control" rows="3" name="eMedList" id="eMedList" readonly>' . $recept_patients_profile[0]['Long_term_med'] . '</textarea>
                </div>
            </div>';
            }

            if (empty($recept_patients_profile[0]['Referred_by_clinic'])) {
                echo
                '
                <div class="col-md-12">
                    <label class="form-label">Are you referred by any clinic?</label><br>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="referBy" id="referredYes" value="Yes" disabled>
                        <label class="form-check-label" for="referredYes">Yes</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="referBy" id="referredNo" value="No" checked disabled>
                        <label class="form-check-label" for="referredNo">No</label>
                    </div>
                    <div id="referredInfo" style="display: none">
                        <label class="form-label">Referred By:</label><br>
                        <input type="text" class="form-control" name="referredBy" id="referredBy" readonly>
                        <label class="form-label mb-2">Referral Memo:</label>
                        <textarea class="form-control" rows="3" name="referredMemo" id="referredMemo" readonly></textarea>
                    </div>
                </div>';
                } else {
                    echo
                    '
                    <div class="col-md-12">
                        <label class="form-label">Are you referred by any clinic?</label><br>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="referBy" id="referredYes" value="Yes" checked disabled>
                            <label class="form-check-label" for="referredYes">Yes</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="referBy" id="referredNo" value="No" disabled>
                            <label class="form-check-label" for="referredNo">No</label>
                        </div>
                        <div id="referredInfo"">
                            <label class="form-label">Referred By:</label><br>
                            <input type="text" class="form-control" name="referredBy" id="referredBy" value="' . $recept_patients_profile[0]['Referred_by_clinic'] . '"readonly>
                            <label class="form-label mb-2">Referral Memo:</label>
                            <textarea class="form-control" rows="3" name="referredMemo" id="referredMemo" readonly>' . $recept_patients_profile[0]['Referred_memo'] . '</textarea>
                        </div>
                    </div>
                    ';
                }

            if (empty($recept_patients_profile[0]['Existing_Med_Conds'])) {
                echo
                '
                <div class="col-md-12 mb-5">
                    <label class="form-label">Do you have CHAS card?</label><br>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="subsidy" id="subsidyYes" value="Yes" disabled>
                        <label class="form-check-label" for="subsidyYes">Yes</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="subsidy" id="subsidyNo" value="No" checked disabled>
                        <label class="form-check-label" for="subsidyNo">No</label>
                    </div>
                </div>
                ';
            } else {
                echo
                '
                <div class="col-md-12 mb-5">
                    <label class="form-label">Do you have CHAS card?</label><br>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="subsidy" id="subsidyYes" value="Yes" checked disabled>
                        <label class="form-check-label" for="subsidyYes">Yes</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="subsidy" id="subsidyNo" value="No" disabled>
                        <label class="form-check-label" for="subsidyNo">No</label>
                    </div>
                </div>
                ';
                }

                echo
                '
                <div class="col-6">
                    <button type="button" class="btn btn-secondary mb-3" onClick="window.location.reload();" id="cancelBtn" hidden="true">Cancel</button>
                </div>
                <div class="col-6 text-end">
                    <button type="submit" class="btn btn-primary mb-3" name="recept_updateBtn" id="recept_updateBtn" hidden="true">Confirm</button>
                </div>
            </form>
        </div>
        ';
    ?>
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.min.js" integrity="sha384-j0CNLUeiqtyaRmlzUHCPZ+Gy5fQu0dQ6eZ/xAww941Ai1SxSY+0EQqNXNE6DZiVc" crossorigin="anonymous"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
    $(document).ready(function() {
        setTimeout(function() {
            $(".alert").alert('close');
            <?php unset($_SESSION['alert']); ?>
        }, 3000);
    });
</script>
<script>
    function check() {
        $famNRIC = $("#familyNRIC").val();
        $famPhone = $("#familyPhone").val();
        $.ajax({
            url: "VerifyFamily.php?fNRIC=" + $famNRIC + "&fPhone=" + $famPhone,
            success: function(result) {
                if (result == "ERROR") {
                    $("#familyID").val("Error!");
                    $("#verifyError").text("Member cannot be found. Please try again.");
                } else {
                    $("#familyID").val(result);
                    $("#verifyError").text("");
                    $("#verifyBtn").html("Verified! <i class='bi bi-check-circle-fill'></i>");
                    $("#verifyBtn").addClass('btn-success').removeClass('btn-primary ');
                }
            }

        })
    }

    function change() {
        if (document.getElementById('editMode').checked) {
            document.getElementById('firstName').readOnly = false;
            document.getElementById('firstName').setAttribute("required", "");
            document.getElementById('lastName').readOnly = false;
            document.getElementById('lastName').setAttribute("required", "");
            document.getElementById('nric_pnum').readOnly = false;
            document.getElementById('nric_pnum').setAttribute("required", "");
            document.getElementById('nationality').disabled = false;
            document.getElementById('nationality').setAttribute("required", "");
            document.getElementById('genderMale').disabled = false;
            document.getElementById('genderMale').setAttribute("required", "");
            document.getElementById('genderFemale').disabled = false;
            document.getElementById('genderFemale').setAttribute("required", "");
            document.getElementById('phoneNum').readOnly = false;
            document.getElementById('phoneNum').setAttribute("required", "");
            document.getElementById('birthDate').readOnly = false;
            document.getElementById('birthDate').setAttribute("required", "");
            document.getElementById('address').readOnly = false;
            document.getElementById('address').setAttribute("required", "");
            document.getElementById('email').readOnly = false;
            document.getElementById('email').setAttribute("required", "");
            document.getElementById('maritalStatus').disabled = false;
            document.getElementById('maritalStatus').setAttribute("required", "");
            document.getElementById('occupation').readOnly = false;
            document.getElementById('occupation').setAttribute("required", "");
            document.getElementById('smoker').disabled = false;
            document.getElementById('smoker').setAttribute("required", "");
            document.getElementById('emerName').readOnly = false;
            document.getElementById('emerName').setAttribute("required", "");
            document.getElementById('emerPhoneNum').readOnly = false;
            document.getElementById('emerPhoneNum').setAttribute("required", "");
            document.getElementById('emerRs').disabled = false;
            document.getElementById('emerRs').setAttribute("required", "");
            document.getElementById('allergyYes').disabled = false;
            document.getElementById('allergyNo').disabled = false;
            document.getElementById('allergyList').readOnly = false;
            document.getElementById('ltmYes').disabled = false;
            document.getElementById('ltmNo').disabled = false;
            document.getElementById('ltmList').readOnly = false;
            document.getElementById('eMedYes').disabled = false;
            document.getElementById('eMedNo').disabled = false;
            document.getElementById('eMedList').readOnly = false;
            document.getElementById('referredYes').disabled = false;
            document.getElementById('referredNo').disabled = false;
            document.getElementById('referredBy').readOnly = false;
            document.getElementById('referredMemo').readOnly = false;
            document.getElementById('subsidyYes').disabled = false;
            document.getElementById('subsidyNo').disabled = false;

            document.getElementById('cancelBtn').hidden = false;
            document.getElementById('recept_updateBtn').hidden = false;
        }
    }
    $(document).ready(function() {
        $("#nationality").val("<?php echo $recept_patients_profile[0]['Nationality']; ?>").change();
        $("#gender<?php echo $recept_patients_profile[0]['Gender']; ?>").attr('checked', 'checked');
        $("#maritalStatus").val("<?php echo $recept_patients_profile[0]['Marital_Status']; ?>").change();
        $("#smoker").val("<?php echo $recept_patients_profile[0]['Smoker']; ?>").change()
        $("#emerRs").val("<?php echo $recept_patients_profile[0]['Emer_relation']; ?>").change();

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
    });
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