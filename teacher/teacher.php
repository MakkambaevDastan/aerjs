<?php
session_start();
if ($_SESSION['AVN_User'] == false) header('Location: ../index.php');
if (!$_SESSION['AVN_User']['status']) header('Location: discipline.php');
include_once '../header.php';
require_once '../vendor/connect.php';
$id_teach = $_SESSION['AVN_User']['id_teacher'];
$status_zav_kaf = $_SESSION['AVN_User']['status'];
$id_kafedra_ = $_SESSION['AVN_User']['id_kafedra'];
$id_faculty_ = $_SESSION['AVN_User']['id_faculty'];
// echo "<pre>";
// echo 
$sql = "SELECT [avn].[dbo].[educ_sh].[id_educ_sh],
[aerjs].[dbo].[syllabus_head].[confirmation],
[aerjs].[dbo].[syllabus_head].[id_sillabus_t],
[discipline].[id_a_year],
[discipline].[p32],
[discipline].[id_teacher],
[discipline].[s_t_fio],
[discipline].[id_kafedra],
[discipline].[id_speciality],
[discipline].[spec],
[discipline].[p25-2],
[discipline].[id_faculty],
[discipline].[p23-1],
[discipline].[p23-2],
[discipline].[id_rate],
[discipline].[p22],
[avn].[dbo].[educ_sh].[id_semester],
[discipline].[id_discipline],
[discipline].[p34],
[discipline].[p34_kg],
[discipline].[f]
FROM (SELECT DISTINCT [id_a_year],
        [p32],
        teacher.[id_teacher],
        teacher.f,
        teacher.[s_t_fio],
        [id_kafedra],
        [avn].[dbo].[group].[id_speciality],
        [spec],
        [p25-2],
        [avn].[dbo].[V_Raspisanie_new].[id_faculty],
        [p23-1],
        [p23-2],
        [id_rate],
        [p22],
        [id_discipline],
        [p34],
        [p34_kg]
    FROM [avn].[dbo].[V_Raspisanie_new]
        INNER JOIN [avn].[dbo].[group] ON [avn].[dbo].[group].[id_group] = [avn].[dbo].[V_Raspisanie_new].[id_group]
        INNER JOIN [avn].[dbo].[g_s] ON [avn].[dbo].[group].[id_speciality] = [avn].[dbo].[g_s].[id_speciality]
        INNER JOIN (
            SELECT DISTINCT [avn].[dbo].[t_fio].[id_teacher],
                [avn].[dbo].[t_fio].[t_fio] as f,
                [avn].[dbo].[t_fio].[s_t_fio],
                [avn].[dbo].[Vakansii].[id_faculty]
            FROM [avn].[dbo].[Working]
                INNER JOIN [avn].[dbo].[Vakansii] ON [avn].[dbo].[Vakansii].[id_vakansiya] = [avn].[dbo].[Working].[id_vakansiya]
                INNER JOIN [avn].[dbo].[t_fio] ON [avn].[dbo].[Working].[id_teacher] = [avn].[dbo].[t_fio].[id_teacher]
            WHERE [avn].[dbo].[Vakansii].[id_kafedra] = '$id_kafedra_'
        ) as teacher ON teacher.id_teacher = [avn].dbo.V_Raspisanie_new.id_teacher
    WHERE ([avn].dbo.V_Raspisanie_new.id_a_year = $rate_year)) AS [discipline]
INNER JOIN [avn].[dbo].[educ_sh] ON [discipline].[id_speciality] = [avn].[dbo].[educ_sh].[id_speciality]
AND [discipline].[id_discipline] = [avn].[dbo].[educ_sh].[id_discipline]
AND [discipline].[id_kafedra] = [avn].[dbo].[educ_sh].[id_kafedra]
AND [discipline].[id_a_year] = [avn].[dbo].[educ_sh].[id_a_year]
LEFT JOIN [aerjs].[dbo].[syllabus_head] ON [aerjs].[dbo].[syllabus_head].[id_educ_sh] = [avn].[dbo].[educ_sh].[id_educ_sh]
ORDER BY [s_t_fio], id_semester, id_speciality";
$select = sqlsrv_query($connect, $sql);
if ($select === false) {
    die(print_r(sqlsrv_errors(), true));
}
while ($row = sqlsrv_fetch_array($select)) {
    $teacher[$row['id_teacher']]['f'] = $row['f'];
    $teacher[$row['id_teacher']][$row['id_educ_sh']] = [
        'id_educ_sh' => $row['id_educ_sh'],
        'confirmation' => $row['confirmation'],
        'id_sillabus_t' => $row['id_sillabus_t'],
        'id_a_year' => $row['id_a_year'],
        'p32' => $row['p32'],
        'id_teacher' => $row['id_teacher'],
        'f' => $row['f'],
        's_t_fio' => $row['s_t_fio'],
        'id_kafedra' => $row['id_kafedra'],
        'id_speciality' => $row['id_speciality'],
        'spec' => $row['spec'],
        'p25-2' => $row['p25-2'],
        'id_faculty' => $row['id_faculty'],
        'p23-1' => $row['p23-1'],
        'p23-2' => $row['p23-2'],
        'id_rate' => $row['id_rate'],
        'p22' => $row['p22'],
        'id_semester' => $row['id_semester'],
        'id_discipline' => $row['id_discipline'],
        'p34' => $row['p34'],
        'p34_kg' => $row['p34_kg']
    ];
}

if ($_SESSION['message']) {
    echo "<h2 class='text-center h2'>" . $_SESSION['message'] . "</h2>";
    unset($_SESSION['message']);
}
// print_r($teacher);
// var_dump($teacher);
echo "<div class='accordion accordion-flush' id='accordionFlushExample'>";
foreach ($teacher as $key => $value) {
    echo "<div class='accordion-item'><h2 class='accordion-header' id='flush-heading$key'>
    <button class='accordion-button collapsed' type='button' 
    data-bs-toggle='collapse' data-bs-target='#flush-collapse$key' aria-expanded='false' aria-controls='flush-collapse$key'>";
    echo $value['f'] . " ";
    unset($value['f']);
    foreach ($value as $k => $v) {
        if ($v['confirmation'] === 1) $t++;
        if ($v['confirmation'] === 0) $f++;
        if ($v['confirmation'] === null) $n++;
    }
    echo "<small> - $n</small><small style='color:green;'>-$t-</small><small style='color:red;'>$f</small>";
    unset($t, $f, $n);
    echo "</button></h2>
    <div id='flush-collapse$key' class='accordion-collapse collapse' aria-labelledby='flush-heading$key' data-bs-parent='#accordionFlushExample'>
    <div class='accordion-body'><ul class='list-group'>";

    foreach ($value as $key1 => $value1) {
    // var_dump($v);

        if ($value1['confirmation'] === 1) {
            echo "<a class=\"list-group-item list-group-item-success list-group-item-action\" href = 'syllabus.php?id_educ_sh=" . $value1['id_educ_sh'] . "'>
            <div class='d-flex w-100 justify-content-between'> <h5 class='mb-1'><small class='text-muted'>Дисциплина: </small>" .
                $value1['p34'] . "</h5> <small class='text-muted'>" .
                $value1['id_semester'] . "-семестр Подтвержден</small></div>
            <p class='mb-1'><small class='text-muted'>специальность: </small>" .
                $value1['p25-2'] . " " . $value1['p43'] . "</p></a>";
        } else if ($value1['confirmation'] === 0) {
            echo "<a class=\"list-group-item list-group-item-danger list-group-item-action\" href = 'syllabus.php?id_educ_sh=" . $value1['id_educ_sh'] . "'>
            <div class='d-flex w-100 justify-content-between'> <h5 class='mb-1'><small class='text-muted'>Дисциплина: </small>" .
                $value1['p34'] . "</h5> <small class='text-muted'>" .
                $value1['id_semester'] . "-семестр Не подтвержден</small></div>
            <p class='mb-1'><small class='text-muted'>специальность: </small>" .
                $value1['p25-2'] . " " . $value1['p43'] . "</p></a>";
        } else {
            echo "<a class=\"list-group-item  list-group-item-action\" href = 'syllabus.php?id_educ_sh=" . $value1['id_educ_sh'] . "'>
            <div class='d-flex w-100 justify-content-between'> <h5 class='mb-1'><small class='text-muted'>Дисциплина: </small>" .
                $value1['p34'] . "</h5> <small class='text-muted'>" .
                $value1['id_semester'] . "-семестр Нет силлабус</small></div>
            <p class='mb-1'><small class='text-muted'>специальность: </small>" .
                $value1['p25-2'] . " " . $value1['p43'] . "</p></a>";
        }
    }
    echo "</ul></div></div></div>";
}
echo "</div>";
include_once '../footer.php';
