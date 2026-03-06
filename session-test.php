<?php
/**
 * Session Diagnostics Page
 * Tests PHP session functionality and Form ID persistence
 * Delete this file after testing
 */

// Set session name BEFORE session_start() to match the application
session_name('ErpWithCRM');
session_start();

header('Content-Type: text/html; charset=UTF-8');
?>
<!DOCTYPE html>
<html>
<head>
    <title>Session Test</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        .test { margin: 20px 0; padding: 10px; border: 1px solid #ccc; }
        .pass { background-color: #d4edda; color: #155724; }
        .fail { background-color: #f8d7da; color: #721c24; }
        .info { background-color: #d1ecf1; color: #0c5460; }
        code { background-color: #f5f5f5; padding: 2px 5px; }
    </style>
</head>
<body>
    <h1>Session Diagnostics Test</h1>
    
    <?php
    // Store test value in session
    $_SESSION['DiagnosticTest'] = 'Test_' . time();
    $testValue = $_SESSION['DiagnosticTest'];
    $sessionId = session_id();
    $sessionName = session_name();
    
    // Get PHP session info
    $sessionPath = ini_get('session.save_path');
    $sessionHandler = ini_get('session.save_handler');
    $useOnlyCookies = ini_get('session.use_only_cookies');
    $gcMaxLifetime = ini_get('session.gc_maxlifetime');
    
    ?>
    
    <div class="test info">
        <h3>Session Configuration</h3>
        <p><strong>Session Name:</strong> <code><?php echo $sessionName; ?></code></p>
        <p><strong>Session ID:</strong> <code><?php echo $sessionId; ?></code></p>
        <p><strong>Session Save Path:</strong> <code><?php echo $sessionPath ?: '(default)'; ?></code></p>
        <p><strong>Session Handler:</strong> <code><?php echo $sessionHandler; ?></code></p>
        <p><strong>Use Only Cookies:</strong> <code><?php echo $useOnlyCookies ? 'Yes (1)' : 'No (0)'; ?></code></p>
        <p><strong>GC Max Lifetime:</strong> <code><?php echo $gcMaxLifetime; ?> seconds</code></p>
    </div>
    
    <div class="test info">
        <h3>Session Data Test</h3>
        <p><strong>Test Value Set:</strong> <code><?php echo $testValue; ?></code></p>
        <p><strong>Session Data Count:</strong> <?php echo count($_SESSION); ?> items</p>
        <p><strong>FormID in Session:</strong> <code><?php echo isset($_SESSION['FormID']) ? substr($_SESSION['FormID'], 0, 20) . '...' : 'NOT SET'; ?></code></p>
    </div>
    
    <div class="test info">
        <h3>Cookie Test</h3>
        <p>On the first load, a session cookie should be created.</p>
        <p><strong>Session Cookie Name:</strong> <code><?php echo $sessionName; ?></code></p>
        <?php
        $cookieSet = isset($_COOKIE[$sessionName]);
        if ($cookieSet) {
            echo '<p class="pass"><strong style="color:green;">✓ PASS:</strong> Session cookie is present in <code>$_COOKIE</code></p>';
            echo '<p><strong>Cookie Value:</strong> <code>' . $_COOKIE[$sessionName] . '</code></p>';
        } else {
            echo '<p class="fail"><strong style="color:red;">✗ FAIL:</strong> Session cookie is NOT present in <code>$_COOKIE</code></p>';
            echo '<p><em>This means the browser is either not accepting cookies or the session cookie was not sent.</em></p>';
        }
        ?>
    </div>
    
    <div class="test">
        <h3>Form Test - Test Session Persistence</h3>
        <p><strong>Instructions:</strong></p>
        <ol>
            <li>Complete this form and submit it</li>
            <li>The test value from this request should appear on the next page</li>
            <li>If it appears, session persistence is working</li>
            <li>If it doesn't appear, there's an issue with session persistence</li>
        </ol>
        
        <form method="POST" action="">
            <input type="hidden" name="test" value="1">
            <input type="hidden" name="FormID" value="<?php echo isset($_SESSION['FormID']) ? htmlspecialchars($_SESSION['FormID']) : 'NOT SET'; ?>">
            <button type="submit">Submit Tests</button>
        </form>
    </div>
    
    <?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['test'])) {
        $previousValue = isset($_SESSION['DiagnosticTest']) ? $_SESSION['DiagnosticTest'] : 'NOT FOUND';
        $currentValue = 'Test_' . time();
        $_SESSION['DiagnosticTest'] = $currentValue;
        $formIdMatch = isset($_POST['FormID']) && $_POST['FormID'] === $_SESSION['FormID'];
        
        echo '<div class="test">';
        echo '<h3>Form Submission Results</h3>';
        
        // Check if session persisted
        if (strpos($previousValue, 'Test_') === 0) {
            echo '<p class="pass"><strong style="color:green;">✓ PASS:</strong> Session values persisted between requests</p>';
            echo '<p><strong>Previous Test Value:</strong> <code>' . $previousValue . '</code></p>';
            echo '<p><strong>Current Test Value:</strong> <code>' . $currentValue . '</code></p>';
        } else {
            echo '<p class="fail"><strong style="color:red;">✗ FAIL:</strong> Session values did NOT persist</p>';
            echo '<p><strong>Expected Previous Value:</strong> <code>Test_*</code></p>';
            echo '<p><strong>Got:</strong> <code>' . $previousValue . '</code></p>';
        }
        
        echo '<br>';
        
        // Check FormID match
        if ($formIdMatch) {
            echo '<p class="pass"><strong style="color:green;">✓ PASS:</strong> FormID matches between requests</p>';
        } else {
            echo '<p class="fail"><strong style="color:red;">✗ FAIL:</strong> FormID does NOT match</p>';
            echo '<p><strong>Submitted FormID:</strong> <code>' . substr($_POST['FormID'], 0, 20) . '...</code></p>';
            echo '<p><strong>Session FormID:</strong> <code>' . substr($_SESSION['FormID'], 0, 20) . '...</code></p>';
            echo '<p><em>This indicates the session is not persisting properly.</em></p>';
        }
        
        echo '</div>';
    }
    ?>
    
    <div class="test info">
        <h3>Troubleshooting Tips</h3>
        <ul>
            <li><strong>Session cookie not sent:</strong> Check PHP's session configuration and ensure cookies are enabled in your browser</li>
            <li><strong>FormID mismatch:</strong> Indicates the session is being reset between requests. Check if the session save path is writable or if there's a redirect happening</li>
            <li><strong>Session values not persisting:</strong> The session might be corrupted or the session file might not be readable</li>
            <li><strong>On Windows:</strong> Ensure the temp directory and session.save_path are writable. Check <code>php.ini</code> for session settings</li>
        </ul>
    </div>
    
    <hr>
    <p><small><em>This is a diagnostic page. Delete <code>session-test.php</code> after testing.</em></small></p>
</body>
</html>
