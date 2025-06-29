# Zie619 Community N8N Workflows - Reverse Proxy Setup Guide

This guide explains how to set up a reverse proxy for the Zie619 Community N8N Workflows application to run at `wengindustries.com/app/n8n-templates/zie619-community`.

## Overview

The Zie619 application is a Python Flask-based API server with a static frontend that provides:
- Browse and search N8N workflows
- Download workflows
- View workflow documentation and diagrams
- REST API for workflow management

**Key Requirements:**
- Application runs on port `8000` locally. But we should assign a different port number like `8001` in case in the future you'll be testing python scripts on your server. So the run command becomes `python run.py --port 8001`
- API calls use `/api/zie619` prefix to avoid conflicts with other APIs
- Static files served under `/app/n8n-templates/zie619-community` path

## Prerequisites

1. The Zie619 application should be running on `127.0.0.1:8001`
2. Web server (nginx or Apache) configured with reverse proxy support
3. Application API endpoints adjusted to use `/api/zie619` prefix. Adjusting to `/api/` is NOT a good idea because you may have multiple reverse proxy apps with /api endpoints in the future.

## Nginx Configuration

Add the following configuration to your nginx server block:

```nginx
# Reverse proxy for Zie619 static content and application
location ~ /app/n8n-templates/zie619-community[/]* {
    rewrite ^/app/n8n-templates/zie619-community[/]*(.*)$ /$1 break;
    proxy_pass http://127.0.0.1:8001;
    proxy_read_timeout 300s;   # Adjust as needed
    proxy_connect_timeout 300s; # Adjust as needed
    proxy_send_timeout 300s;   # Adjust as needed
    proxy_set_header Host $host;
    proxy_set_header X-Real-IP $remote_addr;
    proxy_set_header X-Forwarded-For $proxy_add_x_forwarded_for;
    proxy_set_header X-Forwarded-Proto $scheme;

    # Enable CORS if needed
    # add_header 'Access-Control-Allow-Origin' '*' always;
    # add_header 'Access-Control-Allow-Methods' 'GET, POST, OPTIONS' always;
    # add_header 'Access-Control-Allow-Headers' 'Origin, Content-Type, Accept, Authorization' always;
    
    # Handle OPTIONS (preflight) requests
    if ($request_method = OPTIONS) {
        add_header 'Access-Control-Allow-Methods' 'GET, POST, OPTIONS';
        add_header 'Access-Control-Allow-Headers' 'Origin, Content-Type, Accept, Authorization';
        add_header 'Access-Control-Max-Age' 1728000;
        return 204;
    }
}

# Reverse proxy for Zie619 API requests
location ~ /api/zie619[/]* {
    rewrite ^/api/zie619[/]*(.*)$ /api/$1 break;
    proxy_pass http://127.0.0.1:8001;
    proxy_read_timeout 300s;   # Adjust as needed
    proxy_connect_timeout 300s; # Adjust as needed
    proxy_send_timeout 300s;   # Adjust as needed
    proxy_set_header Host $host;
    proxy_set_header X-Real-IP $remote_addr;
    proxy_set_header X-Forwarded-For $proxy_add_x_forwarded_for;
    proxy_set_header X-Forwarded-Proto $scheme;

    # Enable CORS if needed
    # add_header 'Access-Control-Allow-Origin' '*' always;
    # add_header 'Access-Control-Allow-Methods' 'GET, POST, OPTIONS' always;
    # add_header 'Access-Control-Allow-Headers' 'Origin, Content-Type, Accept, Authorization' always;
    
    # Handle OPTIONS (preflight) requests
    if ($request_method = OPTIONS) {
        add_header 'Access-Control-Allow-Methods' 'GET, POST, OPTIONS';
        add_header 'Access-Control-Allow-Headers' 'Origin, Content-Type, Accept, Authorization';
        add_header 'Access-Control-Max-Age' 1728000;
        return 204;
    }
}
```

## Apache Configuration

For Apache users, add this to your virtual host configuration:

```apache
# Enable required modules
LoadModule proxy_module modules/mod_proxy.so
LoadModule proxy_http_module modules/mod_proxy_http.so
LoadModule rewrite_module modules/mod_rewrite.so

# Reverse proxy for Zie619 static content and application
<LocationMatch "^/app/n8n-templates/zie619-community">
    ProxyPreserveHost On
    ProxyPass http://127.0.0.1:8001/
    ProxyPassReverse http://127.0.0.1:8001/
    ProxyTimeout 300
    
    # Enable CORS if needed
    # Header always set Access-Control-Allow-Origin "*"
    # Header always set Access-Control-Allow-Methods "GET, POST, OPTIONS"
    # Header always set Access-Control-Allow-Headers "Origin, Content-Type, Accept, Authorization"
    
    # Handle OPTIONS requests
    RewriteEngine On
    RewriteCond %{REQUEST_METHOD} OPTIONS
    RewriteRule ^(.*)$ $1 [R=204,L]
</LocationMatch>

# Reverse proxy for Zie619 API requests
<LocationMatch "^/api/zie619">
    ProxyPreserveHost On
    RewriteEngine On
    RewriteRule ^/api/zie619/(.*)$ /api/$1 [P]
    ProxyPass http://127.0.0.1:8001/api/
    ProxyPassReverse http://127.0.0.1:8001/api/
    ProxyTimeout 300
    
    # Enable CORS if needed
    # Header always set Access-Control-Allow-Origin "*"
    # Header always set Access-Control-Allow-Methods "GET, POST, OPTIONS"
    # Header always set Access-Control-Allow-Headers "Origin, Content-Type, Accept, Authorization"
</LocationMatch>
```

## Required Code Adjustments

The following adjustments have been made to the application to work with the reverse proxy:

### 1. API Endpoint Adjustments in index.html

**Original API calls:**
```javascript
const response = await fetch(`/api${endpoint}`, {
```

**Adjusted to:**
```javascript
const response = await fetch(`/api/zie619${endpoint}`, {
```

### 2. Download Button URL Adjustment

**Original download URL:**
```javascript
this.elements.downloadBtn.href = `/api/workflows/${workflow.filename}/download`;
```

**Adjusted to:**
```javascript
this.elements.downloadBtn.href = `/api/zie619/workflows/${workflow.filename}/download`;
```

## Starting the Application

### Manual Start (Development)

1. Navigate to the zie619-community/n8n-workflows directory:
   ```bash
   cd zie619-community/n8n-workflows
   ```

2. Install dependencies (if not already done):
   ```bash
   pip install -r requirements.txt
   ```

3. Start the application:
   ```bash
   python run.py --port 8001
   ```
   
   Or using the API server directly:
   ```bash
   python api_server.py
   ```

4. Verify the application is running on port 8001:
   ```bash
   curl http://127.0.0.1:8001/api/workflows
   ```

### Running Forever (Production)

Refer to [README-zie619-run-forever.md](README-zie619-run-forever.md)