# PowerShell script to update OHA database for live server
$inputFile = "oha_website_fresh_export.sql"
$outputFile = "oha_website_PROPERLY_UPDATED.sql"

Write-Host "Reading database file..." -ForegroundColor Green
$content = Get-Content $inputFile -Raw

Write-Host "Updating table prefixes..." -ForegroundColor Yellow
# Replace table prefix from wp_ to BsTtR2fQpN_
$content = $content -replace '`wp_', '`BsTtR2fQpN_'
$content = $content -replace 'wp_', 'BsTtR2fQpN_'

Write-Host "Updating URLs in content..." -ForegroundColor Yellow
# Replace localhost URLs with live domain
$content = $content -replace 'http://localhost/oha-website', 'https://oha.omaniservers.com/website'
$content = $content -replace 'https://localhost/oha-website', 'https://oha.omaniservers.com/website'
$content = $content -replace 'localhost/oha-website', 'oha.omaniservers.com/website'

Write-Host "Updating WordPress core options..." -ForegroundColor Yellow
# Update WordPress core URLs in options table
$content = $content -replace "VALUES \('siteurl','[^']*localhost[^']*'\)", "VALUES ('siteurl','https://oha.omaniservers.com/website')"
$content = $content -replace "VALUES \('home','[^']*localhost[^']*'\)", "VALUES ('home','https://oha.omaniservers.com/website')"

# Update any remaining localhost references in serialized data
$content = $content -replace 'localhost\\\/oha-website', 'oha.omaniservers.com\\\/website'
$content = $content -replace 'localhost\\/oha-website', 'oha.omaniservers.com\\/website'

Write-Host "Saving updated database..." -ForegroundColor Green
$content | Set-Content $outputFile -Encoding UTF8

Write-Host "Database updated successfully!" -ForegroundColor Green
Write-Host "Output file: $outputFile" -ForegroundColor Cyan

# Show file size
$fileSize = (Get-Item $outputFile).Length / 1MB
Write-Host "File size: $([math]::Round($fileSize, 2)) MB" -ForegroundColor Cyan 