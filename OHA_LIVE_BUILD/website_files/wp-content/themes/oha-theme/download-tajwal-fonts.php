<?php
/**
 * Script to download Tajwal fonts locally
 * Run this script once to download the fonts to your local theme
 */

// Only run this if accessing directly
if (basename(__FILE__) == basename($_SERVER["SCRIPT_FILENAME"])) {
    
    echo "<h1>OHA Tajwal Font Downloader</h1>";
    echo "<p>This script will help you download Tajwal fonts locally to avoid Google Fonts loading issues.</p>";
    
    $fonts_dir = __DIR__ . '/assets/fonts/tajwal/';
    
    // Create directory if it doesn't exist
    if (!file_exists($fonts_dir)) {
        mkdir($fonts_dir, 0755, true);
        echo "<p>✓ Created fonts directory: $fonts_dir</p>";
    }
    
    // Font weight mappings
    $font_weights = [
        '200' => 'ExtraLight',
        '300' => 'Light', 
        '400' => 'Regular',
        '500' => 'Medium',
        '700' => 'Bold',
        '800' => 'ExtraBold',
        '900' => 'Black'
    ];
    
    echo "<h2>To download Tajwal fonts:</h2>";
    echo "<ol>";
    echo "<li>Visit: <a href='https://fonts.google.com/specimen/Tajwal' target='_blank'>Google Fonts - Tajwal</a></li>";
    echo "<li>Click 'Download family' button</li>";
    echo "<li>Extract the downloaded ZIP file</li>";
    echo "<li>Copy the font files to: <code>$fonts_dir</code></li>";
    echo "<li>Refresh this page to see if fonts are detected</li>";
    echo "</ol>";
    
    // Check if fonts exist
    echo "<h2>Font Status:</h2>";
    $fonts_found = 0;
    foreach ($font_weights as $weight => $name) {
        $ttf_file = $fonts_dir . "Tajwal-$name.ttf";
        if (file_exists($ttf_file)) {
            echo "<p>✓ Found: Tajwal-$name.ttf</p>";
            $fonts_found++;
        } else {
            echo "<p>✗ Missing: Tajwal-$name.ttf</p>";
        }
    }
    
    if ($fonts_found > 0) {
        echo "<h2>🎉 Fonts found! You can now enable local Tajwal fonts.</h2>";
        echo "<p>Update your CSS to use local fonts instead of Google Fonts.</p>";
    } else {
        echo "<h2>No fonts found. Please download them manually.</h2>";
    }
    
    echo "<h2>Alternative: Use Font CDN</h2>";
    echo "<p>If Google Fonts doesn't work, you can try:</p>";
    echo "<ul>";
    echo "<li><a href='https://cdn.jsdelivr.net/npm/@fontsource/tajwal@4.5.0/400.css' target='_blank'>jsDelivr CDN</a></li>";
    echo "<li><a href='https://fonts.bunny.net/css?family=tajwal:200,300,400,500,700,800,900' target='_blank'>Bunny Fonts</a></li>";
    echo "</ul>";
    
} else {
    // If included in WordPress, don't output anything
    return;
}
?> 