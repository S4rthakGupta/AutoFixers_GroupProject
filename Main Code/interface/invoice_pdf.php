<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="style.css" rel="stylesheet">
    <title>PDF Generation</title>
    <style>
        .formProduct {
            max-width: 600px;
            margin: auto;
        }

        .responsive-form h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        .item-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 10px;
        }

        .item-row label,
        .item-row select,
        .item-row input {
            margin-right: 10px;
        }

        .item-row select,
        .item-row input {
            width: 40%;
        }

        .item-row button {
            margin-left: 10px;
        }

        .buttons-container {
            display: flex;
            justify-content: space-between;
            margin-top: 20px;
        }

        .buttons-container button {
            width: 48%;
        }
    </style>
</head>

<body>
    <header>
        <div class="storeLogo">
            <img src="../storelogo.jpg" alt="Logo - Auto Fixers">
            <span>Auto Fixers</span>
        </div>
        <ul>
            <li><a href="index.php">Product Data</a></li>
            <li><a href="customers.php">Customer Information</a></li>
            <li><a href="invoice_pdf.php">Invoice Generation (PDF)</a></li>
            <button class="font" onclick="toggleFontSize()">Default Font Size: Medium</button>
        </ul>
    </header>

    <main>
        <div class="banner">
            <p>Auto Fixers</p>
        </div>
        <div class="formProduct">
            <form action="../ProcessOrders.php" method="post" class="responsive-form">
                <h2>Select Customer and Products for Invoice</h2>

                <label for="customer">Choose Customer:</label>
                <select id="customer" name="customer" required>
                    <option value="">Select a customer</option>
                    <?php
                    include '../ConnectDB.php';
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
                        <label for="item">Choose Product:</label>
                        <select name="parts[]" required>
                            <option value="">Select a product</option>
                            <?php
                            $sql = "SELECT PartID, PartName, PartDescription FROM Parts";
                            $result = $conn->query($sql);
                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    $partName = htmlspecialchars($row['PartName']);
                                    $partDescription = htmlspecialchars($row['PartDescription']);
                                    echo "<option value='" . htmlspecialchars($row['PartID']) . "'>{$partName} - {$partDescription}</option>";
                                }
                            }
                            ?>
                        </select>

                        <label for="quantity">Quantity:</label>
                        <input type="number" name="quantities[]" min="1" value="1" required>
                    </div>
                </div>

                <div class="buttons-container">
                    <button class="primary" type="button" onclick="addItemRow()">Add Another Item</button>
                    <button class="success" type="submit">Submit Order</button>
                </div>
            </form>
        </div>
    </main>

    <footer>
        <div class="footerDiv">
            <ul>
                <li>8886070 Shakila Samaradiwakara</li>
                <li></li>
            </ul>
            <ul>
                <li>Sarthak Gupta</li>
                <li></li>
            </ul>
            <ul>
                <li>Abhishek Chachad</li>
                <li></li>
            </ul>
        </div>
        <div class="copyright">
        <p>Copyright 2024 | &copy;Auto Fixers | All rights reserved</p>
        </div>
    </footer>

    <script>
        let fontSizeIndex = 0;
        const fontSizes = ['small', 'medium', 'large', 'x-large'];

        function toggleFontSize() {
            fontSizeIndex = (fontSizeIndex + 1) % fontSizes.length;
            document.body.style.fontSize = fontSizes[fontSizeIndex];
            document.querySelector('button.font').innerText = `Font Size: ${fontSizes[fontSizeIndex]}`;
        }

        function addItemRow() {
            const container = document.getElementById('items-container');
            const newRow = document.createElement('div');
            newRow.className = 'item-row';
            newRow.innerHTML = `
                <label for="item">Choose Item:</label>
                <select name="parts[]" required>
                    <option value="">Select an item</option>
                    <?php
                    $sql = "SELECT PartID, PartName, PartDescription FROM Parts";
                    $result = $conn->query($sql);
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            $partName = htmlspecialchars($row['PartName']);
                            $partDescription = htmlspecialchars($row['PartDescription']);
                            echo "<option value='" . htmlspecialchars($row['PartID']) . "'>{$partName} - {$partDescription}</option>";
                        }
                    }
                    ?>
                </select>

                <label for="quantity">Quantity:</label>
                <input type="number" name="quantities[]" min="1" value="1" required>

                <button type="button" class="danger" onclick="removeItemRow(this)">Remove</button>
            `;
            container.appendChild(newRow);
        }

        function removeItemRow(button) {
            const container = document.getElementById('items-container');
            container.removeChild(button.parentElement);
        }
    </script>
</body>

</html>
