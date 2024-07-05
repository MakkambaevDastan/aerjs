<?php
session_start();
if ($_SESSION['AVN_User'] == false) {
    header('Location: ../index.php');
}
$date = new DateTime();
$id_sillabus_t = (int)$date->format('YmtHisv');
require_once '../vendor/connect.php';
$id_educ_sh = (int)$_POST['id_educ_sh'];
$id_speciality = (int)$_POST['id_speciality'];
$id_discipline = (int)$_POST['id_discipline'];
$id_teacher = (int)$_POST['id_teacher'];
$id_year = (int)$_POST['id_year'];
$id_semester = (int)$_POST['id_semester'];
$hour_week = (int)$_POST['hour_week'];
$lecture = (int)$_POST['lecture'];
$practice = 0;
$laboratory = 0;
$seminar = 0;
$language = (int)$_POST['course_language'];
$krdt = $_POST['kredit_ECTS'];
$today = date('d.n.Y');
$subject_type_get = $_POST['subject_type_2'];
$id_faculty = (int)$_POST['id_faculty'];
$id_kafedra = $_POST['id_kafedra'];
$instrumentos = $_POST['instrumentos'];
$assistant_id = (int)$_POST['testId'];
$assistant = $_POST['assistant'];
if ($subject_type_get == 2) {
    $laboratory = (int)$_POST['lecture2'];
} elseif ($subject_type_get == 3) {
    $practice = (int)$_POST['lecture2'];
} elseif ($subject_type_get == 4) {
    $seminar = (int)$_POST['lecture2'];
}
$sql_insert_sil ="INSERT INTO [dbo].[syllabus_head] (
    id_educ_sh, 
    id_speciality, 
    id_discipline, 
    id_teacher, 
    id_year, 
    assistant, 
    code, 
    id_semester, 
    hour_week, 
    lecture, 
    laboratory, 
    practice, 
    seminar, 
    kredit_ECTS, 
    course_raiting, 
    course_type, 
    course_language, 
    purpose, 
    annotation, 
    competence, 
    result_learning, 
    student_know, 
    student_must, 
    id_update, 
    id_sillabus_t, 
    instrumentos, 
    StudyTypeID
    ) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
$params_sil = array($id_educ_sh, $id_speciality, $id_discipline, $id_teacher, $id_year, $assistant, $_POST['code'], $id_semester, $hour_week, $lecture, $laboratory, $practice, $seminar, $krdt, $_POST['course_raiting'], $_POST['course_type'], $language, $_POST['purpose'], $_POST['annotation'], $_POST['competence'], $_POST['result_learning'], $_POST['student_know'], $_POST['student_must'], $today, $id_sillabus_t, $instrumentos, $subject_type_get);
// print_r($params_sil);
$stmt = sqlsrv_query($connect_local, $sql_insert_sil, $params_sil);
sqlsrv_execute($stmt);
if ($stmt == false) {
    echo 'ошибка запрос вставки силабуса';
    die(print_r(sqlsrv_errors(), true));
}
//==========================================================вставка\обновление данных лек
$i = 1;
while ($_POST["subject_table_1_name_$i"]) {
    $subject_hour = 1;
    $subject_name = $_POST["subject_table_1_name_$i"];
    $subject_num = $_POST["subject_table_1_num_$i"];
    $subject_type = 1;
    $sql_i_u = "INSERT INTO [dbo].[syllabus_subject] (id_sillabus_t, subject_type, subject_hour, subject_name, subject_num) 
                VALUES (?,?,?,?,?)";
    $params = array($id_sillabus_t, $subject_type, $subject_hour, $subject_name, $subject_num);
    $stmt = sqlsrv_query($connect_local, $sql_i_u, $params);
    if ($stmt == false) {
        echo 'Ошибка вставка данных лек';
        die(print_r(sqlsrv_errors(), true));
    }
    $i++;
}
//==========================================================вставка\обновление данных прак\сем\лаб
$i = 1;
while ($_POST["subject_table_2_name_$i"]) {
    $subject_hour = 1;
    $subject_name = $_POST["subject_table_2_name_$i"];
    $subject_num = $_POST["subject_table_2_num_$i"];
    $subject_type = $subject_type_get;
    $sql_i_u = "INSERT INTO [dbo].[syllabus_subject] (id_sillabus_t, subject_type, subject_hour, subject_name, subject_num) 
                VALUES (?,?,?,?,?)";
    $params = array($id_sillabus_t, $subject_type, $subject_hour, $subject_name, $subject_num);
    $stmt = sqlsrv_query($connect_local, $sql_i_u, $params);
    if ($stmt == false) {
        echo 'Ошибка вставка данных прак';
        die(print_r(sqlsrv_errors(), true));
    }
    $i++;
}

//==========================================================вставка\обновление данных литература
$i = 1;
while ($_POST["textbook_autor_$i"]) {
    $textbook_autor = $_POST["textbook_autor_$i"];
    $textbook_name = $_POST["textbook_name_$i"];
    $textbook_link = $_POST["textbook_link_$i"];
    $textbook_num = $_POST["textbook_num_$i"];
    $sql_i_b = "INSERT INTO [dbo].[syllabus_textbook] (id_sillabus_t, textbook_autor, textbook_name, textbook_link, textbook_num) 
                VALUES (?,?,?,?,?)";
    $params = array($id_sillabus_t, $textbook_autor, $textbook_name, $textbook_link, $textbook_num);
    $stmt = sqlsrv_query($connect_local, $sql_i_b, $params);
    if ($stmt == false) {
        echo 'Ошибка вставка данных книги';
        die(print_r(sqlsrv_errors(), true));
    }
    $i++;
    unset($params);
}

$_SESSION['AVN_User']['discipline'][$id_educ_sh]['id_sillabus_t'] = [$id_sillabus_t];
$_SESSION['AVN_User']['discipline'][$id_educ_sh]['confirmation'] = 0;
$_SESSION['message'] = 'Силлабус успешно сохранен!';
header("Location: discipline.php");