<?php
session_start();
if ($_SESSION['AVN_User'] == false) {
    header('Location: ../index.php');
}
include_once '../header.php';
require_once '../vendor/connect.php';
$today = $date->format('d.m.Y G.i');
$today_y = $date->format('d-m-Y');
$id_time = $_SESSION['AVN_User']['now']['id_time'];
$start = $date->format('d-m-Y') . ' ' . str_replace(".", ":", $time_start[$id_time]);
$end = $date->format('d-m-Y') . ' ' . str_replace(".", ":", $time_start[$id_time + 1]);
$now_schedule = $_SESSION['AVN_User']['now'];
unset($now_schedule['id_time']);
foreach ($now_schedule as $keySchedule => $valueSchedule) {
    if ($valueSchedule['StudyTypeID'] == 6) $StudyTypeID = 3;
    else $StudyTypeID = $valueSchedule['StudyTypeID'];
    if (!$now_schedule[$keySchedule]['student']) {
        $sql =
            "SELECT DISTINCT [Student].[id_student],
                [Student].[p1],
                [Student].[p2],
                [Student].[p3]
                FROM [dbo].[movement_t]
            LEFT JOIN [dbo].[Student] ON [student].[id_student] = [movement_t].[id_student]
            WHERE [id_group]= " . $keySchedule
            . " AND id_rate = " . $valueSchedule['id_rate'] . " and isStudying <> 0
            ORDER BY [Student].[p1]";
        $select = sqlsrv_query($connect, $sql);
        while ($row = sqlsrv_fetch_array($select)) {
            $now_schedule[$keySchedule]['student'][$row['id_student']] = [
                'p1' => $row['p1'],
                'p2' => $row['p2'],
                'p3' => $row['p3']
            ];
        }
    }
    if ($valueSchedule['id_sillabus_t']) {
        $sql_rating = "SELECT [id_rating]
                    ,[id_student]
                    ,[id_group]
                    ,[id_sillabus_t]
                    ,[date_rating]
                    ,[status_rating]
                    ,[id_rate]
                    ,[id_schedule]
                    FROM [aerjs].[dbo].[syllabus_rating]
                    WHERE [id_group]= $keySchedule
                    AND [id_sillabus_t] = " . $valueSchedule['id_sillabus_t'] . "
                    AND [date_rating] > '$start' AND [date_rating] < '$end'";
        $select_rating = sqlsrv_query($connect_local, $sql_rating);
        while ($row = sqlsrv_fetch_array($select_rating)) {
            $now_schedule[$keySchedule]['student'][$row['id_student']][$row['id_sillabus_t']] =
                [
                    'id_rating' => $row['id_rating'],
                    'id_student' => $row['id_student'],
                    'id_group' => $row['id_group'],
                    'id_sillabus_t' => $row['id_sillabus_t'],
                    'date_rating' => $row['date_rating'],
                    'status_rating' => $row['status_rating'],
                    'id_rate' => $row['id_rate'],
                    'id_schedule' => $row['id_schedule']
                ];
        }
        $sql = "SELECT dbo.syllabus_subject.id_subject,
                dbo.syllabus_subject.subject_type,
                dbo.syllabus_subject.subject_hour,
                dbo.syllabus_subject.subject_name,
                dbo.syllabus_subject.id_sillabus_t,
                dbo.syllabus_subject.subject_num,
                dbo.syllabus_subject_hour.subject_past_hour,
                dbo.syllabus_subject_hour.subject_past_hour_date,
                dbo.syllabus_subject_hour.id_group,
                dbo.syllabus_subject_hour.id_subject_hour
            FROM dbo.syllabus_subject
                LEFT OUTER JOIN dbo.syllabus_subject_hour ON dbo.syllabus_subject.id_subject = dbo.syllabus_subject_hour.id_syllabus_subject
            WHERE (dbo.syllabus_subject.subject_type = $StudyTypeID)
                AND (dbo.syllabus_subject.id_sillabus_t = " . $valueSchedule['id_sillabus_t'] . ")
                AND (dbo.syllabus_subject_hour.id_group = $keySchedule
                    OR dbo.syllabus_subject_hour.id_group IS NULL)
                    ORDER BY
            syllabus_subject.subject_num, syllabus_subject_hour.subject_num";
        $select = sqlsrv_query($connect_local, $sql);
        while ($row = sqlsrv_fetch_array($select)) {
            $now_schedule[$keySchedule]['subject'][$row['subject_num']] =
                [
                    'id_subject' => $row['id_subject'],
                    'subject_type' => $row['subject_type'],
                    'subject_hour' => $row['subject_hour'],
                    'subject_name' => $row['subject_name'],
                    'id_sillabus_t' => $row['id_sillabus_t'],
                    'subject_num' => $row['subject_num'],
                    'subject_past_hour' => $row['subject_past_hour'],
                    'subject_past_hour_date' => $row['subject_past_hour_date'],
                    'id_group' => $row['id_group'],
                    'id_subject_hour' => $row['id_subject_hour']
                ];
        }
    }
}
$start = new DateTime($start);
$end = new DateTime($end);
function nextSubject($value, $start, $end)
{
    $unixStart = (int)$start->format('U') / 60;
    $unixEnd = (int)$end->format('U') / 60;
    if ($value) {
        foreach ($value as $key => $val) {
            if ($val['subject_past_hour_date']) {
                $unixSubject = (int)$val['subject_past_hour_date']->format('U') / 60;
                if ($unixStart < $unixSubject and $unixSubject < $unixEnd) {
                    return $val;
                }
            } else {
                return $val;
            }
        }
    } else {
        return null;
    }
}
foreach ($now_schedule as $key => $value) {
    $subject = nextSubject($value['subject'], $start, $end);
    if ($value['id_sillabus_t'] and $value['confirmation'] == 1 and $subject) {
        echo "<form name='group$key'>
            <h2 class='text-center h2'>" . $value['p34'] . ' ' . $value['p20'] ."</h2>
            <h2 class='text-center h2'>" . $subject['subject_num'] . ".   " . $subject['subject_name'] . " " . $value['StudyTypeName'] . "  </h2>
            <input type='hidden' name='id_subject' value='" . $subject['id_subject']  . "'>
            <input type='hidden' name='subject_num' value='" . $subject['subject_num']  . "'>
            <input type='hidden' name='id_schedule' value='" . $value['id_schedule'] . "'>
            <input type='hidden' name='day_number' value='" . $value['day_number'] . "'>
            <input type='hidden' name='id_time' value='" . $value['id_time'] . "'>
            <div class='d-flex gap-5 justify-content-center'><div class='list-group '>";
        $i = 0;
        foreach ($value['student'] as $kStudent => $vStudent) {
            echo "<label class='list-group-item list-group-item-action cursor-pointer d-flex gap-5 mx-0'>
                <input id='$kStudent' type='checkbox' name='$kStudent' class='form-check-input flex-shrink-0'";
            if ($vStudent[$value['id_sillabus_t']]['status_rating'] === 'on') echo 'checked';
            echo "/><span><h4 class='h4'>".++$i . ".  " . $vStudent['p1'] . " " . $vStudent['p2'] . " " . $vStudent['p3'] . "</h4></span></label>";
        }
        echo "<label class='list-group-item gap-5 mx-0'><span>
        <div class='d-grid gap-5 col-8 mx-auto m-3 p-3'><input type='button' onclick=\"send('group$key')\" class='btn btn-primary' value='Отправить'></div>
        </span></label></div>
        <div class='list-group mx-0'>";
        foreach ($value['subject'] as $number => $valueSubject) {
            echo "<label class='list-group-item d-flex gap-5 ";
            if ($subject['id_subject'] == $valueSubject['id_subject'])  echo "list-group-item-primary";
            else if ($valueSubject['subject_past_hour_date']) echo "list-group-item-success";
            echo "'><span>" . $number . ". " . $valueSubject['subject_name'] . " " . $value['StudyTypeName'] . "<small class='d-block text-muted'>";
            if ($valueSubject['subject_past_hour_date']) echo $valueSubject['subject_past_hour_date']->format("d-m-Y G:i");
            echo "</small></span></label>";
        }
        echo "</div></div></form>";
    } else if (!$value['id_sillabus_t']) {
        $i = 0;
        echo "<h2 class='text-center'>" . $value['p34'] . ' ' . $value['p20'] . "</h2>
                <h2 class='text-center'>Нет силлабуса</h2>
                <div class='d-flex gap-5 justify-content-center'><div class='list-group '>";
        foreach ($value['student'] as $kStudent => $vStudent) {
            echo "<label class='list-group-item list-group-item-action d-flex gap-4'><span><h5 class='h5 text-center'>" .
                ++$i . ". " . $vStudent['p1'] . " " . $vStudent['p2'] . " " . $vStudent['p3'] . "</span></h5></label>";
        }
        echo "</div></div>";
    } else if ($value['id_sillabus_t'] and $value['confirmation'] != 1) {
        $i = 0;
        echo "<h2 class='text-center'>" . $value['p34'] . ' ' . $value['p20'] . "</h2>
                <h2 class='text-center'>Силлабус не подтвержден</h2>
                <div class='d-flex gap-5 justify-content-center'><div class='list-group '>";
        foreach ($value['student'] as $kStudent => $vStudent) {
            echo "<label class='list-group-item list-group-item-action d-flex gap-4'><span><h5 class='h5 text-center'>" .
                ++$i . ". " . $vStudent['p1'] . " " . $vStudent['p2'] . " " . $vStudent['p3'] . "</span></h5></label>";
        }
        echo "</div></div>";
    } else if (!$subject) {
        $i = 0;
        echo "<h2 class='text-center'>" . $value['p34'] . ' ' . $value['p20'] . "</h2>
                <h2 class='text-center'>Все темы пройдены</h2>
                <div class='d-flex gap-5 justify-content-center'><div class='list-group '>";
        foreach ($value['student'] as $kStudent => $vStudent) {
            echo "<label class='list-group-item list-group-item-action d-flex gap-4'><span><h5 class='h5 text-center'>" .
                ++$i . ". " . $vStudent['p1'] . " " . $vStudent['p2'] . " " . $vStudent['p3'] . "</span></h5></label>";
        }
        echo "</div></div>";
    }
    unset($subject);
}
include_once '../footer.php';
?>
<script>
    function send(key) {
        let formData = new FormData(document.forms[key]);
        let xhr = new XMLHttpRequest();
        xhr.open("POST", "journal_insert.php");
        xhr.send(formData);
    }
</script>