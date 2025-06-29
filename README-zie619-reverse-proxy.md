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
   python run.py
   ```
   
   Or using the API server directly:
   ```bash
   python api_server.py
   ```

4. Verify the application is running on port 8001:
   ```bash
   curl http://127.0.0.1:8001/api/workflows
   ```

## Testing the Reverse Proxy

### 1. Test Main Application Access

Open in web browser:
```bash
curl -I https://wengindustries.com/app/n8n-templates/zie619-community/
```
Should return 200 OK and serve the static index.html

### 2. Test API Endpoints
```bash
# Test workflow listing
curl https://wengindustries.com/api/zie619/workflows

# Test specific workflow
curl https://wengindustries.com/api/zie619/workflows/some-workflow.json

# Test download endpoint
curl -I https://wengindustries.com/api/zie619/workflows/some-workflow.json/download
```


## Troubleshooting

### Common Issues:

1. **404 Not Found on API calls:**
   - Verify the zie619 application is running on port 8001
   - Check that API endpoints use `/api/zie619` prefix in the frontend code
   - Ensure nginx/Apache rewrite rules are correctly configured

2. **CORS Errors:**
   - Uncomment the CORS headers in the nginx/Apache configuration
   - Verify the `Access-Control-Allow-Origin` header matches your domain

3. **Static files not loading:**
   - Check the main location block for `/app/n8n-templates/zie619-community`
   - Verify the proxy_pass URL is correct
   - Test direct access to `http://127.0.0.1:8001/` locally

4. **Timeouts:**
   - Increase the timeout values in proxy configuration
   - Check application logs for slow queries or operations

### Debugging Commands:

```bash
# Check if application is running
netstat -tlnp | grep 8001

# Test local application directly
curl http://127.0.0.1:8001/api/workflows

# Check nginx/Apache error logs
tail -f /var/log/nginx/error.log
tail -f /var/log/apache2/error.log

# Test reverse proxy configuration
nginx -t  # for nginx
apachectl configtest  # for Apache
```

## Security Considerations

1. **Rate Limiting:** Consider implementing rate limiting for API endpoints
2. **Authentication:** Add authentication if the application contains sensitive data
3. **HTTPS:** Ensure SSL/TLS is properly configured
4. **Firewall:** Restrict direct access to port 8001 from external networks

## Performance Optimization

1. **Caching:** Consider enabling caching for static assets and API responses
2. **Compression:** Enable gzip compression for text-based responses
3. **Connection Pooling:** Configure proxy connection pooling for better performance

```nginx
# Example caching configuration for nginx
location ~* \.(css|js|png|jpg|jpeg|gif|ico|svg)$ {
    expires 1y;
    add_header Cache-Control "public, immutable";
    proxy_pass http://127.0.0.1:8001;
}
```

## Monitoring

Monitor the following metrics:
- Response times for API endpoints
- Error rates (4xx, 5xx responses)
- Application server health on port 8001
- Resource usage (CPU, memory, disk I/O)

## Contact

For issues specific to this reverse proxy setup, check the logs and verify:
1. Application is running on correct port
2. API endpoint adjustments are in place
3. Web server configuration is correct
4. Network connectivity between proxy and application server
