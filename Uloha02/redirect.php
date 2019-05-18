<?php
session_start();
include "congif.php";
$_SESSION['tim'] = $_POST['tim'];
$sql = "SELECT jeKapitan FROM clenovaTimov WHERE IDtimu =".$_SESSION['tim']." AND IDziaka =".$_SESSION['uziv'].";";
$stmt = $conn->prepare($sql);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();
if($row['jeKapitan'] == 1) {
    $_SESSION['kapitan'] = 1;
    header("Location: kapitanNahlad.php");
}
else{
    $_SESSION['kapitan'] = 0;
    header("Location: student.php");
}
?>