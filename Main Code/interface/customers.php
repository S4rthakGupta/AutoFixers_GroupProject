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
    <header>
        <div class="storeLogo">
            <img src="../storelogo.jpg" alt="Logo - Auto Fixers">
            <span>Auto Fixers Shop</span>
        </div>
        <ul>
            <li><a href="index.php">Product Details</a></li>
            <li><a href="customers.php">Customer Details</a></li>
            <li><a href="generatepdf.php">Bill Generation(PDF)</a></li>
            <button class="font" onclick="toggleFontSize()">Default Font Size: Medium</button>
        </ul>
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
