<?php
include 'config.php';
require_once('fpdf/fpdf.php');
require_once('fpdf_rotate.php'); // Include the rotation class

// Generate the PDF
$pdf = new PDF_Rotate(); // Use PDF_Rotate class instead of FPDF
$pdf->AddPage();

// Set the watermark (company name)
$pdf->SetFont('Arial', 'B', 50);
$pdf->SetTextColor(200, 200, 200); // Light gray color for watermark

// Rotate the watermark text
$pdf->Rotate(45, 105, 150); // Rotate text at specified coordinates
$pdf->Text(60, 120, 'Aqua Bore Tech'); // Watermark text

$pdf->ResetRotation(); // Reset rotation after watermark

// Set the content theme (light theme)
$pdf->SetFont('Arial', '', 12);
$pdf->SetTextColor(0, 0, 0); // Black text for content

// Retrieve customer and product data from the form submission
$customerName = $_POST['customerName'];
$customerAddress = $_POST['customerAddress'];
$customerPhone = $_POST['customerPhone'];
$customerEmail = $_POST['customerEmail'];
$productIds = $_POST['productId'];
$quantities = $_POST['quantity'];

// Prepare product details for the PDF
$productDetails = [];
$totalAmount = 0;

foreach ($productIds as $index => $productId) {
    $quantity = $quantities[$index];
    $productId = intval($productId);  // Sanitize input

    // Fetch product details from the database
    $stmt = $conn->prepare("SELECT name, price FROM products WHERE id = ?");
    $stmt->bind_param("i", $productId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        $amount = $row['price'] * $quantity;
        $totalAmount += $amount;

        $productDetails[] = [
            'name' => $row['name'],
            'price' => $row['price'],
            'quantity' => $quantity,
            'amount' => $amount
        ];
    }
    $stmt->close();
}

$conn->close();

// Title and Customer Info
$pdf->SetFont('Arial', 'B', 14);
$pdf->Cell(190, 10, 'Quotation', 0, 1, 'C');
$pdf->Ln(5);

$pdf->SetFont('Arial', '', 12);
$pdf->Cell(90, 10, 'Company Name: Aqua Bore Tech', 0, 0);
$pdf->Cell(0, 10, 'Customer Details', 0, 1, 'R');
$pdf->SetFont('Arial', '', 11);
$pdf->Cell(90, 10, 'Address: G.I.D.C MHESANA GUJARAT', 0, 0);
$pdf->Cell(0, 10, 'Name: ' . htmlspecialchars($customerName), 0, 1, 'R');
$pdf->Cell(90, 10, 'Phone: 7567521564', 0, 0);
$pdf->Cell(0, 10, 'Address: ' . htmlspecialchars($customerAddress), 0, 1, 'R');
$pdf->Cell(90, 10, 'Email: khanyunus3003@gmail.com', 0, 0);
$pdf->Cell(0, 10, 'Phone: ' . htmlspecialchars($customerPhone), 0, 1, 'R');
$pdf->Ln(10); // Add a line break

// Product Details Heading
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(0, 10, 'Product Details', 0, 1);
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(80, 8, 'Product Name', 1);
$pdf->Cell(30, 8, 'Price', 1, 0, 'C'); // Direct Rupee symbol
$pdf->Cell(30, 8, 'Quantity', 1, 0, 'C');
$pdf->Cell(30, 8, 'Amount ()', 1, 0, 'C');
$pdf->Ln();
$pdf->SetFont('Arial', '', 10);

// Add each product to the PDF
foreach ($productDetails as $product) {
    $pdf->Cell(80, 8, htmlspecialchars($product['name']), 1);
    $pdf->Cell(30, 8, '' . number_format($product['price'], 2), 1, 0, 'C');
    $pdf->Cell(30, 8, htmlspecialchars($product['quantity']), 1, 0, 'C');
    $pdf->Cell(30, 8, '' . number_format($product['amount'], 2), 1, 0, 'C');
    $pdf->Ln();
}

// Total Amount
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(140, 8, 'Total', 1);
$pdf->Cell(30, 8, '' . number_format($totalAmount, 2), 1, 0, 'C');
$pdf->Ln(10); // Extra space after total

// Footer
$pdf->SetFont('Arial', 'I', 8);
$pdf->Cell(0, 10, 'Thank you for your business!', 0, 1, 'C');

// Output the PDF
$pdf->Output('quotation.pdf', 'I'); // Display PDF in the browser (use 'D' to download)
?>
