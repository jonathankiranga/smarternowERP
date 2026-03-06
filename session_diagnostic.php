<?php
// Session diagnostic
echo "<h2>Session Configuration Diagnostic</h2>";

// 1. Check session save path
$save_path = ini_get('session.save_path');
echo "<p><strong>session.save_path:</strong> " . ($save_path ?: "(empty/default)") . "</p>";

// Get actual save path being used
$actual_path = session_save_path();
echo "<p><strong>Actual session save path:</strong> " . $actual_path . "</p>";

// 2. Check if path exists and is writable
if ($actual_path && is_dir($actual_path)) {
    echo "<p style='color:green;'>✓ Session directory EXISTS</p>";
    if (is_writable($actual_path)) {
        echo "<p style='color:green;'>✓ Session directory is WRITABLE</p>";
    } else {
        echo "<p style='color:red;'>✗ Session directory is NOT WRITABLE</p>";
    }
} else {
    echo "<p style='color:red;'>✗ Session directory DOES NOT EXIST or is not accessible</p>";
}

// 3. Start session and check
session_start();
$session_id = session_id();
echo "<p><strong>Current Session ID:</strong> " . $session_id . "</p>";

// 4. Check if session file exists
$session_file = $actual_path . '/sess_' . $session_id;
if (file_exists($session_file)) {
    echo "<p style='color:green;'>✓ Session FILE exists: " . $session_file . "</p>";
    $file_size = filesize($session_file);
    $file_content = file_get_contents($session_file);
    echo "<p><strong>File Size:</strong> " . $file_size . " bytes</p>";
    echo "<p><strong>File Content:</strong> <pre>" . htmlspecialchars($file_content) . "</pre></p>";
} else {
    echo "<p style='color:red;'>✗ Session FILE does not exist: " . $session_file . "</p>";
}

// 5. Set a test session variable
$_SESSION['TestVariable'] = 'Test Value ' . time();
echo "<p><strong>Set test variable:</strong> \$_SESSION['TestVariable'] = " . $_SESSION['TestVariable'] . "</p>";

// 6. List all files in session directory
echo "<h3>All session files in directory:</h3>";
if ($actual_path && is_dir($actual_path)) {
    $files = array_filter(scandir($actual_path), function($f) {
        return strpos($f, 'sess_') === 0;
    });
    if (count($files) > 0) {
        echo "<p>Total session files: " . count($files) . "</p>";
        echo "<pre>";
        foreach ($files as $f) {
            $mtime = filemtime($actual_path . '/' . $f);
            $size = filesize($actual_path . '/' . $f);
            echo $f . " (size: $size bytes, modified: " . date('Y-m-d H:i:s', $mtime) . ")\n";
        }
        echo "</pre>";
    } else {
        echo "<p style='color:red;'>No session files found in directory!</p>";
    }
}

?>
