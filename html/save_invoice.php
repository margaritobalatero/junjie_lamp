<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['customer_name'];
    $address = $_POST['customer_address'];
    $date = $_POST['invoice_date'];

    // Combine items into one string: "Item1:Price1, Item2:Price2"
    $items = [];
    if (isset($_POST['item_name'], $_POST['item_price'])) {
        for ($i = 0; $i < count($_POST['item_name']); $i++) {
            $items[] = $_POST['item_name'][$i] . ':' . $_POST['item_price'][$i];
        }
    }
    $items_string = implode(", ", $items);

    // Total comes from the calculated field
    $total = $_POST['total_amount'];

    $sql = "INSERT INTO invoices (customer_name, customer_address, invoice_date, items, total_amount)
            VALUES ('$name', '$address', '$date', '$items_string', '$total')";

    if ($conn->query($sql)) {
        echo "Invoice saved successfully. <a href='index.php'>Back</a>";
    } else {
        echo "Error: " . $conn->error;
    }
}
?>
