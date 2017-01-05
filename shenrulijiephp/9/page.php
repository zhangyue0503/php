<?php # page.php - Script 9.9
// This page displays a single page of content.

// Need the utilities file:
require('includes/utilities.inc.php');

try {
    
    // Validate the page ID:
    if (!isset($_GET['id']) || !filter_var($_GET['id'], FILTER_VALIDATE_INT, array('min_range' => 1))) {
        throw new Exception('An invalid page ID was provided to this page.');
    }
    
    // Fetch the page from the database:
    $q = 'SELECT id, creatorId, title, content, DATE_FORMAT(dateAdded, "%e %M %Y") AS dateAdded FROM pages WHERE id=:id'; 
    $stmt = $pdo->prepare($q);
    $r = $stmt->execute(array(':id' => $_GET['id']));

    // If the query ran okay, fetch the record into an object:
    if ($r) {
        $stmt->setFetchMode(PDO::FETCH_CLASS, 'Page');
        $page = $stmt->fetch();
        
        // Confirm that it exists:
        if ($page) {
   
            // Set the browser title to the page title:
            $pageTitle = $page->getTitle();
   
            // Create the page:
            include('includes/header.inc.php');
            include('views/page.html');
            
        } else {
            throw new Exception('An invalid page ID was provided to this page.');
        }
    
    } else {
        throw new Exception('An invalid page ID was provided to this page.');       
    }

} catch (Exception $e) { // Catch generic Exceptions.

    $pageTitle = 'Error!';
    include('includes/header.inc.php');
    include('views/error.html');

}

// Include the footer:
include('includes/footer.inc.php');
?>