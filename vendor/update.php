<?php
session_start();
if ($_SESSION['AVN_User']) {
    unset($_SESSION['AVN_User']['schedule']);
    unset($_SESSION['AVN_User']['discipline']);
    unset($_SESSION['AVN_User']['now']);
    unset($_SESSION['AVN_User']['group']);
    header('Location: ../teacher/discipline.php');
    exit();
} else if ($_SESSION['AVN_Student']) {
    unset($_SESSION['AVN_Student']['schedule']);
    unset($_SESSION['AVN_Student']['discipline']);
    unset($_SESSION['AVN_Student']['now']);
    unset($_SESSION['AVN_Student']['group']);
    header('Location: ../student/index.php');
    exit();
}
