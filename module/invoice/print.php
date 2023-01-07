<?php
require "../../connection.php";

$sql = "SELECT tb_invoice.*,tb_client.name,tb_client.address_1,tb_client.address_2,tb_client.country  FROM tb_invoice INNER JOIN tb_client ON tb_client.id=tb_invoice.client_id WHERE tb_invoice.id='" . $_GET['id'] . "'";
$invoice = $conn->query($sql)->fetch_assoc();

$sql = "SELECT * FROM tb_invoice_detail INNER JOIN tb_item ON tb_item.id=tb_invoice_detail.item_id WHERE tb_invoice_detail.invoice_id='" . $invoice['id'] . "'";
$detail = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice #<?php echo $invoice['id'] ?></title>
    <style>
        .paid {
            text-align: center;
            margin-top: 2rem;
            border: 3px solid green;
            width: 100px;
            padding: 1rem;
            transform: rotate(-25deg);
            font-size: 20px;
            font-weight: bold;
            color: green;
        }

        .waiting_payment {
            text-align: center;
            margin-top: 2rem;
            border: 3px solid red;
            width: 120px;
            padding: 1rem;
            transform: rotate(-25deg);
            font-size: 20px;
            font-weight: bold;
            color: red;
        }
    </style>
</head>

<body onload="print()">
    <table width="100%" border="0">
        <tr>
            <td width="45%" valign="top">
                <h1>INVOICE</h1>
            </td>
            <td width="10%">

                <?php if ($invoice['status'] == 1) : ?>
                    <div class="paid">
                        PAID
                    </div>
                <?php else : ?>
                    <div class="waiting_payment">
                        WAITING PAYMENT
                    </div>
                <?php endif ?>
            </td>
            <td width="45%">
                <table cellspacing="0" cellpadding="5">
                    <tr>
                        <th valign="top" width="100px" align="right">From</th>
                        <td style="border-left: 2px solid grey;">
                            <strong><?php echo $_from_name ?></strong><br>
                            <?php echo $_from_address_1 ?><br>
                            <?php echo $_from_address_2 ?><br>
                            <?php echo $_from_country ?><br>
                        </td>
                    </tr>
                </table><br>

            </td>
        </tr>
        <tr>
            <td width="45%">
                <table cellspacing="0" cellpadding="5">
                    <tr>
                        <th width="100px" align="left">Invoice ID</th>
                        <td style="border-left: 2px solid grey;"><?php echo $invoice['id'] ?></td>
                    </tr>
                    <tr>
                        <th align="left">Issue Date</th>
                        <td style="border-left: 2px solid grey;"><?php echo date("d/m/Y", strtotime($invoice['issue_date'])) ?></td>
                    </tr>
                    <tr>
                        <th align="left">Due Date</th>
                        <td style="border-left: 2px solid grey;"><?php echo date("d/m/Y", strtotime($invoice['due_date'])) ?></td>
                    </tr>
                    <tr>
                        <th align="left" valign="top">Subject</th>
                        <td style=" border-left: 2px solid grey;"><?php echo $invoice['subject'] ?>
                        </td>
                    </tr>
                </table>
            </td>
            <td width="10%"></td>
            <td width="45%" valign="top">
                <table cellspacing="0" cellpadding="5">
                    <tr>
                        <th valign="top" width="100px" align="right">To</th>
                        <td style="border-left: 2px solid grey;">
                            <strong><?php echo $invoice['name'] ?></strong><br>
                            <?php echo $invoice['address_1'] ?><br>
                            <?php echo $invoice['address_2'] ?><br>
                            <?php echo $invoice['country'] ?><br>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td colspan="3">
                <br>
                <table cellpadding="5" cellspacing="0" width="100%" border="1">
                    <tr style="border-top: none;">
                        <th width="15%" align="left">Item Type</th>
                        <th width="40%" align="left">Description</th>
                        <th width="15%" align="right">Quantity</th>
                        <th width="15%" align="right">Unit Price</th>
                        <th width="15%" align="right">Amount</th>
                    </tr>
                    <?php foreach ($detail as $key => $d) { ?>
                        <tr>
                            <td><?php echo $d['type'] ?></td>
                            <td><?php echo $d['description'] ?></td>
                            <td align="right"><?php echo number_format($d['qty'], 2, ',', '.') ?></td>
                            <td align="right">£<?php echo number_format($d['price'], 2, ',', '.') ?></td>
                            <td align="right">£<?php echo number_format($d['amount'], 2, ',', '.') ?></td>
                        </tr>
                    <?php } ?>
                </table>

                <table cellpadding="5" width="100%">
                    <tr>
                        <td width="85%" align="right">Subtotal</td>
                        <td width="15%" align="right">£<?php echo number_format($invoice['subtotal'], 2, ',', '.') ?></td>
                    </tr>
                    <tr>
                        <td width="85%" align="right">Tax (10%)</td>
                        <td width="15%" align="right">£<?php echo number_format($invoice['tax'], 2, ',', '.') ?></td>
                    </tr>
                    <tr>
                        <td width="85%" align="right">Payment</td>
                        <td width="15%" align="right">£<?php echo number_format($invoice['payment'], 2, ',', '.') ?></td>
                    </tr>
                    <tr>
                        <td width="85%" align="right">
                            <h3>Amount Due</h3>
                        </td>
                        <td width="15%" align="right">
                            <h3>£<?php echo number_format($invoice['amount_due'], 2, ',', '.') ?></h3>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>

</html>