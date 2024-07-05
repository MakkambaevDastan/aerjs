<?php
session_start();
if ($_SESSION['AVN_Student'] == false) {
    header('Location: ../index.php');
}
include_once '../header.php';
require_once '../vendor/connect.php';
$discipline = $_SESSION['AVN_Student']['discipline'][$_GET['id_educ_sh']];

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
}
$_SESSION['AVN_Student']['discipline'][$_GET['id_educ_sh']] = $discipline;
?>
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
    <input readonly required value="<?php echo $discipline['code']; ?>" class="form-control" type="text" name="code" onkeydown="return event.key != 'Enter';">
</div>
<div class="mb-3 input-group flex-nowrap">
    <div class="input-group-prepend">
        <span class="input-group-text">Часов в неделю</span>
    </div>
    <input readonly required value="<?php echo $discipline['hour_week']; ?>" class="form-control" type="number" name="hour_week" onkeydown="return event.key != 'Enter';">
</div>
<div class="mb-3 input-group flex-nowrap">
    <div class="input-group-prepend">
        <span class="input-group-text"> Кредит (ECTS)</span>
    </div>
    <input required value="<?php echo $discipline['kredit_ECTS']; ?>" class="form-control" type="number" name="kredit_ECTS" readonly onkeydown="return event.key != 'Enter';">
</div>
<div class="input-group mb-3">
    <label class="input-group-text" for="inputGroupSelect01">Уровень курса</label>
    <?php 
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
    ?>
</div>
<div class="input-group mb-3">
    <label class="input-group-text" for="inputGroupSelect02">Вид курса/Цикл курса</label>
    <?php 
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
      ?>
</div>
<div class="input-group mb-3">
    <label class="input-group-text" for="inputGroupSelect03">Язык курса</label>
    <?php 
        if ($discipline['course_language'] === '1') {
            echo "<input readonly required value='Кыргызча' class='form-control' name='course_language' onkeydown=\"return event.key != 'Enter';\">";
        } else if ($discipline['course_language'] === '2') {
            echo "<input readonly required value='Русский' class='form-control' name='course_language' onkeydown=\"return event.key != 'Enter';\">";
        } else if ($discipline['course_language'] === '3') {
            echo "<input readonly required value='English' class='form-control' name='course_language' onkeydown=\"return event.key != 'Enter';\">";
        }
?>
</div>
<div class="input-group mb-3 h-auto">
    <span class="input-group-text">Цель курса</span>
    <textarea readonly required class="form-control " aria-label="With textarea" name="purpose"><?php echo $discipline['purpose']; ?></textarea>
</div>
<div class="input-group mb-3">
    <span class="input-group-text">Краткое содержание курса</span>
    <textarea readonly required class="form-control" aria-label="With textarea" name="annotation"><?php echo $discipline['annotation']; ?></textarea>
</div>
<div class="input-group mb-3">
    <span class="input-group-text">Компетенция</span>
    <textarea readonly required class="form-control" aria-label="With textarea" name="competence"><?php echo $discipline['competence']; ?></textarea>
</div>
<div class="input-group mb-3">
    <span class="input-group-text">Результат обучения</span>
    <textarea readonly required class="form-control" aria-label="With textarea" name="result_learning"><?php echo $discipline['result_learning']; ?></textarea>
</div>
<div class="input-group mb-3">
    <span class="input-group-text">Студент должен знать:</span>
    <textarea readonly required class="form-control" aria-label="With textarea" name="student_know"><?php echo $discipline['student_know']; ?></textarea>
</div>
<div class="input-group mb-3">
    <span class="input-group-text">Студент должен уметь:</span>
    <textarea readonly required class="form-control" aria-label="With textarea" name="student_must"><?php echo $discipline['student_must']; ?></textarea>
</div>
<div class="input-group mb-3">
    <span class="input-group-text">Используемые инструменты:</span>
    <textarea readonly required class="form-control h-auto" aria-label="With textarea" name="instrumentos"><?php echo $discipline['instrumentos']; ?></textarea>
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
                                <input readonly required class='form-control' type='text' name='subject_table_1_name_" . $subject['subject_num'] . "' value='" . $subject['subject_name'] . "' onkeydown=\"return event.key != 'Enter';\">
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
                            <input readonly required class='form-control' type='text' name='subject_table_2_name_" . $subject['subject_num'] . "' value='" . $subject['subject_name'] . "' onkeydown=\"return event.key != 'Enter';\">
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
                            <input readonly required type='text' class='form-control' name='textbook_autor_$number' value='" . $textbook['textbook_autor'] . "' onkeydown=\"return event.key != 'Enter';\">
                        </td>
                        <td>
                            <input readonly required type='text' class='form-control' name='textbook_name_$number' value='" . $textbook['textbook_name']  . "' onkeydown=\"return event.key != 'Enter';\">
                        </td>
                        <td>
                            <input readonly required type='text' class='form-control' name='textbook_link_$number' value='" . $textbook['textbook_link'] . "' onkeydown=\"return event.key != 'Enter';\">
                        </td>
                    </tr>";
            }
        }
        ?>
    </tbody>
    <tfoot>
        <tr>
            <td colspan='4' class='p-3'>
                <div class='d-grid gap-2 col-2 mx-auto'>
                </div>
            </td>
        </tr>
    </tfoot>
</table>
<?php include_once '../footer.php'; ?>