# OHA Website Image Fix Instructions

## Problem Identified
Images are not appearing on the live website because:
1. **Wrong wp-config.php URLs**: Local config still has localhost URLs
2. **Table prefix mismatch**: Config uses uppercase but database uses lowercase
3. **Potential localhost image URLs**: Some images may still reference localhost

## Solution Steps

### Step 1: Update wp-config.php on Live Server
Replace the current `wp-config.php` on your live server with the corrected version:

**Use the file: `wp-config-live.php`** (created in this directory)

Key changes made:
- Database credentials: `admin_wordpress_6` / `UnzC547dF$`
- Correct table prefix: `bsttr2fqpn_` (lowercase)
- Live URLs: `https://oha.omaniservers.com/website`
- Disabled debug mode for production

### Step 2: Run Image URL Fix Script
Execute the SQL script to fix any remaining localhost image URLs:

**Use the file: `fix_image_urls.sql`** (created in this directory)

This script will:
- Update all attachment URLs from localhost to live server
- Fix image URLs in post content and excerpts
- Update theme options and customizer settings
- Fix BeTheme/Muffin Builder content
- Clear cached data with old URLs

### Step 3: Verify File Permissions
Ensure the uploads directory has proper permissions:
```
wp-content/uploads/ - 755 or 775
All subdirectories - 755 or 775
All image files - 644 or 664
```

### Step 4: Check .htaccess File
Ensure your `.htaccess` file has proper WordPress rewrite rules:
```apache
# BEGIN WordPress
<IfModule mod_rewrite.c>
RewriteEngine On
RewriteBase /website/
RewriteRule ^index\.php$ - [L]
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteRule . /website/index.php [L]
</IfModule>
# END WordPress
```

## Implementation Instructions

### For Plesk File Manager:
1. **Upload wp-config-live.php**:
   - Go to File Manager
   - Navigate to your website root
   - Upload `wp-config-live.php`
   - Rename it to `wp-config.php` (replace existing)

2. **Run SQL Script**:
   - Go to Databases → phpMyAdmin
   - Select `wordpress_e` database
   - Go to SQL tab
   - Copy and paste content from `fix_image_urls.sql`
   - Click "Go" to execute

### Alternative: Manual Database Updates
If you prefer to run individual queries:

```sql
-- Fix attachment URLs
UPDATE bsttr2fqpn_posts 
SET guid = REPLACE(guid, 'http://localhost/oha-website/', 'https://oha.omaniservers.com/website/')
WHERE post_type = 'attachment' AND guid LIKE '%localhost%';

-- Fix site URLs
UPDATE bsttr2fqpn_options SET option_value = 'https://oha.omaniservers.com/website' WHERE option_name = 'home';
UPDATE bsttr2fqpn_options SET option_value = 'https://oha.omaniservers.com/website' WHERE option_name = 'siteurl';
```

## Verification Steps

After implementing the fixes:

1. **Check Homepage**: Visit `https://oha.omaniservers.com/website`
2. **Verify Images**: Look for:
   - Logo in header
   - Hero slider images
   - News article images
   - Sponsor logos
   - Team member photos

3. **Check Admin Panel**: 
   - Login to `/wp-admin`
   - Go to Media Library
   - Verify images display correctly

4. **Test Image Upload**:
   - Try uploading a new image
   - Verify it appears correctly on frontend

## Common Issues & Solutions

### Issue: Images still not showing
**Solution**: Clear browser cache and check browser developer tools for 404 errors

### Issue: Mixed content warnings (HTTP/HTTPS)
**Solution**: Ensure all URLs use HTTPS in the database

### Issue: Permission denied errors
**Solution**: Set proper file permissions on uploads directory

### Issue: Admin panel shows "Sorry, you are not allowed"
**Solution**: Use the admin user creation script provided earlier

## Files Created
- `wp-config-live.php` - Corrected WordPress configuration
- `fix_image_urls.sql` - Database URL fix script
- `IMAGE_FIX_INSTRUCTIONS.md` - This instruction file

## Support
If images still don't appear after following these steps:
1. Check server error logs
2. Verify uploads directory exists and has proper permissions
3. Test with a fresh image upload
4. Contact hosting provider if server-level issues persist

---
**Note**: Always backup your database before running SQL scripts! 