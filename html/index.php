<?php include 'db.php'; ?>
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

    <title>Junjie Cash Invoice</title>
    <style>
        body { font-family: Arial; margin: 20px; }
        input, textarea, button { padding: 8px; margin: 5px; width: 100%; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        table, th, td { border: 1px solid black; padding: 10px; }
        .form-box { border: 1px solid #ccc; padding: 20px; margin-bottom: 20px; }
        .items-container { margin-bottom: 15px; }
        .item-row { display: flex; gap: 10px; margin-bottom: 5px; }
        .item-row input { width: 48%; }
    </style>
  <script>
    function addItemRow() {
        let container = document.getElementById("itemsContainer");
        let rows = container.getElementsByClassName("item-row");

        // Check last row before adding a new one
        if (rows.length > 0) {
            let lastRow = rows[rows.length - 1];
            let inputs = lastRow.getElementsByTagName("input");

            let itemName = inputs[0].value.trim();
            let itemPrice = inputs[1].value.trim();

            if (itemName === "" || itemPrice === "") {
                alert("Please fill in both Item Name and Price before adding a new row.");
                return;
            }
        }

        // Create new row with X button
        let row = document.createElement("div");
        row.classList.add("item-row");
        row.style.marginBottom = "5px";

        row.innerHTML = `
            <input type="text" name="item_name[]" placeholder="Item name" required>
            <input type="number" name="item_price[]" step="0.01" placeholder="Price" oninput="calculateTotal()" required>
            <button type="button" onclick="removeRow(this)" style="background:red;color:white;border:none;padding:2px 6px;cursor:pointer;">X</button>
        `;
        container.appendChild(row);
    }

    function removeRow(button) {
        let row = button.parentNode;
        row.parentNode.removeChild(row);
        calculateTotal(); // Recalculate total after removal
    }

    function calculateTotal() {
        let prices = document.getElementsByName("item_price[]");
        let total = 0;
        for (let i = 0; i < prices.length; i++) {
            let val = parseFloat(prices[i].value);
            if (!isNaN(val)) total += val;
        }
        document.getElementById("total_amount").value = total.toFixed(2);
    }

    // Validate before submitting invoice
    function validateForm() {
        let names = document.getElementsByName("item_name[]");
        let prices = document.getElementsByName("item_price[]");

        for (let i = 0; i < names.length; i++) {
            if (names[i].value.trim() === "" || prices[i].value.trim() === "") {
                alert("Please remove or fill all blank rows before saving.");
                return false;
            }
        }
        return true;
    }

    window.onload = function() {
        addItemRow(); // Start with one row
    }
</script>



</head>
<body>

<h2>Create Cash Invoice</h2>
<div class="form-box">
    <form action="save_invoice.php" method="POST">
        <label>Customer Name:</label>
        <input type="text" name="customer_name" required>

        <label>Customer Address And Phone No.:</label>
        <textarea name="customer_address" required></textarea>

        <label>Invoice Date:</label>
        <input type="date" name="invoice_date" required>

        <label>Items:</label>
        <div id="itemsContainer" class="items-container"></div>
        <button type="button" onclick="addItemRow()">Add Item</button>

        <label>Total Amount:</label>
        <input type="number" name="total_amount" id="total_amount" readonly required>

        <button type="submit">Save Invoice</button>
    </form>
</div>

<h2>Search Invoices</h2>
<form method="GET" action="search_invoice.php">
    <input type="text" name="q" placeholder="Search by customer name">
    <button type="submit">Search</button>
</form>

</body>
</html>
