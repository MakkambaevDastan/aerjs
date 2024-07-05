<?php
session_start();
if ($_SESSION['AVN_Student'] == false) {
    header('Location: ../index.php');
}
include_once '../header.php';
require_once '../vendor/connect.php';
$sql ="SELECT [a_year].[p32],
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
[discipline].[id_discipline],
[discipline].[p34],
[discipline].[p34_kg],
[avn].[dbo].[educ_sh].[id_educ_sh]
,[avn].[dbo].[educ_sh].[id_speciality]
,[avn].[dbo].[educ_sh].[id_a_year]
,[avn].[dbo].[educ_sh].[id_semester]
,[avn].[dbo].[educ_sh].[id_component]
,[avn].[dbo].[educ_sh].[id_kind]
,[avn].[dbo].[educ_sh].[id_teacher]
,[avn].[dbo].[educ_sh].[id_kafedra]
,[avn].[dbo].[educ_sh].[id_discipline]
,[avn].[dbo].[educ_sh].[id_control]
,[avn].[dbo].[educ_sh].[id_examination]
,[avn].[dbo].[educ_sh].[p51]
,[avn].[dbo].[educ_sh].[p52]
,[avn].[dbo].[educ_sh].[p53]
,[avn].[dbo].[educ_sh].[srs]
,[avn].[dbo].[educ_sh].[rzr]
,[avn].[dbo].[educ_sh].[ind_z]
,[avn].[dbo].[educ_sh].[seminar]
,[avn].[dbo].[educ_sh].[p54]
,[avn].[dbo].[educ_sh].[oper]
,[avn].[dbo].[educ_sh].[u_date]
,[avn].[dbo].[educ_sh].[AVN_user]
,[avn].[dbo].[educ_sh].[AVN_update]
,[avn].[dbo].[educ_sh].[Krdt] as [kredit_ECTS]
,[avn].[dbo].[educ_sh].[descGroupNum]
,[avn].[dbo].[educ_sh].[isSelect]
,[avn].[dbo].[educ_sh].[id_disciplineName]
,[avn].[dbo].[educ_sh].[colnedel]
,[avn].[dbo].[educ_sh].[interactive]
,[avn].[dbo].[educ_sh].[srsp]
,[avn].[dbo].[educ_sh].[code_discipline]
,[avn].[dbo].[educ_sh].[vid_discipline]
,[avn].[dbo].[educ_sh].[koefZD],
[aerjs].[dbo].[syllabus_head].[confirmation],
[aerjs].[dbo].[syllabus_head].[id_sillabus_t],
[aerjs].[dbo].[syllabus_head].[id_syllabus],
[aerjs].[dbo].[syllabus_head].[confirmation],
[aerjs].[dbo].[syllabus_head].[id_year],
[aerjs].[dbo].[syllabus_head].[assistant],
[aerjs].[dbo].[syllabus_head].[code],
[aerjs].[dbo].[syllabus_head].[hour_week],
[aerjs].[dbo].[syllabus_head].[lecture],
[aerjs].[dbo].[syllabus_head].[laboratory],
[aerjs].[dbo].[syllabus_head].[practice],
[aerjs].[dbo].[syllabus_head].[seminar] AS [syllabus_seminar],
[aerjs].[dbo].[syllabus_head].[course_raiting],
[aerjs].[dbo].[syllabus_head].[course_type],
[aerjs].[dbo].[syllabus_head].[course_language],
[aerjs].[dbo].[syllabus_head].[purpose],
[aerjs].[dbo].[syllabus_head].[annotation],
[aerjs].[dbo].[syllabus_head].[competence],
[aerjs].[dbo].[syllabus_head].[result_learning],
[aerjs].[dbo].[syllabus_head].[student_know],
[aerjs].[dbo].[syllabus_head].[student_must],
[aerjs].[dbo].[syllabus_head].[id_update],
[aerjs].[dbo].[syllabus_head].[id_sillabus_t],
[aerjs].[dbo].[syllabus_head].[StudyTypeID],
[aerjs].[dbo].[syllabus_head].[instrumentos]
FROM (
    SELECT DISTINCT [id_a_year],
        [p32],
        [id_teacher],
        [s_t_fio],
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
    WHERE ([avn].dbo.V_Raspisanie_new.id_group = " . $_SESSION['AVN_Student']['id_group'] . ")
        AND ([avn].dbo.V_Raspisanie_new.id_a_year = $rate_year)
) AS [discipline]
INNER JOIN [avn].[dbo].[educ_sh] ON [discipline].[id_speciality] = [avn].[dbo].[educ_sh].[id_speciality]
AND [discipline].[id_discipline] = [avn].[dbo].[educ_sh].[id_discipline]
AND [discipline].[id_kafedra] = [avn].[dbo].[educ_sh].[id_kafedra]
AND [discipline].[id_a_year] = [avn].[dbo].[educ_sh].[id_a_year]
LEFT JOIN [aerjs].[dbo].[syllabus_head] ON [aerjs].[dbo].[syllabus_head].[id_educ_sh] = [avn].[dbo].[educ_sh].[id_educ_sh]
INNER JOIN [avn].[dbo].[a_year] ON [a_year].[id_a_year]=[educ_sh].[id_a_year]
ORDER BY [avn].[dbo].[educ_sh].[id_educ_sh]";
$select = sqlsrv_query($connect, $sql);
while ($row = sqlsrv_fetch_array($select)) {
    $discipline[$row['id_educ_sh']] = [
        'id_educ_sh' => $row['id_educ_sh'],
        'id_a_year' => $row['id_a_year'],
        'p32' => $row['p32'],
        'id_teacher' => $row['id_teacher'],
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
        'id_discipline' => $row['id_discipline'],
        'p34' => $row['p34'],
        'p34_kg' => $row['p34_kg'],
        'id_semester' => $row['id_semester'],
        'id_control' => $row['id_control'],
        'id_examination' => $row['id_examination'],
        'p51' => $row['p51'],
        'p52' => $row['p52'],
        'p53' => $row['p53'],
        'srs' => $row['srs'],
        'rzr' => $row['rzr'],
        'ind_z' => $row['ind_z'],
        'seminar' => $row['seminar'],
        'p54' => $row['p54'],
        'oper' => $row['oper'],
        'confirmation' => $row['confirmation'],
        'id_sillabus_t' => $row['id_sillabus_t'],
        'id_syllabus' => $row['id_syllabus'],
        'confirmation' => $row['confirmation'],
        'id_year' => $row['id_year'],
        'assistant' => $row['assistant'],
        'code' => $row['code'],
        'hour_week' => $row['hour_week'],
        'lecture' => $row['lecture'],
        'laboratory' => $row['laboratory'],
        'practice' => $row['practice'],
        'syllabus_seminar' => $row['syllabus_seminar'],
        'kredit_ECTS' => $row['kredit_ECTS'],
        'course_raiting' => $row['course_raiting'],
        'course_type' => $row['course_type'],
        'course_language' => $row['course_language'],
        'purpose' => $row['purpose'],
        'annotation' => $row['annotation'],
        'competence' => $row['competence'],
        'result_learning' => $row['result_learning'],
        'student_know' => $row['student_know'],
        'student_must' => $row['student_must'],
        'id_update' => $row['id_update'],
        'id_sillabus_t' => $row['id_sillabus_t'],
        'StudyTypeID' => $row['StudyTypeID'],
        'instrumentos' => $row['instrumentos']
    ];
}
if (count($discipline) > 0) {
    $_SESSION['AVN_Student']['discipline'] = $discipline;
    echo "<h1 class='text-center h1'>Дисциплины</h1><ul class='list-group'>";
    foreach ($discipline as $key => $value) {
        echo "<li class='list-group-item '> <div class='d-flex w-100 justify-content-between'> <h5 class='mb-1'><small class='text-muted'>Дисциплина: </small>" .
            $value['p34'] . ' ' . $value['confirmation'] .
            "</h5> " . $value['id_semester'] . "-семестр " . "</div><p class='mb-1'><small class='text-muted'>преподаватель: </small>" .
            $value['s_t_fio'] . "</p><ol class='list-group  d-flex flex-row w-100 justify-content-around'>";
        if ($value['confirmation'] === 1) echo "<button class=' btn btn-primary btn-lg  w-25 ' onclick=\"location.href = 'syllabus.php?id_educ_sh=" . $value['id_educ_sh'] . "'\">Силлабус</button>
            <button class=' btn btn-primary btn-lg   w-25 ' onclick=\"location.href = 'journal.php?id_educ_sh=" . $value['id_educ_sh'] . "'\">Журнал</button>";
        echo "</ol>";
    }
    echo "</ul>";
}
include_once '../footer.php';