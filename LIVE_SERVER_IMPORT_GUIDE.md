# OHA Website - Live Server Import Guide

## 🎯 Overview
This guide is for importing your local OHA website data into your **existing live WordPress installation** with the following configuration:

### **Live Server Configuration**
- **Database**: `wordpress_e`
- **Table Prefix**: `BsTtR2fQpN_`
- **Database User**: `admin_wordpress_6`
- **Database Host**: `localhost:3306`

---

## 📦 Files Ready for Import

### **Optimized Database File**
- **File**: `oha_website_ready_for_live_import.sql` (2.17 MB)
- **Optimized for**: Direct phpMyAdmin import
- **Table Prefix**: Already converted to `BsTtR2fQpN_`
- **Features**: Drop tables, create options, optimized for web import

### **URL Replacement Script**
- **File**: `url_replacement_script_live.sql`
- **Purpose**: Update all URLs from localhost to your live domain
- **Table Prefix**: Matches your live server (`BsTtR2fQpN_`)

---

## 🚀 Step-by-Step Import Process

### **Step 1: Backup Your Current Live Database**
⚠️ **CRITICAL**: Always backup before importing!

1. Access **phpMyAdmin** in your Plesk panel
2. Select database `wordpress_e`
3. Click **"Export"** tab
4. Choose **"Quick"** export method
5. Click **"Go"** to download backup
6. Save as `live_backup_before_import.sql`

### **Step 2: Import the Optimized Database**

1. **Access phpMyAdmin**
   - Log into your Plesk control panel
   - Go to **"Databases"** → **"phpMyAdmin"**
   - Select database `wordpress_e`

2. **Import the Database**
   - Click **"Import"** tab
   - Click **"Choose File"**
   - Select `oha_website_ready_for_live_import.sql`
   - **Important Settings**:
     - Format: **SQL**
     - Character set: **utf8**
     - Enable: **"Allow interrupt of import"**
   - Click **"Go"**

3. **Wait for Import**
   - Import may take 2-5 minutes
   - Don't close the browser tab
   - You'll see success message when complete

### **Step 3: Update URLs for Live Domain**

1. **Still in phpMyAdmin**, click **"SQL"** tab
2. **Copy and paste** the content from `url_replacement_script_live.sql`
3. **IMPORTANT**: Replace `https://yourdomain.com` with your actual domain
4. Click **"Go"** to execute the script

**Example URL replacements:**
```sql
-- Replace with your actual domain
UPDATE BsTtR2fQpN_options SET option_value = 'https://omanhockey.com' WHERE option_name = 'home';
UPDATE BsTtR2fQpN_options SET option_value = 'https://omanhockey.com' WHERE option_name = 'siteurl';
```

### **Step 4: Upload Theme and Media Files**

1. **Access File Manager** in Plesk
2. Navigate to your domain's document root
3. **Upload Theme**:
   - Go to `wp-content/themes/`
   - Upload the `oha-theme` folder
   - Set permissions: 755 for folders, 644 for files
4. **Upload Media**:
   - Go to `wp-content/uploads/`
   - Upload all files from your local uploads folder
   - Maintain the year/month folder structure

### **Step 5: Activate Theme and Install Plugins**

1. **Login to WordPress Admin**
   - Go to `https://yourdomain.com/wp-admin`
   - Use your existing admin credentials

2. **Activate OHA Theme**
   - Go to **Appearance** → **Themes**
   - Find **"OHA Theme"**
   - Click **"Activate"**

3. **Install Required Plugins**
   - Go to **Plugins** → **Add New**
   - Install **"Advanced Custom Fields"** (CRITICAL)
   - Install **"Classic Editor"** (if needed)
   - Activate all installed plugins

### **Step 6: Final Configuration**

1. **Update Permalinks**
   - Go to **Settings** → **Permalinks**
   - Click **"Save Changes"** (refreshes URL structure)

2. **Check Custom Post Types**
   - Verify these appear in admin menu:
     - Videos
     - Team Members
     - Sponsors
     - Events
     - Slides

3. **Test Website**
   - Visit your homepage
   - Check all navigation menus
   - Test responsive design
   - Verify all sections load correctly

---

## ✅ Post-Import Checklist

### **Immediate Testing**
- [ ] Homepage loads with OHA branding
- [ ] Navigation menus work (dropdowns function)
- [ ] Latest news section displays
- [ ] Video gallery works
- [ ] Team member carousel functions
- [ ] Events section shows
- [ ] Sponsors section displays
- [ ] Mobile responsiveness works
- [ ] All images load correctly

### **Content Verification**
- [ ] All blog posts imported
- [ ] All pages imported
- [ ] All media files accessible
- [ ] Custom fields data preserved
- [ ] User accounts maintained
- [ ] Comments preserved

### **Functionality Testing**
- [ ] Contact forms work
- [ ] Search functionality
- [ ] Admin dashboard accessible
- [ ] Theme customizer works
- [ ] Widgets function properly

---

## 🔧 Troubleshooting

### **Import Fails or Times Out**
**Solutions:**
1. Check file size limits in phpMyAdmin
2. Try importing in smaller chunks
3. Contact hosting support to increase limits
4. Use alternative import method via Plesk

### **White Screen After Import**
**Solutions:**
1. Check error logs in Plesk
2. Deactivate all plugins temporarily
3. Switch to default theme, then back to OHA theme
4. Increase PHP memory limit

### **Images Not Loading**
**Solutions:**
1. Check file permissions (755/644)
2. Verify uploads folder structure
3. Check if URLs were updated correctly
4. Re-upload media files if needed

### **Theme Not Working**
**Solutions:**
1. Ensure ACF plugin is installed and active
2. Check PHP version (needs 8.0+)
3. Verify all theme files uploaded
4. Check for plugin conflicts

### **Custom Post Types Missing**
**Solutions:**
1. Ensure ACF plugin is active
2. Go to Settings → Permalinks → Save Changes
3. Check if custom post type functions are in theme
4. Verify database import was complete

---

## 🎨 OHA Theme Features Preserved

### **Brand Colors**
- Primary Green: `#58AA35`
- Primary Red: `#E5201D`
- Light Gray: `#D1D3D4`
- Dark Gray: `#58595C`

### **Custom Sections**
- Hero slider with navigation
- Latest news with modern layout
- Video gallery with player
- Team member carousel
- Sponsors section
- Events calendar
- Social media integration

### **Recent Improvements**
- ✅ Fixed navigation dropdown issues
- ✅ Improved event thumbnail display
- ✅ Modern news page template
- ✅ Modern videos page template
- ✅ Latest videos block widget

---

## 📞 Support

### **If You Need Help**
- **Hosting Support**: For server/database issues
- **WordPress Forums**: For WordPress-specific problems
- **ACF Documentation**: For custom fields issues

### **Emergency Rollback**
If something goes wrong, you can restore from your backup:
1. Go to phpMyAdmin
2. Select database `wordpress_e`
3. Import your `live_backup_before_import.sql`
4. This will restore your site to pre-import state

---

## 📋 Quick Import Summary

1. **Backup** current live database
2. **Import** `oha_website_ready_for_live_import.sql`
3. **Run** URL replacement script (update domain)
4. **Upload** theme and media files
5. **Activate** OHA theme
6. **Install** ACF plugin
7. **Test** all functionality

**Estimated Time**: 15-30 minutes  
**Database Size**: 2.17 MB  
**Theme Files**: ~50 MB  
**Total Import**: ~52 MB

---

*Your OHA website will maintain all custom branding, functionality, and recent improvements after import.* 