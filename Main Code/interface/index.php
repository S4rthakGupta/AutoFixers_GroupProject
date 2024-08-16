<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="style.css" rel="stylesheet" >
    <title>Add/Edit Parts</title>
    <script>
        function fneditItem(itemId, itemName, trademark, description, price) {
            //This is where we will set the values of the form fields
            document.getElementById('hdnId').value = itemId;
            document.getElementById('editmodel').value = itemName;
            document.getElementById('editTrademark').value = trademark;
            document.getElementById('editdescription').value = description;
            document.getElementById('editprice').value = price;

            //Here we can show the hidden Edit form
            document.getElementById('edit-form').style.display = 'block';

            //Here we can disable the insert form
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
                <!-- FORM FOR INSERTING THE PRODUCT DETAILS -->
                <label for="model">Part Name:</label>
                <input type="text" id="model" name="model" placeholder="Enter item name" required>
    
                <label for="trademark">Trademark:</label>
                <input type="text" id="trademark" name="trademark" placeholder="Enter trademark name" required>
    
                <label for="description">Part Description:</label>
                <input type="text" id="description" name="description" placeholder="Enter the description" required>
    
                <label for="price">Price:</label>
                <input type="number" id="price" name="price" step="0.01" placeholder="Enter price" required>
    
                <button id="submit-button" class="submit-btn" type="submit">Submit</button>
                
            </form>
            <!-- FORM FOR UPDATING THE PRODUCT DETAILS -->
            <form class="responsive-form" style="display: none" id="edit-form" action="../UpdateItem.php" method="post">
                <h2>Edit Part Details</h2>
                
                <label for="model">Part Name:</label>
                <input type="text" id="editmodel" name="editmodel" placeholder="Enter item name" required>
    
                <label for="trademark">Trademark:</label>
                <input type="text" id="editTrademark" name="editTrademark" placeholder="Enter trademark name" required>
    
                <label for="description">Part Description:</label>
                <input type="text" id="editdescription" name="editdescription" placeholder="Enter the description" required>
    
                <label for="price">Price:</label>
                <input type="number" id="editprice" name="editprice" step="0.01" placeholder="Enter price" required>
    
                <button type="submit" class="submit-btn" id="edit-button">Edit</button>
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
                    <!-- HERE WE ARE FETCHING THE DATA FROM THE DATABASE-->
                    <?php include '../GetItems.php'; ?>
                </tbody>
            </table>
        </div>
    </main>

    <footer class="footer">
        <div class="footer-content">
            <div class="footer-section about">
                <h2>About</h2>
                <a href="index.html" class="logo">Auto<span class="logo-span">Fixers</span></a>
                <p>is dedicated to providing an exceptional car service experience</p>
            </div>
            <!-- Here are the links which are same as navba - FOR CONSISTENCY -->
            <div class="footer-section links">
                <h2>Quick Links</h2>
                <ul>
                    <li><a href="index.php">Product Data</a></li>
                    <li><a href="customers.php">Customer Information</a></li>
                    <li><a href="invoice_pdf.php">Invoice Generation</a></li>
                </ul>
            </div>

            <div class="footer-section contact">
            <h2>Group Members</h2>
                <p>Shakila Samaradiwakara 8886070</p>
                <p>Sarthak Gupta 8971797</p>
                <p>Abhishek Chachad 8971294</p>

            </div>
        </div>
        <!-- FOOTER SECTION -->
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