# Fix News Page Images - OHA Website

## Problem Analysis
The featured images appear in WordPress admin but not on the news page (`https://oha.omaniservers.com/website/latest-news/`) because:

1. **Template uses `get_the_post_thumbnail_url()`** - This function gets URLs from the database
2. **Database still has localhost URLs** - Image attachment URLs weren't fully updated
3. **Serialized data issue** - WordPress stores image metadata in serialized format with string lengths

## Root Cause
Looking at the news template (`page-latest-news.php`), it uses:
```php
get_the_post_thumbnail_url( get_the_ID(), 'large' )
```

This function retrieves URLs from:
- `bsttr2fqpn_posts.guid` (attachment URLs)
- `bsttr2fqpn_postmeta._wp_attachment_metadata` (image sizes/URLs)

## Solution Steps

### Step 1: Update wp-config.php
Use the corrected `wp-config-live.php` file created earlier.

### Step 2: Run Comprehensive Image URL Fix
Execute the `fix_thumbnail_urls.sql` script which specifically targets:
- Attachment GUIDs
- Serialized attachment metadata
- Theme customizer settings
- Widget content
- BeTheme/Muffin Builder content

### Step 3: Clear All Caches
After running the SQL script:
1. **WordPress Object Cache**: If using caching plugins, clear them
2. **Browser Cache**: Hard refresh (Ctrl+F5)
3. **CDN Cache**: If using Cloudflare or similar, purge cache

## Implementation Instructions

### Method 1: Via phpMyAdmin (Recommended)
1. Login to your hosting control panel
2. Go to **Databases** → **phpMyAdmin**
3. Select database `wordpress_e`
4. Click **SQL** tab
5. Copy and paste the entire content from `fix_thumbnail_urls.sql`
6. Click **Go** to execute

### Method 2: Via MySQL Command Line
```bash
mysql -u admin_wordpress_6 -p wordpress_e < fix_thumbnail_urls.sql
```

## Verification Steps

### 1. Check Database URLs
After running the script, verify in phpMyAdmin:
```sql
SELECT guid FROM bsttr2fqpn_posts 
WHERE post_type = 'attachment' AND post_mime_type LIKE 'image%' 
LIMIT 5;
```
Should show URLs starting with `https://oha.omaniservers.com/website/`

### 2. Test News Page
1. Visit: `https://oha.omaniservers.com/website/latest-news/`
2. Check if featured images appear in news cards
3. Inspect element to see if background-image URLs are correct

### 3. Check WordPress Admin
1. Go to **Media Library**
2. Verify images display correctly
3. Check individual post edit pages

## Template Analysis
The news page uses these key functions for images:
- `has_post_thumbnail()` - Checks if post has featured image
- `get_the_post_thumbnail_url()` - Gets the image URL
- Background image CSS: `style="background-image:url('...')"`

## Common Issues & Solutions

### Issue: Images still not showing after SQL fix
**Cause**: Browser/server caching
**Solution**: 
- Clear browser cache (Ctrl+Shift+R)
- If using caching plugins, clear all caches
- Check browser developer tools for 404 errors

### Issue: Some images work, others don't
**Cause**: Mixed localhost/live URLs in database
**Solution**: Run the SQL script again, it's safe to run multiple times

### Issue: Images show in admin but not frontend
**Cause**: Theme template issue or URL mismatch
**Solution**: 
1. Check if `wp-config.php` has correct URLs
2. Verify file permissions on uploads directory
3. Test with a different theme temporarily

### Issue: 404 errors for image files
**Cause**: Files not uploaded or wrong permissions
**Solution**:
1. Verify files exist in `wp-content/uploads/`
2. Check file permissions (644 for files, 755 for directories)
3. Re-upload uploads folder if necessary

## File Permissions Check
Ensure correct permissions:
```
wp-content/uploads/ - 755
wp-content/uploads/2024/ - 755
wp-content/uploads/2024/04/ - 755
*.jpg, *.png, *.gif files - 644
```

## Debug Mode
Temporarily enable debug mode in wp-config.php:
```php
define('WP_DEBUG', true);
define('WP_DEBUG_LOG', true);
define('WP_DEBUG_DISPLAY', true);
```

Check `/wp-content/debug.log` for any image-related errors.

## Expected Results
After implementing the fix:
- ✅ News page shows featured images as background images
- ✅ Image URLs start with `https://oha.omaniservers.com/website/`
- ✅ No 404 errors in browser console
- ✅ Images load quickly without broken image icons

## Files Created
- `fix_thumbnail_urls.sql` - Comprehensive image URL fix script
- `wp-config-live.php` - Corrected WordPress configuration
- `NEWS_PAGE_IMAGE_FIX.md` - This troubleshooting guide

## Support
If images still don't appear:
1. Check browser developer tools (F12) → Network tab for 404 errors
2. Verify the actual image files exist on the server
3. Test with a simple HTML img tag to isolate the issue
4. Contact hosting provider if server-level issues persist

---
**Note**: The SQL script is safe to run multiple times and will only update records that still contain localhost URLs. 