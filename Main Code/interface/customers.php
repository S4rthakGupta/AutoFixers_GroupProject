<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="style.css" rel="stylesheet" >
    <title>Add/Edit Customers</title>
    <script>
        function fneditCustomer(customerId, name, email, phone) {
            // Set the values of the form fields
            document.getElementById('editId').value = customerId;
            document.getElementById('editname').value = name;
            document.getElementById('editemail').value = email;
            document.getElementById('editphone').value = phone;

            // Show the hidden Edit form
            document.getElementById('edit-form').style.display = 'block';

            // Hide the insert form
            document.getElementById('insert-form').style.display = 'none';
        }
    </script>
</head>
<body>
    <header class="header">
        <a href="index.html" class="logo">Auto<span class="logo-span">Fixers</span></a>

        <nav class="navbar">
            <a href="index.php" data-index="1">Product Data</a>
            <a href="customers.php" class="active" data-index="2" > Customer Information</a>
            <a href="invoice_pdf.php" data-index="3">Invoice Generation (PDF)</a>
            <button onclick="toggleFontSize()">Default Font Size: Medium</button>
            </nav>
    </header>
        
        
       

    <main>
        <div class="banner">
            <p>Auto Fixers</p>
        </div>
        <div class="formProduct">
            <form class="responsive-form" id="insert-form" action="../save_customer.php" method="post">
                <h2>Enter Customer Details</h2>
    
                <label for="name">Customer Name:</label>
                <input type="text" id="name" name="name" placeholder="Enter customer name" required>
    
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" placeholder="Enter email id" required>
    
                <label for="phone">Phone number:</label>
                <input type="text" id="phone" name="phone" placeholder="Enter the phone number" required>
    
                <button class="success" type="submit">Submit</button>
            </form>

            <form class="responsive-form" id="edit-form" action="../edit_customer.php" method="post" style="display: none;">
                <h2>Edit Customer Details</h2>
                
                <label for="editname">Customer Name:</label>
                <input type="text" id="editname" name="editname" placeholder="Enter customer name" required>
    
                <label for="editemail">Email:</label>
                <input type="email" id="editemail" name="editemail" placeholder="Enter email id" required>
    
                <label for="editphone">Phone number:</label>
                <input type="text" id="editphone" name="editphone" placeholder="Enter the phone number" required>
    
                <button class="primary" type="submit">Edit</button>
                <input type="hidden" id="editId" name="editId">
            </form>
        </div>
        <div class="ListData">
            <table class="responsive-table">
                <thead>
                    <tr>
                        <th>Customer Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Fetch data from mysql table -->
                    <?php include '../fetch_customers.php'; ?>
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
