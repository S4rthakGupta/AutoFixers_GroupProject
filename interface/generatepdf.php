<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="style.css" rel="stylesheet">
    <title>PDF Generation</title>
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
                <h2>Generate PDF Report</h2>

                <label for="report-type">Select Report Type:</label>
                <select id="report-type" name="report_type" required>
                    <option value="">Select a report type</option>
                    <option value="sales">Sales Report</option>
                    <option value="inventory">Inventory Report</option>
                </select>

                <label for="date-range">Date Range:</label>
                <input type="text" id="date-range" name="date_range" placeholder="e.g., 2024-01-01 to 2024-12-31" required>

                <button type="submit">Generate PDF</button>
            </form>
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
            <p>Copyright 2024. All rights reserved</p>
        </div>
    </footer>
</body>
</html>