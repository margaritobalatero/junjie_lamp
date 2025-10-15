<?php
include 'db.php';

$id = $_GET['id'] ?? 0;
$sql = "SELECT * FROM invoices WHERE id=$id";
$result = $conn->query($sql);
$invoice = $result->fetch_assoc();
?>
<!DOCTYPE html>
<html>
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
    body {
        background-color: #f7f3f0; /* warm light gray */
        font-family: Arial, sans-serif;
    }
    .container {
        margin-top: 30px;
        background: #fff;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    }
    .btn-danger {
        padding: 2px 8px;
        font-size: 14px;
        margin-left: 5px;
    }
</style>

    <title>Print Invoice</title>
    <style>
        body { font-family: Arial; }
        .invoice-box { border: 1px solid #000; padding: 20px; width: 400px; }
        button { margin-top: 10px; }
    </style>
</head>
<body>
<div class="invoice-box">
    <h2>Cash Invoice</h2>
    <p><strong>Customer:</strong> <?= $invoice['customer_name'] ?></p>
    <p><strong>Address:</strong> <?= $invoice['customer_address'] ?></p>
    <p><strong>Date:</strong> <?= $invoice['invoice_date'] ?></p>
    <p><strong>Items:</strong></p>
    <ul>
        <?php
        $items = explode(',', $invoice['items']);
        foreach ($items as $item) {
            echo "<li>" . htmlspecialchars(trim($item)) . "</li>";
        }
        ?>
    </ul>
    <p><strong>Total:</strong> <?= $invoice['total_amount'] ?></p><br>
     <p><strong>Received Full Payment</strong></p><br>   
     <p><strong>_____________________________________:</strong></p>
    <p><strong><center>Margarito V. Balatero Jr.</center></strong></p>
</div>
<button onclick="window.print()">Print</button>
</body>
</html>
