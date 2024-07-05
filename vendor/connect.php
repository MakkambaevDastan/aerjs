<?php
// ===================connect_db_aerjs
$dbServer_local = "localhost";
$dbName_local = "aerjs";
$dbUser_local = "";
$dbPassword_local = "";
$connectionInfo_local = array(
    "Database" => $dbName_local,
    "UID" => $dbUser_local,
    "PWD" => $dbPassword_local,
    "CharacterSet" => "UTF-8"
);
$connect_local = sqlsrv_connect($dbServer_local, $connectionInfo_local);
// =================================


// ===================connect_db_avn
$dbServer = "localhost";
$dbName = "avn";
$dbUser = "";
$dbPassword = "";
$connectionInfo = array(
    "Database" => $dbName,
    "UID" => $dbUser,
    "PWD" => $dbPassword,
    "CharacterSet" => "UTF-8"
);
$connect = sqlsrv_connect($dbServer, $connectionInfo);
// =================================

// ======================set_DateTime
$date = new DateTime();
$date->setTimezone(new DateTimeZone('Asia/Bishkek'));

// $date->setDate(2020, 3, 12);
$date->setDate(2020, 9, 9);
$date->setTime(12, 21);

// $date->setDate(2020, 9, 23);
// $date->setTime(12, 21);

if ($date->format('n') <= 8) {
    $rate_year = $date->format('y') - 1;
    $rate_year_full = date('Y') - 1 . ' - ' . date('Y');
    $w_s = 1;
} else {
    $rate_year = $date->format('y');
    $rate_year_full = date('Y') . ' - ' . date('Y') + 1;
    $w_s = 2;
}

$day_of_week = (int)$date->format('w');
$day_of_month = (int)$date->format('j');
$day = array('Воскресенье', 'Понедельник', 'Вторник', 'Среда', 'Четверг', 'Пятница', 'Суббота');
$time_start = array('0', '8.00', '9.00', '10.00', '11.00', '12.20', '13.20', '14.20', '15.20', '16.20', '17.20', '18.20', '19.20');
$time_end = array('0', '8.50', '9.50', '10.50', '11.50', '13.10', '14.10', '15.10', '16.10', '17.10', '18.10', '19.10', '20.10');
