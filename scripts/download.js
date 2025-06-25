const csvPath = '../data/n8n-templates_enriched.csv';

const fs = require('fs');
const https = require('https');
const http = require('http');
const path = require('path');
const { parse } = require('csv-parse');

// Configuration
const DOWNLOAD_DELAY_MS = 2000; // Delay between downloads to avoid spamming Google Drive servers

// Create json directory if it doesn't exist
const jsonDir = './json';
if (!fs.existsSync(jsonDir)) {
    fs.mkdirSync(jsonDir, { recursive: true });
}

// Function to extract Google Drive file ID from various URL formats
function extractGoogleDriveId(url) {
    if (!url || typeof url !== 'string') return null;
    
    // Handle different Google Drive URL formats
    const patterns = [
        /\/file\/d\/([a-zA-Z0-9-_]+)/,  // /file/d/ID/view format
        /[?&]id=([a-zA-Z0-9-_]+)/,     // ?id=ID format
        /\/open\?id=([a-zA-Z0-9-_]+)/, // /open?id=ID format
    ];
    
    for (const pattern of patterns) {
        const match = url.match(pattern);
        if (match) {
            return match[1];
        }
    }
    return null;
}

// Function to download file from Google Drive
function downloadFile(driveId, filename) {
    return new Promise((resolve, reject) => {
        const downloadUrl = `https://drive.google.com/uc?export=download&id=${driveId}`;
        const filePath = path.join(jsonDir, filename);
        
        console.log(`Downloading ${filename} from Google Drive ID: ${driveId}`);
        
        const file = fs.createWriteStream(filePath);
        
        const request = https.get(downloadUrl, (response) => {
            // Handle redirects
            if (response.statusCode === 302 || response.statusCode === 301) {
                const redirectUrl = response.headers.location;
                console.log(`Following redirect for ${filename}`);
                
                const redirectRequest = https.get(redirectUrl, (redirectResponse) => {
                    if (redirectResponse.statusCode === 200) {
                        redirectResponse.pipe(file);
                        file.on('finish', () => {
                            file.close();
                            console.log(`✓ Downloaded: ${filename}`);
                            resolve();
                        });
                    } else {
                        file.close();
                        fs.unlink(filePath, () => {}); // Delete the file
                        reject(new Error(`Failed to download ${filename}: ${redirectResponse.statusCode}`));
                    }
                });
                
                redirectRequest.on('error', (err) => {
                    file.close();
                    fs.unlink(filePath, () => {});
                    reject(err);
                });
            } else if (response.statusCode === 200) {
                response.pipe(file);
                file.on('finish', () => {
                    file.close();
                    console.log(`✓ Downloaded: ${filename}`);
                    resolve();
                });
            } else {
                file.close();
                fs.unlink(filePath, () => {});
                reject(new Error(`Failed to download ${filename}: ${response.statusCode}`));
            }
        });
        
        request.on('error', (err) => {
            file.close();
            fs.unlink(filePath, () => {});
            reject(err);
        });
        
        file.on('error', (err) => {
            file.close();
            fs.unlink(filePath, () => {});
            reject(err);
        });
    });
}

// Function to process CSV and download files
async function processCSV() {
    
    if (!fs.existsSync(csvPath)) {
        console.error(`CSV file not found: ${csvPath}`);
        return;
    }
    
    const csvContent = fs.readFileSync(csvPath, 'utf8');
    const records = [];
    
    // Parse CSV
    await new Promise((resolve, reject) => {
        parse(csvContent, {
            columns: true,
            skip_empty_lines: true,
            trim: true
        }, (err, data) => {
            if (err) {
                reject(err);
            } else {
                records.push(...data);
                resolve();
            }
        });
    });
    
    console.log(`Found ${records.length} records in CSV`);
    
    let downloadCount = 0;
    let errorCount = 0;
    
    for (let i = 0; i < records.length; i++) {
        const record = records[i];
        const resourceUrl = record.resource_url || record.template_url;
        const videoId = record.id;
        
        if (!resourceUrl || !videoId) {
            console.log(`Skipping row ${i + 1}: Missing resource_url or id`);
            continue;
        }
        
        // Handle multiple URLs (some entries have multiple space-separated URLs)
        const urls = resourceUrl.split(/\s+/).filter(url => url.trim());
        
        for (let urlIndex = 0; urlIndex < urls.length; urlIndex++) {
            const url = urls[urlIndex].trim();
            const driveId = extractGoogleDriveId(url);
            
            if (!driveId) {
                console.log(`Skipping URL: ${url} (not a valid Google Drive URL)`);
                continue;
            }
            
            // Create filename: if multiple URLs, append index
            const filename = urls.length > 1 
                ? `${videoId}_${urlIndex + 1}.json`
                : `${videoId}.json`;
            
            const filePath = path.join(jsonDir, filename);
            
            // Skip if file already exists
            if (fs.existsSync(filePath)) {
                console.log(`Skipping ${filename}: File already exists`);
                continue;
            }
            
            try {
                await downloadFile(driveId, filename);
                downloadCount++;
                
                // Add delay between downloads to be respectful to Google's servers
                await new Promise(resolve => setTimeout(resolve, DOWNLOAD_DELAY_MS));
                
            } catch (error) {
                console.error(`✗ Failed to download ${filename}:`, error.message);
                errorCount++;
            }
        }
    }
    
    console.log('\n=== Download Summary ===');
    console.log(`Total downloads: ${downloadCount}`);
    console.log(`Total errors: ${errorCount}`);
    console.log(`Files saved to: ${path.resolve(jsonDir)}`);
}

// Run the script
processCSV().catch(console.error); 