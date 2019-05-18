<?php
include "config.php";
$predmet = "SELECT ID FROM predmety WHERE nazov = '" . $_POST['predmet'] . "';";
$tmp = $conn->prepare($predmet);
$tmp->execute();
$tmp_vysl = $tmp->get_result();
$riadok = $tmp_vysl->fetch_assoc();

$sql = "SELECT ID FROM timy where rok =" . $_POST['rok'] . " and IDpredmetu = " . $riadok['ID'] . ";";
$stmt = $conn->prepare($sql);
$stmt->execute();
$result = $stmt->get_result();
$to_csv = array();
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $sql = "SELECT IDziaka,body from clenovaTimov where IDtimu = " . $row['ID'] . ";";
        $stmt2 = $conn->prepare($sql);
        $stmt2->execute();
        $result2 = $stmt2->get_result();
        if ($result2->num_rows > 0) {
            while ($row2 = $result2->fetch_assoc()) {
                $sql = "SELECT meno from studenti where ID = " . $row2['IDziaka'] . ";";
                $stmt3 = $conn->prepare($sql);
                $stmt3->execute();
                $result3 = $stmt3->get_result();
                $row3 = $result3->fetch_assoc();
                $tmp = array();
                array_push($tmp, $row2['IDziaka'], $row3['meno'], $row2['body']);
                array_push($to_csv, $tmp);
            }
        }
    }
}

if (sizeof($to_csv) > 0) {
    //set headers to download file rather than displayed
//    $filename = "members_" . date('Y-m-d') . ".csv";
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename="data.csv"');
    $seperator = "sep=;";

    //create a file pointer
    $f = fopen('php://output', 'w');

    //set column headers
    $fields = array('ID', 'Meno', 'Body');
    fputcsv($f, $fields, ';');

    //output each row of the data, format line as csv and write to file pointer
    foreach ($to_csv as $data) {
        fputcsv($f, $data,';');
    }

    //move back to beginning of file
    fseek($f, 0);

    //output all remaining data on a file pointer
    fpassthru($f);
}
exit;
?>