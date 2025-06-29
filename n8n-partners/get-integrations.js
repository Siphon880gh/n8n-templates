const fs = require('fs');
const path = require('path');

// Path to the context.json file
const contextFile = path.join(__dirname, 'context', 'context.json');
const outputFile = path.join(__dirname, 'context', 'integrations.json');

function getIntegrations() {
    try {
        // Check if context.json exists
        if (!fs.existsSync(contextFile)) {
            console.error('❌ Error: context.json not found!');
            console.error('📝 Please run `node create-context.js` first to create the context file from test-workflows submodule.');
            process.exit(1);
        }

        // Read and parse context.json
        const contextContent = fs.readFileSync(contextFile, 'utf8');
        const context = JSON.parse(contextContent);

        console.log('📖 Reading context.json...');

        // Extract unique integrations
        const integrationSet = new Set();
        
        Object.values(context).forEach(workflow => {
            const integration = workflow.integration;
            if (integration && integration.trim() !== '') {
                integrationSet.add(integration.trim());
            }
        });

        // Convert to array of objects with integration and empty category
        const integrations = Array.from(integrationSet)
            .sort() // Sort alphabetically
            .map(integration => ({
                integration: integration,
                category: ""
            }));

        // Write the integrations.json file
        fs.writeFileSync(outputFile, JSON.stringify(integrations, null, 2));

        console.log(`✅ Successfully extracted ${integrations.length} unique integrations`);
        console.log(`📄 Integrations file created at: ${outputFile}`);
        
        // Show some examples
        console.log('\n🔍 Sample integrations found:');
        integrations.slice(0, 10).forEach(item => {
            console.log(`   - ${item.integration}`);
        });
        
        if (integrations.length > 10) {
            console.log(`   ... and ${integrations.length - 10} more`);
        }

    } catch (error) {
        console.error('❌ Error processing integrations:', error.message);
        process.exit(1);
    }
}

// Run the script
getIntegrations(); 