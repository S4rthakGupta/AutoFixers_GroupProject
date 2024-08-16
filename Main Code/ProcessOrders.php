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
    $this->SetTextColor(0, 0, 255); // Optional: Set title color to blue
    $this->Cell(0, 10, 'INVOICE', 0, 1, 'C');
    $this->Ln(10); // Add some space after the title

    // Add the logo image
    $this->Image('auto-logo.png', 10, 20, 30); // Adjust the x, y position, and size as needed

    // Set font for the company title "AUTO-FIXERS"
    $this->SetFont('Arial', 'B', 16);
    $this->SetTextColor(0, 0, 255); // Optional: Set color to blue
    $this->SetXY(50, 25); // Adjust based on image position and size
    $this->Cell(0, 10, 'AUTO-FIXERS', 0, 1, 'L'); // Align text to the left

    // Set font for the description
    $this->SetFont('Arial', '', 12);
    $this->SetTextColor(0, 0, 255); // Optional: Set color to blue
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
        $this->Cell(0, 3, 'Shakila Samaradiwakara 8886070 | Sarthak Gupta 8971797 |  8971294', 0, 1, 'C');
        
        // Page number
        $this->Cell(0, 10, 'Page ' . $this->PageNo() . '/{nb}', 0, 0, 'C');
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
        // Add the "BILL TO" title above the table
        $this->SetFont('Arial', 'B', 14);
        $this->SetTextColor(0, 0, 255); // Set text color to blue (RGB: 0, 0, 255)
        $this->Cell(0, 10, 'BILL TO', 0, 1, 'L');
        $this->Ln(5); // Add some space after the title
    
        // Set the font and colors for the table header
        $this->SetFont('Arial', 'B', 12);
        $this->SetFillColor(173, 216, 230); // Set fill color to light blue (RGB: 173, 216, 230)
        $this->SetTextColor(0, 0, 255); // Set text color to blue (RGB: 0, 0, 255)
    
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
        $this->Ln(10);
        $this->SetFont('Arial', 'B', 12);
        $this->SetTextColor(50, 50, 50);
        $this->Cell(0, 6, 'SUBTOTAL: $' . number_format($totals['Subtotal'], 2), 0, 1, 'R');
        $this->Cell(0, 6, 'TAX (13%): $' . number_format($totals['Tax'], 2), 0, 1, 'R');
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

// Add totals to PDF
$pdf->InvoiceTotals([
    'Subtotal' => $subtotal,
    'Tax' => $tax,
    'Total' => $total
]);

// Output PDF
$pdf->Output('I', 'Invoice_' . $orderID . '.pdf');

// Close database connection
$conn->close();
?>