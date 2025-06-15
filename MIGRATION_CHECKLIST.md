# OHA Website Migration - Quick Checklist

## ✅ Files Ready for Migration

### Migration Package: `oha_website_final_migration.zip` (58 MB)
Contains:
- ✅ **Database Backup**: `oha_website_complete_backup.sql` (2.17 MB)
- ✅ **Custom Theme**: `wp-content/themes/oha-theme/`
- ✅ **Media Files**: `wp-content/uploads/`
- ✅ **URL Replacement Script**: `url_replacement_script.sql`
- ✅ **Complete Guide**: `OHA_WEBSITE_MIGRATION_GUIDE.md`

---

## 🚀 Quick Migration Steps

### 1. **Prepare Plesk Hosting**
- [ ] Install fresh WordPress on your domain
- [ ] Note database credentials (name, user, password, host)
- [ ] Access File Manager or FTP

### 2. **Upload Files**
- [ ] Upload `oha_website_final_migration.zip` to your hosting
- [ ] Extract the zip file
- [ ] Copy `oha-theme` folder to `wp-content/themes/`
- [ ] Copy uploads folder contents to `wp-content/uploads/`

### 3. **Import Database**
- [ ] Access phpMyAdmin in Plesk
- [ ] Import `oha_website_complete_backup.sql`
- [ ] Run `url_replacement_script.sql` (replace yourdomain.com with actual domain)

### 4. **Configure WordPress**
- [ ] Update `wp-config.php` with new database credentials
- [ ] Login to WordPress admin
- [ ] Activate "OHA Theme"
- [ ] Install Advanced Custom Fields (ACF) plugin

### 5. **Final Steps**
- [ ] Go to Settings > Permalinks > Save Changes
- [ ] Test all functionality
- [ ] Enable SSL certificate
- [ ] Set up backups

---

## 🔧 Important Notes

### **Replace in URL Script**
Change `https://yourdomain.com` to your actual domain in `url_replacement_script.sql`

### **Required Plugins**
- Advanced Custom Fields (ACF) - **CRITICAL**
- Yoast SEO (recommended)
- Wordfence Security (recommended)

### **Test These Features**
- [ ] Homepage hero slider
- [ ] Navigation menus (check dropdowns work)
- [ ] Latest news section
- [ ] Video gallery
- [ ] Team member carousel
- [ ] Events section
- [ ] Sponsors section
- [ ] Mobile responsiveness
- [ ] Contact forms

### **OHA Custom Post Types**
- Videos (`oha_video`)
- Team Members (`team_member`)
- Sponsors (`sponsor`)
- Events (`event`)
- Slides (`slide`)

---

## 🆘 If Something Goes Wrong

### **White Screen**
1. Check error logs in Plesk
2. Deactivate all plugins
3. Switch to default theme temporarily

### **Database Connection Error**
1. Double-check wp-config.php credentials
2. Verify database exists
3. Contact hosting support

### **Images Not Loading**
1. Check file permissions (755 folders, 644 files)
2. Verify uploads folder exists
3. Check URL replacements worked

### **Theme Not Working**
1. Ensure ACF plugin is installed
2. Check PHP version (needs 8.0+)
3. Verify theme files uploaded correctly

---

## 📞 Support

- **Hosting Support**: For server/database issues
- **WordPress Forums**: For WordPress-specific problems
- **ACF Documentation**: For custom fields issues

---

**Migration Package Created**: 15-06-2025  
**Package Size**: 58 MB  
**Database Size**: 2.17 MB  
**Ready for Upload**: ✅ 