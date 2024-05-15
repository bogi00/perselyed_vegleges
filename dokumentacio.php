<?php
$file = 'Dokumentacio_perselyed.docx';

if (file_exists($file)) {
    header('Content-Description: File Transfer');
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename="'.basename($file).'"');
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
    header('Content-Length: ' . filesize($file));
    readfile($file);
	echo 'A dokumentáció sikeresen letöltve.';
	
} else {
    echo 'A fájl nem található.';
}
?>
