For reverse proxy so that the /api/zie619 maps to the port we're running for the zie619's api server:

Added unique subpath to /api at n8n-workflows/static/index.html:
```
      async apiCall(endpoint, options = {}) {
        const response = await fetch(`/api/zie619${endpoint}`, {
```

And:

```
        this.elements.downloadBtn.href = `/api/zie619/workflows/${workflow.filename}/download`;
```


Added breadcrumb with tailwind and fontawesome at n8n-workflows/static/index.html:

```
  <script src="https://cdn.tailwindcss.com"></script>
  <script>
    tailwind.config = {
      corePlugins: {
        preflight: false,
      }
    }
  </script>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
```

And:

```
<body>
  <div id="app">

    <!-- Breadcrumb Navigation (Dark) -->
    <div class="mb-4 flex justify-center bg-gradient-to-r from-blue-600 to-purple-600 py-4">
        <nav class="flex items-center text-sm">
            <a href="../index.php" class="text-blue-100 hover:text-white transition-colors flex items-center" style="text-decoration: none;">
                <i class="fas fa-cogs mr-1"></i>
                n8n Templates Portal
            </a>
            <i class="fas fa-chevron-right mx-2 text-blue-200"></i>
            <span class="text-white font-medium">Zie619's</span>
        </nav>
    </div>

    <!-- Header -->
```