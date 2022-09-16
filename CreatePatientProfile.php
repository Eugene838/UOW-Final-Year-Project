<?php
ob_start();
$path = basename($_SERVER['PHP_SELF'], ".php");
include 'db_connection.php';
include 'Navbar.php';
include 'Receptionist.php';
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

        .required-field::after {
            content: "*";
            color: red;
        }
        .list-group-item{
            background-color:transparent;
            color: #fff;
            border: 1px solid #ddd;
            width:18rem;
        }
    </style>
</head>

<body>
    <div class="container-fluid col-6 mt-4 mb-4 bg-light">
        <!-- Content here -->
        <form class="row g-3 needs-validation" method="POST" novalidate>
            <div class="col-md-12">
                <h4><u>Patient Information</u></h4>
            </div>
            <div class="col-md-6">
                <label class="form-label required-field">First Name</label>
                <input type="text" class="form-control" name="firstName" id="firstName" pattern="^([A-Za-z]+[,.]?[ ]?|[A-Za-z]+['-]?)+$" placeholder="Tony" value="<?php echo isset($_POST["firstName"]) ? $_POST["firstName"] : ''; ?>" required>
                <div class="invalid-feedback">
                    Please enter first name.
                </div>
            </div>
            <div class="col-md-6">
                <label class="form-label required-field">Last Name</label>
                <input type="text" class="form-control" name="lastName" id="lastName" pattern="^([A-Za-z]+[,.]?[ ]?|[A-Za-z]+['-]?)+$" placeholder="Stark" value="<?php echo isset($_POST["lastName"]) ? $_POST["lastName"] : ''; ?>" required>
                <div class="invalid-feedback">
                    Please enter last name.
                </div>
            </div>
            <div class="col-md-6">
                <label class="form-label required-field">NRIC/Passport No.</label>
                <input type="text" class="form-control" name="nric_pnum" id="nric_pnum" pattern="[A-Za-z][0-9]{7}[A-Za-z]" placeholder="S1234567A" value="<?php echo isset($_POST["nric_pnum"]) ? $_POST["nric_pnum"] : ''; ?>" required>
                <div class="invalid-feedback">
                    Please enter a valid NRIC/Passport No.
                </div>
            </div>
            <div class="col-md-6">
                <label class="form-label required-field">Nationality</label>
                <select class="form-select" aria-label="Default select example" name="nationality" id="nationality" required>
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
            <div class="col-md-12">
                <label class="form-label required-field">Gender</label><br>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="gender" id="genderM" value="M" required>
                    <label class="form-check-label" for="genderM">Male</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="gender" id="genderF" value="F" required>
                    <label class="form-check-label" for="genderF">Female</label>
                </div>
                <div class="form-check p-0">
                    <input type="radio" name="gender" style="display: none;" required>
                    <div class="invalid-feedback">
                        Please choose a gender.
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <label class="form-label required-field">Phone Number (+65)</label>
                <input type="text" class="form-control" name="phoneNum" id="phoneNum" pattern="[8-9]{1}[0-9]{7}" placeholder="81234567" required>
                <div class="invalid-feedback">
                    Please enter a valid singapore mobile number.
                </div>
            </div>
            <div class="col-md-6">
                <label class="form-label">Birth date</label>
                <input type="date" class="form-control" name="birthDate" id="birthDate" required>
                <div class="invalid-feedback">
                    Please select a date.
                </div>
            </div>
            <div class="col-md-12">
                <label class="form-label">Address</label>
                <textarea class="form-control" rows="5" name="address" id="address" required></textarea>
                <div class="invalid-feedback">
                    Please enter a residential address.
                </div>
            </div>
            <div class="mb-2">
                <label class="form-label">Email Address</label>
                <input type="email" class="form-control" name="email" id="email" placeholder="" required>
                <div class="invalid-feedback">
                    Please enter a valid email address.
                </div>
            </div>
            <div class="col-md-4">
                <label class="form-label">Marital Status</label>
                <select class="form-select" aria-label="Default select example" name="maritalStatus" id="maritalStatus" required>
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
                <input type="text" class="form-control" name="occupation" pattern="^(([A-Za-z]+)(\s[A-Za-z]+)?)$" id="occupation" placeholder="Student" required>
                <div class="invalid-feedback">
                    Please enter an occupation.
                </div>
            </div>
            <div class="col-md-4">
                <label class="form-label">Are you a smoker?</label>
                <select class="form-select" aria-label="Default select example" name="smoker" id="smoker" required>
                    <option value="">-- Select one --</option>
                    <option value="Yes">Yes</option>
                    <option value="No">No</option>
                </select>
                <div class="invalid-feedback">
                    Please choose an option.
                </div>
            </div>
            <div class="col-md-12">
                <h4><u>Emergency Contact Details</u></h4>
            </div>
            <div class="col-md-4">
                <label class="form-label required-field">Contact Name</label>
                <input type="text" class="form-control" name="emerName" pattern="^([A-Za-z]+[,.]?[ ]?|[A-Za-z]+['-]?)+$" id="emerName" placeholder="Tony" required>
                <div class="invalid-feedback">
                    Please enter the emergency contact's full name.
                </div>
            </div>
            <div class="col-md-4">
                <label class="form-label required-field">Phone Number</label>
                <input type="text" class="form-control" pattern="[8-9]{1}[0-9]{7}" name="emerPhoneNum" id="emerPhoneNum" placeholder="81234567" required>
                <div class="invalid-feedback">
                    Please enter an valid emergency contact number.
                </div>
            </div>
            <div class="col-md-4">
                <label class="form-label required-field">Relationship</label>
                <select class="form-select" aria-label="Default select example" name="emerRs" id="emerRs" required>
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
            </div>
            <div class="pt-3">
                <div class="form-group">
                    <label class="form-label">Do you have any allergies?</label><br>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="allergies" id="allergyYes" value="Yes" required>
                        <label class="form-check-label" for="allergyYes">Yes</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="allergies" id="allergyNo" value="No" required>
                        <label class="form-check-label" for="allergyNo">No</label>
                    </div>
                    <div class="form-check form-check-inline p-0">
                        <input type="radio" name="allergies" style="display:none" required>
                        <div class="invalid-feedback">
                            Please choose an option.
                        </div>
                    </div>
                    <div id="allergiesInfo" style="display: none">
                        <label class="form-label">Allergies:</label><br>
                        <textarea class="form-control" rows="3" name="allergyList" id="allergyList"></textarea>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <label class="form-label">Are you on any long term medications?</label><br>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="ltm" id="ltmYes" value="Yes" required>
                    <label class="form-check-label" for="ltmYes">Yes</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="ltm" id="ltmNo" value="No">
                    <label class="form-check-label" for="ltmNo">No</label>
                </div>
                <div class="form-check form-check-inline p-0">
                    <input type="radio" name="ltm" style="display: none" required>
                    <div class="invalid-feedback">
                        Please choose an option.
                    </div>
                </div>
                <div id="ltmInfo" style="display: none">
                    <label class="form-label">Long term medications:</label><br>
                    <textarea class="form-control" rows="3" name="ltmList" id="ltmList"></textarea>
                </div>
            </div>
            <div class="col-md-12">
                <label class="form-label">Are you taking any medications currently?</label><br>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="existMeds" id="eMedYes" value="Yes" required>
                    <label class="form-check-label" for="eMedYes">Yes</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="existMeds" id="eMedNo" value="No">
                    <label class="form-check-label" for="eMedNo">No</label>
                </div>
                <div class="form-check form-check-inline p-0">
                    <input type="radio" name="existMeds" style="display: none" required>
                    <div class="invalid-feedback">
                        Please choose an option.
                    </div>
                </div>
                <div id="eMedInfo" style="display: none">
                    <label class="form-label">Existing Medications:</label><br>
                    <textarea class="form-control" rows="3" name="eMedList" id="eMedList"></textarea>
                </div>
            </div>
            <div class="col-md-12">
                <label class="form-label">Are you referred by any clinic?</label><br>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="referBy" id="referredYes" value="Yes" required>
                    <label class="form-check-label" for="referredYes">Yes</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="referBy" id="referredNo" value="No">
                    <label class="form-check-label" for="referredNo">No</label>
                </div>
                <div class="form-check form-check-inline p-0">
                    <input type="radio" name="referBy" style="display: none" required>
                    <div class="invalid-feedback">
                        Please choose an option.
                    </div>
                </div>
                <div id="referredInfo" style="display: none">
                    <label class="form-label">Referred By:</label><br>
                    <input type="text" class="form-control" name="referredBy" id="referredBy">
                    <label class="form-label mb-2">Referral Memo:</label>
                    <textarea class="form-control" rows="3" name="referredMemo" id="referredMemo"></textarea>
                </div>
            </div>
            <div class="col-md-12">
                <label class="form-label">Do you have any family that is currently visiting our clinic?</label><br>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="family" id="familyYes" value="Yes" required>
                    <label class="form-check-label" for="familyYes">Yes</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="family" id="familyNo" value="No">
                    <label class="form-check-label" for="familyNo">No</label>
                </div>
                <div class="form-check form-check-inline p-0">
                    <input type="radio" name="family" style="display: none" required>
                    <div class="invalid-feedback">
                        Please choose an option.
                    </div>
                </div>
                <div class="row" id="familyInfo" style="display: none">
                    <div class="col-md-1">
                        <label class="form-label">Family ID:</label><br>
                        <input type="text" class="form-control" name="familyID" id="familyID" value="<?php echo isset($famID) ? $famID : 'N/A'; ?>" disabled>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Family Member's NRIC/Passport No.</label><br>
                        <input type="text" class="form-control" name="familyNRIC" id="familyNRIC">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Family Member's Phone Number</label><br>
                        <input type="text" class="form-control" name="familyPhone" id="familyPhone">
                    </div>
                    <div class="col-md-2 mt-4 pt-2">
                        <button type="button" class="btn btn-primary" name="verifyBtn" id="verifyBtn" onclick=check()>Verify</button>
                    </div>
                </div>
            </div>
            <div class="col-md-12 mb-4">
                <label class="form-label">Do you have CHAS card?</label><br>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="subsidy" id="subsidyYes" value="Yes" required>
                    <label class="form-check-label" for="subsidyYes">Yes</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="subsidy" id="subsidyNo" value="No">
                    <label class="form-check-label" for="subsidyNo">No</label>
                </div>
                <div class="form-check form-check-inline p-0">
                    <input type="radio" name="subsidy" style="display: none" required>
                    <div class="invalid-feedback">
                        Please choose an option.
                    </div>
                </div>
            </div>
            <button type="submit" class="btn btn-primary m-auto mb-2" name="addPatientProfileBtn">Create Profile</button>
        </form>
    </div>
</body>
</html>