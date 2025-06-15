# PowerShell script to update OHA database for live server deployment
# This script changes all localhost/oha-website URLs to live server /website/ URLs

Write-Host "Starting OHA Database URL Update for Live Server..." -ForegroundColor Green

# Input and output files
$inputFile = "oha_website_for_live_server.sql"
$outputFile = "oha_website_READY_FOR_LIVE.sql"

# Check if input file exists
if (-not (Test-Path $inputFile)) {
    Write-Host "Error: Input file $inputFile not found!" -ForegroundColor Red
    exit 1
}

Write-Host "Reading database file..." -ForegroundColor Yellow
$content = Get-Content $inputFile -Raw

Write-Host "Updating URLs..." -ForegroundColor Yellow

# Update all localhost/oha-website URLs to live server URLs
$content = $content -replace 'http://localhost/oha-website', 'https://oha.omaniservers.com/website'
$content = $content -replace 'https://localhost/oha-website', 'https://oha.omaniservers.com/website'
$content = $content -replace 'localhost/oha-website', 'oha.omaniservers.com/website'

# Handle serialized data (WordPress stores some data in serialized format)
# This is crucial for image URLs and theme options
$content = $content -replace 'localhost\\\/oha-website', 'oha.omaniservers.com\\\/website'
$content = $content -replace 'localhost\\/oha-website', 'oha.omaniservers.com\\/website'

# Update table prefix references (from uppercase to lowercase)
$content = $content -replace 'BsTtR2fQpN_', 'bsttr2fqpn_'

# Fix any remaining HTTP references to use HTTPS
$content = $content -replace 'http://oha\.omaniservers\.com', 'https://oha.omaniservers.com'

Write-Host "Saving updated database file..." -ForegroundColor Yellow
$content | Out-File -FilePath $outputFile -Encoding UTF8

Write-Host "Database update completed successfully!" -ForegroundColor Green
Write-Host "Output file: $outputFile" -ForegroundColor Cyan

# Show file sizes for verification
$inputSize = (Get-Item $inputFile).Length / 1MB
$outputSize = (Get-Item $outputFile).Length / 1MB

Write-Host "`nFile Information:" -ForegroundColor White
Write-Host "Input file size: $([math]::Round($inputSize, 2)) MB" -ForegroundColor Gray
Write-Host "Output file size: $([math]::Round($outputSize, 2)) MB" -ForegroundColor Gray

Write-Host "`nNext Steps:" -ForegroundColor White
Write-Host "1. Upload the WordPress files to your live server" -ForegroundColor Gray
Write-Host "2. Replace wp-config.php with wp-config-for-live.php" -ForegroundColor Gray
Write-Host "3. Replace .htaccess with .htaccess-for-live" -ForegroundColor Gray
Write-Host "4. Import $outputFile into your live database" -ForegroundColor Gray
Write-Host "5. Test the website at https://oha.omaniservers.com/website/" -ForegroundColor Gray

Write-Host "`nDatabase is ready for live deployment!" -ForegroundColor Green 