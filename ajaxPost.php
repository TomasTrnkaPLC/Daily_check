<?php
$link = new PDO("mysql:host=mariadb103.websupport.sk;port=3313;dbname=eguq5gfm", "eguq5gfm", "Gp8oh8yz?S");
$link->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$link->exec("SET CHARACTER SET utf8");

$allData = $_POST['allData'];
$i = 1;
foreach ($allData as $key => $value) {

    $sql = "UPDATE tbl_care_type SET
    Position = :pos
    WHERE id = :id";
    $stmt= $link->prepare($sql);
    $stmt->bindValue(':id', $value);
    $stmt->bindValue(':pos', $i);
    $data =   $stmt->execute();
    

    $i++;
}
echo $sql;
