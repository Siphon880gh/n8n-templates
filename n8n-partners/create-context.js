const fs = require('fs');
const path = require('path');

const notIntegrationTokens = ["Merge"];

// Directory containing the workflow JSON files
const workflowsDir = path.join(__dirname, 'test-workflows', 'workflows');
const outputFile = path.join(__dirname, 'context', 'context.json');

// Function to read all JSON files and extract name field
function createContext() {
    try {
        // Ensure the context directory exists
        const contextDir = path.dirname(outputFile);
        if (!fs.existsSync(contextDir)) {
            fs.mkdirSync(contextDir, { recursive: true });
        }

        // Read all files in the workflows directory
        const files = fs.readdirSync(workflowsDir);
        
        // Filter for JSON files only
        const jsonFiles = files.filter(file => file.endsWith('.json'));
        
        console.log(`Found ${jsonFiles.length} JSON files in workflows directory`);
        
        const context = {};
        
        for (const file of jsonFiles) {
            try {
                const filePath = path.join(workflowsDir, file);
                const fileContent = fs.readFileSync(filePath, 'utf8');
                const workflow = JSON.parse(fileContent);
                
                // Extract the name field from the workflow
                let workflowName = workflow.name || 'Unnamed Workflow';
                
                // Add safeguard: prefix with "a" if name starts with a number
                if (/^\d/.test(workflowName)) {
                    workflowName = 'a' + workflowName;
                }
                
                // Extract integration name from workflow name
                let integration = '';
                if (workflowName.includes(':')) {
                    const firstToken = workflowName.split(':')[0];
                    if (!notIntegrationTokens.includes(firstToken)) {
                        integration = firstToken;
                    }
                }
                
                // Use the workflow name as the key (integration key)
                context[workflowName] = {
                    path: path.relative(__dirname, filePath),
                    integration: integration
                };
                
                console.log(`Processed: ${file} - "${workflowName}"`);
            } catch (error) {
                console.error(`Error processing file ${file}:`, error.message);
                // Continue processing other files
            }
        }
        
        // Write the context.json file
        fs.writeFileSync(outputFile, JSON.stringify(context, null, 2));
        
        console.log(`\nContext file created successfully at: ${outputFile}`);
        console.log(`Total workflows processed: ${Object.keys(context).length}`);
        
    } catch (error) {
        console.error('Error creating context:', error);
    }
}

// Run the script
createContext(); 