<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="style.css" rel="stylesheet" >
    <title>Add/Edit Parts</title>
    <script>
        function fneditItem(itemId, itemName, brand, description, price) {
            // Set the values of the form fields
            document.getElementById('hdnId').value = itemId;
            document.getElementById('editmodel').value = itemName;
            document.getElementById('editbrand').value = brand;
            document.getElementById('editdescription').value = description;
            document.getElementById('editprice').value = price;

            // Show the hidden Edit form
            document.getElementById('edit-form').style.display = 'block';

            // Disable the insert form
            document.getElementById('insert-form').style.display = 'none';
        }

    </script>
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
            <form class="responsive-form" id="insert-form" action="../save_item.php" method="post">
                <h2>Insert Part Details</h2>
    
                <label for="model">Part Name:</label>
                <input type="text" id="model" name="model" placeholder="Enter item name" required>
    
                <label for="brand">Trademark:</label>
                <input type="text" id="brand" name="brand" placeholder="Enter brand name" required>
    
                <label for="description">Part Description:</label>
                <input type="text" id="description" name="description" placeholder="Enter the description" required>
    
                <label for="price">Price:</label>
                <input type="number" id="price" name="price" step="0.01" placeholder="Enter price" required>
    
                <button id="submit-button" class="success" type="submit">Submit</button>
                
            </form>

            <form class="responsive-form" style="display: none" id="edit-form" action="../edit_item.php" method="post">
                <h2>Edit Part Details</h2>
                
                <label for="model">Part Name:</label>
                <input type="text" id="editmodel" name="editmodel" placeholder="Enter item name" required>
    
                <label for="brand">Trademark:</label>
                <input type="text" id="editbrand" name="editbrand" placeholder="Enter brand name" required>
    
                <label for="description">Part Description:</label>
                <input type="text" id="editdescription" name="editdescription" placeholder="Enter the description" required>
    
                <label for="price">Price:</label>
                <input type="number" id="editprice" name="editprice" step="0.01" placeholder="Enter price" required>
    
                <button type="submit" class="primary" id="edit-button">Edit</button>
                <input style="visibility: hidden;" type="text" id="hdnId" name="hdnId">
            </form>
        </div>
        <div class="ListData">
            <table class="responsive-table">
                <thead>
                    <tr>
                        <th>Part Name</th>
                        <th>Trademark</th>
                        <th>Part Description</th>
                        <th>Price</th>
                        <th>Modify</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Fetch data from mysql table -->
                    <?php include '../fetch_items.php'; ?>
                </tbody>
            </table>
        </div>
    </main>

    <footer>
        <div class="footerDiv">
            <ul>
                <li>Sarthak Gupta</li>
                <li></li>
            </ul>
            <ul>
                <li>Abhishek Chachad</li>
                <li></li>
            </ul>
            <ul>
                <li>Shakila Samardiwakara</li>
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
            document.querySelector('button').innerText = `Font Size: ${fontSizes[fontSizeIndex]}`;
        }
    </script>
</body>
</html>