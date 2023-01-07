<?php

if ($_POST) {

    $date = DateTime::createFromFormat('d/m/Y', $_POST['issue_date']);
    $issue_date = $date->format('Y-m-d');

    $date = DateTime::createFromFormat('d/m/Y', $_POST['due_date']);
    $due_date = $date->format('Y-m-d');

    $sql = "INSERT INTO `tb_invoice` (`id`, `issue_date`, `due_date`, `subject`, `client_id`, `subtotal`, `tax`, `payment`, `amount_due`, `status`, `created_at`) 
            VALUES ('" . $_POST['invoice_id'] . "', '" . $issue_date . "', '" . $due_date . "', '" . $_POST['subject'] . "', '" . $_POST['client_id'] . "', '" . $_POST['subtotal'] . "', '" . $_POST['tax'] . "', '" . $_POST['payment'] . "', '" . $_POST['amount_due'] . "', '" . $_POST['status'] . "', '" . date('Y-m-d H:i:s') . "');";

    $conn->query($sql);

    $jml = count($_POST['qty']);
    for ($i = 0; $i < $jml; $i++) {
        $sql = "INSERT INTO `tb_invoice_detail` (`id`, `invoice_id`, `item_id`, `qty`, `amount`) VALUES (NULL, '" . $_POST['invoice_id'] . "', '" . $_POST['item_id'][$i] . "', '" . $_POST['qty'][$i] . "', '" . $_POST['amount'][$i] . "');";
        $conn->query($sql);
    }
    header("location:index.php?mod=invoice&act=create&status=1");
}


$sql = "SELECT *FROM tb_invoice";
$invoice = $conn->query($sql);

$id = $invoice->num_rows + 1;
$invoice_id = sprintf('%04d', $id);

$sql = "SELECT * FROM tb_client WHERE deleted_at IS NULL";
$client = $conn->query($sql);

$sql = "SELECT * FROM tb_item WHERE deleted_at IS NULL";
$item = $conn->query($sql);
?>

<h2>Create New Invoice</h2>

<?php if (isset($_GET['status']) == 1) { ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>Success</strong> New invoice has been created
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php } ?>

<form method="POST">
    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    Information
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <label for="invoice_id" class="col-sm-4 col-form-label">Invoice ID</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control-plaintext" name="invoice_id" id="invoice_id" value="<?php echo $invoice_id ?>" readonly>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="issue_date" class="col-sm-4 col-form-label">Issue Date</label>
                        <div class="col-sm-8">
                            <div class="input-group">
                                <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                                <input type="text" class="form-control datepicker" name="issue_date" id="issue_date" value="<?php echo date('d/m/Y') ?>" required>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="due_date" class="col-sm-4 col-form-label">Due Date</label>
                        <div class="col-sm-8">
                            <div class="input-group">
                                <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                                <input type="text" class="form-control datepicker" name="due_date" id="due_date" value="<?php echo date('d/m/Y') ?>" required>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="subject" class="col-sm-4 col-form-label">Subject</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" name="subject" id="subject" required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="client_id" class="col-sm-4 col-form-label">Client</label>
                        <div class="col-sm-8">
                            <select class="form-select" name="client_id" id="client_id" required>
                                <option value="">Choose Client</option>
                                <?php
                                while ($row = $client->fetch_assoc()) {
                                ?>
                                    <option value="<?php echo $row["id"] ?>"><?php echo $row["name"] ?></option>
                                <?php
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="status" class="col-sm-4 col-form-label">Status</label>
                        <div class="col-sm-8">
                            <select class="form-select" name="status" id="status" required>
                                <option value="0">Waiting Payment</option>
                                <option value="1">Paid</option>
                            </select>
                        </div>
                    </div>

                </div>

            </div>
        </div>
        <div class="col-md-8">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Detail</div>
                    <div class="card-body">
                        <div class="input-group mb-3">
                            <!-- <input type="text" class="form-control" placeholder="Recipient's username" aria-label="Recipient's username" aria-describedby="button-addon2"> -->
                            <select class="form-select" id="item">
                                <option value="">Choose Item</option>
                                <?php
                                while ($row = $item->fetch_assoc()) {
                                ?>
                                    <option value=" <?php echo $row["id"] ?>"><?php echo $row["description"] ?></option>
                                <?php
                                }
                                ?>
                            </select>
                            <button class="btn btn-primary" type="button" id="add-item">Add Item</button>
                        </div>

                        <input type="hidden" id="rows" value="0">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Item </th>
                                    <th>Description</th>
                                    <th>Quantity</th>
                                    <th>Unit Price</th>
                                    <th>Amount</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody id="detail"></tbody>


                        </table>

                        <div class="row">
                            <div class="col-md-6 offset-md-6">

                                <div class="row mb-3">
                                    <label for="subtotal" class="col-sm-4 col-form-label">Subtotal</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control-plaintext" id="subtotal" name="subtotal" value="0" readonly>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="tax" class="col-sm-4 col-form-label">Tax(10%)</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control-plaintext" id="tax" name="tax" value="0" readonly>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="payment" class="col-sm-4 col-form-label">Payment</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" id="payment" name="payment" onchange="hitung_resume()" value="0" required>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="amount_due" class="col-sm-4 col-form-label">Ammount Due</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control-plaintext" id="amount_due" name="amount_due" value="0" readonly>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary float-end">Save</button>
                    </div>
                </div>
            </div>
        </div>



    </div>
</form>
<script>
    $('#add-item').click(function() {
        var item_id = $("#item").val()
        var rows = $("#rows").val()
        $.ajax({
            url: "json.php?data=item&id=" + item_id,
            dataType: "json",
            type: "GET",
            success: function(data) {
                var html = '<tr id="row-' + rows + '">';
                html += '<input type="hidden" name="item_id[]" value="' + data.id + '">';
                html += '<td><input type="text" id="item-' + rows + '" class="form-control-plaintext" value="' + data.type + '"></td>';
                html += '<td><input type="text" id="description-' + rows + '" class="form-control-plaintext"  value="' + data.description + '"></td>';
                html += '<td><input type="text" id="qty-' + rows + '" class="form-control" name="qty[]" onchange="hitung(' + rows + ')" value="1" required></td>';
                html += '<td><input type="text" id="price-' + rows + '" class="form-control-plaintext"  value="' + data.price + '" readonly></td>';
                html += '<td><input type="text" id="amount-' + rows + '" class="form-control-plaintext amount" name="amount[]"  value="' + data.price + '"></td>';
                html += '<td><button id="delete-' + rows + '" class="btn btn-danger" onclick="deleteRow(' + rows + ')"><i class="fa fa-times"</i></button></td>';
                html += '</tr>';
                $('#detail').append(html);

                $("#rows").val(parseInt(rows) + 1);

                hitung_resume();
            }
        });

    });

    function deleteRow(rows) {
        $('#row-' + rows).closest('tr').remove();
        hitung_resume();
    }

    function hitung(rows) {
        var qty = $('#qty-' + rows).val();
        var price = $('#price-' + rows).val();

        var amount = parseFloat(qty) * parseFloat(price);

        $('#amount-' + rows).val(amount);

        hitung_resume();
    }

    function hitung_resume() {
        var subtotal = 0;
        $('.amount').each(function() {
            subtotal += parseFloat($(this).val());
        });

        $('#subtotal').val(subtotal);

        var tax = (10 / 100) * subtotal;
        $('#tax').val(tax);

        var payment = $('#payment').val();

        var amount_due = (subtotal + tax) - payment;
        $('#amount_due').val(amount_due);

    }
</script>



<!-- <button type="submit" class="btn btn-primary">Save</button> -->


<div class="col-md-4 offset-md-4 d-none">
    <div class="card">
        <div class="card-header">
            For
        </div>
        <div class="card-body">
            <div class="row mb-3">
                <label for="issue_date" class="col-sm-4 col-form-label">Name</label>
                <div class="col-sm-8">
                    <input type="text" class="form-control" id="issue_date">
                </div>
            </div>
            <div class="row mb-3">
                <label for="issue_date" class="col-sm-4 col-form-label">Address 1</label>
                <div class="col-sm-8">
                    <input type="text" class="form-control" id="issue_date">
                </div>
            </div>
            <div class="row mb-3">
                <label for="issue_date" class="col-sm-4 col-form-label">Address 2</label>
                <div class="col-sm-8">
                    <input type="text" class="form-control" id="issue_date">
                </div>
            </div>
            <div class="row mb-3">
                <label for="issue_date" class="col-sm-4 col-form-label">Country</label>
                <div class="col-sm-8">
                    <input type="text" class="form-control" id="issue_date">
                </div>
            </div>
        </div>
    </div>

</div>
<div class="row mt-4">

</div>