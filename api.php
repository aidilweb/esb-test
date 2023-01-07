<?php

require('connection.php');
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

$mod = '';
if (isset($_GET['mod'])) {
    $mod = $_GET['mod'];
}

$act = '';
if (isset($_GET['act'])) {
    $act = $_GET['act'];
}


if ($mod == '') {
    http_response_code(400);
    echo json_encode(["message" => "module not fund"]);
} elseif ($mod == 'invoice') {
    if ($act == 'list') {
        $sql = "SELECT tb_invoice.*,tb_client.name,tb_client.address_1,tb_client.address_2,tb_client.country   FROM tb_invoice INNER JOIN tb_client ON tb_client.id=tb_invoice.client_id WHERE tb_invoice.deleted_at IS NULL";
        $invoice = $conn->query($sql);


        http_response_code(200);
        echo json_encode(["message" => "ok", "data" => $invoice->fetch_all(MYSQLI_ASSOC)]);
    } elseif ($act == 'detail') {

        $sql = "SELECT tb_invoice.*,tb_client.name,tb_client.address_1,tb_client.address_2,tb_client.country   FROM tb_invoice INNER JOIN tb_client ON tb_client.id=tb_invoice.client_id WHERE tb_invoice.deleted_at IS NULL AND tb_invoice.id=" . $_GET['id'];
        $invoice = $conn->query($sql);

        $data = $invoice->fetch_assoc();

        $sql = "SELECT tb_invoice_detail.*,tb_item.type,tb_item.description,tb_item.price FROM tb_invoice_detail INNER JOIN tb_item ON tb_item.id=tb_invoice_detail.item_id WHERE tb_invoice_detail.invoice_id='" . $data['id'] . "'";
        $detail = $conn->query($sql);

        $data['detail'] = $detail->fetch_all(MYSQLI_ASSOC);

        if ($invoice->num_rows > 0) {
            http_response_code(200);
            echo json_encode(["message" => "ok", "data" => $data]);
        } else {
            http_response_code(200);
            echo json_encode(["message" => "invoice not found"]);
        }
    } else {
        http_response_code(400);
        echo json_encode(["message" => "action not found"]);
    }
} else {
    http_response_code(400);
    echo json_encode(["message" => "module not found"]);
}
