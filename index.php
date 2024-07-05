<?php
include_once './header.php';
require_once './vendor/connect.php';
$sql = "SELECT DISTINCT dbo.[group].id_faculty,
dbo.faculty.[p23-2]
FROM dbo.[group]
INNER JOIN dbo.movement_t ON dbo.[group].id_group = dbo.movement_t.id_group
INNER JOIN dbo.faculty ON dbo.[group].id_faculty = dbo.faculty.id_faculty
WHERE dbo.movement_t.isStudying > 0
ORDER BY dbo.faculty.[p23-2]";
$select = sqlsrv_query($connect, $sql);
while ($row = sqlsrv_fetch_array($select)) {
    $faculty[$row['id_faculty']] = $row['p23-2'];
}
echo "<h1 class='h1 text-center'></h1><div class='d-flex gap-5 justify-content-center'><div class='list-group'>
<label class='list-group-item list-group-item-info gap-5 mx-0 '><span><h3 class='h3 text-center'>Факультеты</h3></span></label>";
foreach ($faculty as $id_faculty => $p23_2) {
    if (strpos($p23_2, '(з/о)')) $z_o[$id_faculty] = $p23_2;
    else {
        echo "<label class='list-group-item list-group-item-action cursor-pointer d-flex gap-5 mt-1 mb-1 btn btn-primary' 
        onclick=\"location.href = './faculty.php?id_faculty=$id_faculty&p23_2=$p23_2'\">
        <span><h4 class='h4'>$p23_2</h4></span></label>";
    }
}
echo "</div><div class='list-group'><label class='list-group-item list-group-item-info  gap-5 mx-0 '><span><h3 class='h3 text-center'>Заочный</h3></span></label>";
foreach ($z_o as $id_faculty => $p23_2) {
    echo "<label class='list-group-item list-group-item-action cursor-pointer d-flex gap-5 mt-1 mb-1 btn btn-primary' 
    onclick=\"location.href = './faculty.php?id_faculty=$id_faculty'\">
    <span><h4 class='h4'>$p23_2</h4></span></label>";
}
echo "</div></div>";
include_once './footer.php';