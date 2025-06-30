const fs = require('fs');
const path = require('path');

// Read the input files
const workflowsPath = path.join(__dirname, 'context', 'workflows.json');
const categoriesPath = path.join(__dirname, 'context', 'def_categories.json');
const outputDir = path.join(__dirname, 'official-workflows');

// Ensure output directory exists
if (!fs.existsSync(outputDir)) {
    fs.mkdirSync(outputDir, { recursive: true });
}

// Read JSON files
const workflows = JSON.parse(fs.readFileSync(workflowsPath, 'utf8'));
const categories = JSON.parse(fs.readFileSync(categoriesPath, 'utf8'));

// Create integration to category mapping
const integrationMap = {};
categories.forEach(item => {
    integrationMap[item.integration.toLowerCase()] = {
        integration: item.integration,
        category: item.category
    };
});

console.log(`Processing ${workflows.length} workflows...`);
console.log(`Found ${categories.length} integration definitions...`);

// First round: Enrich integration and category fields
workflows.forEach((workflow, index) => {
    const filename = workflow.filename.toLowerCase();
    let matchFound = false;
    
    // Check each integration for a match in the filename
    for (const [integrationKey, integrationData] of Object.entries(integrationMap)) {
        if (filename.includes(integrationKey.toLowerCase())) {
            workflow.integration = integrationData.integration;
            workflow.category = integrationData.category;
            matchFound = true;
            console.log(`Match found for "${workflow.filename}": ${integrationData.integration} -> ${integrationData.category}`);
            break; // Take first match
        }
    }
    
    if (!matchFound) {
        console.log(`No match found for "${workflow.filename}"`);
        // Leave integration and category as empty strings (they should already be empty)
        workflow.integration = workflow.integration || "";
        workflow.category = workflow.category || "";
    }
});

// Second round: Save JSON files and update json field
console.log('\nSaving JSON files...');
workflows.forEach((workflow, index) => {
    if (workflow.json) {
        // Create filename for the JSON file
        const jsonFilename = `${workflow.filename}.json`;
        const jsonFilePath = path.join(outputDir, jsonFilename);
        
        try {
            // Parse and re-stringify to ensure valid JSON formatting
            const jsonData = JSON.parse(workflow.json);
            fs.writeFileSync(jsonFilePath, JSON.stringify(jsonData, null, 2));
            
            // Update the json field
            workflow.json = "<savedAsJSONFile>";
            
            console.log(`Saved: ${jsonFilename}`);
        } catch (error) {
            console.error(`Error processing JSON for ${workflow.filename}:`, error.message);
            // Keep original json if there's an error
        }
    }
});

// Write the updated workflows.json back
fs.writeFileSync(workflowsPath, JSON.stringify(workflows, null, 2));

console.log('\nProcessing complete!');
console.log(`Updated workflows.json with enriched data`);
console.log(`JSON files saved to: ${outputDir}`);

// Summary statistics
const enrichedCount = workflows.filter(w => w.integration && w.integration !== "").length;
const totalCount = workflows.length;
console.log(`\nSummary:`);
console.log(`- Total workflows: ${totalCount}`);
console.log(`- Enriched with integration data: ${enrichedCount}`);
console.log(`- Workflows without matches: ${totalCount - enrichedCount}`);
