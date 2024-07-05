<?php
session_start();
if ($_SESSION['AVN_Student'] == false) {
    header('Location: ../index.php');
}
include_once '../header.php';
require_once '../vendor/connect.php';
if (!$_SESSION['AVN_Student']['schedule']) {
    $s = $w_s == 1 ? "=" : "<>";
    $sql =
        "SELECT DISTINCT TOP (100) PERCENT dbo.V_Raspisanie_new.ID,
        dbo.V_Raspisanie_new.id_a_year,
        dbo.V_Raspisanie_new.p32,
        dbo.V_Raspisanie_new.id_w_s,
        dbo.V_Raspisanie_new.day_number,
        dbo.V_Raspisanie_new.Day_name,
        dbo.V_Raspisanie_new.id_time,
        dbo.V_Raspisanie_new.Time_,
        dbo.V_Raspisanie_new.sort,
        dbo.V_Raspisanie_new.vid_time,
        dbo.V_Raspisanie_new.SubGroup,
        dbo.V_Raspisanie_new.EveryWeek,
        dbo.V_Raspisanie_new.ch_zham,
        dbo.V_Raspisanie_new.StudyTypeID,
        dbo.V_Raspisanie_new.StudyTypeName,
        dbo.V_Raspisanie_new.id_teacher,
        dbo.V_Raspisanie_new.s_t_fio,
        dbo.V_Raspisanie_new.id_auditorium,
        dbo.V_Raspisanie_new.number,
        dbo.V_Raspisanie_new.id_kafedra,
        dbo.V_Raspisanie_new.sn_f1,
        dbo.V_Raspisanie_new.beg_nedeli,
        dbo.V_Raspisanie_new.end_nedeli,
        dbo.V_Raspisanie_new.id_group,
        dbo.V_Raspisanie_new.p20,
        dbo.V_Raspisanie_new.id_faculty,
        dbo.V_Raspisanie_new.[p23-1],
        dbo.V_Raspisanie_new.[p23-2],
        dbo.V_Raspisanie_new.id_rate,
        dbo.V_Raspisanie_new.p22,
        dbo.V_Raspisanie_new.EmployeeID2,
        dbo.V_Raspisanie_new.id_discipline,
        dbo.V_Raspisanie_new.p34,
        dbo.V_Raspisanie_new.Sh_Date,
        dbo.V_Raspisanie_new.p34_kg,
        dbo.[group].id_speciality,
        dbo.g_s.spec,
        dbo.g_s.[p25-2],
        dbo.educ_sh.id_educ_sh,
        aerjs.dbo.syllabus_head.id_sillabus_t,
        aerjs.dbo.syllabus_head.confirmation,
        dbo.educ_sh.id_semester
    FROM dbo.V_Raspisanie_new
        INNER JOIN dbo.[group] ON dbo.[group].id_group = dbo.V_Raspisanie_new.id_group
        AND dbo.V_Raspisanie_new.id_faculty = dbo.[group].id_faculty
        INNER JOIN dbo.educ_sh ON dbo.V_Raspisanie_new.id_a_year = dbo.educ_sh.id_a_year
        AND dbo.V_Raspisanie_new.id_kafedra = dbo.educ_sh.id_kafedra
        AND dbo.[group].id_speciality = dbo.educ_sh.id_speciality
        AND dbo.V_Raspisanie_new.id_discipline = dbo.educ_sh.id_discipline
        LEFT OUTER JOIN aerjs.dbo.syllabus_head ON dbo.educ_sh.id_educ_sh = aerjs.dbo.syllabus_head.id_educ_sh
        LEFT OUTER JOIN dbo.g_s ON dbo.[group].id_speciality = dbo.g_s.id_speciality
    WHERE (dbo.V_Raspisanie_new.id_a_year = $rate_year)
        AND (CAST(dbo.educ_sh.id_semester AS INT) % 2 $s 0)
        AND (dbo.V_Raspisanie_new.id_group = " . $_SESSION['AVN_Student']['id_group'] . ")
    ORDER BY dbo.V_Raspisanie_new.id_time";
    $schedule = [
        'max_time' => 0,
        'max_day' => 0,
        1 => [1 => [], 2 => [], 3 => [], 4 => [], 5 => [], 6 => [], 7 => [], 8 => [], 9 => [], 10 => [], 11 => [], 12],
        2 => [1 => [], 2 => [], 3 => [], 4 => [], 5 => [], 6 => [], 7 => [], 8 => [], 9 => [], 10 => [], 11 => [], 12],
        3 => [1 => [], 2 => [], 3 => [], 4 => [], 5 => [], 6 => [], 7 => [], 8 => [], 9 => [], 10 => [], 11 => [], 12],
        4 => [1 => [], 2 => [], 3 => [], 4 => [], 5 => [], 6 => [], 7 => [], 8 => [], 9 => [], 10 => [], 11 => [], 12],
        5 => [1 => [], 2 => [], 3 => [], 4 => [], 5 => [], 6 => [], 7 => [], 8 => [], 9 => [], 10 => [], 11 => [], 12],
        6 => [1 => [], 2 => [], 3 => [], 4 => [], 5 => [], 6 => [], 7 => [], 8 => [], 9 => [], 10 => [], 11 => [], 12]
    ];
    $parameter = [$rate_year, $_SESSION['AVN_User']['id_teacher']];
    $select = sqlsrv_query($connect, $sql, $parameter);
    while ($row = sqlsrv_fetch_array($select)) {
        if ($schedule['max_time'] < $row['id_time'])
            $schedule['max_time'] = $row['id_time'];
        if ($schedule['max_day'] < $row['day_number'])
            $schedule['max_day'] = $row['day_number'];
        $schedule[$row['day_number']][$row['id_time']][] = [
            'id_schedule' => $row['ID'],
            'id_a_year' => $row['id_a_year'],
            'p32' => $row['p32'],
            'id_w_s' => $row['id_w_s'],
            'day_number' => $row['day_number'],
            'Day_name' => $row['Day_name'],
            'id_time' => $row['id_time'],
            'Time_' => $row['Time_'],
            'sort' => $row['sort'],
            'vid_time' => $row['vid_time'],
            'SubGroup' => $row['SubGroup'],
            'EveryWeek' => $row['EveryWeek'],
            'ch_zham' => $row['ch_zham'],
            'StudyTypeID' => $row['StudyTypeID'],
            'StudyTypeName' => $row['StudyTypeName'],
            'id_teacher' => $row['id_teacher'],
            's_t_fio' => $row['s_t_fio'],
            'id_auditorium' => $row['id_auditorium'],
            'number' => $row['number'],
            'id_kafedra' => $row['id_kafedra'],
            'sn_f1' => $row['sn_f1'],
            'beg_nedeli' => $row['beg_nedeli'],
            'end_nedeli' => $row['end_nedeli'],
            'id_group' => $row['id_group'],
            'p20' => $row['p20'],
            'id_faculty' => $row['id_faculty'],
            'p23-1' => $row['p23-1'],
            'p23-2' => $row['p23-2'],
            'id_rate' => $row['id_rate'],
            'p22' => $row['p22'],
            'EmployeeID2' => $row['EmployeeID2'],
            'id_discipline' => $row['id_discipline'],
            'p34' => $row['p34'],
            'Sh_Date' => $row['Sh_Date'],
            'p34_kg' => $row['p34_kg'],
            'id_speciality' => $row['id_speciality'],
            'spec' => $row['spec'],
            'p25-2' => $row['p25-2'],
            'id_educ_sh' => $row['id_educ_sh'],
            'id_sillabus_t' => $row['id_sillabus_t'],
            'confirmation' => $row['confirmation'],
            'id_semester' => $row['id_semester']
        ];
    }
    $_SESSION['AVN_Student']['schedule'] = $schedule;
} else $schedule = $_SESSION['AVN_Student']['schedule'];
foreach ($time_start as $key => $value) {
    if ($date->format('H.i') > $value && $time_end[$key] > $date->format('H.i')) $now = $key;
}
echo "<div class='table-responsive shadow'><table class='table table-borderless text-center schedule-table list-group'>";
for ($i = 0; $i <= $schedule['max_time']; $i++) {
    echo "<tr>";
    for ($j = 0; $j <=$schedule['max_day']; $j++) {
        if ($j == 0 and $i == 0) {
            echo "<td></td>";
        } else if ($i == 0 and $j != 0) {
            if ($j == $day_of_week) echo "<th class='table-info border'>";
            else echo "<th class='border'>";
            echo $day[$j] . "</th>";
        } else if ($i != 0 and $j == 0) {
            if ($i == $now) echo "<th  class='table-info border'>";
            else echo "<th  class='border'>";
            echo "$i-урок <br/>" . $time_start[$i] . "</th>";
        } else if ($j == $day_of_week && count($schedule[$j][$i])) {
            echo "<td class='border table-info p-0'><ul class='list-group m-0 p-0  n'>";
            for ($it = 0; $it < count($schedule[$j][$i]); $it++) {
                if ($schedule[$j][$i][$it]['id_time'] < $now)
                    echo "<a class='list-group-item list-group-item-success list-group-item-action '>
                    <h5 class='h5'>" . $schedule[$j][$i][$it]['p34'] . "</h5>  " .
                        $schedule[$j][$i][$it]['StudyTypeName'] . " " .
                        $schedule[$j][$i][$it]['number'] . " " .
                        $schedule[$j][$i][$it]['s_t_fio'] . "</a>";
                if ($schedule[$j][$i][$it]['id_time'] == $now) {
                    $_SESSION['AVN_Student']['now'] = $schedule[$j][$i][$it]['id_educ_sh'];
                    echo "<a class='list-group-item shadow-lg list-group-item-primary list-group-item-action m-1 rounded-lg' href = 'journal.php'>
                    <h5 class='h5'>" . $schedule[$j][$i][$it]['p34'] . "</h5>  " .
                        $schedule[$j][$i][$it]['StudyTypeName'] . " " .
                        $schedule[$j][$i][$it]['number'] . " " .
                        $schedule[$j][$i][$it]['s_t_fio'] . "</a>";
                }
                if ($schedule[$j][$i][$it]['id_time'] > $now)
                    echo "<a class='list-group-item list-group-item-danger m-0 list-group-item-action'>
                    <h5 class='h5'>" . $schedule[$j][$i][$it]['p34'] . "</h5>  " .
                        $schedule[$j][$i][$it]['StudyTypeName'] . " " .
                        $schedule[$j][$i][$it]['number'] . " " .
                        $schedule[$j][$i][$it]['s_t_fio'] . "</a>";
            }
            echo "</ul></td>";
        } else if ($day_of_week > $j and count($schedule[$j][$i])) {
            echo "<td class='border  p-0'><ul class='list-group m-0 p-0 '>";
            for ($it = 0; $it < count($schedule[$j][$i]); $it++) {
                echo "<a class='list-group-item list-group-item-success m-0 list-group-item-action'>
                <h5 class='h5'>" . $schedule[$j][$i][$it]['p34'] . "</h5>  " .
                    $schedule[$j][$i][$it]['StudyTypeName'] . " " .
                    $schedule[$j][$i][$it]['number'] . " " .
                    $schedule[$j][$i][$it]['s_t_fio'] . "</a>";
            }
            echo "</ul></td>";
        } else if (count($schedule[$j][$i]) and $day_of_week < $j) {
            echo "<td class='border  p-0'><ul class='list-group m-0 p-0 n'>";
            for ($it = 0; $it < count($schedule[$j][$i]); $it++) {
                echo "<a class='list-group-item list-group-item-warning m-0 list-group-item-action'>
                <h5 class='h5'>" . $schedule[$j][$i][$it]['p34'] . "</h5>  " .
                    $schedule[$j][$i][$it]['StudyTypeName'] . " " .
                    $schedule[$j][$i][$it]['number'] . " " .
                    $schedule[$j][$i][$it]['s_t_fio'] . "</a>";
            }
            echo "</ul></td>";
        } else {
            if ($i == $now && $j == $day_of_week || $j == $day_of_week) echo "<td class='border table-info'></td>";
            else echo "<td class='border'></td>";
        }
    }
    echo "</tr>";
}
echo "</table></div>";
include_once '../footer.php';