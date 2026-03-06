<?php
/**
 * Session Validity Check Endpoint
 * Called via AJAX to verify if user session is still active
 * Returns JSON response
 */

header('Content-Type: application/json');
header('Cache-Control: no-cache, must-revalidate');

$PageSecurity = 0;
include('includes/session.inc');

// If session.inc allows us to reach here without redirecting, session is valid
if (isset($_SESSION['userid'])) {
    // Session is valid
    echo json_encode([
        'valid' => true,
        'userid' => $_SESSION['userid'],
        'username' => isset($_SESSION['realname']) ? $_SESSION['realname'] : 'User',
        'lastCheck' => date('Y-m-d H:i:s')
    ]);
} else {
    // Session has expired
    echo json_encode([
        'valid' => false,
        'message' => 'Session expired',
        'lastCheck' => date('Y-m-d H:i:s')
    ]);
}
?>
