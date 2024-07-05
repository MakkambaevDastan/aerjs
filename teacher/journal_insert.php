<?php
session_start();
if ($_SESSION['AVN_User'] == false) {
    header('Location: ../index.php');
}
require_once '../vendor/connect.php';
$id_time = (int)$_POST['id_time'];
unset($_POST['id_time']);
$id_subject = $_POST['id_subject'];
unset($_POST['id_subject']);
$subject_num = $_POST['subject_num'];
unset($_POST['subject_num']);
$id_schedule = $_POST['id_schedule'];
unset($_POST['id_schedule']);
$day_number = $_POST['day_number'];
unset($_POST['day_number']);
$start = $date->format('d-m-Y') . ' ' . str_replace(".", ":", $time_start[$id_time]);
$end = $date->format('d-m-Y') . ' ' . str_replace(".", ":", $time_start[$id_time + 1]);
$today = $date->format('d-m-Y G:i');
foreach ($_SESSION['AVN_User']['schedule'][$day_number][$id_time] as $key => $value) {
    if ($id_schedule == $value['id_schedule']) {
        $schedule = $value;
    }
}
if ($schedule['StudyTypeID'] == 6) $StudyTypeID = 3;
else $StudyTypeID = $value['StudyTypeID'];
echo $StudyTypeID;
$sql = "SELECT dbo.movement_t.id_student
FROM     dbo.V_Raspisanie_new INNER JOIN
                  dbo.movement_t ON dbo.V_Raspisanie_new.id_group = dbo.movement_t.id_group
WHERE  (dbo.V_Raspisanie_new.ID = " . $schedule['id_schedule'] . ") 
AND (dbo.movement_t.isStudying <> 0) 
AND (dbo.V_Raspisanie_new.id_rate = " . $schedule['id_rate'] . ")";
$select = sqlsrv_query($connect, $sql);
while ($row = sqlsrv_fetch_array($select)) {
    if ($_POST[$row['id_student']]) {
        $student[$row['id_student']] = $_POST[$row['id_student']];
    } else {
        $student[$row['id_student']] = 'off';
    }
}
$sql = "SELECT DISTINCT[id_group]
    FROM [aerjs].[dbo].[syllabus_rating]
    WHERE  [id_group]=" . $schedule['id_group'] . "
        AND [id_subject]=$id_subject
        AND [id_sillabus_t]=" . $schedule['id_sillabus_t'] . "
        AND [date_rating] > '$start'
        AND [date_rating] < '$end'
        AND [id_rate]=" . $schedule['id_rate'] . "
        AND [id_schedule]=" . $schedule['id_schedule'];

$select = sqlsrv_query($connect, $sql);
$row = sqlsrv_fetch_array($select);
$ifRating = $row['id_group'];
if ($ifRating) {
    foreach ($student as $id => $rating) {
        $id_student = (int)$id;
        $sql = "UPDATE [dbo].[syllabus_rating]
                    SET [date_rating] = '$today'
                    ,[status_rating] = '$rating'
                WHERE [id_student] = $id_student
                        AND [date_rating] > '$start'
                       AND [date_rating] < '$end'
                       AND [id_subject] = $id_subject
                       AND [id_rate] = " . $schedule['id_rate'] . "
                      AND [id_schedule] = " . $schedule['id_schedule'];
        try {
            $stmt = sqlsrv_query($connect_local, $sql);
            $result['student'][$id_student] = $stmt;
        } catch (sqlsrv_sql_exception $ex) {
            $result['student'][$id_student] = $ex;
        }
    }
} else {
    foreach ($student as $id => $rating) {
        $id_student = (int)$id;
        $params_u = array($rating);
        $sql = "INSERT INTO [dbo].[syllabus_rating]
                        ([id_student]
                        ,[id_group]
                        ,[id_sillabus_t]
                        ,[date_rating]
                        ,[status_rating]
                        ,[id_rate]
                        ,[id_schedule]
                        ,[id_subject])
                VALUES
                        ($id_student
                        ," . $schedule['id_group'] . "
                        ," . $schedule['id_sillabus_t'] . "
                        ,'$today'
                        ,'$rating'
                        ," . $schedule['id_rate'] . "
                        ," . $schedule['id_schedule'] . "
                        ,$id_subject)";
        try {
            $stmt = sqlsrv_query($connect_local, $sql);
            $result['student'][$id_student] = $stmt;
        } catch (sqlsrv_sql_exception $ex) {
            $result['student'][$id_student] = $ex;
        }
    }
}
$syllabus_subject = "INSERT INTO [dbo].[syllabus_subject_hour]
           ([id_sillabus_t]
           ,[subject_past_hour]
           ,[subject_type]
           ,[subject_past_hour_date]
           ,[id_syllabus_subject]
           ,[subject_num]
		   ,[id_group]
           ,[id_schedule])
           SELECT 
           " . $schedule['id_sillabus_t'] . ", 
           1, 
           $StudyTypeID, 
           '$today', 
           $id_subject, 
           $subject_num, 
           " . $schedule['id_group'] . ",
           " . $schedule['id_schedule'] . "
           WHERE not exists (select *  from [syllabus_subject_hour] where
           [id_sillabus_t] = " . $schedule['id_sillabus_t'] . " and
            subject_past_hour_date >= '$start' and 
            subject_past_hour_date <= '$end' and
		   id_group = " . $schedule['id_group'] . " and 
           [id_schedule] = " . $schedule['id_schedule'] . ")";
try {
    $subject_hour = sqlsrv_query($connect_local, $syllabus_subject);
    $result['subject'][$id_subject] = $subject_hour;
} catch (sqlsrv_sql_exception $ex) {
    $result['subject'][$id_subject] = $ex;
}