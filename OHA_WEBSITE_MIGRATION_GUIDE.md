# OHA Website Migration Guide - Local to Plesk Hosting

## Overview
This guide will help you migrate your local OHA (Oman Hockey Association) WordPress website from XAMPP to online Plesk hosting.

## Prerequisites
- Access to your Plesk hosting control panel
- FTP/SFTP access credentials
- Database access credentials from your hosting provider
- The migration files we've prepared: `oha_website_migration.zip`

## Migration Files Prepared
✅ **Database Backup**: `oha_website_backup.sql` (contains all your content, settings, and data)
✅ **Custom Theme**: `wp-content/themes/oha-theme/` (your custom OHA theme)
✅ **Media Files**: `wp-content/uploads/` (all images, videos, and media)
✅ **Migration Package**: `oha_website_migration.zip` (contains everything above)

---

## Step-by-Step Migration Process

### Phase 1: Prepare Hosting Environment

#### 1. **Set Up WordPress on Plesk**
1. Log into your Plesk control panel
2. Go to **"Applications"** or **"WordPress Toolkit"**
3. Click **"Install WordPress"**
4. Choose your domain name
5. Set up admin credentials (remember these!)
6. Complete the WordPress installation

#### 2. **Note Your Database Details**
After WordPress installation, note down:
- **Database Name**: (usually something like `username_wp123`)
- **Database User**: (usually same as database name)
- **Database Password**: (provided by hosting or set during setup)
- **Database Host**: (usually `localhost` or specific server name)

### Phase 2: Upload Files

#### 3. **Upload Migration Package**
1. Use **File Manager** in Plesk or **FTP client**
2. Navigate to your domain's document root (usually `httpdocs/` or `public_html/`)
3. Upload `oha_website_migration.zip`
4. Extract the zip file

#### 4. **Install Custom Theme**
1. In Plesk File Manager, navigate to `wp-content/themes/`
2. Copy the extracted `oha-theme` folder here
3. Set proper permissions (755 for folders, 644 for files)

#### 5. **Upload Media Files**
1. Navigate to `wp-content/uploads/`
2. Copy all files from the extracted uploads folder
3. Maintain the folder structure (organized by year/month)

### Phase 3: Database Migration

#### 6. **Import Database**
**Option A: Using Plesk Database Manager**
1. Go to **"Databases"** in Plesk
2. Click on your WordPress database
3. Click **"Import Dump"**
4. Upload `oha_website_backup.sql`
5. Click **"Import"**

**Option B: Using phpMyAdmin**
1. Access **phpMyAdmin** from Plesk
2. Select your WordPress database
3. Click **"Import"** tab
4. Choose `oha_website_backup.sql`
5. Click **"Go"**

#### 7. **Update Database URLs**
After importing, you need to update URLs from local to live:

**SQL Commands to run in phpMyAdmin:**
```sql
-- Replace 'localhost/oha-website' with your actual domain
UPDATE wp_options SET option_value = 'https://yourdomain.com' WHERE option_name = 'home';
UPDATE wp_options SET option_value = 'https://yourdomain.com' WHERE option_name = 'siteurl';
UPDATE wp_posts SET post_content = REPLACE(post_content, 'http://localhost/oha-website', 'https://yourdomain.com');
UPDATE wp_posts SET post_excerpt = REPLACE(post_excerpt, 'http://localhost/oha-website', 'https://yourdomain.com');
UPDATE wp_comments SET comment_content = REPLACE(comment_content, 'http://localhost/oha-website', 'https://yourdomain.com');
```

### Phase 4: WordPress Configuration

#### 8. **Update wp-config.php**
1. Navigate to your WordPress root directory
2. Edit `wp-config.php` file
3. Update database credentials:

```php
// ** Database settings ** //
define('DB_NAME', 'your_database_name');
define('DB_USER', 'your_database_user');
define('DB_PASSWORD', 'your_database_password');
define('DB_HOST', 'localhost'); // or your host's database server
```

#### 9. **Activate OHA Theme**
1. Log into WordPress admin: `https://yourdomain.com/wp-admin`
2. Go to **Appearance > Themes**
3. Activate **"OHA Theme"**

#### 10. **Install Required Plugins**
Install these essential plugins:
- **Advanced Custom Fields (ACF)** - Required for custom fields
- **Classic Editor** - If you prefer the classic editor
- **Yoast SEO** - For SEO optimization
- **Wordfence Security** - For security

### Phase 5: Final Configuration

#### 11. **Update Permalinks**
1. Go to **Settings > Permalinks**
2. Click **"Save Changes"** (this refreshes the permalink structure)

#### 12. **Check Custom Post Types**
Verify these custom post types are working:
- Videos (`oha_video`)
- Team Members (`team_member`)
- Sponsors (`sponsor`)
- Events (`event`)
- Slides (`slide`)

#### 13. **Test Website Functionality**
- ✅ Homepage loads correctly
- ✅ Navigation menus work
- ✅ News/blog posts display
- ✅ Video gallery functions
- ✅ Contact forms work
- ✅ Mobile responsiveness
- ✅ All custom sections display

### Phase 6: DNS and SSL

#### 14. **Update DNS Settings**
1. Point your domain to the new hosting server
2. Update A records and CNAME records as needed
3. Wait for DNS propagation (24-48 hours)

#### 15. **Enable SSL Certificate**
1. In Plesk, go to **"SSL/TLS Certificates"**
2. Install **Let's Encrypt** certificate (free)
3. Enable **"Redirect from HTTP to HTTPS"**

---

## Post-Migration Checklist

### Immediate Tasks
- [ ] Test all pages and functionality
- [ ] Check all images and media load correctly
- [ ] Verify contact forms work
- [ ] Test mobile responsiveness
- [ ] Check all navigation links

### SEO and Performance
- [ ] Submit new sitemap to Google Search Console
- [ ] Update Google Analytics (if used)
- [ ] Set up website monitoring
- [ ] Configure caching (if available in Plesk)
- [ ] Optimize images for web

### Security
- [ ] Change all passwords (WordPress admin, FTP, database)
- [ ] Install security plugin
- [ ] Set up regular backups
- [ ] Update all plugins and themes
- [ ] Remove default WordPress content

### Content Updates
- [ ] Update contact information
- [ ] Check all embedded videos work
- [ ] Verify social media links
- [ ] Update any hardcoded local URLs
- [ ] Test all forms and functionality

---

## Troubleshooting Common Issues

### **Issue: White Screen of Death**
**Solution:**
1. Check error logs in Plesk
2. Increase PHP memory limit
3. Deactivate all plugins, then reactivate one by one

### **Issue: Images Not Loading**
**Solution:**
1. Check file permissions (644 for files, 755 for folders)
2. Verify uploads folder exists and is writable
3. Update image URLs in database

### **Issue: Theme Not Working**
**Solution:**
1. Verify theme files uploaded correctly
2. Check PHP version compatibility
3. Ensure all theme dependencies are met

### **Issue: Database Connection Error**
**Solution:**
1. Double-check wp-config.php database credentials
2. Verify database exists and user has permissions
3. Contact hosting support for database server details

---

## Important Notes

### **OHA Brand Colors** (for reference)
- Primary Green: `#58AA35`
- Primary Red: `#E5201D`
- Light Gray: `#D1D3D4`
- Dark Gray: `#58595C`

### **Custom Features to Test**
- Hero slider functionality
- Latest news section
- Video gallery with player
- Team member carousel
- Sponsors section
- Events calendar
- Social media integration
- Mobile navigation

### **Performance Optimization**
- Enable Gzip compression
- Use WebP images where possible
- Minimize CSS/JS files
- Set up browser caching
- Use CDN if available

---

## Support Contacts

### **Technical Issues**
- Hosting Provider Support
- WordPress.org Support Forums
- OHA Theme Developer (if needed)

### **Content Management**
- WordPress Admin Training
- ACF Documentation
- Theme Customization Guide

---

## Backup Strategy (Post-Migration)

### **Regular Backups**
1. **Daily**: Database backups
2. **Weekly**: Full website backups
3. **Monthly**: Download backup copies locally
4. **Before Updates**: Always backup before plugin/theme updates

### **Backup Locations**
- Plesk automatic backups
- External cloud storage
- Local computer storage

---

**Migration Prepared By**: AI Assistant  
**Date**: $(Get-Date)  
**Website**: OHA (Oman Hockey Association)  
**Theme**: Custom OHA Theme based on Underscores

---

*This migration guide ensures your OHA website maintains its custom branding, functionality, and performance when moved to live hosting.* 