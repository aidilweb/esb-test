<?php
require('connection.php');

$data = '';
if (isset($_GET['data'])) {
    $data = $_GET['data'];
}

if ($data == 'item') {
    $id = $_GET['id'];

    $sql = "SELECT * FROM tb_item WHERE id =" . $id . " AND deleted_at IS NULL";
    $item = $conn->query($sql);

    echo json_encode($item->fetch_assoc());
}
