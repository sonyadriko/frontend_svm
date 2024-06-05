<?php
// File path to the Excel file to be deleted
$file_path = '../../backend/data_tweet.csv';

// Check if the file exists before attempting to delete it
if (file_exists($file_path)) {
    // Attempt to delete the file
    if (unlink($file_path)) {
        $response = array('success' => true);
    } else {
        $response = array('success' => false);
    }
} else {
    $response = array('success' => false);
}

// Return the response as JSON
header('Content-Type: application/json');
echo json_encode($response);
?>