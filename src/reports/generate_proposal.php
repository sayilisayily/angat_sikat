<?php 
require_once('../../libs/tcpdf/TCPDF-main/tcpdf.php');
require_once('../connection.php');
include('../session_check.php');
header('Content-Type: application/json');

try {
// Get form data
$event_id =  $_POST['event_id'];
if (empty($event_id)) {
        $_SESSION['project_proposal_error'] = "Event ID is required.";
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
        $this->Cell(0, 10, 'SGOA FORM 08', 0, 1, 'R'); // Right-aligned header text
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
        $this->Cell(0, 5, 'PROJECT PROPOSAL', 0, 1, 'L');
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



// Query to fetch the event title and start date
$query = "SELECT title, event_start_date, event_venue FROM events WHERE event_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $event_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $eventTitle = ($row['title']); // Convert the title to uppercase
    $eventStartDate = date("F j, Y", strtotime($row['event_start_date'])); // Format the start date
    $eventVenue = ($row['event_venue']); 
} else {
    $eventTitle = strtoupper("Event Not Found"); // Default title if event is not found
    $eventStartDate = "N/A"; // Default date if event is not found
}


$stmt->close();

// Add titles
$pdf->SetFont($arialBold, '', 11);
$pdf->Cell(0, 0, strtoupper($organization_name), 0, 1, 'C', 0, '', 1);
$pdf->Ln(5);
$pdf->Cell(0, 0, "PROJECT PROPOSAL", 0, 1, 'C', 0, '', 1);
$pdf->Ln(10);

// Add body
$left_width = 80;  // Width for the left column
$right_width = 120; // Width for the right column
$row_height = 8;   // Height for each row

// I. TITLE
$pdf->SetFont($arialBold, '', 11);
$pdf->Cell($left_width, $row_height, 'I. TITLE:', 0, 0, 'L'); // Left cell
$pdf->SetFont('arial', '', 11);
$pdf->Cell($right_width, $row_height, $eventTitle, 0, 1, 'L'); // Right cell

// II. PROPONENT
$pdf->SetFont($arialBold, '', 11);
$pdf->Cell($left_width, $row_height, 'II. PROPONENT:', 0, 0, 'L');
$pdf->SetFont('arial', '', 11);
$pdf->Cell($right_width, $row_height, $organization_name, 0, 1, 'L');

// III. COLLABORATOR(S)
$pdf->SetFont($arialBold, '', 11);
$pdf->Cell($left_width, $row_height, 'III. COLLABORATOR(S):', 0, 0, 'L');

// Fetch the selected collaborators from the form
$collaborators = isset($_POST['collaborators']) ? $_POST['collaborators'] : [];

// Check if "N/A" is selected or no collaborators are provided
if (in_array('0', $collaborators) || empty($collaborators)) {
    $pdf->SetFont('arial', '', 11);
    $pdf->Cell($right_width, $row_height, 'None', 0, 1, 'L');
} else {
    // Fetch collaborator names from the database based on selected IDs
    $collaborator_ids = implode(',', array_map('intval', $collaborators)); // Sanitize input
    $collab_query = "SELECT organization_name FROM organizations WHERE organization_id IN ($collaborator_ids)";
    $collab_result = mysqli_query($conn, $collab_query);

    if ($collab_result && mysqli_num_rows($collab_result) > 0) {
        $collab_names = [];
        while ($row = mysqli_fetch_assoc($collab_result)) {
            $collab_names[] = $row['organization_name'];
        }
        $collaborator_list = implode(', ', $collab_names);
    } else {
        $collaborator_list = 'None';
    }

    // Output the collaborator names in the PDF
    $pdf->SetFont('arial', '', 11);
    $pdf->MultiCell($right_width, $row_height, $collaborator_list, 0, 'L');
}

// IV. TARGET DATE AND VENUE
$pdf->SetFont($arialBold, '', 11);
$pdf->Cell($left_width, $row_height, 'IV. TARGET DATE AND VENUE:', 0, 0, 'L');
$pdf->SetFont('arial', '', 11);
$pdf->Cell($right_width, $row_height, $eventStartDate, 0, 1, 'L');
$pdf->Cell($left_width, $row_height, '', 0, 0, 'L'); // Empty left cell for alignment
$pdf->Cell($right_width, $row_height, $eventVenue, 0, 1, 'L');

// Set column widths
$right_column_width = 140; // Width for the SDG list
$row_height = 6; // Row height
// Add left column
$pdf->SetFont($arialBold, '', 11);
$pdf->Cell($left_width, $row_height, 'V. AGENDA:', 0, 0, 'L');

// Fetch selected SDGs from the form
$agenda = isset($_POST['agenda']) ? $_POST['agenda'] : [];

// Check if any SDGs are selected
if (!empty($agenda)) {
    // Concatenate the selected SDGs into a single string
    $selected_agenda = implode("\n", array_map('htmlspecialchars', $agenda));
} else {
    // Default text if no SDGs are selected
    $selected_agenda = 'None';
}

// Add right column with selected SDGs
$pdf->SetFont('arial', '', 11);
$pdf->MultiCell($right_width, $row_height, $selected_agenda, 0, 'L', false, 1, '', '', true);

// VI. RATIONALE
$pdf->SetFont($arialBold, '', 11);
$pdf->Cell(0, 10, 'VI. RATIONALE', 0, 1);
$pdf->SetFont('arial', '', 11);

// Fetch rationale input
$rationale = isset($_POST['rationale']) && !empty(trim($_POST['rationale'])) 
    ? htmlspecialchars(trim($_POST['rationale'])) 
    : 'Provide short rationale about your activity, focusing on who are the proponents and why this activity will be conducted.';

// Output rationale to PDF
$pdf->MultiCell(0, 10, $rationale, 0, 'L', false, 1, '', '', true);

// VII. DESCRIPTION
$pdf->SetFont($arialBold, '', 11);
$pdf->Cell(0, 10, 'VII. DESCRIPTION', 0, 1);
$pdf->SetFont('arial', '', 11);

// Fetch description input
$description = isset($_POST['description']) && !empty(trim($_POST['description'])) 
    ? htmlspecialchars(trim($_POST['description'])) 
    : 'Describe the event, focusing on when and where it will happen.';

// Output description to PDF
$pdf->MultiCell(0, 10, $description, 0, 'J', false, 1, '', '', true);
// VIII. OBJECTIVES
$pdf->SetFont($arialBold, '', 11);
$pdf->Cell(0, 10, 'VIII. OBJECTIVES', 0, 1);
$pdf->SetFont('arial', '', 11);

// Fetch general objective from the form
$generalObjective = isset($_POST['general_objective']) && !empty(trim($_POST['general_objective'])) 
    ? htmlspecialchars(trim($_POST['general_objective'])) 
    : "The general objective of this activity is to………………………………… Specifically, it aims to:";

// Output the general objective
$pdf->MultiCell(0, 10, $generalObjective, 0, 'L', false, 1, '', '', true);

// Fetch specific objectives from the form
$specificObjectives = isset($_POST['specific_objectives']) && is_array($_POST['specific_objectives']) 
    ? array_filter(array_map('trim', $_POST['specific_objectives'])) 
    : ["specific objective 1", "specific objective 2", "specific objective 3", "specific objective 4"];

// Output each specific objective with numbering and indentation
if (!empty($specificObjectives)) {
    foreach ($specificObjectives as $index => $objective) {
        $formattedObjective = ($index + 1) . ". " . htmlspecialchars($objective);
        $pdf->Cell(10); // Add indentation
        $pdf->MultiCell(0, 10, $formattedObjective, 0, 'L', false, 1, '', '', true);
    }
}
// IX. IMPLEMENTATION PLAN
$pdf->SetFont($arialBold, '', 11);
$pdf->Cell(0, 10, 'IX. IMPLEMENTATION PLAN:', 0, 1);
$pdf->Ln(5); // Add some space
$pdf->SetFont('arial', '', 11);

// Fetch data from the modal form
$activities = isset($_POST['activities']) && is_array($_POST['activities']) 
    ? array_filter(array_map('trim', $_POST['activities'])) 
    : [];

$targetDates = isset($_POST['target_dates']) && is_array($_POST['target_dates']) 
    ? array_filter($_POST['target_dates']) 
    : [];

// Ensure both arrays have the same length
$implementationPlan = [];
for ($i = 0; $i < count($activities); $i++) {
    if (!empty($activities[$i]) && !empty($targetDates[$i])) {
        $implementationPlan[] = [
            "activity" => htmlspecialchars($activities[$i]),
            "date" => htmlspecialchars($targetDates[$i]),
        ];
    }
}

// Default example data if no input is provided
if (empty($implementationPlan)) {
    $implementationPlan = [
        [
            "activity" => "Planning of the event (preparation of proposal, letters for communication, formation of committees, and target approval of the event)",
            "date" => "December 16-20, 2024"
        ],
        [
            "activity" => "Opening Program",
            "date" => "January 10, 2025 (8 a.m. to 9 a.m.)"
        ],
        [
            "activity" => "Conduct of different competitions",
            "date" => "January 10, 2025 (9 a.m. to 5 p.m.)"
        ],
        [
            "activity" => "Post Evaluation Meeting",
            "date" => "January 13, 2025"
        ]
    ];
}

// HTML Table for implementation plan
$html = '<table border="1" cellpadding="5" cellspacing="0" style="width: 100%; border-collapse: collapse;">';
$html .= '<tr>';
$html .= '<th style="text-align: center; width: 50%;">Activity</th>';
$html .= '<th style="text-align: center; width: 50%;">Target Date</th>';
$html .= '</tr>';

// Add table rows based on the data
foreach ($implementationPlan as $row) {
    $html .= '<tr>';
    $html .= '<td style="text-align: left;">' . $row['activity'] . '</td>';
    $html .= '<td style="text-align: left;">' . $row['date'] . '</td>';
    $html .= '</tr>';
}

$html .= '</table>';

// Output the table to the PDF using writeHTML
$pdf->writeHTML($html, true, false, true, false, '');

// X. IMPLEMENTING GUIDELINES
$pdf->Ln(10); // Add space before the section
$pdf->SetFont($arialBold, '', 11);
$pdf->Cell(0, 10, 'X. IMPLEMENTING GUIDELINES:', 0, 1);

// Fetch guidelines from the form input
$guidelines = isset($_POST['guidelines']) && is_array($_POST['guidelines']) 
    ? array_filter(array_map('trim', $_POST['guidelines'])) 
    : [];

// Default example guidelines if no input is provided
if (empty($guidelines)) {
    $guidelines = [
        "The ABC Organization Day will be conducted on January 10, 2025, from 8 a.m. to 5 p.m. at the CvSU-CCAT Campus Covered Court 1.",
        "Registration will start at 7 a.m.",
        "Venue will be kept clean while observing the Garbage-In-Garbage-Out policy.",
        "Upon approval, an excuse letter will be prepared and approved by the chairperson of the department and director for instruction.",
        "A letter for the utilization of Covered Court 1 will also be prepared with prior communication to the court custodian."
    ];
}

// Output each guideline with numbers
$pdf->SetFont('arial', '', 11);
foreach ($guidelines as $index => $guideline) {
    $formattedGuideline = ($index + 1) . ". " . htmlspecialchars($guideline); // Number each guideline
    $pdf->MultiCell(0, 10, $formattedGuideline, 0, 'L', false, 1, '', '', true);
}

// IX. FINANCIAL PLAN
$pdf->SetFont($arialBold, '', 11);
$pdf->Cell(0, 10, 'XI. FINANCIAL PLAN:', 0, 1);
$pdf->Ln(5); // Add some space
$pdf->SetFont('arial', '', 11);

// Query the database for event items (e.g., revenue or expense items) based on event_id

$sql = "SELECT description, quantity, amount, type FROM event_items WHERE event_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $event_id);
$stmt->execute();
$result = $stmt->get_result();

// Initialize arrays for revenue and expense items
$revenueItems = [];
$expenseItems = [];

// Assuming event_items have a "type" column (e.g., "revenue" or "expense")
while ($row = $result->fetch_assoc()) {
    if ($row['type'] == 'revenue') {
        $revenueItems[] = $row;
    } elseif ($row['type'] == 'expense') {
        $expenseItems[] = $row;
    }
}

// HTML content for the table, dynamically populated
$html = '

<h4>PROJECTED REVENUE</h4>
<table border="1" cellpadding="5" cellspacing="0" style="width: 100%; border-collapse: collapse;">
    <thead>
        <tr style="background-color: #E6E6E6; text-align: center;">
            <th>Description</th>
            <th>QTY</th>
            <th>UNIT PRICE</th>
            <th>TOTAL</th>
        </tr>
    </thead>
    <tbody>';

// Loop through the revenue items and create rows
$totalRevenue = 0;
foreach ($revenueItems as $item) {
    $totalAmount = $item['quantity'] * $item['amount']; // Calculate total amount
    $html .= '<tr>';
    $html .= '<td>' . $item['description'] . '</td>';
    $html .= '<td style="text-align: center;">' . $item['quantity'] . '</td>';
    $html .= '<td style="text-align: center;">' . number_format($item['amount'], 2) . '</td>';
    $html .= '<td style="text-align: center;">' . number_format($totalAmount, 2) . '</td>';
    $html .= '</tr>';
    $totalRevenue += $totalAmount;
}

$html .= '
        <tr>
            <td colspan="3" style="text-align: right;"><strong>Subtotal</strong></td>
            <td style="text-align: center;">' . number_format($totalRevenue, 2) . '</td>
        </tr>
    </tbody>
</table>

<br>
<h4>PROJECTED EXPENSES</h4>
<table border="1" cellpadding="5" cellspacing="0" style="width: 100%; border-collapse: collapse;">
    <thead>
        <tr style="background-color: #E6E6E6; text-align: center;">
            <th>Description</th>
            <th>QTY</th>
            <th>UNIT PRICE</th>
            <th>TOTAL</th>
        </tr>
    </thead>
    <tbody>';

// Loop through the expense items and create rows
$totalExpenses = 0;
foreach ($expenseItems as $item) {
    $totalAmount = $item['quantity'] * $item['amount']; // Calculate total amount
    $html .= '<tr>';
    $html .= '<td>' . $item['description'] . '</td>';
    $html .= '<td style="text-align: center;">' . $item['quantity'] . '</td>';
    $html .= '<td style="text-align: center;">' . number_format($item['amount'], 2) . '</td>';
    $html .= '<td style="text-align: center;">' . number_format($totalAmount, 2) . '</td>';
    $html .= '</tr>';
    $totalExpenses += $totalAmount;
}

$html .= '
        <tr>
            <td colspan="3" style="text-align: right;"><strong>Subtotal</strong></td>
            <td style="text-align: center;">' . number_format($totalExpenses, 2) . '</td>
        </tr>
    </tbody>
</table>

<br>
<table border="1" cellpadding="5" cellspacing="0" style="width: 100%; border-collapse: collapse;">
    <tr>
        <td colspan="3" style="text-align: right; font-weight: bold;">Projected Income</td>
        <td style="text-align: center;">' . number_format($totalRevenue - $totalExpenses, 2) . '</td>
    </tr>
</table>
';

// Output the HTML content to the PDF using TCPDF
$pdf->writeHTML($html, true, false, true, false, '');


// VI. RATIONALE
$pdf->SetFont($arialBold, '', 11);
$pdf->Cell(0, 10, 'XII. FUNDING SOURCE', 0, 1);
$pdf->SetFont('arial', '', 11);

// Fetch rationale input
$funding_source = isset($_POST['funding_source']) && !empty(trim($_POST['funding_source'])) 
    ? htmlspecialchars(trim($_POST['funding_source'])) 
    : 'Fund will come from the registration of participants. Income from this activity will be deposited on the bank account of ABC Organization and will be utilized for future activities.';

// Output rationale to PDF
$pdf->MultiCell(0, 10, $funding_source, 0, 'J', false, 1, '', '', true);


$pdf->Ln(10); // Space for signatures above names

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

$file_name = 'Project_Proposal_' . $eventTitle .date("F j, Y"). '.pdf';
$pdf->Output($file_name, 'I');

// Exit to ensure no extra output
    $_SESSION['project_proposal_success'] = "Project proposal generated successfully!";
        header("Location: reports.php"); // Redirect back to the modal page
        exit();
} catch (Exception $e) {
    // Return error response
    $_SESSION['project_proposal_error'] = "An error occurred: " . $e->getMessage();
        header("Location: reports.php");
        exit();
}
?>