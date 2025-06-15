<?php
/**
 * Simple script to create placeholder partner logos
 * Run this once to generate placeholder images
 */

// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Check if GD extension is available
if (!extension_loaded('gd')) {
    die('GD extension is not available');
}

// Create partners directory if it doesn't exist
$partnersDir = __DIR__ . '/partners';
if (!is_dir($partnersDir)) {
    mkdir($partnersDir, 0755, true);
}

// Partner logos to create
$partners = array(
    array(
        'name' => 'Oman Olympic Committee',
        'filename' => 'oman-olympic-committee.png',
        'width' => 80,
        'height' => 80,
        'bg_color' => array(255, 255, 255), // White background
        'text_color' => array(229, 32, 29), // Red text
        'text' => 'OOC'
    ),
    array(
        'name' => 'BADR AL SAMAA',
        'filename' => 'badr-al-samaa.png',
        'width' => 120,
        'height' => 50,
        'bg_color' => array(255, 255, 255), // White background
        'text_color' => array(0, 100, 200), // Blue text
        'text' => 'BADR AL SAMAA'
    ),
    array(
        'name' => 'JINDAL STEEL',
        'filename' => 'jindal-steel.png',
        'width' => 120,
        'height' => 50,
        'bg_color' => array(255, 255, 255), // White background
        'text_color' => array(88, 170, 53), // Green text
        'text' => 'JINDAL STEEL'
    )
);

foreach ($partners as $partner) {
    // Create image
    $image = imagecreate($partner['width'], $partner['height']);
    
    // Allocate colors
    $bg_color = imagecolorallocate($image, $partner['bg_color'][0], $partner['bg_color'][1], $partner['bg_color'][2]);
    $text_color = imagecolorallocate($image, $partner['text_color'][0], $partner['text_color'][1], $partner['text_color'][2]);
    $border_color = imagecolorallocate($image, 200, 200, 200); // Light gray border
    
    // Fill background
    imagefill($image, 0, 0, $bg_color);
    
    // Add border
    imagerectangle($image, 0, 0, $partner['width']-1, $partner['height']-1, $border_color);
    
    // Add text
    $font_size = ($partner['width'] > 100) ? 3 : 2; // Smaller font for smaller images
    $text_width = imagefontwidth($font_size) * strlen($partner['text']);
    $text_height = imagefontheight($font_size);
    
    $x = ($partner['width'] - $text_width) / 2;
    $y = ($partner['height'] - $text_height) / 2;
    
    imagestring($image, $font_size, $x, $y, $partner['text'], $text_color);
    
    // Save image
    $filepath = $partnersDir . '/' . $partner['filename'];
    imagepng($image, $filepath);
    imagedestroy($image);
    
    echo "Created: " . $partner['filename'] . "\n";
}

echo "All placeholder images created successfully!\n";
?> 