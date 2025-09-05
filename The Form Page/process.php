<?php
// process.php - Handles form data and displays it back

/**
 * Function to sanitize user input (SECURITY CONCEPT)
 * @param string $data - The raw input data
 * @return string - Sanitized data
 */
function sanitizeInput($data) {
    $data = trim($data);                // Remove whitespace
    $data = stripslashes($data);        // Remove backslashes
    $data = htmlspecialchars($data);    // Convert special chars to HTML entities
    return $data;
}

/**
 * Function to display the submitted data
 * @param array $formData - Associative array containing form data
 */
function displayFormData($formData) {
    echo "<div class='result-container'>";
    echo "<h2>Form Submission Received!</h2>";
    echo "<p>Here's what you submitted:</p>";

    echo "<ul>";
    foreach ($formData as $key => $value) {
        // Skip the submit button value in display
        if ($key !== 'submit') {
            echo "<li><strong>" . ucfirst($key) . ":</strong> " . $value . "</li>";
        }
    }
    echo "</ul>";

    echo "<a href='index.html' class='back-btn'>Go Back</a>";
    echo "</div>";
}

// MAIN EXECUTION STARTS HERE

// Check if form was submitted using POST method
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Create an associative array to store sanitized data
    $submittedData = array();

    // Process each form field using $_POST superglobal
    $submittedData['name'] = sanitizeInput($_POST['name']);
    $submittedData['email'] = sanitizeInput($_POST['email']);
    $submittedData['message'] = sanitizeInput($_POST['message']);

    // Display the HTML header
    echo "<!DOCTYPE html>
    <html lang='en'>
    <head>
        <meta charset='UTF-8'>
        <meta name='viewport' content='width=device-width, initial-scale=1.0'>
        <title>Form Submission Result</title>
        <link rel='stylesheet' href='style.css'>
    </head>
    <body>";

    // Call our function to display the data
    displayFormData($submittedData);

    // Debug section - show raw POST data (for learning)
    echo "<div class='debug-container'>";
    echo "<h3>Debug Information (Raw POST Data):</h3>";
    echo "<pre>";
    echo "Request Method: " . $_SERVER['REQUEST_METHOD'] . "\n";
    print_r($_POST);
    echo "</pre>";
    echo "</div>";

    echo "</body></html>";

} else {
    // If someone tries to access process.php directly without submitting form
    echo "<!DOCTYPE html>
    <html>
    <head>
        <title>Error</title>
        <link rel='stylesheet' href='style.css'>
    </head>
    <body>
        <div class='error-container'>
            <h2>Oops! No form data received.</h2>
            <p>Please submit the form from the <a href='index.html'>contact page</a>.</p>
            <p>Server Request Method: " . $_SERVER['REQUEST_METHOD'] . "</p>
        </div>
    </body>
    </html>";
}
?>