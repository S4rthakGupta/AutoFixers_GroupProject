<?php
require('fpdf184/fpdf.php');
include 'db_connect.php';

// Start output buffering
ob_start();

// Retrieve selected customer from POST data
$customer_id = isset($_POST['customer']) ? $_POST['customer'] : null;

// Check if customer_id is provided
if (!$customer_id) {
    die('Customer ID is required.');
}

// Fetch customer details
$sql = "SELECT name, email, phone_number FROM Customers WHERE customer_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $customer_id);
$stmt->execute();
$stmt->bind_result($customerName, $customerEmail, $customerPhone);
$stmt->fetch();
$stmt->close();

// Check if customer details were fetched
if (!$customerName) {
    die('Customer not found.');
}

// Initialize FPDF
$pdf = new FPDF();
$pdf->AddPage();

// Set Title
$pdf->SetFont('Arial', 'B', 16);
$pdf->SetTextColor(0, 102, 204); // Blue color
$pdf->Cell(0, 10, 'Customer Details', 0, 1, 'C');
$pdf->Ln(10);

// Set font for details
$pdf->SetFont('Arial', '', 12);
$pdf->SetTextColor(0, 0, 0); // Black color

// Calculate width and height for centered box
$pageWidth = $pdf->GetPageWidth();
$boxWidth = 180; // Width of the border box
$boxHeight = 60; // Height of the border box

// Center the box on the page
$x = ($pageWidth - $boxWidth) / 2;
$y = $pdf->GetY() + 10; // Start the box a bit lower from the top

// Draw border box
$pdf->SetDrawColor(0, 0, 0); // Black border
$pdf->Rect($x, $y, $boxWidth, $boxHeight); // Draw the rectangle

// Add customer details inside the box
$pdf->SetXY($x, $y + 10); // Set position inside the box with padding

// Center-align the text
$pdf->Cell($boxWidth, 10, "Customer:", 0, 1, 'C');
$pdf->Cell($boxWidth, 10, $customerName, 0, 1, 'C');
$pdf->Ln(5);

$pdf->Cell($boxWidth, 10, "Email:", 0, 1, 'C');
$pdf->Cell($boxWidth, 10, $customerEmail, 0, 1, 'C');
$pdf->Ln(5);

$pdf->Cell($boxWidth, 10, "Phone:", 0, 1, 'C');
$pdf->Cell($boxWidth, 10, $customerPhone, 0, 1, 'C');

// Clean the output buffer and output the PDF
ob_end_clean();
$pdf->Output('D', 'Customer_Details.pdf');

// Close database connection
$conn->close();
?>
