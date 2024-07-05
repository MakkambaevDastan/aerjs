<?php
session_start();

// unset($_SESSION['syllabus_add']);
// unset($_SESSION['conf']);
// unset($_SESSION['id_time']);
// unset($_SESSION['syllabus']);
// unset($_SESSION['id_faculty']);
// unset($_SESSION['AVN_teacher_foto']);
// unset($_SESSION['discipline']);
unset($_SESSION['USER']);
unset($_SESSION['AVN_User']);
unset($_SESSION['AVN_Student']);
unset($_SESSION['message']);

header('Location: ../index.php');
