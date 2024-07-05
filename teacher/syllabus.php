<?php
session_start();
if ($_SESSION['AVN_User'] == false) {
    header('Location: ../facultet.php');
}
include_once '../header.php';
require_once '../vendor/connect.php';
if ($_SESSION['AVN_User']['status']) {
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
FROM (SELECT DISTINCT [id_a_year],
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
    WHERE ([avn].dbo.V_Raspisanie_new.id_a_year = $rate_year)
) AS [discipline]
INNER JOIN [avn].[dbo].[educ_sh] ON [discipline].[id_speciality] = [avn].[dbo].[educ_sh].[id_speciality]
AND [discipline].[id_discipline] = [avn].[dbo].[educ_sh].[id_discipline]
AND [discipline].[id_kafedra] = [avn].[dbo].[educ_sh].[id_kafedra]
AND [discipline].[id_a_year] = [avn].[dbo].[educ_sh].[id_a_year]
LEFT JOIN [aerjs].[dbo].[syllabus_head] ON [aerjs].[dbo].[syllabus_head].[id_educ_sh] = [avn].[dbo].[educ_sh].[id_educ_sh]
INNER JOIN [avn].[dbo].[a_year] ON [a_year].[id_a_year]=[educ_sh].[id_a_year]
WHERE [avn].[dbo].[educ_sh].[id_educ_sh] = " . $_GET['id_educ_sh'] . "
ORDER BY [avn].[dbo].[educ_sh].[id_educ_sh]";
    $select = sqlsrv_query($connect, $sql);
    while ($row = sqlsrv_fetch_array($select)) {
        $discipline = [
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
} else {
    $discipline = $_SESSION['AVN_User']['discipline'][$_GET['id_educ_sh']];
}
if ((int)$discipline['p51'] !== 0) {
    $lecture = (int)$discipline['p51'];
    $lecture_name = 'Лекции';
    $lecture_type = 1;
}
if ((int)$discipline['p52'] !== 0) {
    $lecture2 = (int)$discipline['p52'];
    $lecture2_name = 'Лабораторные';
    $lecture2_type = 2;
} else if ((int)$discipline['p53'] !== 0) {
    $lecture2 = (int)$discipline['p53'];
    $lecture2_name = 'Практические';
    $lecture2_type = 3;
} else if ((int)$discipline['seminar'] !== 0) {
    $lecture2 = (int)$discipline['seminar'];
    $lecture2_name = 'Семинары';
    $lecture2_type = 4;
}
for ($i = 1; $i <= $lecture; $i++) {
    $discipline['subject'][$lecture_type][$i] =
        [
            'id_subject' => '',
            'id_syllabus' => '',
            'subject_type' => $lecture_type,
            'subject_hour' => 1,
            'subject_name' => '',
            'id_sillabus_t' => '',
            'subject_num' => $i,
        ];
}
for ($i = 1; $i <= $lecture2; $i++) {
    $discipline['subject'][$lecture2_type][$i] =
        [
            'id_subject' => '',
            'id_syllabus' => '',
            'subject_type' => $lecture2_type,
            'subject_hour' => 1,
            'subject_name' => '',
            'id_sillabus_t' => '',
            'subject_num' => $i,
        ];
}
if ($discipline['id_sillabus_t']) {
    $sql_syllabus_subject2 =
        "SELECT TOP (100)
                [id_subject]
                ,[id_syllabus]
                ,[subject_type]
                ,[subject_hour]
                ,[subject_name]
                ,[id_sillabus_t]
                ,[subject_num]
            FROM [dbo].[syllabus_subject]
            where [id_sillabus_t] = " . $discipline['id_sillabus_t'] . " 
            ORDER BY subject_num";
    $select_syllabus_subject = sqlsrv_query($connect_local, $sql_syllabus_subject2);
    while ($row = sqlsrv_fetch_array($select_syllabus_subject)) {
        $discipline['subject'][$row['subject_type']][$row['subject_num']] =
            [
                'id_subject' => $row['id_subject'],
                'id_syllabus' => $row['id_syllabus'],
                'subject_type' => $row['subject_type'],
                'subject_hour' => $row['subject_hour'],
                'subject_name' => $row['subject_name'],
                'id_sillabus_t' => $row['id_sillabus_t'],
                'subject_num' => $row['subject_num']
            ];
    }
    $sql_syllabus_book =
        "SELECT TOP (1000) [id_syllabus]
            ,[id_textbook]
            ,[textbook_autor]
            ,[textbook_name]
            ,[textbook_link]
            ,[id_sillabus_t]
            ,[textbook_num]
        FROM [dbo].[syllabus_textbook]
        where [id_sillabus_t] = " . $discipline['id_sillabus_t'];
    $select_syllabus_book = sqlsrv_query($connect_local, $sql_syllabus_book);
    while ($row = sqlsrv_fetch_array($select_syllabus_book)) {
        $discipline['textbook'][$row['textbook_num']] = [
            'id_textbook' => $row['id_textbook'],
            'textbook_autor' => $row['textbook_autor'],
            'textbook_name' => $row['textbook_name'],
            'textbook_link' => $row['textbook_link'],
            'textbook_num' => $row['textbook_num']
        ];
    }
    if ($discipline['confirmation'] == 1) {
        $readonly = "readonly";
    }
}
if (!$discipline['id_sillabus_t']) { ?>
    <form id='Form' action='syllabus_insert.php' method='post'>
        <input type='hidden' name='id_educ_sh' value="<?php echo $discipline['id_educ_sh']; ?>">
        <input type='hidden' name='id_speciality' value="<?php echo $discipline['id_speciality']; ?>">
        <input type='hidden' name='id_discipline' value="<?php echo $discipline['id_discipline']; ?>">
        <input type='hidden' name='id_teacher' value="<?php echo $_SESSION['AVN_User']['id_teacher']; ?>">
        <input type='hidden' name='id_year' value="<?php echo $discipline['id_a_year']; ?>">
        <input type="hidden" name="id_kafedra" value="<?php echo $discipline['id_kafedra']; ?>" />
        <input type="hidden" name="id_faculty" value="<?php echo $_SESSION['AVN_User']['id_faculty']; ?>" />
        <input type="hidden" name="id_semester" value="<?php echo $discipline['id_semester']; ?>" />
        <input type="hidden" name="lecture" value="<?php echo $discipline['p51']; ?>" />
        <input type="hidden" name="lecture2" value="<?php echo $lecture2; ?>" />
    <?php } else if (!$readonly) { ?>
        <form id='Form' action='syllabus_update.php' method='post'>
            <input type="hidden" name="subject_type_get" value="<?php echo $lecture2_type; ?>" />
            <input type="hidden" name="id_syllabus_t" value="<?php echo $discipline['id_sillabus_t']; ?>" />
        <?php } ?>
        <div class="h1 text-center">
            <h1 class="h1 text-center">Силлабус</h1>
        </div>
        <div class="mb-3 input-group flex-nowrap">
            <div class="input-group-prepend">
                <span class="input-group-text">Дисциплина</span>
            </div>
            <input required value="<?php echo $discipline['p34']; ?>" class="form-control" type="text" readonly onkeydown="return event.key != 'Enter';">
        </div>
        <div class="mb-3 input-group flex-nowrap">
            <div class="input-group-prepend">
                <span class="input-group-text">Специальность</span>
            </div>
            <input required value="<?php echo $discipline['spec']; ?>" class="form-control" type="text" readonly onkeydown="return event.key != 'Enter';">
        </div>
        <div class="mb-3 input-group flex-nowrap">
            <div class="input-group-prepend">
                <span class="input-group-text">Учебный год</span>
            </div>
            <input required value="<?php echo $discipline['p32']; ?>" class="form-control" type="text" readonly onkeydown="return event.key != 'Enter';">
        </div>
        <div class="mb-3 input-group flex-nowrap">
            <div class="input-group-prepend">
                <span class="input-group-text">Семестр</span>
            </div>
            <input required value="<?php echo $discipline['id_semester']; ?>" class="form-control" type="text" readonly onkeydown="return event.key != 'Enter';">
        </div>
        <div class="mb-3 input-group flex-nowrap">
            <div class="input-group-prepend">
                <span class="input-group-text">Код курса:</span>
            </div>
            <input <?php echo $readonly; ?> required value="<?php echo $discipline['code']; ?>" class="form-control" type="text" name="code" onkeydown="return event.key != 'Enter';">
        </div>
        <div class="mb-3 input-group flex-nowrap">
            <div class="input-group-prepend">
                <span class="input-group-text">Часов в неделю</span>
            </div>
            <input <?php echo $readonly; ?> required value="<?php echo $discipline['hour_week']; ?>" class="form-control" type="number" name="hour_week" onkeydown="return event.key != 'Enter';">
        </div>
        <div class="mb-3 input-group flex-nowrap">
            <div class="input-group-prepend">
                <span class="input-group-text"> Кредит (ECTS)</span>
            </div>
            <input required value="<?php echo $discipline['kredit_ECTS']; ?>" class="form-control" type="number" name="kredit_ECTS" readonly onkeydown="return event.key != 'Enter';">
        </div>
        <div class="input-group mb-3">
            <label class="input-group-text" for="inputGroupSelect01">Уровень курса</label>
            <?php if ($readonly) {
                if ($discipline['course_raiting'] === '1') {
                    echo "<input readonly required value='СПО' class='form-control' name='course_raiting' onkeydown=\"return event.key != 'Enter';\">";
                } else if ($discipline['course_raiting'] === '2') {
                    echo "<input readonly required value='Бакалавр' class='form-control' name='course_raiting' onkeydown=\"return event.key != 'Enter';\">";
                } else if ($discipline['course_raiting'] === '3') {
                    echo "<input readonly required value='Специалитет' class='form-control' name='course_raiting' onkeydown=\"return event.key != 'Enter';\">";
                } else if ($discipline['course_raiting'] === '4') {
                    echo "<input readonly required value='Магистратура' class='form-control' name='course_raiting' onkeydown=\"return event.key != 'Enter';\">";
                } else if ($discipline['course_raiting'] === '5') {
                    echo "<input readonly required value='Аспирантура' class='form-control' name='course_raiting' onkeydown=\"return event.key != 'Enter';\">";
                } else if ($discipline['course_raiting'] === '6') {
                    echo "<input readonly required value='PhD' class='form-control' name='course_raiting' onkeydown=\"return event.key != 'Enter';\">";
                }
            } else { ?>
                <select required class="form-select" id="inputGroupSelect01" name="course_raiting">
                    <option name="course_raiting" value="0" <?php if ($discipline['course_raiting'] === '0') {
                                                                echo "selected='selected'";
                                                            } ?>> </option>
                    <option name="course_raiting" value="1" <?php if ($discipline['course_raiting'] === '1') {
                                                                echo "selected='selected'";
                                                            } ?>>СПО</option>
                    <option name="course_raiting" value="2" <?php if ($discipline['course_raiting'] === '2') {
                                                                echo "selected='selected'";
                                                            } ?>>Бакалавр</option>
                    <option name="course_raiting" value="3" <?php if ($discipline['course_raiting'] === '3') {
                                                                echo "selected='selected'";
                                                            } ?>>Специалитет</option>
                    <option name="course_raiting" value="4" <?php if ($discipline['course_raiting'] === '4') {
                                                                echo "selected='selected'";
                                                            } ?>>Магистратура</option>
                    <option name="course_raiting" value="5" <?php if ($discipline['course_raiting'] === '5') {
                                                                echo "selected='selected'";
                                                            } ?>>Аспирантура</option>
                    <option name="course_raiting" value="6" <?php if ($discipline['course_raiting'] === '6') {
                                                                echo "selected='selected'";
                                                            } ?>>PhD</option>
                </select>
            <?php } ?>
        </div>
        <div class="input-group mb-3">
            <label class="input-group-text" for="inputGroupSelect02">Вид курса/Цикл курса</label>
            <?php if ($readonly) {
                if ($discipline['course_type'] === '1') {
                    echo "<input readonly required value='ГСЭ ГК' class='form-control' name='course_type' onkeydown=\"return event.key != 'Enter';\">";
                } else if ($discipline['course_type'] === '2') {
                    echo "<input readonly required value='ГСЭ ВК' class='form-control' name='course_type' onkeydown=\"return event.key != 'Enter';\">";
                } else if ($discipline['course_type'] === '3') {
                    echo "<input readonly required value='ГСЭ КПВ' class='form-control' name='course_type' onkeydown=\"return event.key != 'Enter';\">";
                } else if ($discipline['course_type'] === '4') {
                    echo "<input readonly required value='МЕН ГК' class='form-control' name='course_type' onkeydown=\"return event.key != 'Enter';\">";
                } else if ($discipline['course_type'] === '5') {
                    echo "<input readonly required value='МЕН ВК' class='form-control' name='course_type' onkeydown=\"return event.key != 'Enter';\">";
                } else if ($discipline['course_type'] === '6') {
                    echo "<input readonly required value='МЕН КПВ' class='form-control' name='course_type' onkeydown=\"return event.key != 'Enter';\">";
                } else if ($discipline['course_type'] === '7') {
                    echo "<input readonly required value='ПЦ ГК' class='form-control' name='course_type' onkeydown=\"return event.key != 'Enter';\">";
                } else if ($discipline['course_type'] === '8') {
                    echo "<input readonly required value='ПЦ ВК' class='form-control' name='course_type' onkeydown=\"return event.key != 'Enter';\">";
                } else if ($discipline['course_type'] === '9') {
                    echo "<input readonly required value='ПЦ КПВ' class='form-control' name='course_type' onkeydown=\"return event.key != 'Enter';\">";
                }
            } else { ?>
                <select required class="form-select" id="inputGroupSelect02" name="course_type">
                    <option name="course_type" value="0" <?php if ($discipline['course_type'] === '0') {
                                                                echo "selected='selected'";
                                                            } ?>> </option>
                    <option name="course_type" value="1" <?php if ($discipline['course_type'] === '1') {
                                                                echo "selected='selected'";
                                                            } ?>>ГСЭ ГК</option>
                    <option name="course_type" value="2" <?php if ($discipline['course_type'] === '2') {
                                                                echo "selected='selected'";
                                                            } ?>>ГСЭ ВК</option>
                    <option name="course_type" value="3" <?php if ($discipline['course_type'] === '3') {
                                                                echo "selected='selected'";
                                                            } ?>>ГСЭ КПВ</option>
                    <option name="course_type" value="4" <?php if ($discipline['course_type'] === '4') {
                                                                echo "selected='selected'";
                                                            } ?>>МЕН ГК</option>
                    <option name="course_type" value="5" <?php if ($discipline['course_type'] === '5') {
                                                                echo "selected='selected'";
                                                            } ?>>МЕН ВК</option>
                    <option name="course_type" value="6" <?php if ($discipline['course_type'] === '6') {
                                                                echo "selected='selected'";
                                                            } ?>>МЕН КПВ</option>
                    <option name="course_type" value="7" <?php if ($discipline['course_type'] === '7') {
                                                                echo "selected='selected'";
                                                            } ?>>ПЦ ГК</option>
                    <option name="course_type" value="8" <?php if ($discipline['course_type'] === '8') {
                                                                echo "selected='selected'";
                                                            } ?>>ПЦ ВК</option>
                    <option name="course_type" value="9" <?php if ($discipline['course_type'] === '9') {
                                                                echo "selected='selected'";
                                                            } ?>>ПЦ КПВ</option>
                </select>
            <?php } ?>
        </div>
        <div class="input-group mb-3">
            <label class="input-group-text" for="inputGroupSelect03">Язык курса</label>
            <?php if ($readonly) {
                if ($discipline['course_language'] === '1') {
                    echo "<input readonly required value='Кыргызча' class='form-control' name='course_language' onkeydown=\"return event.key != 'Enter';\">";
                } else if ($discipline['course_language'] === '2') {
                    echo "<input readonly required value='Русский' class='form-control' name='course_language' onkeydown=\"return event.key != 'Enter';\">";
                } else if ($discipline['course_language'] === '3') {
                    echo "<input readonly required value='English' class='form-control' name='course_language' onkeydown=\"return event.key != 'Enter';\">";
                }
            } else { ?>
                <select required class="form-select" id="inputGroupSelect03" name="course_language" onkeydown="return event.key != 'Enter';">
                    <option name="course_language" value="0" <?php if ($discipline['course_language'] === '0') {
                                                                    echo "selected='selected'";
                                                                } ?>></option>
                    <option name="course_language" value="1" <?php if ($discipline['course_language'] === '1') {
                                                                    echo "selected='selected'";
                                                                } ?>>Кыргызча</option>
                    <option name="course_language" value="2" <?php if ($discipline['course_language'] === '2') {
                                                                    echo "selected='selected'";
                                                                } ?>>Русский</option>
                    <option name="course_language" value="3" <?php if ($discipline['course_language'] === '3') {
                                                                    echo "selected='selected'";
                                                                } ?>>English</option>
                </select>
            <?php } ?>
        </div>
        <div class="input-group mb-3">
            <span class="input-group-text">Цель курса</span>
            <textarea <?php echo $readonly; ?> required class="form-control" aria-label="With textarea" name="purpose"><?php echo $discipline['purpose']; ?></textarea>
        </div>
        <div class="input-group mb-3">
            <span class="input-group-text">Краткое содержание курса</span>
            <textarea <?php echo $readonly; ?> required class="form-control" aria-label="With textarea" name="annotation"><?php echo $discipline['annotation']; ?></textarea>
        </div>
        <div class="input-group mb-3">
            <span class="input-group-text">Компетенция</span>
            <textarea <?php echo $readonly; ?> required class="form-control" aria-label="With textarea" name="competence"><?php echo $discipline['competence']; ?></textarea>
        </div>
        <div class="input-group mb-3">
            <span class="input-group-text">Результат обучения</span>
            <textarea <?php echo $readonly; ?> required class="form-control" aria-label="With textarea" name="result_learning"><?php echo $discipline['result_learning']; ?></textarea>
        </div>
        <div class="input-group mb-3">
            <span class="input-group-text">Студент должен знать:</span>
            <textarea <?php echo $readonly; ?> required class="form-control" aria-label="With textarea" name="student_know"><?php echo $discipline['student_know']; ?></textarea>
        </div>
        <div class="input-group mb-3">
            <span class="input-group-text">Студент должен уметь:</span>
            <textarea <?php echo $readonly; ?> required class="form-control" aria-label="With textarea" name="student_must"><?php echo $discipline['student_must']; ?></textarea>
        </div>
        <div class="input-group mb-3">
            <span class="input-group-text">Используемые инструменты:</span>
            <textarea rows="5" <?php echo $readonly; ?> required class="form-control" aria-label="With textarea" name="instrumentos"><?php echo $discipline['instrumentos']; ?></textarea>
        </div>
        <table id="subject_table_1" class="table m-1 p-1">
            <thead>
                <tr>
                    <th></th>
                    <th style='width: 98%;' colspan='2' class="text-center h2">
                        <?php echo " " . $lecture_name . " " . count($discipline['subject'][$lecture_type]) . "-часов"; ?>
                    </th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($discipline['subject'][$lecture_type]) {
                    foreach ($discipline['subject'][$lecture_type] as $type => $subject) {
                        echo "<tr>
                            <th scope='row'>
                                <input type='hidden' name='subject_table_1_num_" . $subject['subject_num'] . "' value='" . $subject['subject_num'] . "'>
                                <input name='subject_type_1' value='" . $subject['subject_type'] . "' hidden>
                                " . $subject['subject_num'] . "
                            </th>
                            <td >
                                <input $readonly required class='form-control' type='text' name='subject_table_1_name_" . $subject['subject_num'] . "' value='" . $subject['subject_name'] . "' onkeydown=\"return event.key != 'Enter';\">
                            </td>
                        </tr>";
                    }
                }
                ?>
            </tbody>
        </table>
        <table id='subject_table_2' class='table m-1 p-1'>
            <thead>
                <tr>
                    <th></th>
                    <th style='width: 98%;' colspan='2' class='text-center h2'>
                        <?php echo " " . $lecture2_name . " " . count($discipline['subject'][$lecture2_type]) . "-часов"; ?>
                    </th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($discipline['subject'][$lecture2_type]) {
                    foreach ($discipline['subject'][$lecture2_type] as $type => $subject) {

                        echo "<tr>
                        <th scope='row'>
                            <input type='hidden' name='subject_table_2_num_" . $subject['subject_num'] . "' value='" . $subject['subject_num'] . "'>
                            <input name='subject_type_2' value='" . $subject['subject_type'] . "' hidden>
                            " . $subject['subject_num'] . "
                        </th>
                        <td style='width: 98%;'>
                            <input $readonly required class='form-control' type='text' name='subject_table_2_name_" . $subject['subject_num'] . "' value='" . $subject['subject_name'] . "' onkeydown=\"return event.key != 'Enter';\">
                        </td>
                    </tr>";
                    }
                }
                ?>
            </tbody>
        </table>
        <table id='textbook' class='table m-1 p-1 '>
            <thead>
                <tr>
                    <th colspan='4' class='text-center h2'>Литература</th>
                </tr>
                <tr>
                    <th style='width: 2%;'></th>
                    <th style='width: 20%;'>Автор</th>
                    <th style='width: 46%;'>Учебник</th>
                    <th style='width: 32%;'>Ссылка</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($discipline['textbook']) {
                    foreach ($discipline['textbook'] as $number => $textbook) {
                        echo "<tr>
                        <th scope='row'>
                            <input type='hidden' name='textbook_num_$number' value='$number'>
                            $number
                        </th>
                        <td>
                            <input $readonly required type='text' class='form-control' name='textbook_autor_$number' value='" . $textbook['textbook_autor'] . "' onkeydown=\"return event.key != 'Enter';\">
                        </td>
                        <td>
                            <input $readonly required type='text' class='form-control' name='textbook_name_$number' value='" . $textbook['textbook_name']  . "' onkeydown=\"return event.key != 'Enter';\">
                        </td>
                        <td>
                            <input $readonly required type='text' class='form-control' name='textbook_link_$number' value='" . $textbook['textbook_link'] . "' onkeydown=\"return event.key != 'Enter';\">
                        </td>
                    </tr>";
                    }
                }
                $number++;
                ?>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan='4' class='p-3'>
                        <div class='d-grid gap-2 col-2 mx-auto'>
                            <?php if (!$readonly) { ?>
                                <input onclick="add_textbook('textbook')" class='btn btn-primary' type='button' value='Добавить учебник'>
                            <?php } ?>
                        </div>
                    </td>
                </tr>
            </tfoot>
        </table>
        <div class='d-grid gap-3 col-4 mx-auto p-3'>
            <?php if (!$readonly) { ?>
                <input class='btn btn-primary' type='submit' value='Сохранить силлабус'>
            <?php } ?>
        </div>
        <?php if (!$readonly and !$discipline['id_sillabus_t']) {
            echo "</form>";
        } ?>
        <div class='d-grid gap-3 col-6 mx-auto p-3'>
            <?php
            if ($discipline['confirmation'] === 0 and $_SESSION['AVN_User']['status']) {
                echo "<a class='btn btn-primary btn-lg' href='syllabus_confirmation.php?c=1&id_sillabus_t=".$discipline['id_sillabus_t']."' role='button'>Подтвердить силлабус</a>";
            } else if ($discipline['confirmation'] == 1 and $_SESSION['AVN_User']['status']) {
                echo "<a class='btn btn-primary btn-lg' href='syllabus_confirmation.php?c=0&id_sillabus_t=".$discipline['id_sillabus_t']."' role='button'>Отменить подтверждение</a>";
            }
            ?>
        </div>
        <script>
            <?php echo 'var number_book=' . $number . '; '; ?>
            function add_textbook(id) {

                var input_book_0 = document.createElement('INPUT');
                input_book_0.type = 'hidden';
                input_book_0.name = ("name", "textbook_num_" + number_book);
                input_book_0.value = ("value", number_book);
                input_book_0.setAttribute("onkeydown", "return event.key != 'Enter';");

                var input_book_1 = document.createElement('INPUT');
                input_book_1.type = 'text';
                input_book_1.name = ("name", "textbook_autor_" + number_book);
                input_book_1.setAttribute("class", "form-control");
                input_book_1.setAttribute("onkeydown", "return event.key != 'Enter';");

                var input_book_2 = document.createElement('INPUT');
                input_book_2.type = 'text';
                input_book_2.name = ("name", "textbook_name_" + number_book);
                input_book_2.setAttribute("class", "form-control");
                input_book_2.setAttribute("onkeydown", "return event.key != 'Enter';");

                var input_book_3 = document.createElement('INPUT');
                input_book_3.type = 'text';
                input_book_3.name = ("name", "textbook_link_" + number_book);
                input_book_3.setAttribute("class", "form-control");
                input_book_3.setAttribute("onkeydown", "return event.key != 'Enter';");

                var tbody_book = document.getElementById(id).getElementsByTagName("TBODY")[0];
                var tr_book = document.createElement("TR");

                var td_book_1 = document.createElement("TH");
                td_book_1.setAttribute("scope", "row");
                td_book_1.appendChild(document.createTextNode(number_book));
                td_book_1.appendChild(input_book_0);

                var td_book_2 = document.createElement("TD");
                td_book_2.appendChild(input_book_1);

                var td_book_3 = document.createElement("TD");
                td_book_3.appendChild(input_book_2);

                var td_book_4 = document.createElement("TD");
                td_book_4.appendChild(input_book_3);

                tr_book.appendChild(td_book_1);
                tr_book.appendChild(td_book_2);
                tr_book.appendChild(td_book_3);
                tr_book.appendChild(td_book_4);
                tbody_book.appendChild(tr_book);
                number_book++;
            }
        </script>
        <?php include_once '../footer.php'; ?>