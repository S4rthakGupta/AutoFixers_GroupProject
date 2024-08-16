<?php

// Include database connection
include 'ConnectDB.php';

// Include PDF generation library (e.g., FPDF)
require 'fpdf184/fpdf.php';

// Get form data
$customerID = $_POST['customer'];
$parts = $_POST['parts'];
$quantities = $_POST['quantities'];

// Fetch customer name
$stmt = $conn->prepare("SELECT CustomerName FROM Customers WHERE CustomerID = ?");
$stmt->bind_param("i", $customerID);
$stmt->execute();
$stmt->bind_result($customerName);
$stmt->fetch();
$stmt->close();

// Insert order into Orders table
$orderDate = date('Y-m-d');
$stmt = $conn->prepare("INSERT INTO Orders (OrderDate, CustomerID) VALUES (?, ?)");
$stmt->bind_param("si", $orderDate, $customerID);
$stmt->execute();
$orderID = $stmt->insert_id;
$stmt->close();

// Insert ordered items into OrderedItems table
$totalPrice = 0;
foreach ($parts as $index => $partID) {
    $quantity = $quantities[$index];
    $stmt = $conn->prepare("INSERT INTO OrderedParts (OrderID, PartID, Quantity) VALUES (?, ?, ?)");
    $stmt->bind_param("iii", $orderID, $partID, $quantity);
    $stmt->execute();
    $stmt->close();

    // Calculate total price
    $stmt = $conn->prepare("SELECT Price FROM Parts WHERE PartID = ?");
    $stmt->bind_param("i", $partID);
    $stmt->execute();
    $stmt->bind_result($price);
    $stmt->fetch();
    $totalPrice += $price * $quantity;
    $stmt->close();
}

// Generate PDF
class PDF extends FPDF
{
   // Add a logo at the top
   function AddLogo()
{
    // Set font for the title "INVOICE"
    $this->SetFont('Arial', 'B', 20);
    $this->SetTextColor(0, 0, 0); // Optional: Set title color to blue
    $this->Cell(0, 10, 'INVOICE', 0, 1, 'C');
    $this->Ln(10); // Add some space after the title

    // Add the logo image
    $this->Image('auto-logo.png', 10, 20, 30); // Adjust the x, y position, and size as needed

// Set font for the company title "AUTO-FIXERS"
$this->SetFont('Arial', 'B', 24); // Larger font size and bold
$this->SetTextColor(204, 153, 102); // Optional: Set color to blue
$this->SetXY(50, 25); // Adjust based on image position and size
$this->Cell(0, 15, 'AUTO-FIXERS', 0, 1, 'L'); // Align text to the left with larger height


    // Set font for the description
    $this->SetFont('Arial', '', 12);
    $this->SetTextColor(0, 0, 0); // Optional: Set color to blue
    $this->SetXY(50, 35); // Adjust based on title position
    $this->MultiCell(0, 5, 'We will fix whatever you need! We will provide the best service.', 0, 'L');

    // Move cursor down for spacing after the logo and text
    $this->Ln(20);
}

   

    // Page footer
    function Footer()
    {
        // Position at 1.5 cm from bottom
        $this->SetY(-15);
        
        // Set font
        $this->SetFont('Arial', 'I', 8);
        
        // Footer text (Names and IDs)
        $this->Cell(0, 3, 'Shakila Samaradiwakara 8886070 | Sarthak Gupta 8971797 | Abhishek Chachad 8971294', 0, 1, 'C');
        
        // Page number
        $this->Cell(0, 10, 'Page ' . $this->PageNo() . '', 0, 0, 'C');
    }

    // Invoice header
    function InvoiceHeader($customer)
    {
        $this->SetFont('Arial', '', 12);
        $this->SetTextColor(50, 50, 50);
        $this->Cell(0, 6, 'BILLED TO:', 0, 1);
        $this->SetFont('Arial', 'B', 12);
        $this->Cell(0, 6, $customer['CustomerName'], 0, 1);
        $this->SetFont('Arial', '', 12);
        $this->Cell(0, 6, $customer['Email'], 0, 1);
        $this->Cell(0, 6, $customer['Phone'], 0, 1);
        $this->Ln(10);
    }

    // Invoice details
    function InvoiceDetails($invoice)
    {
        $this->SetFont('Arial', 'B', 12);
        $this->SetTextColor(100, 100, 100);
        $this->Cell(0, 6, 'INVOICE NUMBER: ' . $invoice['OrderID'], 0, 1);
        $this->Cell(0, 6, 'DATE OF ISSUE: ' . $invoice['OrderDate'], 0, 1);
        $this->Ln(10);
    }

    // Table header
    function TableHeader()
{
    // Add the "ITEM DETAILS" title above the table
    $this->SetFont('Arial', 'B', 14);
    $this->SetTextColor(0, 0, 0); // Set text color to black (RGB: 0, 0, 0)
    $this->Cell(0, 10, 'ITEM DETAILS :', 0, 1, 'L');
    $this->Ln(5); // Add some space after the title

    // Set the font and colors for the table header
    $this->SetFont('Arial', 'B', 12);
    $this->SetFillColor(255, 204, 153); // Set fill color to light orange (RGB: 255, 204, 153)
    $this->SetTextColor(0, 0, 0); // Set text color to black (RGB: 0, 0, 0)

    // Table headers
    $this->Cell(30, 7, 'ITEM NAME', 1, 0, 'C', true);
    $this->Cell(70, 7, 'DESCRIPTION', 1, 0, 'C', true);
    $this->Cell(25, 7, 'UNIT COST', 1, 0, 'C', true);
    $this->Cell(15, 7, 'QTY', 1, 0, 'C', true);
    $this->Cell(25, 7, 'UNIT PRICE', 1, 0, 'C', true);
    $this->Cell(30, 7, 'AMOUNT', 1, 0, 'C', true);
    $this->Ln();
}

// Table row
function TableRow($item)
{
    $this->SetFont('Arial', '', 12);
    
    // Calculate the height of the ItemDescription column
    $nb = $this->NbLines(70, $item['PartDescription']);
    $rowHeight = 6 * $nb;
    
    // Print cells with the same height
    $this->Cell(30, $rowHeight, $item['PartName'], 1);
    
    $x = $this->GetX();
    $y = $this->GetY();
    $this->MultiCell(70, 6, $item['PartDescription'], 1);
    $this->SetXY($x + 70, $y);
    
    $this->Cell(25, $rowHeight, '$' . number_format($item['Price'], 2), 1, 0, 'R');
    $this->Cell(15, $rowHeight, $item['Quantity'], 1, 0, 'C');
    $this->Cell(25, $rowHeight, '$' . number_format($item['Price'], 2), 1, 0, 'R');
    $this->Cell(30, $rowHeight, '$' . number_format($item['Total'], 2), 1, 0, 'R');
    $this->Ln($rowHeight);
}


    // Calculate number of lines needed for text
    function NbLines($w, $txt)
    {
        if (!isset($this->CurrentFont)) {
            $this->Error('No font has been set');
        }
        $cw = $this->CurrentFont['cw'];
        if ($w == 0) {
            $w = $this->w - $this->rMargin - $this->x;
        }
        $wmax = ($w - 2 * $this->cMargin) * 1000 / $this->FontSize;
        $s = str_replace("\r", '', (string)$txt);
        $nb = strlen($s);
        if ($nb > 0 && $s[$nb - 1] == "\n") {
            $nb--;
        }
        $sep = -1;
        $i = 0;
        $j = 0;
        $l = 0;
        $nl = 1;
        while ($i < $nb) {
            $c = $s[$i];
            if ($c == "\n") {
                $i++;
                $sep = -1;
                $j = $i;
                $l = 0;
                $nl++;
                continue;
            }
            if ($c == ' ') {
                $sep = $i;
            }
            $l += $cw[$c];
            if ($l > $wmax) {
                if ($sep == -1) {
                    if ($i == $j) {
                        $i++;
                    }
                } else {
                    $i = $sep + 1;
                }
                $sep = -1;
                $j = $i;
                $l = 0;
                $nl++;
            } else {
                $i++;
            }
        }
        return $nl;
    }

    // Invoice totals
    function InvoiceTotals($totals)
{
    $this->Ln(10); // Add space before totals
    $this->SetFont('Arial', 'B', 12);
    $this->SetTextColor(50, 50, 50);

    // Define line length and right margin
    $lineLength = 60; // Shorter length of the line
    $rightMargin = 10; // Right margin from the edge of the page

    // Get page width and calculate x start and end positions
    $pageWidth = $this->GetPageWidth();
    $xEnd = $pageWidth - $rightMargin;
    $xStart = $xEnd - $lineLength;

    // Display subtotal
    $this->Cell(0, 6, 'SUBTOTAL: $' . number_format($totals['Subtotal'], 2), 0, 1, 'R');
    $this->Ln(2); // Add a small space after the row
    $this->Line($xStart, $this->GetY(), $xEnd, $this->GetY()); // Draw a line

    // Display discount
    $this->Ln(5); // Add space before discount
    $this->Cell(0, 6, 'DISCOUNT: $' . number_format($totals['Discount'], 2), 0, 1, 'R');
    $this->Ln(2); // Add a small space after the row
    $this->Line($xStart, $this->GetY(), $xEnd, $this->GetY()); // Draw a line

    // Display subtotal less discount
    $this->Ln(5); // Add space before subtotal less discount
    $this->Cell(0, 6, 'SUBTOTAL LESS DISCOUNT: $' . number_format($totals['SubtotalLessDiscount'], 2), 0, 1, 'R');
    $this->Ln(2); // Add a small space after the row
    $this->Line($xStart, $this->GetY(), $xEnd, $this->GetY()); // Draw a line

    // Display shipping/landing
    $this->Ln(5); // Add space before shipping/landing
    $this->Cell(0, 6, 'SHIPPING/LANDING: $' . number_format($totals['Shipping'], 2), 0, 1, 'R');
    $this->Ln(2); // Add a small space after the row
    $this->Line($xStart, $this->GetY(), $xEnd, $this->GetY()); // Draw a line

    // Display tax
    $this->Ln(5); // Add space before tax
    $this->Cell(0, 6, 'TAX (13%): $' . number_format($totals['Tax'], 2), 0, 1, 'R');
    $this->Ln(2); // Add a small space after the row
    $this->Line($xStart, $this->GetY(), $xEnd, $this->GetY()); // Draw a line

    // Display total
    $this->Ln(5); // Add space before total
    $this->Cell(0, 6, 'TOTAL: $' . number_format($totals['Total'], 2), 0, 1, 'R');
}

    
    
}

// Initialize PDF
$pdf = new PDF();
$pdf->AddPage();
$pdf->AddLogo();

// Fetch customer info
$stmt = $conn->prepare("SELECT * FROM Customers WHERE CustomerID = ?");
$stmt->bind_param("i", $customerID);
$stmt->execute();
$result = $stmt->get_result();
$customer = $result->fetch_assoc();
$stmt->close();

// Fetch order details
$itemsQuery = "SELECT 
                p.PartName, 
                p.PartDescription, 
                p.Price, 
                op.Quantity, 
                (op.Quantity * p.Price) AS Total 
              FROM OrderedParts op 
              JOIN Parts p ON op.PartID = p.PartID 
              WHERE op.OrderID = ?";
$stmt = $conn->prepare($itemsQuery);
$stmt->bind_param("i", $orderID);
$stmt->execute();
$result = $stmt->get_result();

// Generate PDF
$pdf->InvoiceHeader($customer);
$pdf->InvoiceDetails(['OrderID' => $orderID, 'OrderDate' => $orderDate]);

// Table header
$pdf->TableHeader();

// Initialize totals
$subtotal = 0;

// Fetch and add items
while ($item = $result->fetch_assoc()) {
    $subtotal += $item['Total'];
    $pdf->TableRow($item);
}

// Calculate tax and total
$tax = $subtotal * 0.13;
$total = $subtotal + $tax;
$discount = 0; // You can adjust this value or fetch it from your data
$subtotalLessDiscount = 0;
$shipping = 10; // Example value, adjust or fetch from your data

// Add totals to PDF
$pdf->InvoiceTotals([
    'Subtotal' => $subtotal,
    'Discount' => $discount,
    'subtotalLessDiscount' => $subtotalLessDiscount,
    'shipping' => $shipping,
    'Tax' => $tax,
    'Total' => $total
]);

// Output PDF
$pdf->Output('I', 'Invoice_' . $orderID . '.pdf');

// Close database connection
$conn->close();
?>