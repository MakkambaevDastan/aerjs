<?php
session_start();
require_once 'connect.php';
$login = $_POST['username'];
$password = md5($_POST['password']);
$student = $_POST['student'];
if ($login != null and $password != null) {
    if ($student == 'on') {
        $sql_student = "SELECT
    [dbo].[Student].id_Student,
    [dbo].[movement_t].[id_group],
    [dbo].[movement_t].id_semester,
    [dbo].[movement_t].id_rate,
    [dbo].[Student].p1,
    [dbo].[Student].p2,
    [dbo].[Student].p3,
    [dbo].[Student].[login]
    FROM [dbo].[movement_t]
    LEFT JOIN [dbo].[Student] ON [student].[id_student]=[movement_t].[id_student]
    WHERE [dbo].[Student].[login] = ?
    --and [dbo].[Student].[password] = ?
    and [movement_t].isStudying <> 0
    ORDER BY [Student].id_student";
        $params_student = array($login, $password);
        $options_student = array("Scrollable" => SQLSRV_CURSOR_KEYSET);
        $check_student = sqlsrv_query($connect, $sql_student, $params_student, $options_student);
        if (sqlsrv_num_rows($check_student) > 0) {
            while ($user = sqlsrv_fetch_array($check_student)) {
                $id_Student = $user['id_Student'];
                $_SESSION['AVN_Student'] = [
                    "id_student" => $user['id_Student'],
                    "id_group" => $user['id_group'],
                    "id_semester" => $user['id_semester'],
                    "id_rate" => $user['id_rate'],
                    "p1" => $user['p1'],
                    "p2" => $user['p2'],
                    "p3" => $user['p3']
                ];
                $_SESSION['USER']['surname'] = $user['p1'];
                $_SESSION['USER']['name'] = $user['p2'];
                $_SESSION['USER']['patronymic'] = $user['p3'];
            }
            header("Location: ../student/discipline.php");
            exit();
        } else {
            $_SESSION['message'] = 'Не верный логин или пароль';
            header('Location: ../index.php');
            exit();
        }
    } else {
        $sql = "SELECT
                [dbo].[Vakansii].[id_faculty],
                dbo.faculty.[p23-2],
                dbo.Vakansii.id_vakansiya,
                dbo.Vakansii.id_a_year,
                dbo.Vakansii.id_otdel_1,
                dbo.Vakansii.id_otdel_11,
                dbo.Vakansii.id_otdel_2,
                dbo.Vakansii.id_kafedra,
                dbo.Vakansii.id_structure,
                dbo.Vakansii.id_bk,
                dbo.post.id_post,
                dbo.post.post,
                dbo.Working.id_teacher,
                dbo.Photo.photo,
                dbo.AVN_User.AVN_login,
                dbo.AVN_User.id_AVN_user,
                dbo.AVN_User.name,
                dbo.AVN_User.surname,
                dbo.AVN_User.patronymic,
                dbo.AVN_User.doljnost
            FROM
                dbo.Vakansii
                INNER JOIN dbo.post ON dbo.Vakansii.id_post = dbo.post.id_post
                INNER JOIN dbo.Working ON dbo.Vakansii.id_vakansiya = dbo.Working.id_vakansiya
                INNER JOIN dbo.teacher ON dbo.Working.id_teacher = dbo.teacher.id_teacher
                INNER JOIN dbo.AVNTeacher ON dbo.teacher.id_teacher = dbo.AVNTeacher.id_teacher
                INNER JOIN dbo.AVN_User ON dbo.AVNTeacher.id_avn_login = dbo.AVN_User.id_AVN_user
                LEFT OUTER JOIN dbo.Photo ON dbo.teacher.id_teacher = dbo.Photo.id_teacher
                LEFT OUTER JOIN dbo.faculty ON dbo.Vakansii.id_faculty = dbo.faculty.id_faculty
            WHERE        (dbo.Working.id_leave = 4) AND (dbo.AVN_User.AVN_login = ?) 
            --AND (dbo.AVN_User.AVN_password = ?)
            ORDER BY id_faculty";
        $params = array($login, $password);
        $options = array("Scrollable" => SQLSRV_CURSOR_KEYSET);
        $check_user = sqlsrv_query($connect, $sql, $params, $options);
        if (sqlsrv_num_rows($check_user) > 0) {
            while ($user = sqlsrv_fetch_array($check_user)) {
                $id_post_arr[] = $user['id_post'];
                $id_faculty[] = $user['id_faculty'];
                $id_kafedra[] = $user['id_kafedra'];
                $_SESSION['AVN_User'] = [
                    "id_AVN_user" => $user['id_AVN_user'],
                    "id_teacher" => $user['id_teacher'],
                    "AVN_login" => $user['AVN_login'],
                    "name" => $user['name'],
                    "surname" => $user['surname'],
                    "patronymic" => $user['patronymic'],
                    "doljnost" => $user['doljnost'],
                    "id_post" => $user['id_post'],
                    "post" => $user['post'],
                    "id_faculty" => $user['id_faculty'],
                    "id_kafedra" => $user['id_kafedra'],
                    "id_otdel_1" => $user['id_otdel_1'],
                    "id_otdel_11" => $user['id_otdel_11'],
                    "id_otdel_2" => $user['id_otdel_2'],
                    "id_structure" => $user['id_structure']
                ];
                $_SESSION['USER']['surname'] = $user['surname'];
                $_SESSION['USER']['name'] = $user['name'];
                $_SESSION['USER']['patronymic'] = $user['patronymic'];
                $id_post = (int)$user['id_post'];
                $id_post_metodist_array = [29, 764, 765, 155, 250, 276, 38, 198, 450, 815, 328, 325, 252, 122, 429, 762];
                if (in_array($id_post, $id_post_metodist_array)) {
                    $_SESSION['AVN_User']['metodist'] = 1;
                }
                $id_otdel_1 = (int)$user['id_otdel_1'];
                $id_otdel_1_array = [1, 71, 124, 251, 252, 68];
                $id_post_rector_array = [1, 308, 450, 30, 271, 117, 38, 796, 250, 798, 429];
                if (in_array($id_otdel_1, $id_otdel_1_array) && in_array($id_post, $id_post_rector_array)) {
                    $_SESSION['AVN_User']['rector'] = 1;
                }
                $id_post_arr_status = [198, 258, 233, 259, 328, 349, 399, 414, 757, 779, 786, 815];
                for ($i = 0; $i < count($id_post_arr); $i++) {
                    if (in_array((int)$id_post_arr[$i], $id_post_arr_status)) {
                        $_SESSION['AVN_User']['status'] = 1;
                        for ($j = 0; $j < count($id_faculty); $j++) {
                            if ($id_faculty[$i] == $id_faculty[$j] and $id_kafedra[$j] != 0) {
                                $_SESSION['AVN_User']['id_faculty'] = $id_faculty[$j];
                                $_SESSION['AVN_User']['id_kafedra'] = $id_kafedra[$j];
                                break;
                            }
                        }
                    }
                }
            }
            header("Location: ../teacher/discipline.php");
            exit();
        } else {
            $_SESSION['message'] = 'Не верный логин или пароль';
            header('Location: ../index.php');
            exit();
        }
    }
    $_SESSION['message'] = 'Студент?';
    header('Location: ../index.php');
    exit();
} else {
    $_SESSION['message'] = 'Введите логин и пароль';
    header('Location: ../index.php');
    exit();
}