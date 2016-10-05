<meta charset="utf-8">
<?php
include_once('db.php');
$req = $conn->query("SELECT UGSN.ID as ugsnId, UGSN.Name as ugsnName, Direction.ID as dirId, Direction.Name as dirName FROM UGSN INNER JOIN Direction ON UGSN.ID = Direction.ID_Ugsn ORDER BY ugsnId");
while ($row = $req->fetch()) {
    echo $row['ugsnId']." ".$row['ugsnName']." ".$row['dirId']." ".$row['dirName']."<br>";
}
?>

