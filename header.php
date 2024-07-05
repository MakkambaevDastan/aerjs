<?php
session_start();
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../assets/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <link href="assets/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <link href="../assets/css/style.css" rel="stylesheet" type="text/css">
    <link href="assets/css/style.css" rel="stylesheet" type="text/css">
</head>
<body class="bg-gradient">
    <nav class="navbar navbar-light bg-light shadow rounded py-2 mb-3">
        <div class="container-fluid">
            <ul class="nav">
                <li class="nav-item">
                    <div id='doc_time' class="nav-link px-2 text-muted"></div>
                </li>
            </ul>
            <ul class="nav ">
                <?php if ($_SESSION['AVN_User']['id_teacher']) { ?>
                    <li class="nav-item"><a class="nav-link navbar-brand" href="index.php">Расписание</a></li>
                    <li class="nav-item"><a class="nav-link navbar-brand" href="journal.php">Журнал</a></li>
                    <li class="nav-item"><a class="nav-link navbar-brand" href="discipline.php">Силлабус</a></li>
                    <?php if ($_SESSION['AVN_User']['status']){?>
                    <li class="nav-item"><a class="nav-link navbar-brand" href="teacher.php">Преподаватели</a></li>
                        <?php }?>
                <?php } else if ($_SESSION['AVN_Student']['id_student']) { ?>

                    <li class="nav-item"><a class="nav-link navbar-brand" href="index.php">Расписание</a></li>
                    <li class="nav-item"><a class="nav-link navbar-brand" href="discipline.php">Силлабус-Журнал</a></li>
                <?php } else { ?>
                    <li class='nav-item'><a class='nav-link navbar-brand' href='index.php'>Главная</a></li>
                <?php  } ?>
            </ul>
            <ul class="nav">
                <?php if ($_SESSION['USER']['surname']) { ?>
                    <form action='../vendor/update.php' method='post' accept-charset='UTF-8'>
                        <button class="btn btn-primary border" type="submit">Обновить</button>
                    </form>
                    <form action='../vendor/logout.php' method='post' accept-charset='UTF-8'>
                        <button class="btn btn-primary border" type="submit">Выход</button>
                    </form>
                <?php } else { ?>
                    <form action='./vendor/auth.php' method='post' accept-charset='UTF-8'>
                        <input type="login" name='username' placeholder="Логин">
                        <input type="password" name='password' placeholder="Пароль">
                        <label for="student">
                            <input type="checkbox" name="student" id="student" /> Я студент</label>
                        <button class="btn btn-primary border" type="submit">Вход</button>
                        <label style="color: #ff0600" class="invalid-feedback">
                            <div>
                                <?php if ($_SESSION['message']) {
                                    echo $_SESSION['message'];
                                    unset($_SESSION['message']);
                                }
                                ?>
                            </div>
                        </label>
                    </form>
                <?php } ?>
            </ul>
        </div>
    </nav>
    <div class="container bg-light bg-gradient shadow-lg rounded">