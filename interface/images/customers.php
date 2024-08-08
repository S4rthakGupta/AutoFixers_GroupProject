<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="style.css" rel="stylesheet" >
    <title>Document</title>
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
        <a>LOGO</a>
        <ul>
            <li><a href="index.php">Home</a></li>
            <li><a href="generatepdf.php">PDF Generation</a></li>
            <li><a href="customers.php">Customer Details</a></li>
        </ul>
    </header>
    <main>
        <div class="banner">
            <p>Customer Details</p>
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
    
                <button type="submit">Submit</button>
            </form>

            <form class="responsive-form" id="edit-form" action="../edit_customer.php" method="post" style="display: none;">
                <h2>Edit Customer Details</h2>
                
                <label for="editname">Customer Name:</label>
                <input type="text" id="editname" name="editname" placeholder="Enter customer name" required>
    
                <label for="editemail">Email:</label>
                <input type="email" id="editemail" name="editemail" placeholder="Enter email id" required>
    
                <label for="editphone">Phone number:</label>
                <input type="text" id="editphone" name="editphone" placeholder="Enter the phone number" required>
    
                <button type="submit">Edit</button>
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
                <li>Susmi Rani</li>
                <li></li>
            </ul>
            <ul>
                <li>Mandar</li>
                <li></li>
            </ul>
            <ul>
                <li>Druvin</li>
                <li></li>
            </ul>
        </div>
        <div class="copyright">
            <p>Copyright 2024.All rights reserved</p>
        </div>
    </footer>
</body>
</html>
