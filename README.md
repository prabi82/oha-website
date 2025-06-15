# OHA (Oman Hockey Association) WordPress Theme

A custom WordPress theme for the Oman Hockey Association built on the Underscores (_s) starter theme foundation.

## 🏒 About

This is a custom WordPress theme designed specifically for the Oman Hockey Association website. The theme features modern design, responsive layout, and custom functionality tailored for sports organizations.

## 🎨 Features

- **Custom Brand Colors**: OHA Green (#58AA35) and Red (#E5201D)
- **Modern Typography**: PF Din Text Universal font family
- **Responsive Design**: Mobile-first approach with clean layouts
- **Custom Post Types**: Videos, Team Members, Sponsors, Events
- **Homepage Sections**: Hero slider, Latest News, Videos, Team carousel, Sponsors
- **Video Integration**: YouTube/Vimeo video modal support
- **Events Management**: Custom events with date, time, location
- **SEO Optimized**: Semantic HTML and proper heading hierarchy

## 🚀 Installation

### Prerequisites
- WordPress 5.0+
- PHP 8.0+
- MySQL 5.7+

### Setup Instructions

1. **Clone the repository:**
   ```bash
   git clone https://github.com/yourusername/oha-website.git
   cd oha-website
   ```

2. **Configure WordPress:**
   ```bash
   cp wp-config-sample.php wp-config.php
   ```
   Edit `wp-config.php` with your database credentials and security keys.

3. **Set up database:**
   - Create a MySQL database
   - Import your database backup (not included in repository)
   - Update database URLs if needed

4. **Install dependencies:**
   - Upload to your web server or local development environment
   - Ensure proper file permissions

## 🎯 Theme Structure

```
wp-content/themes/oha-theme/
├── style.css                 # Main theme stylesheet
├── functions.php            # Theme functionality
├── index.php               # Main template
├── header.php              # Site header
├── footer.php              # Site footer
├── assets/
│   ├── css/               # Stylesheets
│   ├── js/                # JavaScript files
│   └── fonts/             # Custom fonts
├── template-parts/        # Reusable template parts
├── inc/                   # Theme includes
└── languages/             # Translation files
```

## 🎨 Brand Guidelines

### Colors
- **Primary Green**: `#58AA35` (RGB: 88, 170, 53)
- **Primary Red**: `#E5201D` (RGB: 229, 32, 29)
- **Light Gray**: `#D1D3D4` (RGB: 209, 211, 212)
- **Dark Gray**: `#58595C` (RGB: 88, 89, 92)

### Typography
- **Font Family**: PF Din Text Universal
- **Weights**: ExtraBold, Bold, Medium, Regular, Light

## 🔧 Custom Post Types

- **Videos** (`oha_video`) - Video content management
- **Team Members** (`team_member`) - Team profiles
- **Sponsors** (`sponsor`) - Sponsor management  
- **Events** (`event`) - Event management
- **Slides** (`slide`) - Homepage slider content

## 📱 Responsive Breakpoints

- **Desktop**: >1200px (4 columns)
- **Large Tablet**: 1200px-1024px (3 columns)
- **Tablet**: 1024px-600px (2 columns)
- **Mobile**: <600px (1 column)

## 🛠️ Development

### Local Development Setup

1. **XAMPP/WAMP/MAMP**: Place in `htdocs/oha-website/`
2. **Database**: Import your database backup
3. **URLs**: Update `WP_HOME` and `WP_SITEURL` in `wp-config.php`

### Code Standards
- Follow WordPress PHP coding standards
- Use `oha_` prefix for custom functions
- Comment complex functionality
- Sanitize and validate all inputs

## 🔒 Security Notes

**IMPORTANT**: This repository excludes sensitive files:
- `wp-config.php` (contains database credentials)
- Database files (`*.sql`)
- Uploads directory
- WordPress core files

Always create your own `wp-config.php` from the sample file and never commit sensitive information.

## 📦 What's Included

- ✅ Custom OHA theme (`/wp-content/themes/oha-theme/`)
- ✅ Theme documentation
- ✅ Sample configuration file
- ❌ WordPress core files (download separately)
- ❌ Database content (backup separately)
- ❌ Uploaded media files
- ❌ Sensitive configuration

## 🚀 Deployment

1. **Production Setup:**
   - Upload theme files to your hosting
   - Create production `wp-config.php`
   - Import database backup
   - Update site URLs
   - Set proper file permissions

2. **Environment Variables:**
   ```php
   define('WP_DEBUG', false);           // Disable debug in production
   define('WP_DEBUG_LOG', false);       // Disable debug logging
   define('WP_DEBUG_DISPLAY', false);   // Hide debug output
   ```

## 🤝 Contributing

1. Fork the repository
2. Create a feature branch
3. Make your changes
4. Test thoroughly
5. Submit a pull request

## 📄 License

This theme is developed specifically for the Oman Hockey Association. All rights reserved.

## 📞 Support

For technical support or questions about this theme, please contact the development team.

---

**Note**: This repository contains only the custom theme and configuration files. WordPress core files, database content, and sensitive information are excluded for security reasons. 