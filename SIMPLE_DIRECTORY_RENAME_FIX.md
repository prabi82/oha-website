# SIMPLE DIRECTORY RENAME FIX - Much Easier Solution!

## 🎯 **BRILLIANT INSIGHT!**

Instead of updating multiple configuration files, we can simply **rename the website directory** to match the existing configuration!

## 🔄 **The Simple Solution**

### **Current Situation:**
- **Live directory**: `/website/`
- **Configuration expects**: `/oha-website/`
- **Database URLs**: `http://oha.omaniservers.com/website/`

### **Simple Fix:**
1. **Rename directory**: `website` → `oha-website`
2. **Update database URLs**: HTTP → HTTPS only
3. **Done!**

## 📋 **Implementation Steps**

### **Step 1: Rename Website Directory**
In your Plesk File Manager:
1. Navigate to your domain's root directory
2. Right-click on the `website` folder
3. Rename it to `oha-website`
4. Confirm the change

### **Step 2: Fix HTTP to HTTPS URLs Only**
Run this simplified SQL script in phpMyAdmin:

```sql
-- Simple HTTP to HTTPS fix for OHA Website
-- Only fixing the protocol, keeping the path as /oha-website/

-- Fix site URL and home URL
UPDATE bsttr2fqpn_options 
SET option_value = 'https://oha.omaniservers.com/oha-website' 
WHERE option_name IN ('siteurl', 'home');

-- Fix all attachment URLs (main image URLs)
UPDATE bsttr2fqpn_posts 
SET guid = REPLACE(guid, 'http://oha.omaniservers.com/oha-website/', 'https://oha.omaniservers.com/oha-website/')
WHERE post_type = 'attachment' AND guid LIKE 'http://oha.omaniservers.com/oha-website/%';

-- Fix image URLs in post content
UPDATE bsttr2fqpn_posts 
SET post_content = REPLACE(post_content, 'http://oha.omaniservers.com/oha-website/', 'https://oha.omaniservers.com/oha-website/')
WHERE post_content LIKE '%http://oha.omaniservers.com/oha-website/%';

-- Fix attachment metadata
UPDATE bsttr2fqpn_postmeta 
SET meta_value = REPLACE(meta_value, 'http://oha.omaniservers.com/oha-website/', 'https://oha.omaniservers.com/oha-website/')
WHERE meta_value LIKE '%http://oha.omaniservers.com/oha-website/%';

-- Fix theme options
UPDATE bsttr2fqpn_options 
SET option_value = REPLACE(option_value, 'http://oha.omaniservers.com/oha-website/', 'https://oha.omaniservers.com/oha-website/')
WHERE option_value LIKE '%http://oha.omaniservers.com/oha-website/%';

-- Clear cached data
DELETE FROM bsttr2fqpn_options WHERE option_name LIKE '%_transient_%' AND option_value LIKE '%http://oha.omaniservers.com/oha-website/%';

-- Show results
SELECT 'Simple HTTP to HTTPS Fix Complete' as Status;
SELECT COUNT(*) as 'Remaining HTTP URLs' FROM bsttr2fqpn_posts WHERE guid LIKE 'http://oha.omaniservers.com/oha-website/%';
```

### **Step 3: Test the Website**
Visit: `https://oha.omaniservers.com/oha-website/`

## ✅ **Why This is Much Better**

### **Advantages:**
- ✅ **No wp-config.php changes** - Already configured correctly
- ✅ **No .htaccess changes** - Already has correct RewriteBase
- ✅ **Minimal database changes** - Only HTTP→HTTPS conversion
- ✅ **No file uploads needed** - Just directory rename
- ✅ **Faster implementation** - 2 steps instead of 5
- ✅ **Less error-prone** - Fewer things to change

### **What Stays the Same:**
- All file paths and directory structure
- WordPress configuration
- Server rewrite rules
- Database table structure
- Theme files and uploads

### **What Changes:**
- Directory name: `website` → `oha-website`
- URL protocol: `http://` → `https://`

## 🎯 **New Website URL**
After the fix: `https://oha.omaniservers.com/oha-website/`

## 📝 **Implementation Checklist**

1. **Rename Directory:**
   - [ ] Login to Plesk File Manager
   - [ ] Navigate to domain root
   - [ ] Rename `website` folder to `oha-website`

2. **Fix Database URLs:**
   - [ ] Go to phpMyAdmin
   - [ ] Select `wordpress_e` database
   - [ ] Run the simplified SQL script above

3. **Test Website:**
   - [ ] Visit `https://oha.omaniservers.com/oha-website/`
   - [ ] Check news page for images
   - [ ] Test admin panel access

## 🚨 **Important Notes**

1. **URL Change**: Your website URL will change from `/website/` to `/oha-website/`
2. **Update Bookmarks**: Update any bookmarks or links you have
3. **SEO Impact**: Minimal since this is a new migration
4. **Much Simpler**: This approach requires far fewer changes

## 🎉 **Expected Results**

After this simple fix:
- ✅ Website accessible at `https://oha.omaniservers.com/oha-website/`
- ✅ All images display properly
- ✅ No configuration file changes needed
- ✅ Admin panel works normally
- ✅ All existing functionality preserved

---
**This is definitely the smarter approach - work with the existing configuration instead of fighting against it!** 