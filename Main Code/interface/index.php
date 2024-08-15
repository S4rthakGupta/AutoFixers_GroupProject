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
<header class="header">
        <a href="index.html" class="logo">Auto<span class="logo-span">Fixers</span></a>

        <nav class="navbar">
            <a href="index.php" class="active" data-index="1">Product Data</a>
            <a href="customers.php" data-index="2" > Customer Information</a>
            <a href="invoice_pdf.php" data-index="3">Invoice Generation (PDF)</a>
            <button class="font" onclick="toggleFontSize()">Default Font Size: Medium</button>
            </nav>
    </header>
    <main>
        <div class="banner">
            <p>Auto Fixers</p>
        </div>
        <div class="formProduct">
            <form class="responsive-form" id="insert-form" action="../SaveItems.php" method="post">
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

            <form class="responsive-form" style="display: none" id="edit-form" action="../UpdateItem.php" method="post">
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
                    <?php include '../GetItems.php'; ?>
                </tbody>
            </table>
        </div>
    </main>

    <footer class="footer">
        <div class="footer-content">
            <div class="footer-section about">
                <h2>About</h2>
                <!-- It has the same logo as the navbar but with a different colour. -->
                <a href="index.html" class="logo">Auto<span class="logo-span">Fixers</span></a>
                <p>is dedicated to providing an exceptional car service experience</p>
            </div>
            <!-- These are the links which are same as navbar. -->
            <div class="footer-section links">
                <h2>Quick Links</h2>
                <ul>
                    <li><a href="index.php">Product Data</a></li>
                    <li><a href="customers.php">Customer Information</a></li>
                    <li><a href="invoice_pdf.php">Invoice Generation</a></li>
                </ul>
            </div>

            <div class="footer-section contact">
                <h2>Contact Us</h2>
                <p><i class="fas fa-phone-alt"></i> +1 365-456-7890</p>
                <p><i class="fas fa-envelope"></i> info@cardeals.com</p>
            </div>
        </div>
        <!-- A copyright mark and a text on the footer. -->
        <div class="footer-bottom">
            &copy; 2024 Auto-Fixers | All Rights Reserved
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