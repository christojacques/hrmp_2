<?php
$data='<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
<style type="text/css" media="screen">
.noprint{
display:none !importent;
}
table tr{
border:1px solid #000;
}
table th{
border:1px solid #000;
}
table td{
border:1px solid #000;
}
table{
text-wrap: nowrap;
text-size:12px;
}
table {
page-break-inside: avoid;
}
</style>';
$data.=$_POST['data'];
?>
<?php
require 'vendor/autoload.php';
use Dompdf\Dompdf;
use Dompdf\Options;
$options = new Options();
$options->set('isRemoteEnabled', true);
$dompdf = new Dompdf($options);
$dompdf->loadHtml($data);
$dompdf->setPaper('A4', 'portrait');//portrait
try {
$dompdf->render();
} catch (Exception $e) {
echo 'Error: ' . $e->getMessage();
exit();
}
$pdfFilename = $_POST['filename'];
$dompdf->stream($pdfFilename, array("Attachment" => true));
exit();
?>
