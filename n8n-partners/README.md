# n8n-partners



![Last Commit](https://img.shields.io/github/last-commit/Siphon880gh/n8n-templates/main)
<a target="_blank" href="https://github.com/Siphon880gh" rel="nofollow"><img src="https://img.shields.io/badge/GitHub--blue?style=social&logo=GitHub" alt="Github" data-canonical-src="https://img.shields.io/badge/GitHub--blue?style=social&logo=GitHub" style="max-width:8.5ch;"></a>
<a target="_blank" href="https://www.linkedin.com/in/weng-fung/" rel="nofollow"><img src="https://img.shields.io/badge/LinkedIn-blue?style=flat&logo=linkedin&labelColor=blue" alt="Linked-In" data-canonical-src="https://img.shields.io/badge/LinkedIn-blue?style=flat&amp;logo=linkedin&amp;labelColor=blue" style="max-width:10ch;"></a>
<a target="_blank" href="https://www.youtube.com/@WayneTeachesCode/" rel="nofollow"><img src="https://img.shields.io/badge/Youtube-red?style=flat&logo=youtube&labelColor=red" alt="Youtube" data-canonical-src="https://img.shields.io/badge/Youtube-red?style=flat&amp;logo=youtube&amp;labelColor=red" style="max-width:10ch;"></a>

By Weng Fei Fung. A browser for exploring n8n's official `test-workflows` repository, focusing on third-party integrations and partner services.

## Overview

n8n-partners is designed to help you browse and discover the extensive collection of workflows from [n8n's official test-workflows repository](https://github.com/n8n-io/test-workflows). The majority of these workflows demonstrate integrations with third-party applications and services, such as CrateDB and many other partner platforms.

## Project Structure

This folder contains a **submodule** called `test-workflows` that is n8n's official repository. This submodule provides access to all of n8n's official workflow examples and test cases.

## Getting Started

To create or update the browsable experience of n8n's workflows, follow these steps in order:

> **Note**: If you're updating with newer workflows from n8n, make sure to first run `git pull` in the `test-workflows` submodule directory to get the latest workflows.

### 1. Generate Workflow Context
First, run the context command to analyze all workflows and create a browsable database:

```bash
npm run context
```

This command processes all workflows in the `test-workflows` submodule and extracts contextual information, making them searchable and browsable.

It produces a `context/context.json` file:
```
{
  "Twitter:tweet:create:create like retweet delete search": {
    "path": "test-workflows/workflows/1.json",
    "integration": "Twitter"
  },
  "PagerDuty:incident:create get update getAll:incidentNote:create getAll:User:get:LogEntry:getAll get": {
    "path": "test-workflows/workflows/10.json",
    "integration": "PagerDuty"
  },
  "RenameKeys": {
    "path": "test-workflows/workflows/101.json",
    "integration": ""
  },
  "ReadBinaryFile": {
    "path": "test-workflows/workflows/102.json",
    "integration": ""
  },
  "ExecuteCommand": {
    "path": "test-workflows/workflows/103.json",
    "integration": ""
  },
  ...
```

### 2. Extract Integration Names
After generating the context, run the integrations command to identify all third-party integrations:

```bash
npm run integrations
```

This command analyzes the workflows and extracts the names of all integrations, allowing you to browse workflows by specific third-party services.

It produces a `context/integrations.json` file:
```
[
  {
    "integration": "APITemplate.io",
    "category": "",
    "description": ""
  },
  {
    "integration": "AWS Transcribe",
    "category": "",
    "description": ""
  },
  {
    "integration": "AWSComprehend",
    "category": "",
    "description": ""
  },
  ...
```

### 3. AI-Powered Categorization
Once you have the integration data, you'll need to ask **ChatGPT or another AI agent** to categorize the workflows into appropriate categories. Cursor AI is not bad actually for this (Make sure to open on the `integrations.json` file).

Prompt:
```
You are a business automation and integration expert. You will help user enrich this JSON file of integrations. Fill the JSON data with categories and description where they are empty. For example, Twilio is under the category "Marketing & Advertising Automation". The description is where you describe what that service does.

#### Example Categories:
- **AI Agent Development**
- **Business Process Automation**
- **Creative Content & Video Automation**
- **Creative Design Automation**
- **Data Processing & Analysis**
- **Marketing & Advertising Automation**
- **Technical Infrastructure & DevOps**
- **Web Scraping & Data Extraction**

You can suggest additional categories as long as they remain as a broad category like the above categories, so we don't end up with too many categories.
```

## Purpose

This browser makes it easy to:

- **Find specific integrations**: Quickly locate workflows for particular third-party services or applications
- **Discover new integrations**: Explore the wide range of available third-party integrations and partner services
- **Browse workflows**: Navigate through n8n's comprehensive collection of integration examples
- **Browse by category**: Find workflows grouped by their primary use case or industry focus

## What's Inside

The workflows in this collection showcase integrations with various third-party services, providing real-world examples of how n8n connects with external platforms and APIs. Whether you're looking for a specific integration or want to discover what's possible with n8n's ecosystem, this browser provides an organized way to explore these valuable resources.
