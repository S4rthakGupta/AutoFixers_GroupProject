<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="style.css" rel="stylesheet">
    <title>Select Customer</title>
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
            <p>Computer Store</p>
        </div>
        <div class="formProduct">
            <form action="../generate_pdf.php" method="post" class="responsive-form">
                <h2>Select Customer</h2>

                <label for="customer">Choose Customer:</label>
                <select id="customer" name="customer" required>
                    <option value="">Select a customer</option>
                    <?php
                    // Include database connection
                    include '../db_connect.php';

                    // Fetch customer data
                    $sql = "SELECT customer_id, name FROM Customers";
                    $result = $conn->query($sql);

                    // Check if any results were returned
                    if ($result->num_rows > 0) {
                        // Loop through each customer and create an option for the dropdown
                        while ($row = $result->fetch_assoc()) {
                            $customerId = htmlspecialchars($row['customer_id']);
                            $customerName = htmlspecialchars($row['name']);
                            echo "<option value='$customerId'>$customerName</option>";
                        }
                    } else {
                        // If no customers are found, display a default message
                        echo "<option value=''>No customers available</option>";
                    }
                    
                    // Close database connection
                    $conn->close();
                    ?>
                </select>

                <button type="submit">Generate PDF</button>
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
</body>
</html>
