# n8n Official Workflows Data Processing

This directory contains tools and data for processing official n8n team workflows from [https://n8n.io/creators/n8n-team/](https://n8n.io/creators/n8n-team/).

## Overview

The workflow enrichment process takes raw scraped workflow data and enhances it with integration and category information to create a better browsing experience for users. This allows users to search and filter workflows by integration type and category.

## Files Structure

- `create-context.js` - Main script that enriches workflow data
- `context/workflows.json` - Enriched workflow metadata 
- `context/def_categories.json` - Integration to category mapping definitions
- `context/last-updated.txt` - Timestamp of last processing that you manually enter.
- `official-workflows/` - Individual JSON files for each workflow

## Workflow Process

### 1. Data Collection

Use a Puppeteer IDE Chrome extension script to scrape workflow data from the n8n team page. The script captures:
- Workflow URLs
- Workflow filenames  
- Complete workflow JSON definitions

The puppeteer IDE script is:
```
const listHandles = await page.$x('/html/body/div[1]/section/div/div[2]/section[1]/div/div/div[2]/div[2]');
let ahrefs = [];

if (listHandles.length) {
  const list = listHandles[0]; // get the actual element handle

  const linkHandles = await list.$$('a'); // get all <a> elements inside it

  for (const link of linkHandles) {
    const href = await link.evaluate(el => el.href);
    ahrefs.push(href);
  }
} else {
  console.error('No element found for the XPath');
}

console.log(ahrefs)

for(var i=0; i<ahrefs.length; i++) {
    var ahref = ahrefs[i];
    await page.goto(ahref);

    const workflowJsonTag = await page.waitForSelector("n8n-demo") // Yes the webpage has a custom HTML Tag that stored the workflow json `<n8n-demo workflow="josn...">`

    const json = await workflowJsonTag.evaluate(el => el.getAttribute("workflow")); // get the value of the 'workflow' attribute
    
    // The data structure
    if(ahref.endsWith("/")) {
        ahref = ahref.substr(0, ahref.length-1)
    }
    // href already defined at this point
    var filename = ahref.split("/").pop();
    var integration = ""; // will be filled by a post script outside of web browser. looks at filename that has words hyphenated for keyword for integration 
    var category = ""; // will be filled by a post script outside of web browser. it looks up the integration word in order to look up the category in another file def_categories.json
    // json already filled by puppeteer at this point. The post script will get rid of the json field and save to json file of the same filename, in order to make parsing a smaller json file on demand possible.
    ahrefs[i] = {
        href: ahref,
        filename,
        integration,
        category,
        json
    } // ahrefs array being modified

   await page.waitForTimeout(2000); // dont get banned!

   console.log(ahrefs);
}
```

If you need help with puppeteer IDE, refer to my coding notes root folder Scraping -> Puppeteer -> Puppeteer IDE at
https://codernotes.wengindustries.com/

This Readme assumes you have Puppeteer knowledge to be able to run that headful. If not, it's okay - just refer to my other tutorial at the link above.

Once done with headful puppetter IDE, the console output will look like this:

```javascript
[
  {
    "href": "https://n8n.io/workflows/1806-send-zendesk-tickets-to-pipedrive-contacts-and-assign-tasks",
    "filename": "1806-send-zendesk-tickets-to-pipedrive-contacts-and-assign-tasks",
    "integration": "",
    "category": "",
    "json": "..." // Very long workflow JSON definition
  },
  {
    "href": "https://n8n.io/workflows/1807-sync-zendesk-tickets-to-pipedrive-contact-owners", 
    "filename": "1807-sync-zendesk-tickets-to-pipedrive-contact-owners",
    "integration": "",
    "category": "",
    "json": "..." // Very long workflow JSON definition  
  },
  // ... more workflows
]
```

### 2. Saving Raw Data

1. Right-click in the browser console
2. Select "Store as object" 
3. Copy the logged array
4. Paste it into `context/workflows.json`

At this stage, the `integration` and `category` fields are empty, and the `json` field contains the complete workflow definition.

### 3. Data Enrichment

Run the enrichment script:

```bash
node create-context.js
```

The script performs two main operations:

#### Integration & Category Enrichment

The script uses `def_categories.json` to map integrations to categories. It:

1. Reads the workflow filename
2. Searches for integration keywords in the filename (case-insensitive)
3. Looks up the corresponding category from `def_categories.json`
4. Populates the `integration` and `category` fields

For example, if a filename contains "pipedrive", it will be mapped to:
- **Integration**: "Pipedrive"  
- **Category**: "CRM & Sales"

#### JSON File Extraction

The script also:

1. Extracts the workflow JSON from each entry
2. Saves it as an individual file in `official-workflows/`
3. Replaces the `json` field value with `"<savedAsJSONFile>"`

This approach:
- Makes individual workflows easily browsable
- Keeps the main `workflows.json` file lightweight
- Improves search performance by avoiding bloated metadata files

### 4. Final Result

After processing, `workflows.json` becomes:

```javascript
[
  {
    "href": "https://n8n.io/workflows/1806-send-zendesk-tickets-to-pipedrive-contacts-and-assign-tasks",
    "filename": "1806-send-zendesk-tickets-to-pipedrive-contacts-and-assign-tasks", 
    "integration": "Pipedrive",
    "category": "CRM & Sales",
    "json": "<savedAsJSONFile>"
  },
  {
    "href": "https://n8n.io/workflows/1807-sync-zendesk-tickets-to-pipedrive-contact-owners",
    "filename": "1807-sync-zendesk-tickets-to-pipedrive-contact-owners",
    "integration": "Pipedrive", 
    "category": "CRM & Sales",
    "json": "<savedAsJSONFile>"
  },
  // ... more enriched workflows
]
```

## Integration Categories Reference

The `def_categories.json` file contains mappings between n8n integrations and their logical categories:

- **AI Agent Development** - AI services, LLM chains, vector stores
- **Communication & Messaging** - Email, chat, notifications  
- **CRM & Sales** - Customer relationship management tools
- **Data Processing & Analysis** - Databases, spreadsheets, analytics
- **Marketing & Advertising Automation** - Email marketing, lead generation
- **Project Management** - Task management, collaboration tools
- **Technical Infrastructure & DevOps** - CI/CD, monitoring, cloud services
- **Business Process Automation** - General business workflows
- **Creative Design Automation** - Design tools, content creation
- **And more...**

This categorization system is also used in the `zie619-community/` directory for consistent filtering across different workflow collections.

## Script Output

When running `create-context.js`, you'll see output like:

```
Processing 10 workflows...
Found 726 integration definitions...
Match found for "1806-send-zendesk-tickets-to-pipedrive-contacts-and-assign-tasks": Pipedrive -> CRM & Sales
Match found for "1807-sync-zendesk-tickets-to-pipedrive-contact-owners": Pipedrive -> CRM & Sales
No match found for "1929-v1-helper-find-params-with-affected-expressions"

Saving JSON files...
Saved: 1806-send-zendesk-tickets-to-pipedrive-contacts-and-assign-tasks.json
Saved: 1807-sync-zendesk-tickets-to-pipedrive-contact-owners.json

Processing complete!
Updated workflows.json with enriched data
JSON files saved to: official-workflows/

Summary:
- Total workflows: 10
- Enriched with integration data: 9  
- Workflows without matches: 1
```

## Benefits

This enrichment process enables:

- **Faster Loading**: Lightweight metadata files load quickly
- **Better Search**: Users can filter by integration and category
- **Easy Browsing**: Individual JSON files are easily accessible
- **Consistent Categorization**: Standardized categories across workflow collections
- **Scalability**: Process works efficiently with large numbers of workflows
