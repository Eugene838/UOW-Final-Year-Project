<?php
session_start();

// Clinic Logout condition
if(isset($_SESSION['Role'])) {
    session_unset();
    session_destroy();
    header("Location: index.php");
}
// Paitent Logout condition
else if (isset($_SESSION['Patient_ID'])) {
    session_unset();
    session_destroy();
    header("Location: PatientLogin.php");
}
else {
    session_unset();
    session_destroy();
    header("Location: ./error-page/404.html");
}
