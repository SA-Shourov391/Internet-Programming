<?php
require_once "config.php";
require_once "db.php";

// Get ID passed in URL: example → generate_pdf.php?id=5
if (!isset($_GET['id'])) {
    die("No application ID provided!");
}

$id = intval($_GET['id']);

// Fetch record from DB
$query = "SELECT * FROM admission_applications WHERE id = $id";
$result = $conn->query($query);

if ($result->num_rows == 0) {
    die("Application not found!");
}

$data = $result->fetch_assoc();

// Load DOMPDF
require_once __DIR__ . "/dompdf/autoload.inc.php";
use Dompdf\Dompdf;
$dompdf = new Dompdf();

// Create HTML for PDF
$html = "
<h2 style='text-align:center;'>Admission Slip</h2>
<hr>
<p><strong>Name:</strong> {$data['fullname']}</p>
<p><strong>Email:</strong> {$data['email']}</p>
<p><strong>Phone:</strong> {$data['phone']}</p>
<p><strong>Program:</strong> {$data['program']}</p>
<p><strong>Department:</strong> {$data['department']}</p>
<p><strong>Gender:</strong> {$data['gender']}</p>
<p><strong>Date of Birth:</strong> {$data['date_of_birth']}</p>
<p><strong>Address:</strong> {$data['address']}</p>
<p><strong>Submitted:</strong> {$data['created_at']}</p>
<hr>
<p style='text-align:center;'>Thank you for applying.</p>
";

// Load PDF
$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'portrait');

$dompdf->render();
$dompdf->stream("admission_slip.pdf", ["Attachment" => true]);
?>
