# Zie619 Community Workflows

This folder serves as a placeholder for Zie619's community-sourced n8n workflows. Zie619 has created an excellent browsable interface for exploring and managing n8n workflows already so I did not have to create one.

Once you are done with setup, the portal will be able to open Zie619's template browser because you would have setup reverse proxy to where this placeholder path would be.

## Setup Instructions

To set up Zie619's workflow browser locally:

1. **Download the repository**
```
git clone https://github.com/Zie619/n8n-workflows
cd n8n-workflows
```

2. **Install Python dependencies**
```
pip install -r requirements.txt
```

3. **Run the application**
```
python app.py
```

4. **Configure reverse proxy**
   Configure your reverse proxy to point to the running Python application. Then the portal will be able to open this curated collection as well.