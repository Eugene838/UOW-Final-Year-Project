<?php
session_start();
//Conditions for clinics
if (strtolower(basename($_SERVER['HTTP_REFERER'], ".php")) == "index") {
    switch ($_SESSION['Role']) {
        case "Dentist":
            header("Location: DentistDashboard.php");
            break;
        case "Dentist Assistant":
            header("Location: AssistantDashboard.php");
            break;
        case "Receptionist":
            header("Location: ReceptionistDashboard.php");
            break;
        case "Clinic Admin":
            header("Location: AdminDashboard.php");
            break;
        case "Super Admin":
            header("Location: SuperAdminDashboard.php");
            break;
        default:
            header("Location: index.php");
    }
} else if (strtolower(basename($_SERVER['HTTP_REFERER'], ".php")) == "patientlogin") {
    if (isset($_SESSION['Patient_ID'])) {
        header("Location: PatientDashboard.php");
    } else {
        header("Location: PatientLogin.php");
    }
} else {
    header("Location:" . $_SERVER['HTTP_REFERER']);
}
