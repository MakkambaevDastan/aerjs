<?php
session_start();
if ($_SESSION['AVN_Student'] == false) {
    header('Location: ../index.php');
}
include_once '../header.php';
require_once '../vendor/connect.php';
if (!$_GET['id_educ_sh'] and $_SESSION['AVN_Student']['now'])
    $discipline = $_SESSION['AVN_Student']['discipline'][$_SESSION['AVN_Student']['now']];
else $discipline = $_SESSION['AVN_Student']['discipline'][$_GET['id_educ_sh']];
$sql = "SELECT dbo.syllabus_subject.id_subject,
            dbo.syllabus_subject.subject_type,
            dbo.syllabus_subject.subject_hour,
            dbo.syllabus_subject.subject_name,
            dbo.syllabus_subject.id_sillabus_t,
            dbo.syllabus_subject.subject_num,
            dbo.syllabus_subject_hour.id_subject_hour,
            dbo.syllabus_subject_hour.subject_past_hour,
            dbo.syllabus_subject_hour.subject_past_hour_date,
            dbo.syllabus_subject_hour.id_group
        FROM dbo.syllabus_subject
            LEFT OUTER JOIN dbo.syllabus_subject_hour ON dbo.syllabus_subject.id_subject = dbo.syllabus_subject_hour.id_syllabus_subject
        WHERE dbo.syllabus_subject.id_sillabus_t = " . $discipline['id_sillabus_t'] . "
            AND ((dbo.syllabus_subject_hour.id_group = " . $_SESSION['AVN_Student']['id_group'] . ")
            OR (dbo.syllabus_subject_hour.id_group IS NULL))
            ORDER BY dbo.syllabus_subject.id_subject";
$select = sqlsrv_query($connect_local, $sql);
if ($select) {
    while ($row = sqlsrv_fetch_array($select)) {
        $discipline['subject'][$row['subject_type']][$row['subject_num']] =
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
    $sql_rating = "SELECT dbo.syllabus_rating.id_rating,
        dbo.syllabus_rating.id_student,
        dbo.syllabus_rating.id_group,
        dbo.syllabus_rating.id_sillabus_t,
        dbo.syllabus_rating.date_rating,
        dbo.syllabus_rating.status_rating,
        dbo.syllabus_rating.id_rate,
        dbo.syllabus_rating.id_schedule,
        dbo.syllabus_rating.id_subject,
        dbo.syllabus_subject.subject_num,
        dbo.syllabus_subject.subject_type
    FROM dbo.syllabus_rating
        INNER JOIN dbo.syllabus_subject ON dbo.syllabus_rating.id_subject = dbo.syllabus_subject.id_subject
    WHERE (dbo.syllabus_rating.id_group = " .  $_SESSION['AVN_Student']['id_group']  . ")
        AND dbo.syllabus_rating.id_sillabus_t = " . $discipline['id_sillabus_t'];
    $select_rating = sqlsrv_query($connect_local, $sql_rating);
    while ($row = sqlsrv_fetch_array($select_rating)) {
        $discipline['student'][$row['id_student']][$row['subject_type']][$row['subject_num']] =
            [
                'id_rating' => $row['id_rating'],
                'subject_num' => $row['subject_num'],
                'subject_type' => $row['subject_type'],
                'id_student' => $row['id_student'],
                'id_group' => $row['id_group'],
                'id_sillabus_t' => $row['id_sillabus_t'],
                'date_rating' => $row['date_rating'],
                'status_rating' => $row['status_rating'],
                'id_rate' => $row['id_rate'],
                'id_subject' => $row['id_subject'],
                'id_schedule' => $row['id_schedule']
            ];
    }
    $sql =
        "SELECT DISTINCT [Student].[id_student],
                [Student].[p1],
                [Student].[p2],
                [Student].[p3]
                FROM [dbo].[movement_t]
            LEFT JOIN [dbo].[Student] ON [student].[id_student] = [movement_t].[id_student]
            WHERE [id_group]= " . $_SESSION['AVN_Student']['id_group'] . " AND id_rate = " . $_SESSION['AVN_Student']['id_rate'] . " and isStudying <> 0
            ORDER BY [Student].[p1]";
    $select = sqlsrv_query($connect, $sql);
    while ($row = sqlsrv_fetch_array($select)) {
        $student[$row['id_student']] = [
            'p1' => $row['p1'],
            'p2' => $row['p2'],
            'p3' => $row['p3']
        ];
    }
    echo "<h1 class='h1 text-center'>" . $discipline['p34'] . "</h1>";
    foreach ($discipline['subject'] as $subject_type => $subject) {
        $n = count($subject);
        echo "<div class='table-responsive'><table class='table'><tr><td></td><th class='w-75' colspan='$n'><h1 class='h1'>" . $discipline['id_semester'] . "-семестр ";
        if ($subject_type == 1) echo " Лекция ";
        else if ($subject_type == 2) echo " Лабораторная ";
        else if ($subject_type == 3) echo " Практическая ";
        else if ($subject_type == 4) echo " Семинар ";
            $s=count($student)+4;
            echo "</h1></th></tr>";
            echo "<tr><th>День</th>";
            foreach ($subject as $subject_num => $id_subject) {
                if ($id_subject['subject_past_hour']) {
                    echo "<th class='cel table-success'>" . $id_subject['subject_past_hour_date']->format("j") . "</th>";
                } else {
                    echo "<th class='cel table-light'>-</th>";
                }
            }
            echo "</tr>";
            echo "<tr><th>Месяц</th>";
            foreach ($subject as $subject_num => $id_subject) {
                if ($id_subject['subject_past_hour']) {
                    echo "<th class='cel table-success'>" . $id_subject['subject_past_hour_date']->format("m") . "</th>";
                } else {
                    echo "<th class='cel table-light'>-</th>";
                }
            }
            echo "</tr>";
            echo "<tr><th>Номер урока</th>";
            foreach ($subject as $subject_num => $id_subject) {
                if ($id_subject['subject_past_hour']) {
                    echo "<th class='cel table-success'>" . $id_subject['subject_num'] . "</th>";
                } else {
                    echo "<th class='cel table-light'>" . $id_subject['subject_num'] . "</th>";
                }
            }
            echo "</tr>";
        foreach ($student as $id_student => $fio) {
            echo "<tr><th class='text-left'>" . ++$j . ". " . $fio['p1'] . " " . $fio['p2'] . "</th>";
            for ($i = 1; $i <= $n; $i++) {
                if ($discipline['student'][$id_student][$subject_type][$i]['status_rating'] == 'on') echo "<td class='cel table-success'>+</td>";
                else if ($discipline['student'][$id_student][$subject_type][$i]['status_rating'] == 'off') echo "<td class='cel table-danger'>-</td>";
                else echo "<td class='cel table-light'> </td>";
            }
            // if($subject[$j]['subject_past_hour']) echo "<td  class='cel table-success'>";
            // else echo "<td>";
            // echo $subject[$j]['subject_num'].'.'. $subject[$j]['subject_name'];
            // echo "</td>";
            echo "</tr>";
        }
        $j = 0;
        echo "</table>";
        echo "<table class='table'>";
        echo "<tr><th>№</th><th>Дата</th><th>Тема урока</th></tr>";
        foreach ($subject as $subject_num => $id_subject) {
            if ($id_subject['subject_past_hour']) echo "<tr class='cel table-success'>";
            else echo "<tr class='cel table-light'>";
            echo "<th class='cel'>" . $id_subject['subject_num'] . "</th>";
            echo "<th>";
            if($id_subject['subject_past_hour_date']) echo $id_subject['subject_past_hour_date']->format("d.m.Y G.i");
            echo "</th>";
            echo "<th class='text-left'>" . $id_subject['subject_name'] . "</th>";
            echo "</tr>";
        }
        echo "</table>";
        echo "</div>";
    }
}
include_once '../footer.php';

// echo "<h1 class='h1 text-center'>$p20</h1>";
// foreach ($journal as $key => $value) {
//     if ($value['id_sillabus_t']) {
//         foreach ($value['subject'] as $subject_type => $subject) {
//             // print_r($subject);
//             $n = count($subject);
//             echo "<div class='table-responsive'><table class='table'><tr><td></td><th  class='w-75' colspan='$n'><h1 class='h1'>".
//             $value['p34'] . " ".$value['id_semester'] . "-семестр ";
//             if ($subject_type == 1) {
//                 echo " Лекция ";
//             } else if ($subject_type == 2) {
//                 echo " Лабораторная ";
//             } else if ($subject_type == 3) {
//                 echo " Практическая ";
//             } else if ($subject_type == 4) {
//                 echo " Семинар ";
//             }
//             $s=count($student)+3;
//             echo "</h1></th><th rowspan='$s'></th></tr> <tr><th></th>";
//             foreach ($subject as $subject_num => $id_subject) {
//                 if ($id_subject['subject_past_hour']) {
//                     echo "<th class='cel table-success'>".$id_subject['subject_num']."</th>";
//                 } else {
//                     echo "<th class='cel table-light'>".$id_subject['subject_num']."</th>";
//                 }
//             }
//             echo "</tr>";
//             foreach ($student as $id_student => $fio) {
//                 echo "<tr><th class='text-left'>".++$j . ". " . $fio['p1'] . " " . $fio['p2']."</th>";
//                 for ($i = 1; $i <= $n; $i++) {
//                     if ($value['student'][$id_student][$subject_type][$i]['status_rating'] == 'on') {
//                         echo "<td class='cel table-success'>+</td>";
//                     } else if ($value['student'][$id_student][$subject_type][$i]['status_rating'] == 'off') {
//                         echo "<td class='cel table-danger'>-</td>";
//                     } else {
//                         echo "<td class='cel table-light'></td>";
//                     }
//                 }
//                 if($subject[$j]['subject_past_hour']) echo "<td  class='cel table-success'>";
//                 else echo "<td>";
//                 echo $subject[$j]['subject_num'].'.'. $subject[$j]['subject_name'];
//                 echo "</td>";
//                 echo "</tr>";
//             }
//             $j = 0;
//             echo "</table></div>";
//         }
//     } else {
//         echo "<table class='table table-hover'><tr><th colspan=''><h2 class='h2'>".
//         $value['p34'] . " ".$value['id_semester'] . "-семестр Нет силлабуса</h2></th></tr>";
//         foreach ($student as $id_student => $fio) {
//             echo "<tr><th>".++$i . ". " . $fio['p1'] . " " . $fio['p2'] . " " . $fio['p3']."</th></tr>";
//         }
//         $i = 0;
//         echo "</table>";
//     }
// }

?>
<style>
    table {
        border: 1px solid black;
    }

    .cel {
        height: 30px;
        width: 30px;
        margin: 0;
        padding: 0;
        text-align: center;
        border: 1px solid black;
    }

    td,
    th {
        border: 1px solid black;
    }
</style>