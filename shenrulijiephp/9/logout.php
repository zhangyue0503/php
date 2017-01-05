<?php # logout.php - Script 9.14
// This page logs the user out.

// Need the utilities file:
require('includes/utilities.inc.php');

// Check for a user before attempting to actually log them out:
if ($user) {
    
    // Clear the variable:
    $user = null;
    
    // Clear the session data:
    $_SESSION = array();
    
    // Clear the cookie:
    setcookie(session_name(), false, time()-3600);
    
    // Destroy the session data:
    session_destroy();
    
} // End of $user IF.

// Set the page title and include the header:
$pageTitle = 'Logout';
include('includes/header.inc.php');

// Need the view:
include('views/logout.html');

// Include the footer:
include('includes/footer.inc.php');
?>