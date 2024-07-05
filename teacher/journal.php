<?php
session_start();
if ($_SESSION['AVN_User'] == false) {
    header('Location: ../index.php');
}
include_once '../header.php';
require_once '../vendor/connect.php';
$sql = "SELECT TOP (100) PERCENT
        dbo.educ_sh.id_educ_sh,
        dbo.educ_sh.id_semester, 
        discipline.id_speciality, 
        discipline.spec,
        discipline.id_group,
        discipline.p20,
        discipline.p21,
        discipline.o_z,
        discipline.id_sub_group
        FROM (
        SELECT DISTINCT dbo.[group].id_group,
        dbo.g_s.spec,
        dbo.g_s.[p25-2],
        dbo.[group].p20,
        dbo.[group].p21,
        dbo.[group].o_z,
        dbo.[group].id_sub_group,
        dbo.V_Raspisanie_new.id_w_s,
        dbo.[group].id_speciality,
        dbo.V_Raspisanie_new.id_discipline,
        dbo.V_Raspisanie_new.id_a_year,
        dbo.V_Raspisanie_new.id_kafedra
        FROM dbo.V_Raspisanie_new
        INNER JOIN dbo.[group] ON dbo.[group].id_group = dbo.V_Raspisanie_new.id_group
        INNER JOIN dbo.g_s ON dbo.[group].id_speciality = dbo.g_s.id_speciality
        WHERE (dbo.V_Raspisanie_new.id_teacher = " . $_SESSION['AVN_User']['id_teacher'] . ")
        AND (dbo.V_Raspisanie_new.id_a_year = $rate_year)
        ) AS discipline
        INNER JOIN dbo.educ_sh ON discipline.id_speciality = dbo.educ_sh.id_speciality
        AND discipline.id_discipline = dbo.educ_sh.id_discipline
        AND discipline.id_kafedra = dbo.educ_sh.id_kafedra
        AND discipline.id_a_year = dbo.educ_sh.id_a_year
        ORDER BY discipline.id_speciality, discipline.id_group";
$select = sqlsrv_query($connect, $sql);
while ($row = sqlsrv_fetch_array($select)) {
    $_SESSION['AVN_User']['group'][$row['id_group']][$row['id_educ_sh']] =
        [
            'id_educ_sh' => $row['id_educ_sh'],
            'id_semester' => $row['id_semester'],
            'spec' => $row['spec'],
            'id_group' => $row['id_group'],
            'p20' => $row['p20'],
            'o_z' => $row['o_z'],
            'p21' => $row['p21'],
            'id_sub_group' => $row['id_sub_group']
        ];
    $group[$row['id_group']]['p20'] = $row['p20'];
    $group[$row['id_group']]['spec'] = $row['spec'];
}
echo "<h1 class='text-center h1'>Группы</h1><ul class='list-group'>";
foreach ($group as $key => $value) {
    echo "
        <a class='list-group-item list-group-item-action list-group-item-primary'
         href = 'journal_view.php?id_group=$key'>
        <div class='d-flex w-100 justify-content-between'> 
        <h5 class='mb-1'>
        <small class='text-muted'></small>
        " . $value['p20'] . ' - ' . $value['spec'] . "
        </h5> 
        <small class='text-muted'></small>
        </div>
        <p class='mb-1'>
        <small class='text-muted'></small>
        </p>
        </a>";
}
echo "</ul>";
include_once '../footer.php';
