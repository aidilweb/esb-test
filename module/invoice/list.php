<?php
$sql = "SELECT tb_invoice.*,tb_client.name  FROM tb_invoice INNER JOIN tb_client ON tb_client.id=tb_invoice.client_id WHERE tb_invoice.deleted_at IS NULL";
$invoice = $conn->query($sql);

// print_r($inp)
?>

<h2>Invoice List</h2>

<?php if (isset($_GET['delete']) == 1) { ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>Success</strong> Invoice has been deleted
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php } ?>


<table class="table table-bordered dt">
    <thead>
        <tr>
            <th>Invoice No</th>
            <th>Created Date</th>
            <th>Customer Name</th>
            <th>Invoice Total</th>
            <th>Status</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($invoice as $key => $iv) { ?>
            <tr>
                <td><?php echo $iv['id'] ?></td>
                <td><?php echo date("d/m/Y H:i:s", strtotime($iv['created_at'])) ?></td>
                <td><?php echo $iv['name'] ?></td>
                <td>£<?php echo number_format($iv['subtotal'] + $iv['tax'], 2, ',', '.') ?></td>
                <td>
                    <?php
                    if ($iv['status'] == 0) {
                        echo "Waiting Payment";
                    } elseif ($iv['status'] == 1) {
                        echo "Paid";
                    }
                    ?>
                </td>
                <td>
                    <a href="module/invoice/print.php?id=<?php echo $iv['id'] ?>" class="btn btn-success" target="_blank"> <i class="fa fa-print"></i></a>
                    <a href="index.php?mod=invoice&act=edit&id=<?php echo $iv['id'] ?>" class="btn btn-primary"> <i class="fa fa-pencil"></i></a>
                    <a href="index.php?mod=invoice&act=delete&id=<?php echo $iv['id'] ?>" class="btn btn-danger" onclick="return confirm('Are you sure?')"> <i class="fa fa-times"></i></a>
                </td>
            </tr>
        <?php } ?>
    </tbody>
</table>