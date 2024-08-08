<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="style.css" rel="stylesheet">
    <title>Order Processing</title>
</head>
<body>
    <header>
        <a>LOGO</a>
        <ul>
            <li><a href="index.php">Home</a></li>
            <li><a href="generatepdf.php">PDF Generation</a></li>
            <li><a href="customers.php">Customer Details</a></li>
        </ul>
    </header>
    <main>
        <div class="banner">
            <p>Auto Fixers</p>
        </div>
        <div class="formProduct">
            <form action="../process_order.php" method="post" class="responsive-form">
                <h2>Select Customer and Items</h2>

                <label for="customer">Choose Customer:</label>
                <select id="customer" name="customer" required>
                    <option value="">Select a customer</option>
                    <?php
                    include '../auto_fixers.php';
                    $sql = "SELECT CustomerID, CustomerName FROM Customers";
                    $result = $conn->query($sql);
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<option value='" . htmlspecialchars($row['CustomerID']) . "'>" . htmlspecialchars($row['CustomerName']) . "</option>";
                        }
                    }
                    ?>
                </select>

                <h2>Select Items</h2>
                <div id="items-container">
                    <div class="item-row">
                        <label for="item">Choose Item:</label>
                        <select name="items[]" required>
                            <option value="">Select an item</option>
                            <?php
                            $sql = "SELECT ItemID, ItemName, ItemDescription FROM Items";
                            $result = $conn->query($sql);
                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    $itemName = htmlspecialchars($row['ItemName']);
                                    $itemDescription = htmlspecialchars($row['ItemDescription']);
                                    echo "<option value='" . htmlspecialchars($row['ItemID']) . "'>{$itemName} - {$itemDescription}</option>";
                                }
                            }
                            ?>
                        </select>

                        <label for="quantity">Quantity:</label>
                        <input type="number" name="quantities[]" min="1" required>
                    </div>
                </div>

                <button type="button" onclick="addItemRow()">Add Another Item</button>
                <button type="submit">Submit Order</button>
            </form>
        </div>
    </main>

    <footer>
        <div class="footerDiv">
            <ul>
                <li>Sarthak Gupta</li>
                <li></li>
            </ul>
            <ul>
                <li>Shakila Samardiwakara</li>
                <li></li>
            </ul>
            <ul>
                <li>Abhishek Chachad</li>
                <li></li>
            </ul>
        </div>
        <div class="copyright">
            <p>Copyright 2024. All rights reserved</p>
        </div>
    </footer>

    <script>
        function addItemRow() {
            var container = document.getElementById('items-container');
            var newRow = document.createElement('div');
            newRow.className = 'item-row';
            newRow.innerHTML = `
                <label for="item">Choose Item:</label>
                <select name="items[]" required>
                    <option value="">Select an item</option>
                    <?php
                    include '../dbconnect.php';
                    $sql = "SELECT ItemID, ItemName, ItemDescription FROM Items";
                    $result = $conn->query($sql);
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            $itemName = htmlspecialchars($row['ItemName']);
                            $itemDescription = htmlspecialchars($row['ItemDescription']);
                            echo "<option value='" . htmlspecialchars($row['ItemID']) . "'>{$itemName} - {$itemDescription}</option>";
                        }
                    }
                    ?>
                </select>
                <label for="quantity">Quantity:</label>
                <input type="number" name="quantities[]" min="1" required>
            `;
            container.appendChild(newRow);
        }
    </script>
</body>
</html>