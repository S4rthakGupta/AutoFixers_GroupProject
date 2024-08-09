<?php
// Include database connection
include 'dbconnect.php';

// Include PDF generation library (e.g., FPDF)
require 'fpdf184/fpdf.php';

// Get form data
$customerID = $_POST['customer'];
$items = $_POST['items'];
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
foreach ($items as $index => $itemID) {
    $quantity = $quantities[$index];
    $stmt = $conn->prepare("INSERT INTO OrderedItems (OrderID, ItemID, Quantity) VALUES (?, ?, ?)");
    $stmt->bind_param("iii", $orderID, $itemID, $quantity);
    $stmt->execute();
    $stmt->close();

    // Calculate total price
    $stmt = $conn->prepare("SELECT Price FROM Items WHERE ItemID = ?");
    $stmt->bind_param("i", $itemID);
    $stmt->execute();
    $stmt->bind_result($price);
    $stmt->fetch();
    $totalPrice += $price * $quantity;
    $stmt->close();
}

// Generate PDF
class PDF extends FPDF
{
    // Page header
    function Header()
    {
        $this->SetFont('Arial', 'B', 12);
        $this->Cell(0, 10, 'Invoice', 0, 1, 'C');
        $this->Ln(10);
    }

    // Page footer
    function Footer()
    {
        $this->SetY(-15);
        $this->SetFont('Arial', 'I', 8);
        $this->Cell(0, 10, 'Page ' . $this->PageNo() . '/{nb}', 0, 0, 'C');
    }

    // Invoice header
    function InvoiceHeader($customer)
    {
        $this->SetFont('Arial', '', 12);
        $this->Cell(0, 6, 'BILLED TO', 0, 1);
        $this->Cell(0, 6, $customer['CustomerName'], 0, 1);
        $this->Cell(0, 6, $customer['Email'], 0, 1);
        $this->Cell(0, 6, $customer['Phone'], 0, 1);
        $this->Ln(10);
    }

    // Invoice details
    function InvoiceDetails($invoice)
    {
        $this->SetFont('Arial', '', 12);
        $this->Cell(0, 6, 'INVOICE NUMBER: ' . $invoice['OrderID'], 0, 1);
        $this->Cell(0, 6, 'DATE OF ISSUE: ' . $invoice['OrderDate'], 0, 1);
        $this->Ln(10);
    }

    // Table header

    function TableHeader()
    {
        $this->SetFont('Arial', 'B', 12);
        $this->Cell(30, 7, 'ITEM NAME', 1);
        $this->Cell(70, 7, 'DESCRIPTION', 1);
        $this->Cell(25, 7, 'UNIT COST', 1);
        $this->Cell(15, 7, 'QTY', 1);
        $this->Cell(25, 7, 'UNIT PRICE', 1);
        $this->Cell(30, 7, 'AMOUNT', 1);
        $this->Ln();
    }

    // Table row
    function TableRow($item)
    {
        $this->SetFont('Arial', '', 12);
        
        // Calculate the height of the ItemDescription column
        $nb = $this->NbLines(70, $item['ItemDescription']);
        $rowHeight = 6 * $nb;
        
        // Print cells with the same height
        $this->Cell(30, $rowHeight, $item['ItemName'], 1);
        
        $x = $this->GetX();
        $y = $this->GetY();
        $this->MultiCell(70, 6, $item['ItemDescription'], 1);
        $this->SetXY($x + 70, $y);
        
        $this->Cell(25, $rowHeight, '$' . number_format($item['Price'], 2), 1, 0, 'R');
        $this->Cell(15, $rowHeight, $item['Quantity'], 1, 0, 'C');
        $this->Cell(25, $rowHeight, '$' . number_format($item['Price'], 2), 1, 0, 'R');
        $this->Cell(30, $rowHeight, '$' . number_format($item['Total'], 2), 1, 0, 'R');
        $this->Ln($rowHeight);
    }


    //source: http://www.fpdf.org/en/script/script3.php:
    
    function NbLines($w, $txt)
    {
        // Compute the number of lines a MultiCell of width w will take
        if(!isset($this->CurrentFont))
            $this->Error('No font has been set');
        $cw = $this->CurrentFont['cw'];
        if($w==0)
            $w = $this->w-$this->rMargin-$this->x;
        $wmax = ($w-2*$this->cMargin)*1000/$this->FontSize;
        $s = str_replace("\r",'',(string)$txt);
        $nb = strlen($s);
        if($nb>0 && $s[$nb-1]=="\n")
            $nb--;
        $sep = -1;
        $i = 0;
        $j = 0;
        $l = 0;
        $nl = 1;
        while($i<$nb)
        {
            $c = $s[$i];
            if($c=="\n")
            {
                $i++;
                $sep = -1;
                $j = $i;
                $l = 0;
                $nl++;
                continue;
            }
            if($c==' ')
                $sep = $i;
            $l += $cw[$c];
            if($l>$wmax)
            {
                if($sep==-1)
                {
                    if($i==$j)
                        $i++;
                }
                else
                    $i = $sep+1;
                $sep = -1;
                $j = $i;
                $l = 0;
                $nl++;
            }
            else
                $i++;
        }
        return $nl;
    }


    // Invoice totals
    function InvoiceTotals($totals)
    {
        $this->Ln(10);
        $this->SetFont('Arial', '', 12);
        $this->Cell(0, 6, 'SUBTOTAL: $' . number_format($totals['subtotal'], 2), 0, 1, 'R');
        $this->Cell(0, 6, 'TAX: $' . number_format($totals['tax'], 2), 0, 1, 'R');
        $this->Cell(0, 6, 'TOTAL: $' . number_format($totals['total'], 2), 0, 1, 'R');
    }
}

// Fetch customer data
$customerID = $_POST['customer'];
$customerQuery = "SELECT * FROM Customers WHERE CustomerID = ?";
$customerStmt = $conn->prepare($customerQuery);
$customerStmt->bind_param("i", $customerID);
$customerStmt->execute();
$customerResult = $customerStmt->get_result();
$customer = $customerResult->fetch_assoc();

// Fetch order data
$orderQuery = "SELECT * FROM Orders WHERE OrderID = ?";
$orderStmt = $conn->prepare($orderQuery);
$orderStmt->bind_param("i", $orderID);
$orderStmt->execute();
$orderResult = $orderStmt->get_result();
$order = $orderResult->fetch_assoc();

// Fetch ordered items data
$itemsQuery = "SELECT i.ItemName, i.ItemDescription, i.Price, oi.Quantity, (i.Price * oi.Quantity) AS Total 
               FROM OrderedItems oi 
               JOIN Items i ON oi.ItemID = i.ItemID 
               WHERE oi.OrderID = ?";
$itemsStmt = $conn->prepare($itemsQuery);
$itemsStmt->bind_param("i", $orderID);
$itemsStmt->execute();
$itemsResult = $itemsStmt->get_result();

// Calculate totals
$subtotal = 0;
while ($item = $itemsResult->fetch_assoc()) {
    $subtotal += $item['Total'];
}
$taxRate = 0.13; // Example tax rate
$tax = $subtotal * $taxRate;
$total = $subtotal + $tax;

$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->InvoiceHeader($customer);
$pdf->InvoiceDetails($order);
$pdf->TableHeader();
$itemsResult->data_seek(0); // Reset pointer to the beginning
while ($item = $itemsResult->fetch_assoc()) {
    $pdf->TableRow($item);
}
$pdf->InvoiceTotals(['subtotal' => $subtotal, 'tax' => $tax, 'total' => $total]);

$pdf->Output();
?>
