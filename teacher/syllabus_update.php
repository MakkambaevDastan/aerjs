<?php
session_start();
if ($_SESSION['AVN_User']==false) {
    header('Location: ../facultet.php');
}
require_once '../vendor/connect.php';
$date = new DateTime();
$id_syllabus_t = (int)$_POST['id_syllabus_t'];
$subject_type_get = $_POST['subject_type_get'];
$hour_week=(int)$_POST['hour_week'];
////==========================================================обновление данных силабуса
$sql_update_sil = "UPDATE [dbo].[syllabus_head] SET code = ?, hour_week = ?, course_language = ?, purpose = ?, annotation = ?, competence = ?, result_learning = ?, student_know = ?, student_must = ?, id_update = ? instrumentos = ? WHERE id_sillabus_t = id_syllabus_t";
$language=(int)$_POST['course_language'];
$today=date('d.n.Y');
$params_sil = array($_POST['code'], $hour_week, $language, $_POST['purpose'], $_POST['annotation'], $_POST['competence'], $_POST['result_learning'], $_POST['student_know'], $_POST['student_must'], $today, $_POST['instrumentos']);
$options =  array("SendStreamParamsAtExec"=>0);
$stmt = sqlsrv_prepare($connect_local, $sql_update_sil, $params_sil);
sqlsrv_execute($stmt);
if ($stmt == false) {
  echo 'ошибка запрос обновления силабуса';
  die(print_r(sqlsrv_errors(), true));
}
//==========================================================вставка\обновление данных лек
$i=1;
while($_POST["subject_table_1_name_$i"]){
    $subject_hour=1;
    $subject_name=$_POST["subject_table_1_name_$i"];
    $subject_num=$_POST["subject_table_1_num_$i"];
    $subject_type=1;
    $id_sillabus_t = $id_syllabus_t;
    $options = array("Scrollable" => SQLSRV_CURSOR_KEYSET);
    $params = array();
    $sql_select = "SELECT id_sillabus_t, subject_num FROM [syllabus_subject] WHERE subject_type = 1 AND id_sillabus_t = $id_sillabus_t AND subject_num = $subject_num";
    $stmt  = sqlsrv_query($connect_local, $sql_select, $params, $options);
    $row_count = sqlsrv_num_rows($stmt);
    if ($row_count > 0){
        $sql_i_u = "UPDATE [dbo].[syllabus_subject]  
                SET subject_hour = ?, subject_name = ?
                WHERE id_sillabus_t = $id_sillabus_t AND subject_num = $subject_num AND subject_type = 1";
        $params = array( $subject_hour, $subject_name);
    }
    if ($row_count == 0) {
        $sql_i_u = "INSERT INTO [dbo].[syllabus_subject] (id_sillabus_t, subject_type, subject_hour, subject_name, subject_num) 
                VALUES (?,?,?,?,?) ";
        $params = array($id_sillabus_t, $subject_type, $subject_hour, $subject_name, $subject_num);
    }
    $stmt = sqlsrv_query( $connect_local, $sql_i_u, $params);
    if ($stmt == false) {
        echo 'Ошибка обновления данных лек\прак';
        die(print_r(sqlsrv_errors(), true));
    }
    $i++;
}
//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
$i=1;
while($_POST["subject_table_2_name_$i"]){
    $subject_hour=1;
    $subject_name=$_POST["subject_table_2_name_$i"];
    $subject_num=$_POST["subject_table_2_num_$i"];
	//=======================================================================тип пр\лаб\сем
	// echo '<pre>';
	$subject_type=$subject_type_get;
    $id_sillabus_t = (int)$id_syllabus_t;
    $options = array("Scrollable" => SQLSRV_CURSOR_KEYSET);
    $params = array();
    $sql_select = "SELECT id_sillabus_t, subject_num FROM [syllabus_subject] 
                    WHERE subject_type = 2 AND id_sillabus_t = $id_sillabus_t AND subject_num = $subject_num
                    OR subject_type = 3 AND id_sillabus_t = $id_sillabus_t AND subject_num = $subject_num
                    OR subject_type = 4  AND id_sillabus_t = $id_sillabus_t AND subject_num = $subject_num";
    $stmt  = sqlsrv_query($connect_local, $sql_select, $params, $options);
    $row_count = sqlsrv_num_rows($stmt);
    if ($row_count > 0){
        $sql_i_u = "UPDATE [dbo].[syllabus_subject]  
                SET subject_hour = ?, subject_name = ?
                WHERE id_sillabus_t = $id_sillabus_t AND subject_num = $subject_num AND subject_type = $subject_type";
        $params = array( $subject_hour, $subject_name);
    }
    if ($row_count == 0) {
       $sql_i_u = "INSERT INTO [dbo].[syllabus_subject] (id_sillabus_t, subject_type, subject_hour, subject_name, subject_num) 
                VALUES (?,?,?,?,?) ";
        $params = array($id_sillabus_t, $subject_type, $subject_hour, $subject_name, $subject_num);
    }
    $stmt = sqlsrv_query( $connect_local, $sql_i_u, $params);
    if ($stmt == false) {
        echo 'Ошибка вставка данных лек\прак';
        die(print_r(sqlsrv_errors(), true));
    }
    $i++;
}

//==========================================================вставка\обновление данных литература
$i=1;
while($_POST["textbook_autor_$i"]){
  $textbook_autor=$_POST["textbook_autor_$i"];
  $textbook_name=$_POST["textbook_name_$i"];
  $textbook_link=$_POST["textbook_link_$i"];
  $textbook_num=$_POST["textbook_num_$i"];
  $id_sillabus_t = $id_syllabus_t;
    $options = array("Scrollable" => SQLSRV_CURSOR_KEYSET);
    $params = array();
    $sql_select = "SELECT id_sillabus_t, textbook_num FROM [dbo].[syllabus_textbook] WHERE id_sillabus_t = $id_sillabus_t AND textbook_num = $textbook_num";
    $stmt  = sqlsrv_query($connect_local, $sql_select, $params, $options);
    $row_count = sqlsrv_num_rows($stmt);
    if ($row_count > 0) {
        $sql_i_b = "UPDATE [dbo].[syllabus_textbook]  
                SET textbook_autor = ?, textbook_name = ?, textbook_link = ?
                WHERE id_sillabus_t = $id_sillabus_t AND textbook_num = $textbook_num";
        $params = array($textbook_autor, $textbook_name, $textbook_link);
    }
    if ($row_count == 0) {
        $sql_i_b = "INSERT INTO [dbo].[syllabus_textbook] (id_sillabus_t, textbook_autor, textbook_name, textbook_link, textbook_num) VALUES (?,?,?,?,?)";
        $params = array($id_sillabus_t, $textbook_autor, $textbook_name, $textbook_link, $textbook_num);
    }
    $stmt = sqlsrv_query( $connect_local, $sql_i_b, $params);
    if ($stmt == false) {
        echo 'Ошибка вставка данных книги';
        die(print_r(sqlsrv_errors(), true));
    }
    $i++;
  unset($params);
}
$_SESSION['message']='Силлабус успешно сохранен!';
 header('Location: discipline.php');
?>