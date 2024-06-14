<?php
    // session_start();
    $conn = oci_connect('Nischal', 'Nischal', '//localhost/xe'); if (!$conn) {
        $m = oci_error();
        echo $m['message'], "\n";
        // exit;
    }
?>