<?php
session_start();
if ($_SESSION['AVN_User'] == false) header('Location: ../index.php');
if (!$_SESSION['AVN_User']['status']) header('Location: discipline.php');
require_once '../vendor/connect.php';
$sql = "UPDATE [aerjs].[dbo].[syllabus_head] SET [confirmation]=" . $_GET['c'] . " WHERE [id_sillabus_t]=" . $_GET['id_sillabus_t'];
$update = sqlsrv_query($connect_local, $sql);
if ($update == false) $_SESSION['message'] = "Ощибка";
else $_SESSION['message'] = 'Успешно';
header("location: teacher.php");
