<?php
// Function to log errors to a file
function log_error($message) {
    $log_file = 'error_log.txt';
    
    // Check if the error log file exists, if not, create it
    if (!file_exists($log_file)) {
        // Create the file if it doesn't exist
        file_put_contents($log_file, "Error log created on: " . date('Y-m-d H:i:s') . PHP_EOL);
    }
    
    // Add the error message to the log file
    $current_time = date('Y-m-d H:i:s');
    $log_message = "[$current_time] - $message" . PHP_EOL;
    file_put_contents($log_file, $log_message, FILE_APPEND);
}
?>