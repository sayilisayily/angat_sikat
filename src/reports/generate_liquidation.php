<?php 
require_once('../../libs/tcpdf/TCPDF-main/tcpdf.php');
require_once('../connection.php');
include('../session_check.php');

try {
// Get form data
$event_id = $_POST['event_id'];
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
        $this->Cell(0, 10, 'SGOA FORM 07', 0, 1, 'R'); // Right-aligned header text
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

// Connect to the database
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

$referenceNumber = $_POST['reference_number'];
$cashReceived = $_POST['cash_received']; // Amount received in numeric format
// SQL query to fetch disbursements and their details
$query = "
    SELECT
        date AS detail_date, 
        description AS detail_description, 
        quantity AS detail_qty, 
        amount AS detail_unit_price, 
        reference AS detail_reference
    FROM event_summary_items
    WHERE event_id = ?"; // assuming event_id is passed as a parameter

$stmt = $conn->prepare($query);
if (!$stmt) {
    die("Prepare failed: (" . $conn->errno . ") " . $conn->error);
}

$stmt->bind_param("i", $event_id); // bind event_id for filtering
$stmt->execute();
$result = $stmt->get_result();

$stmt->close();


$disbursements = [];
$noteCounter = 1; // Initialize the note counter

while ($row = $result->fetch_assoc()) {
    // Check if this disbursement description already exists in the array
    $existingIndex = array_search($row['detail_description'], array_column($disbursements, 'description'));

    if ($existingIndex !== false) {
        // Add the details to the existing disbursement
        $disbursements[$existingIndex]['details'][] = [
            'date' => $row['detail_date'],
            'description' => $row['detail_description'],
            'qty' => $row['detail_qty'],
            'unit_price' => $row['detail_unit_price'],
            'total_amount' => $row['detail_qty'] * $row['detail_unit_price'], // Calculate the total dynamically
            'reference' => $row['detail_reference'],
        ];

        // Recalculate the total disbursement amount for this item
        $disbursements[$existingIndex]['amount'] += $row['detail_qty'] * $row['detail_unit_price'];
    } else {
        // Add a new disbursement entry
        $totalAmount = $row['detail_qty'] * $row['detail_unit_price']; // Calculate the total dynamically
        $disbursements[] = [
            'description' => $row['detail_description'],
            'note' => $noteCounter++, // Assign the current note counter value and increment it
            'amount' => $totalAmount, // Start with the first detail's total amount
            'details' => [
                [
                    'date' => $row['detail_date'],
                    'description' => $row['detail_description'],
                    'qty' => $row['detail_qty'],
                    'unit_price' => $row['detail_unit_price'],
                    'total_amount' => $totalAmount, // Use calculated total
                    'reference' => $row['detail_reference'],
                ]
            ]
        ];
    }
}

// If you want to re-index the array based on description
$disbursements = array_values($disbursements);

$totalDisbursement = 0;

// Loop through the $disbursements array to sum the 'amount'
foreach ($disbursements as $disbursement) {
    $totalDisbursement += $disbursement['amount'];
}

$amountToBeRemitted = $cashReceived - $totalDisbursement;

// Add titles
$pdf->SetFont('arial_b13', '', 12);
$pdf->Cell(0, 0, strtoupper($organization_name), 0, 1, 'C', 0, '', 1);
$pdf->Cell(0, 0, "LIQUIDATION REPORT", 0, 1, 'C', 0, '', 1);
$pdf->Ln(10);

// Function to convert number to words
function convertNumberToWord($number) {
    // Implement the conversion function here (same as previously discussed)
    $number = str_replace(array(',', ' '), '', trim($number));
    if (! $number) {
        return false;
    }
    $number = (int) $number;
    $words = array();
    $list1 = array('', 'one', 'two', 'three', 'four', 'five', 'six', 'seven', 'eight', 'nine', 'ten', 'eleven',
        'twelve', 'thirteen', 'fourteen', 'fifteen', 'sixteen', 'seventeen', 'eighteen', 'nineteen'
    );
    $list2 = array('', 'ten', 'twenty', 'thirty', 'forty', 'fifty', 'sixty', 'seventy', 'eighty', 'ninety', 'hundred');
    $list3 = array('', 'thousand', 'million', 'billion', 'trillion', 'quadrillion', 'quintillion', 'sextillion', 'septillion',
        'octillion', 'nonillion', 'decillion', 'undecillion', 'duodecillion', 'tredecillion', 'quattuordecillion',
        'quindecillion', 'sexdecillion', 'septendecillion', 'octodecillion', 'novemdecillion', 'vigintillion'
    );
    $number_length = strlen($number);
    $levels = (int) (($number_length + 2) / 3);
    $max_length = $levels * 3;
    $number = substr('00' . $number, -$max_length);
    $number_levels = str_split($number, 3);
    for ($i = 0; $i < count($number_levels); $i++) {
        $levels--;
        $hundreds = (int) ($number_levels[$i] / 100);
        $hundreds = ($hundreds ? ' ' . $list1[$hundreds] . ' hundred' . ' ' : '');
        $tens = (int) ($number_levels[$i] % 100);
        $singles = '';
        if ($tens < 20) {
            $tens = ($tens ? ' ' . $list1[$tens] . ' ' : '');
        } else {
            $tens = (int)($tens / 10);
            $tens = ' ' . $list2[$tens] . ' ';
            $singles = (int) ($number_levels[$i] % 10);
            $singles = ' ' . $list1[$singles] . ' ';
        }
        $words[] = $hundreds . $tens . $singles . (($levels && (int) ($number_levels[$i])) ? ' ' . $list3[$levels] . ' ' : '');
    }
    return strtoupper(implode(' ', $words));
}

// Set font
$pdf->SetFont('arial', '', 11);
$pdf->Cell(0, 0, 'Reference Number: '.$referenceNumber, 0, 1, 'L', 0, '', 1);
$pdf->Cell(0, 0, 'Date Prepared: '.date("F j, Y"), 0, 1, 'L', 0, '', 1);
$pdf->Ln(5);

// Set font
$pdf->SetFont('arial', '', 11);
$html = '
    <table border="1" cellpadding="5" cellspacing="0" style="width:100%; text-align:left;">
        <tr>
            <th colspan="2" style="text-align:center;">Title of Activity</th>
            <td colspan="2" style="text-align:center;">' . $eventTitle . '</td>
        </tr>
        <tr>
            <th colspan="2" style="text-align:center;">Cash Received</th>
            <td colspan="2" style="text-align:center;">' . convertNumberToWord($cashReceived) . ' PESOS (P ' . number_format($cashReceived, 2) . ')</td>
        </tr>
        <tr>
            <th colspan="4" style="text-align:left;">Less Disbursement:</th>
        </tr>
        <tr>
            <th style="width: 50%;">Description</th>
            <th style="width: 25%;">Note</th>
            <th style="width: 25%;">Amount (P)</th>
        </tr>';

foreach ($disbursements as $disbursement) {
    $html .= '
        <tr>
            <td>' . $disbursement['description'] . '</td>
            <td>' . $disbursement['note'] . '</td>
            <td>' . number_format($disbursement['amount'], 2) . '</td>
        </tr>';
}

// Add total disbursement and amount to be remitted

if ($amountToBeRemitted < 0) {
    $html .= '
        <tr>
            <td><b>Total Disbursement</b></td>
            <td colspan="2">' . number_format($totalDisbursement, 2) . '</td>
        </tr>
        <tr>
            <td><b>Amount Overspent</b></td>
            <td colspan="2">' . number_format(abs($amountToBeRemitted), 2) . '</td>
        </tr>
    </table>';
} else {
    $html .= '
        <tr>
            <td><b>Total Disbursement</b></td>
            <td colspan="2">' . number_format($totalDisbursement, 2) . '</td>
        </tr>
        <tr>
            <td><b>Amount to be Remitted</b></td>
            <td colspan="2">' . number_format($amountToBeRemitted, 2) . '</td>
        </tr>
    </table>';
}


$pdf->writeHTML($html, true, false, true, false, '');

$pdf->Ln(10); // Space for signatures above names

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

// Add new page for detailed disbursements
$pdf->AddPage();
$pdf->SetMargins(25.4, 25.4, 25.4); // 1-inch margins (25.4mm)
$pdf->SetFont('arial', '', 11);

// Loop through disbursements to create detailed tables for each
foreach ($disbursements as $disbursement) {
    // Start the table for each disbursement
    $html2 = '
        <div style="text-align: center; margin: 0 auto;">
            <table border="1" cellpadding="5" cellspacing="0" style="width:90%; text-align:left; margin: 0 auto;">
                <tr>
                    <th colspan="6" style="text-align:left;">Note ' . $disbursement['note'] . ': ' . htmlspecialchars($disbursement['description']) . '</th>
                </tr>
                <tr>
                    <th>Date</th>
                    <th>Description</th>
                    <th>Qty</th>
                    <th>Unit Price</th>
                    <th>Total Amount</th>
                    <th>Reference</th>
                </tr>';
    
    // Add rows dynamically from the details
    $totalAmountForDisbursement = 0;
    foreach ($disbursement['details'] as $detail) {
        $html2 .= '
                <tr>
                    <td>' . htmlspecialchars($detail['date']) . '</td>
                    <td>' . htmlspecialchars($detail['description']) . '</td>
                    <td>' . htmlspecialchars($detail['qty']) . '</td>
                    <td>' . number_format($detail['unit_price'], 2) . '</td>
                    <td>' . number_format($detail['total_amount'], 2) . '</td>
                    <td>' . htmlspecialchars($detail['reference']) . '</td>
                </tr>';
        $totalAmountForDisbursement += $detail['total_amount'];
    }
    
    // Add total row for this disbursement
    $html2 .= '
                <tr>
                    <td colspan="4" style="text-align:right;"><b>TOTAL:</b></td>
                    <td colspan="2">' . number_format($totalAmountForDisbursement, 2) . '</td>
                </tr>
            </table>
        </div>';
    
    // Write the table to the PDF
    $pdf->writeHTML($html2, true, false, true, false, '');
}


// Generate the file name
    $file_name = "LR " . $referenceNumber . ".pdf";

    // Use the 'D' parameter to force download
    $pdf->Output($file_name, 'I'); // Forces the PDF to be downloaded with the given filename

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