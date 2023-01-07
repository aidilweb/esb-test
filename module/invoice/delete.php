<?php

$sql = "UPDATE tb_invoice
    SET deleted_at='" . date("Y-m-d H:i:s") . "'
    WHERE id=" . $_GET['id'];

$conn->query($sql);
header("location:index.php?mod=invoice&act=list&delete=1");
