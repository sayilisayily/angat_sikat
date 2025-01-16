<?php 
require_once('../../libs/tcpdf/TCPDF-main/tcpdf.php');
require_once('../connection.php');
include('../session_check.php');
header('Content-Type: application/json');

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
        $this->Cell(0, 10, 'SGOA FORM 11', 0, 1, 'R'); // Right-aligned header text
    }

    // Footer Method
    public function Footer() {
        $this->SetY(-25.4); // Position 1 inch from the bottom
        $this->SetFont('play', '', 10); // Set font
        global $acronym;

        $this->SetLineWidth(0.5); // Set line width
        $this->Line(10, $this->GetY() - 5, 200, $this->GetY() - 5); // Draw line (x1, y1, x2, y2)

        // HTML content for footer with adjusted left and right margins
        $this->Cell(0, 5, 'SASCO', 0, 1, 'L');
        $this->Cell(0, 5, 'PERMIT TO WITHDRAW', 0, 1, 'L');
        $this->Cell(0, 5, $acronym, 0, 1, 'L');
        $this->Cell(0, 5, ' Page ' . $this->getAliasNumPage() . ' of ' . $this->getAliasNbPages(), 0, 1, 'L');
    }
}

$pdf = new CustomPDF();

// Register fonts
$bookmanOldStyle = TCPDF_FONTS::addTTFfont('../../libs/tcpdf/TCPDF-main/fonts/bookman-old-style_j4eZ5/Bookman Old Style/Bookman Old Style Bold/Bookman Old Style Bold.ttf', 'TrueTypeUnicode', '', 96);
$arialBold = TCPDF_FONTS::addTTFfont('../../libs/tcpdf/TCPDF-main/fonts/arial-font/arial_bold13.ttf', 'TrueTypeUnicode', '', 96);
$arial = TCPDF_FONTS::addTTFfont('../../libs/tcpdf/TCPDF-main/fonts/arial-font/arial.ttf', 'TrueTypeUnicode', '', 96);
$centuryGothicBold = TCPDF_FONTS::addTTFfont('../../libs/tcpdf/TCPDF-main/fonts/century-gothic/GOTHICB.TTF""', 'TrueTypeUnicode', '', 96);
$centurygothic = TCPDF_FONTS::addTTFfont('../../libs/tcpdf/TCPDF-main/fonts/century-gothic/Century Gothic.ttf', 'TrueTypeUnicode', '', 96);
$play = TCPDF_FONTS::addTTFfont('../../libs/tcpdf/TCPDF-main/fonts/play/Play-Regular.ttf"', 'TrueTypeUnicode', '', 96);

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
$pdf->SetFont($centurygothic, 'B', 11);
$pdf->SetY(15); // Adjust Y to align with logos
$pdf->Cell(0, 5, 'Republic of the Philippines', 0, 1, 'C');
$pdf->SetFont('Bookman Old Style', 'B', 11);
$pdf->Cell(0, 5, 'CAVITE STATE UNIVERSITY', 0, 1, 'C');
$pdf->SetFont($centuryGothicBold, 'B', 11);
$pdf->Cell(0, 5, 'CCAT Campus', 0, 1, 'C');
$pdf->SetFont($centurygothic, 'B', 11);
$pdf->Cell(0, 5, 'Rosario, Cavite', 0, 1, 'C');

$pdf->Ln(2);
$pdf->Cell(0, 5, '(046) 437-9507 / (046) 437-6659', 0, 1, 'C');
$pdf->Cell(0, 5, 'cvsurosario@cvsu.edu.ph', 0, 1, 'C');
$pdf->Cell(0, 5, 'www.cvsu-rosario.edu.ph', 0, 1, 'C');

$pdf->Ln(10); // Add space after header


// Function to convert numbers to words
function convertNumberToWord($number = false)
{
    $number = str_replace(array(',', ' '), '' , trim($number));
    if(! $number) {
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
        if ( $tens < 20 ) {
            $tens = ($tens ? ' ' . $list1[$tens] . ' ' : '' );
        } else {
            $tens = (int)($tens / 10);
            $tens = ' ' . $list2[$tens] . ' ';
            $singles = (int) ($number_levels[$i] % 10);
            $singles = ' ' . $list1[$singles] . ' ';
        }
        $words[] = $hundreds . $tens . $singles . ( ( $levels && ( int ) ( $number_levels[$i] ) ) ? ' ' . $list3[$levels] . ' ' : '' );
    } //end for loop
    $commas = count($words);
    if ($commas > 1) {
        $commas = $commas - 1;
    }
    return strtoupper(implode(' ', $words));
}

// Query to fetch the title and total amount
$query = "SELECT title, total_amount FROM events WHERE event_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $event_id); // Changed "id" to "i" for integer
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $eventTitle = ($row['title']); // Convert the title to uppercase
    $eventAmount = number_format($row['total_amount'], 2); // Format the amount
    $eventAmountWords = convertNumberToWord($row['total_amount']); // Convert amount to words
} else {
    $eventTitle = strtoupper("Event Not Found"); // Default title if event is not found
    $eventAmount = "N/A"; // Default amount if event is not found
    $eventAmountWords = "N/A"; // Default words if event is not found
}


$stmt->close();

// Add titles
$pdf->SetFont($arialBold, '', 11);
$pdf->Cell(0, 0, strtoupper($organization_name), 0, 1, 'C', 0, '', 1);
$pdf->Ln(5);
$pdf->Cell(0, 0, "PERMIT TO WITHDRAW", 0, 1, 'C', 0, '', 1);
$pdf->Ln(10);

$html = '
    <table style="width: 100%; font-size: 11px; font-family: Arial, sans-serif; line-height: 1.5;">
        <!-- Date -->
        <tr>
            <td style="width: 70%;"></td>
            <td style="width: 30%; text-align: right;">
                <b>Date:</b>
                <span style="border-bottom: 1px solid #000; padding-right: 5px;">' . date('F d, Y') . '</span>
            </td>
        </tr>
        <tr><td colspan="2" style="height: 10px;"></td></tr> <!-- Space after Date -->

        <!-- Name of Organization and Checkboxes -->
        <tr>
            <td style="width: 28%; text-align: left; padding-top: 10px;"><b>Name of Organization:</b></td>
            <td style="width: 72%; border-bottom: 1px solid #000; padding-top: 10px; vertical-align: middle;">
                ' . htmlspecialchars($organization_name) . ' 
            </td>
        </tr>
        <tr>
            <td style="width: 100%; text-align: left; padding-top: 10px;">
                <b>□ Academic</b> 
                <b>□ Non-Academic</b>
            </td>
        
        </tr>

        <!-- Purpose -->
        <tr>
            <td style="width: 12%; text-align: left; padding-top: 10px;"><b>Purpose:</b></td>
            <td style="width: 88%; border-bottom: 1px solid #000; padding-top: 10px;">' . htmlspecialchars($eventTitle) . '</td>
        </tr>

        <!-- Amount -->
        <tr>
            <td style="width: 12%; text-align: left; padding-top: 10px;"><b>Amount:</b></td>
            <td style="width: 88%; border-bottom: 1px solid #000; padding-top: 10px;">
                ' . htmlspecialchars($eventAmountWords) . ' PESOS (P ' . htmlspecialchars($eventAmount) . ')
            </td>
        </tr>
    </table>
';

// Output the HTML to TCPDF
$pdf->writeHTML($html, true, false, true, false, '');

// Add final spacing
$pdf->Ln(10);
 // Space for signatures above names

// Prepared By Section
$pdf->SetFont($arial, '', 11); 
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
$pdf->SetFont($arialBold, '', 11);
$pdf->Cell(80, 10, strtoupper($treasurer), 0, 0, 'L', 0); // Treasurer's name
$pdf->Cell(80, 10, strtoupper($president), 0, 1, 'L', 0); // President's name
$pdf->SetFont($arial, 'B', 11);
$pdf->Cell(80, 10, "Treasurer, ".$acronym, 0, 0, 'L', 0);
$pdf->Cell(80, 10, "President, ".$acronym, 0, 1, 'L', 0);
$pdf->Ln(10); // Add spacing between sections

// Recommending Approval Section
$pdf->SetFont($arial, '', 11);
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
$pdf->SetFont($arialBold, '', 11);
$pdf->Cell(80, 10, strtoupper($juniorAdviser), 0, 0, 'L', 0); // Junior Adviser name
$pdf->Cell(80, 10, strtoupper($seniorAdviser), 0, 1, 'L', 0); // Senior Adviser name
$pdf->SetFont($arial, 'B', 11);
$pdf->Cell(80, 10, "Junior Adviser, " . $acronym, 0, 0, 'L', 0);
$pdf->Cell(80, 10, "Senior Adviser, " . $acronym, 0, 1, 'L', 0);
$pdf->Ln(10); // Add spacing between sections



// Example Names for Signatures
$pdf->SetFont($arialBold, '', 11);
$pdf->Ln(10); // Space for signatures above names
$pdf->Cell(80, 10, "GUILLIER E. PARULAN", 0, 0, 'L', 0);
$pdf->Cell(80, 10, "MICHAEL EDWARD T. ARMINTIA, REE", 0, 1, 'L', 0);
$pdf->SetFont($arial, 'B', 11);
$pdf->Cell(80, 10, "President, CSG", 0, 0, 'L', 0);
$pdf->Cell(80, 10, "In-charge, SGOA", 0, 1, 'L', 0);
$pdf->Ln(10); // Final spacing


// Approved Section
$pdf->SetFont($arial, 'B', 11); // Arial and Bold for the "Approved" title
$pdf->Cell(0, 0, "APPROVED:", 0, 1, 'C', 0, '', 1);
$pdf->Ln(10);
$pdf->SetFont($arialBold, 'B', 11);
$pdf->Cell(0, 0, "JIMPLE JAY R. MALIGRO", 0, 1, 'C', 0, '', 1);
$pdf->SetFont($arial, 'B', 11);
$pdf->Cell(0, 0, "Coordinator, SDS", 0, 1, 'C', 0, '', 1);

// Generate the file name
    $file_name = "Permit_to_Withdraw_" . $eventTitle . '_' . time() . ".pdf";

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