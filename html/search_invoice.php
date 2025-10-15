<?php
include 'db.php';

$q = $_GET['q'] ?? '';
$sort = $_GET['sort'] ?? 'id';
$order = $_GET['order'] ?? 'ASC';

// Allow only safe columns
$allowedSort = ['id', 'customer_name', 'invoice_date', 'total_amount'];
if (!in_array($sort, $allowedSort)) $sort = 'id';

// Toggle ASC/DESC
$order = strtoupper($order) === 'DESC' ? 'DESC' : 'ASC';
$nextOrder = $order === 'ASC' ? 'DESC' : 'ASC';

$sql = "SELECT * FROM invoices 
        WHERE customer_name LIKE '%$q%' 
        ORDER BY $sort $order";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Search Results</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f7f3f0; /* warm light gray */
        }
        .container {
            margin-top: 30px;
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        th a {
            text-decoration: none;
            color: inherit;
        }
        th a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
<div class="container">
    <h2 class="mb-4">Search Results</h2>
    <a href="index.php" class="btn btn-secondary mb-3">Back</a>

    <table class="table table-bordered table-striped mt-3">
        <thead class="table-light">
            <tr>
                <th><a href="?q=<?= urlencode($q) ?>&sort=id&order=<?= $nextOrder ?>">ID</a></th>
                <th><a href="?q=<?= urlencode($q) ?>&sort=customer_name&order=<?= $nextOrder ?>">Customer</a></th>
                <th><a href="?q=<?= urlencode($q) ?>&sort=invoice_date&order=<?= $nextOrder ?>">Date</a></th>
                <th>Items</th>
                <th><a href="?q=<?= urlencode($q) ?>&sort=total_amount&order=<?= $nextOrder ?>">Total</a></th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php while($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?= $row['id'] ?></td>
                <td><?= htmlspecialchars($row['customer_name']) ?></td>
                <td><?= $row['invoice_date'] ?></td>
                <td>
                    <?php
                    $items = explode(',', $row['items']);
                    foreach ($items as $item) {
                        echo htmlspecialchars(trim($item)) . "<br>";
                    }
                    ?>
                </td>
                <td><?= $row['total_amount'] ?></td>
                <td><a href="print_invoice.php?id=<?= $row['id'] ?>" target="_blank" class="btn btn-sm btn-info">Print</a></td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>
</body>
</html>
