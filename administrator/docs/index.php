<?php

require_once 'vendor/autoload.php';

use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\IOFactory;
use PhpOffice\PhpWord\Shared\Html;

// Retrieve HTML content of payroll slip page
$htmlContent = '<h1>Payroll Slip</h1><p>Employee Name: John Doe</p><p>Amount: $5000</p>'; // Fetch your HTML content here

// Create a new PHPWord object
$phpWord = new PhpWord();

// Add a section to the document
$section = $phpWord->addSection();

// Add the HTML content to the document
Html::addHtml($section, $htmlContent, false, false);

// Save the document
$filename = 'payroll_slip.docx';
$objWriter = IOFactory::createWriter($phpWord, 'Word2007');
$objWriter->save($filename);

// Set headers for file download
header("Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document");
header("Content-Disposition: attachment; filename=\"$filename\"");
header("Content-Length: " . filesize($filename));

// Output the file contents
readfile($filename);

// Delete the temporary file
unlink($filename);

exit();
