<?php 
require_once('../../libs/tcpdf/TCPDF-main/tcpdf.php');
require_once('../connection.php');
include('../session_check.php');
header('Content-Type: application/json');

try {
// Get form data
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
        $this->Cell(0, 10, 'SGOA FORM 05', 0, 1, 'R'); // Right-aligned header text
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

$query = "SELECT title FROM events WHERE event_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $event_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $eventTitle = strtoupper($row['title']); // Convert the title to uppercase
} else {
    $eventTitle = strtoupper("Event Not Found"); // Default title if event is not found
}

// Fetching income rows
$income_query = "SELECT title, amount, reference FROM income WHERE organization_id = $organization_id AND archived=0";
$income_result = mysqli_query($conn, $income_query);

$inflows = []; // Array to store the fetched income rows
if ($income_result && mysqli_num_rows($income_result) > 0) {
    while ($row = mysqli_fetch_assoc($income_result)) {
        $inflows[] = $row; // Append each row to the inflows array
    }
} else {
    echo "No income records found for the organization.";
}

// Fetching total inflows
$total_query = "SELECT SUM(amount) AS total_inflows FROM income WHERE organization_id = $organization_id AND archived=0";
$total_result = mysqli_query($conn, $total_query);

if ($total_result && mysqli_num_rows($total_result) > 0) {
    $total_row = mysqli_fetch_assoc($total_result);
    $total_inflows = $total_row['total_inflows'];
} else {
    $total_inflows = 0; // Fallback if no income rows exist
}

// Add titles
$pdf->SetFont('arial_b13', '', 12);
$pdf->Cell(0, 0, strtoupper($organization_name), 0, 1, 'C', 0, '', 1);
$pdf->Ln(5);
$pdf->Cell(0, 0, "FINANCIAL STATEMENT", 0, 1, 'C', 0, '', 1);
$pdf->Cell(0, 0, "AY 2024-2025", 0, 1, 'C', 0, '', 1);
$pdf->Cell(0, 0, "As of ".date('F d, Y'), 0, 1, 'C', 0, '', 1);
$pdf->Ln(10);

$pdf->SetFont('arial', '', 11);

// Calculate totals
$total_inflows = array_sum(array_column($inflows, 'amount'));

// Table 1: Cash Inflows
$html1 = '
<table border="1" cellpadding="5" cellspacing="0" style="width:100%; text-align:left;">
    <tr>
        <th>Cash Inflows</th>
        <th>Amount</th>
        <th>Reference</th>
    </tr>';

foreach ($inflows as $inflow) {
    $html1 .= '
    <tr>
        <td>'. htmlspecialchars($inflow['title']) .'</td>
        <td>' . number_format($inflow['amount'], 2) . '</td>
        <td>' . htmlspecialchars(pathinfo(($inflow['reference']), PATHINFO_FILENAME)) . '</td>
    </tr>';
}
$html1 .= '
    <tr>
        <td><b>TOTAL INFLOWS</b></td>
        <td colspan="2">' . number_format($total_inflows, 2) . '</td>
    </tr>
</table>';

// Fetch outflows grouped by category
$query = "
    SELECT 
        category,
        SUM(amount) AS subtotal,
        GROUP_CONCAT(CONCAT(title, ' (', reference, ')') SEPARATOR ', ') AS details
    FROM expenses
    WHERE organization_id = $organization_id
    GROUP BY category
";

// Execute the query
$result = mysqli_query($conn, $query);

// Initialize arrays for subtotals and total outflows
$outflows = [];
$total_outflows = 0;

if ($result && mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $outflows[] = [
            'category' => $row['category'],
            'subtotal' => $row['subtotal'],
            'details' => $row['details'],
        ];
        $total_outflows += $row['subtotal'];
    }
}
$html2 = ' 
<table border="1" cellpadding="5" cellspacing="0" style="width:100%; text-align:left;">
    <tr>
        <th>Cash Outflows</th>
        <th>Amount</th>
        <th>Reference</th>
    </tr>';

foreach ($outflows as $outflow) {
    // Add the category row with colspan across all three columns
    $html2 .= '
    <tr>
        <td colspan="3" style="font-weight:bold;">' . htmlspecialchars($outflow['category']) . '</td>
    </tr>';

    // Add each outflow detail (event title, amount, and reference) under the category
    $details = explode(", ", $outflow['details']);
    foreach ($details as $detail) {
        // Example of detail split to show title and reference
        // Assuming the details are in the format "Event Title (reference)"
        preg_match('/(.*)\s\((.*)\)/', $detail, $matches);
        $title = $matches[1];
        $reference = $matches[2];

        $reference = pathinfo($reference, PATHINFO_FILENAME);

        $html2 .= '
        <tr>
            <td>' . htmlspecialchars($title) . '</td>
            <td>' . number_format($outflow['subtotal'], 2) . '</td>
            <td>' . htmlspecialchars($reference) . '</td>
        </tr>';
    }
}

$html2 .= '
    <tr>
        <td><b>TOTAL OUTFLOWS</b></td>
        <td colspan="2">' . number_format($total_outflows, 2) . '</td>
    </tr>
</table>';


// Fetch Cash Balance Beginning, Cash on Bank, and Cash on Hand from organizations table
$organization_query = "
    SELECT 
        beginning_balance, 
        cash_on_bank, 
        cash_on_hand 
    FROM organizations 
    WHERE organization_id = $organization_id
";
$organization_result = mysqli_query($conn, $organization_query);

if ($organization_result && mysqli_num_rows($organization_result) > 0) {
    $organization_row = mysqli_fetch_assoc($organization_result);
    $beginning_balance = $organization_row['beginning_balance'];
    $cash_on_bank = $organization_row['cash_on_bank'];
    $cash_on_hand = $organization_row['cash_on_hand'];
} else {
    $beginning_balance = 0;
    $cash_on_bank = 0;
    $cash_on_hand = 0;
}

// Fetch the latest Cash Balance End from balance_history table
$balance_query = "
    SELECT 
        balance AS cash_balance_end
    FROM balance_history 
    WHERE organization_id = $organization_id 
    ORDER BY updated_at DESC 
    LIMIT 1
";
$balance_result = mysqli_query($conn, $balance_query);

if ($balance_result && mysqli_num_rows($balance_result) > 0) {
    $balance_row = mysqli_fetch_assoc($balance_result);
    $cash_balance_end = $balance_row['cash_balance_end'];
} else {
    $cash_balance_end = 0; // Fallback if no record is found
}

// Table 3: Cash Balance
$html3 = '
<table border="1" cellpadding="5" cellspacing="0" style="width:100%; text-align:left;">
    <tr>
        <td><b>CASH BALANCE BEGINNING (from previous term)</b></td>
        <td>' . number_format($beginning_balance, 2) . '</td>
    </tr>
    <tr>
        <td><b>TOTAL INFLOWS</b></td>
        <td>' . number_format($total_inflows, 2) . '</td>
    </tr>
    <tr>
        <td><b>TOTAL OUTFLOWS</b></td>
        <td>' . number_format($total_outflows, 2) . '</td>
    </tr>
    <tr>
        <td><b>Accounted as follows:</b></td>
        <td></td>
    </tr>
    <tr>
        <td>CASH ON BANK</td>
        <td>' . number_format($cash_on_bank, 2) . '</td>
    </tr>
    <tr>
        <td>CASH ON HAND</td>
        <td>' . number_format($cash_on_hand, 2) . '</td>
    </tr>
    <tr>
        <td><b>CASH BALANCE END</b></td>
        <td>' . number_format($cash_balance_end, 2) . '</td>
    </tr>
</table>';

// Write HTML to PDF
$pdf->writeHTML($html1, true, false, true, false, '');
$pdf->writeHTML($html2, true, false, true, false, '');
$pdf->writeHTML($html3, true, false, true, false, '');

// Add final spacing
$pdf->Ln(10);
 // Space for signatures above names

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
$pdf->Cell(80, 10, "GUILLIER E. PARULAN", 0, 0, 'L', 0);
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
    $file_name = "Financial_Statement_". $eventTitle . date("F j, Y") . ".pdf";

    // Use the 'D' parameter to force download
    $pdf->Output($file_name, 'I'); 

    // Exit to ensure no extra output
    exit;
} catch (Exception $e) {
    // Return error response
    echo json_encode([
        "success" => false,
        "errors" => [$e->getMessage()],
    ]);
}
?>