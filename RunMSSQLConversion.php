<?php
/**
 * Comprehensive MSSQL to MySQL Conversion Script
 * This script converts all MSSQL syntax to MySQL syntax across all PHP files
 */

// Track all changes
$stats = [
    'files_processed' => 0,
    'files_modified' => 0,
    'bracket_replacements' => 0,
    'isnull_replacements' => 0,
    'getdate_replacements' => 0,
    'errors' => []
];

// Function to recursively process all PHP files
function processDirectory($dir, &$stats) {
    $files = scandir($dir);
    
    foreach ($files as $file) {
        if ($file === '.' || $file === '..') continue;
        
        $filepath = $dir . DIRECTORY_SEPARATOR . $file;
        
        // Skip certain directories
        if (is_dir($filepath)) {
            $skipDirs = ['vendor', 'node_modules', 'includes/vendor', '.git', 'nbproject'];
            if (!in_array($file, $skipDirs)) {
                processDirectory($filepath, $stats);
            }
            continue;
        }
        
        // Only process PHP files
        if (pathinfo($filepath, PATHINFO_EXTENSION) !== 'php') {
            continue;
        }
        
        $stats['files_processed']++;
        processFile($filepath, $stats);
    }
}

function processFile($filepath, &$stats) {
    $original = file_get_contents($filepath);
    $content = $original;
    
    // Count replacements before
    $bracket_count = preg_match_all('/\[[a-zA-Z_][a-zA-Z0-9_]*\]/', $content);
    $isnull_count = preg_match_all('/isnull\s*\(/i', $content);
    $getdate_count = preg_match_all('/GETDATE\s*\(\)/i', $content);
    
    // 1. Replace `TableName`.`ColumnName` with `TableName`.`ColumnName`
    $content = preg_replace('/\[([a-zA-Z_][a-zA-Z0-9_]*)\]\.\[([a-zA-Z_][a-zA-Z0-9_]*)\]/', '`$1`.`$2`', $content);
    
    // 2. Replace `ColumnName` with `ColumnName` (remaining)
    $content = preg_replace('/\[([a-zA-Z_][a-zA-Z0-9_]*)\]/', '`$1`', $content);
    
    // 3. Replace IFNULL() with IFNULL()
    $content = preg_replace_callback('/isnull\s*\(\s*([^,]+)\s*,\s*([^)]+)\s*\)/i', function($m) {
        return 'IFNULL(' . trim($m[1]) . ',' . trim($m[2]) . ')';
    }, $content);
    
    // 4. Replace NOW() with NOW()
    $content = preg_replace('/GETDATE\s*\(\)/i', 'NOW()', $content);
    
    // 5. Replace CAST(... AS ...) with CAST syntax (MySQL compatible, but note differences)
    // This is already mostly compatible, but let's standardize some common cases
    
    // 6. Remove MSSQL-specific functions like sp_MSforeachtable (these are handled in the wrapper)
    
    // Check if content changed
    if ($content !== $original) {
        $stats['files_modified']++;
        $stats['bracket_replacements'] += $bracket_count;
        $stats['isnull_replacements'] += $isnull_count;
        $stats['getdate_replacements'] += $getdate_count;
        
        // Write back
        if (file_put_contents($filepath, $content) === false) {
            $stats['errors'][] = "Failed to write: $filepath";
        } else {
            echo "✓ " . basename($filepath) . " - $bracket_count brackets, $isnull_count isnull, $getdate_count GETDATE\n";
        }
    }
}

// Get workspace root
$root = dirname(__FILE__);

echo "=== MSSQL to MySQL Conversion Starting ===\n";
echo "Root directory: $root\n\n";

processDirectory($root, $stats);

echo "\n=== Conversion Complete ===\n";
echo "Files processed: " . $stats['files_processed'] . "\n";
echo "Files modified: " . $stats['files_modified'] . "\n";
echo "Bracket replacements: " . $stats['bracket_replacements'] . "\n";
echo "ISNULL replacements: " . $stats['isnull_replacements'] . "\n";
echo "GETDATE replacements: " . $stats['getdate_replacements'] . "\n";

if (!empty($stats['errors'])) {
    echo "\nErrors:\n";
    foreach ($stats['errors'] as $error) {
        echo "- $error\n";
    }
}

echo "\nConversion script finished!\n";
?>
