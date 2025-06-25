# n8n Templates Library

By Weng Fei Fung
![Last Commit](https://img.shields.io/github/last-commit/Siphon880gh/n8n-templates/main)
<a target="_blank" href="https://github.com/Siphon880gh" rel="nofollow"><img src="https://img.shields.io/badge/GitHub--blue?style=social&logo=GitHub" alt="Github" data-canonical-src="https://img.shields.io/badge/GitHub--blue?style=social&logo=GitHub" style="max-width:8.5ch;"></a>
<a target="_blank" href="https://www.linkedin.com/in/weng-fung/" rel="nofollow"><img src="https://img.shields.io/badge/LinkedIn-blue?style=flat&logo=linkedin&labelColor=blue" alt="Linked-In" data-canonical-src="https://img.shields.io/badge/LinkedIn-blue?style=flat&amp;logo=linkedin&amp;labelColor=blue" style="max-width:10ch;"></a>
<a target="_blank" href="https://www.youtube.com/@WayneTeachesCode/" rel="nofollow"><img src="https://img.shields.io/badge/Youtube-red?style=flat&logo=youtube&labelColor=red" alt="Youtube" data-canonical-src="https://img.shields.io/badge/Youtube-red?style=flat&amp;logo=youtube&amp;labelColor=red" style="max-width:10ch;"></a>

A beautiful, searchable web interface for browsing and downloading n8n automation templates. This project makes Oleg Melnikov's comprehensive n8n templates collection easily accessible through a modern web application.

## 🌟 Features

- **🔐 Secure Login System** - Password-protected access to the templates library
- **🔍 Advanced Search & Filtering** - Search by template name, creator, description, or category
- **📊 Real-time Statistics** - View total templates, available downloads, and unique creators
- **⬇️ Direct Downloads** - Download JSON workflow files directly
- **👁️ Template Preview** - View template JSON structure in a modal popup
- **📱 Responsive Design** - Works perfectly on desktop, tablet, and mobile devices
- **🎨 Modern UI** - Beautiful gradient design with smooth animations and transitions
- **📋 Copy to Clipboard** - Easy copying of template JSON for import into n8n

## 🎯 Data Source

The core template data is sourced from [Oleg Melnikov's comprehensive n8n templates collection](https://www.youtube.com/watch?v=yAiCXyGLZ2c), uploaded on June 20th, 2025. This collection contains hundreds of n8n automation workflows covering various use cases and integrations.

### 🤖 AI-Powered Template Recommendations

For personalized template recommendations and assistance, visit [Oleg's AI Chat](https://olegfuns.app.n8n.cloud/webhook/cda21b26-b940-4b60-8afa-fd7b8281a96b/chat) where you can get AI-powered suggestions for the perfect n8n template for your needs.

## 🚀 Quick Start

### Prerequisites
- PHP 8.4+ with session support
- Web server (Apache, Nginx, or PHP built-in server)

### Installation

1. **Clone or download this repository**
   ```bash
   git clone <repository-url>
   cd templates
   ```

2. **Ensure data files are present**
   - `data/n8n-templates_enriched.csv` - Main template database
   - `json/` directory with individual template JSON files

3. **Start the web server**
   ```bash
   # Using PHP built-in server
   php -S localhost:8000
   
   # Or configure your web server to serve the project directory
   ```

4. **Access the application**
   - Open your browser and navigate to `http://localhost:8000`
   - Login with password: `go`

## 📁 Project Structure

```
templates/
├── index.php              # Main application file
├── README.md              # This file
├── package.json           # Node.js dependencies (for data processing)
├── data/
│   ├── n8n-templates_enriched.csv    # Processed template data
│   └── n8n-templates_unenriched.csv  # Original template data
├── json/                  # Individual template JSON files
│   └── {template-id}.json
└── scripts/
    └── download.js        # Script to download template JSON files
```

## 🔧 Data Processing

The project includes a Node.js script to download template JSON files from Google Drive:

```bash
# Install dependencies
npm install

# Run the download script
node scripts/download.js
```

The download script reads the CSV file and downloads JSON files using:
```bash
wget -O json/$id.json "https://drive.google.com/uc?export=download&id={google_drive_id}"
```

## 💻 Usage

### Login
- Default password is `go` (configurable in `index.php`)
- Session-based authentication with logout functionality

### Browsing Templates
- **Search**: Use the search bar to find templates by name, description, or creator
- **Filter**: Filter by creator or category using the dropdown menus
- **Sort**: Click column headers to sort by category, template name, creator, date, or availability
- **Download**: Click the green "JSON" button to download template files
- **Preview**: Click the blue "View" button to see the template structure

### Template Import
1. Download the JSON file from the web interface
2. In your n8n instance, go to "Templates" or "Workflows"
3. Import the downloaded JSON file
4. Configure any required credentials and settings

## 🎨 Customization

### Changing the Password
Edit the `$password` variable in `index.php`:
```php
$password = "your-new-password";
```

### Styling
The interface uses Tailwind CSS for styling. Modify the classes in `index.php` to customize the appearance.

## 🔄 Compatibility

- **n8n Version**: Tested with self-hosted community n8n version v1.94.1
- **PHP**: Requires PHP 8.4+ (uses null coalescing operator and other modern PHP features)
- **Browsers**: Compatible with all modern browsers (Chrome, Firefox, Safari, Edge)

## 👥 Contributors

- **[Weng Fung](https://www.linkedin.com/in/weng-fung/)** - Created the searchable web interface and login system
- **[Oleg Melnikov](https://www.youtube.com/watch?v=yAiCXyGLZ2c)** - Provided the comprehensive n8n templates collection and AI chat service

## 📝 License

This project is open source. Please respect the original creators' work and provide appropriate attribution when using or redistributing.

## 🆘 Support

- For web interface issues: Contact Weng via LinkedIn
- For template-specific questions: Check out [Oleg's AI Chat](https://olegfuns.app.n8n.cloud/webhook/cda21b26-b940-4b60-8afa-fd7b8281a96b/chat)
- For n8n usage help: Visit the [official n8n documentation](https://docs.n8n.io/)

---

Made with ❤️ by [Weng](https://www.linkedin.com/in/weng-fung/) • Data by [Oleg Melnikov](https://www.youtube.com/watch?v=yAiCXyGLZ2c)