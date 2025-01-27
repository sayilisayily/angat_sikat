<?php 
require_once('../../libs/tcpdf/TCPDF-main/tcpdf.php');
require_once('../connection.php');
include('../session_check.php');
header('Content-Type: application/json');

try {
// Get form data
$event_id = $_POST['event_id'];
// Example validation
    if (empty($event_id)) {
        $_SESSION['budget_request_error'] = "Event ID is required.";
        header("Location: reports.php"); // Replace with the page where the modal is located
        exit();
    }
$org_query = "SELECT organization_name, acronym FROM organizations WHERE organization_id = $organization_id";
                                    $org_result = mysqli_query($conn, $org_query);

                                    if ($org_result && mysqli_num_rows($org_result) > 0) {
                                        $org_row = mysqli_fetch_assoc($org_result);
                                        $organization_name = $org_row['organization_name'];
                                        $acronym = $org_row['acronym'];
                                    } else {
                                        $organization_name = "Unknown Organization"; // Fallback if no name is found
                                    }

class CustomPDF extends TCPDF {
    public function Header() {
        $this->SetFont('play', 'I', 10); // Set font to Arial, size 11
        $this->Cell(0, 10, 'SGOA FORM 10', 0, 1, 'R'); // Right-aligned header text
    }
    
    // Footer Method
    public function Footer() {
        global $acronym;
        $this->SetY(-25.4); // Position 1 inch from the bottom
        $this->SetFont('play', '', 10); // Set font
        
        $this->SetLineWidth(0.5); // Set line width
        $this->Line(10, $this->GetY() - 5, 200, $this->GetY() - 5); // Draw line (x1, y1, x2, y2)

        // HTML content for footer with adjusted left and right margins
        $this->Cell(0, 5, 'SASCO', 0, 1, 'L');
        $this->Cell(0, 5, 'LIQUIDATION REPORT', 0, 1, 'L');
        $this->Cell(0, 5, $acronym, 0, 1, 'L');
        $this->Cell(0, 5, ' Page ' . $this->getAliasNumPage() . ' of ' . $this->getAliasNbPages(), 0, 1, 'L');
    }
}

$pdf = new CustomPDF();

$pdf->AddPage();
$pdf->SetMargins(25.4, 25.4, 25.4); // 1-inch margins (25.4mm)
$pdf->SetAutoPageBreak(true, 30.48); // 1.2-inch bottom margin

// Set left logo using HTML
$htmlLeftLogo = '
    <div style="text-align: left;">
        <img src="img/cvsu.jpg" style="width: 100px; height: 100px; margin-top: 5px;" />
    </div>
';

// Set right logo using HTML
$htmlRightLogo = '
    <div style="text-align: right;">
        <img src="img/bagongpilipinas.jpg" style="width: 100px; height: 100px; margin-top: 5px;" />
    </div>
';

// Add the left logo
$pdf->writeHTMLCell(30, 40, 15, 15, $htmlLeftLogo, 0, 0, false, true, 'L', true);

// Add the right logo
$pdf->writeHTMLCell(30, 40, 165, 15, $htmlRightLogo, 0, 0, false, true, 'R', true);

// Center-align the header text
$pdf->SetFont('centurygothic', 'B', 11);
$pdf->SetY(15); // Adjust Y to align with logos
$pdf->Cell(0, 5, 'Republic of the Philippines', 0, 1, 'C');
$pdf->SetFont('bookmanoldstyleb', 'B', 11);
$pdf->Cell(0, 5, 'CAVITE STATE UNIVERSITY', 0, 1, 'C');
$pdf->SetFont('gothicb', 'B', 11);
$pdf->Cell(0, 5, 'CCAT Campus', 0, 1, 'C');
$pdf->SetFont('centurygothic', 'B', 11);
$pdf->Cell(0, 5, 'Rosario, Cavite', 0, 1, 'C');

$pdf->Ln(2);
$pdf->Cell(0, 5, '(046) 437-9507 / (046) 437-6659', 0, 1, 'C');
$pdf->Cell(0, 5, 'cvsurosario@cvsu.edu.ph', 0, 1, 'C');
$pdf->Cell(0, 5, 'www.cvsu-rosario.edu.ph', 0, 1, 'C');

$pdf->Ln(10); // Add space after header


// Query to fetch the event title and start date
$query = "SELECT title, event_start_date FROM events WHERE event_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $event_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $eventTitle = ($row['title']); // Convert the title to uppercase
    $eventStartDate = date("F j, Y", strtotime($row['event_start_date'])); // Format the start date
} else {
    $eventTitle = strtoupper("Event Not Found"); // Default title if event is not found
    $eventStartDate = "N/A"; // Default date if event is not found
}


$stmt->close();

// Add titles
$pdf->SetFont('arial_b13', '', 12);
$pdf->Cell(0, 0, strtoupper($organization_name), 0, 1, 'C', 0, '', 1);
$pdf->Ln(5);
$pdf->Cell(0, 0, "BUDGET REQUEST", 0, 1, 'C', 0, '', 1);
$pdf->Cell(0, 0, $eventTitle, 0, 1, 'C', 0, '', 1);
$pdf->Ln(10);

// Add letter body
// Bold font for date and name
$pdf->SetFont('arial_b13', '', 11);
$pdf->Cell(0, 0, date("F j, Y"), 0, 1, 'L', 0, '', 1);
$pdf->Cell(0, 0, 'JIMPLE JAY R. MALIGRO', 0, 1, 'L', 0, '', 1);

// Normal font for the rest
$pdf->SetFont('arial', '', 11);
$pdf->MultiCell(0, 0, "Coordinator, SDS\nThis Campus\n\nSir:\n\nGreetings of peace. I am writing this letter to request for budget disbursement allotted for ". $eventTitle ." scheduled on " . $eventStartDate . ". This budget will be utilized as follows:", 0, 'L', 0, 1, '', '', true);
$pdf->Ln(5);

// Prepare data for the table
$query = "SELECT description, quantity, amount AS unit_price FROM event_items WHERE event_id = ? AND type = 'expense'";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $event_id);
$stmt->execute();
$result = $stmt->get_result();

$items = [];
$totalAmount = 0;

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $row['total'] = $row['quantity'] * $row['unit_price'];
        $totalAmount += $row['total'];
        $items[] = $row;
    }
} else {
    $_SESSION['budget_request_error'] = 'No items found for the given event.';
    header("Location: reports.php"); // Replace with the page where the modal is located
    exit();
}

// Create the table HTML
$html = '
<table border="1" cellpadding="5" cellspacing="0" style="width: 100%; border-collapse: collapse; text-align: center;">
    <thead>
        <tr>
            <th colspan="4">
                PROJECTED EXPENSES
            </th>
        </tr>
        <tr>
            <th style="width: 50%;">Description</th>
            <th style="width: 15%;">QTY</th>
            <th style="width: 15%;">UNIT PRICE</th>
            <th style="width: 20%;">TOTAL</th>
        </tr>
    </thead>
    <tbody>';

// Add rows to the table
foreach ($items as $item) {
    $html .= '
        <tr>
            <td style="text-align: left; width: 50%;">' . htmlspecialchars($item['description']) . '</td>
            <td style="width: 15%;">' . $item['quantity'] . '</td>
            <td style="width: 15%;">' . number_format($item['unit_price'], 2) . '</td>
            <td style="width: 20%;">' . number_format($item['total'], 2) . '</td>
        </tr>';
}

// Add the total row
$html .= '
        <tr style="font-weight: bold;">
            <td colspan="3" style="text-align: right;">TOTAL</td>
            <td>' . number_format($totalAmount, 2) . '</td>
        </tr>
    </tbody>
</table>';

// Write the table to the PDF
$pdf->writeHTML($html, true, false, true, false, '');


// Prepared By Section
$pdf->SetFont('arial', '', 11); 
$pdf->Cell(0, 0, "Prepared by:", 0, 1, 'L', 0, '', 1);
$pdf->Ln(10); // Space for signatures above names
// Query to fetch the President and Treasurer of the organization
$query = "
    SELECT first_name, last_name, position 
    FROM users 
    WHERE organization_id = ? AND position IN ('President', 'Treasurer')
    ORDER BY FIELD(position, 'Treasurer', 'President')";

$stmt = $conn->prepare($query);
$stmt->bind_param("i", $organization_id); // Assuming $organization_id is available
$stmt->execute();
$result = $stmt->get_result();

$president = null;
$treasurer = null;

// Loop through results and assign values based on position
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        if ($row['position'] == 'President') {
            $president = $row['first_name'] . ' ' . $row['last_name'];
        } elseif ($row['position'] == 'Treasurer') {
            $treasurer = $row['first_name'] . ' ' . $row['last_name'];
        }
    }
}

// Default values if no President or Treasurer found
if (!$president) {
    $president = "N/A";
}
if (!$treasurer) {
    $treasurer = "N/A";
}

// Add the fetched names to the PDF
$pdf->SetFont('arial_b13', '', 11);
$pdf->Cell(80, 10, strtoupper($treasurer), 0, 0, 'L', 0); // Treasurer's name
$pdf->Cell(80, 10, strtoupper($president), 0, 1, 'L', 0); // President's name
$pdf->SetFont('arial', 'B', 11);
$pdf->Cell(80, 10, "Treasurer, ".$acronym, 0, 0, 'L', 0);
$pdf->Cell(80, 10, "President, ".$acronym, 0, 1, 'L', 0);
$pdf->Ln(10); // Add spacing between sections


// Recommending Approval Section
$pdf->SetFont('arial', '', 11);
$pdf->Cell(0, 0, "Recommending Approval:", 0, 1, 'L', 0, '', 1);
$pdf->Ln(10); // Space for signatures above names

// Query to fetch the Junior and Senior Advisers of the organization
$query = "
    SELECT first_name, last_name, position 
    FROM advisers 
    WHERE organization_id = ? AND position IN ('Junior Adviser', 'Senior Adviser')
    ORDER BY FIELD(position, 'Junior Adviser', 'Senior Adviser')";

$stmt = $conn->prepare($query);
$stmt->bind_param("i", $organization_id); // Assuming $organization_id is available
$stmt->execute();
$result = $stmt->get_result();

$juniorAdviser = null;
$seniorAdviser = null;

// Loop through results and assign values based on position
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        if ($row['position'] == 'Junior Adviser') {
            $juniorAdviser = $row['first_name'] . ' ' . $row['last_name'];
        } elseif ($row['position'] == 'Senior Adviser') {
            $seniorAdviser = $row['first_name'] . ' ' . $row['last_name'];
        }
    }
}

// Default values if no advisers are found
if (!$juniorAdviser) {
    $juniorAdviser = "N/A";
}
if (!$seniorAdviser) {
    $seniorAdviser = "N/A";
}

// Add the fetched names to the Recommending Approval Table in the PDF
$pdf->SetFont('arial_b13', '', 11);
$pdf->Cell(80, 10, strtoupper($juniorAdviser), 0, 0, 'L', 0); // Junior Adviser name
$pdf->Cell(80, 10, strtoupper($seniorAdviser), 0, 1, 'L', 0); // Senior Adviser name
$pdf->SetFont('arial', 'B', 11);
$pdf->Cell(80, 10, "Junior Adviser, " . $acronym, 0, 0, 'L', 0);
$pdf->Cell(80, 10, "Senior Adviser, " . $acronym, 0, 1, 'L', 0);
$pdf->Ln(10); // Add spacing between sections


// Example Names for Signatures
$pdf->SetFont('arial_b13', '', 11);
$pdf->Ln(10); // Space for signatures above names
$pdf->Cell(80, 10, "GUILLIER T. PARULAN", 0, 0, 'L', 0);
$pdf->Cell(80, 10, "MICHAEL EDWARD T. ARMINTIA, REE", 0, 1, 'L', 0);
$pdf->SetFont('arial', 'B', 11);
$pdf->Cell(80, 10, "President, CSG", 0, 0, 'L', 0);
$pdf->Cell(80, 10, "In-charge, SGOA", 0, 1, 'L', 0);
$pdf->Ln(10); // Final spacing


// Approved Section
$pdf->SetFont('arial', 'B', 11); // Arial and Bold for the "Approved" title
$pdf->Cell(0, 0, "APPROVED:", 0, 1, 'C', 0, '', 1);
$pdf->Ln(10);
$pdf->SetFont('arial_b13', 'B', 11);
$pdf->Cell(0, 0, "JIMPLE JAY R. MALIGRO", 0, 1, 'C', 0, '', 1);
$pdf->SetFont('arial', 'B', 11);
$pdf->Cell(0, 0, "Coordinator, SDS", 0, 1, 'C', 0, '', 1);
// Generate the file name
    $file_name = "Budget_Request_" . $eventTitle . '_' . date("F j, Y") . ".pdf";

    // Use the 'D' parameter to force download
    $pdf->Output($file_name, 'I'); // Forces the PDF to be downloaded with the given filename

    // Exit to ensure no extra output
    $_SESSION['budget_request_success'] = "Budget request report generated successfully!";
        header("Location: reports.php"); // Redirect back to the modal page
        exit();
} catch (Exception $e) {
    // Return error response
    $_SESSION['budget_request_error'] = "An error occurred: " . $e->getMessage();
        header("Location: reports.php");
        exit();
}

?>