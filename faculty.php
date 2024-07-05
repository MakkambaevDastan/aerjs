<?php
include_once './header.php';
require_once './vendor/connect.php';
$sql = "SELECT DISTINCT 
max(dbo.movement_t.id_rate) as id_rate,
dbo.[group].id_group,
dbo.[group].p20
FROM dbo.[group]
INNER JOIN dbo.movement_t ON dbo.[group].id_group = dbo.movement_t.id_group
WHERE (dbo.[group].id_faculty = " . $_GET['id_faculty'] . ")
AND (dbo.movement_t.isStudying > 0)
GROUP BY dbo.[group].id_group,
dbo.[group].p20
ORDER BY dbo.[group].id_group DESC";
$select = sqlsrv_query($connect, $sql);
while ($row = sqlsrv_fetch_array($select)) {
  $group[$row['id_rate']][$row['id_group']] = $row['p20'];
}
if (count($group)) {
  echo  "<table class='table table-sm table-borderless bg-light text-center mb-0 schedule-table fs-5 fw-bold'>
       <tr><th colspan='4' class='table-light border'>" . $_GET['p23_2'] . "</th><tr>";
  foreach ($group as $rate => $groups) {
    echo "<tr><th colspan='4' class='table-info border'>$rate-курс</th><tr><tr><td class='d-flex flex-wrap '>";
    foreach ($groups as $id_group => $p20) {
      echo "<button class='btn btn-primary m-1' onclick=\"location . href = './schedule.php?id_group=$id_group'\" >$p20</button>";
    }
    echo "</td></tr>";
  }
  echo "</table>";
}
include_once 'footer.php';