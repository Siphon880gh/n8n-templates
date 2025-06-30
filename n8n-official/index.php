<?php
// PHP version 8.4.7
session_start();

$workflowsPath = 'context/workflows.json';
$protectedPage = false;
$password = "go";

// Handle login (keeping same structure as n8n-partners)
$loginError = '';
if ($_POST['action'] ?? '' === 'login') {
    $inputPassword = $_POST['password'] ?? '';
    if ($inputPassword === $password) {
        $_SESSION['logged_in'] = true;
        header('Location: ' . $_SERVER['PHP_SELF']);
        exit;
    } else {
        $loginError = 'Invalid password. Please try again.';
    }
}

// Handle logout
if ($_GET['action'] ?? '' === 'logout') {
    session_destroy();
    header('Location: ' . $_SERVER['PHP_SELF']);
    exit;
}

// Check if user is logged in
$isLoggedIn = $_SESSION['logged_in'] ?? false;

// Suppress deprecation warnings
error_reporting(E_ALL & ~E_DEPRECATED & ~E_STRICT);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>n8n Official - Workflow Templates</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-50">

<?php if ($protectedPage && !$isLoggedIn): ?>
    <!-- Login Form (keeping same as n8n-partners) -->
    <div class="min-h-screen flex items-center justify-center px-4 py-8">
        <div class="max-w-md w-full">
            <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                <!-- Login Header -->
                <div class="bg-gradient-to-r from-blue-600 to-indigo-600 text-white p-6 text-center">
                    <h1 class="text-2xl font-bold flex items-center justify-center">
                        <i class="fas fa-lock mr-3"></i>
                        Login Required
                    </h1>
                    <p class="mt-2 text-blue-100">Access n8n Official Workflow Library</p>
                </div>

                <!-- Login Form -->
                <div class="p-6">
                    <?php if (!empty($loginError)): ?>
                        <div class="mb-4 p-3 bg-red-100 border border-red-400 text-red-700 rounded">
                            <i class="fas fa-exclamation-triangle mr-2"></i>
                            <?php echo htmlspecialchars($loginError); ?>
                        </div>
                    <?php endif; ?>

                    <form method="POST" action="" class="space-y-4">
                        <input type="hidden" name="action" value="login">
                        
                        <div>
                            <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="fas fa-key mr-1"></i>
                                Password
                            </label>
                            <input 
                                type="password" 
                                id="password" 
                                name="password" 
                                required 
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-colors"
                                placeholder="Enter password"
                                autocomplete="current-password"
                            >
                        </div>

                        <button 
                            type="submit" 
                            class="w-full bg-gradient-to-r from-blue-600 to-indigo-600 text-white py-3 px-4 rounded-lg font-medium hover:from-blue-700 hover:to-indigo-700 transition-all duration-200 transform hover:scale-[1.02] focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2"
                        >
                            <i class="fas fa-sign-in-alt mr-2"></i>
                            Login
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

<?php else: ?>
    <!-- Main Content -->
    <div class="container mx-auto px-4 py-8">
        <div class="bg-white rounded-lg shadow-lg overflow-hidden">
            <!-- Header -->
            <div class="bg-gradient-to-r from-blue-600 to-indigo-600 text-white p-6">
                <!-- Breadcrumb Navigation -->
                <div class="mb-4">
                    <nav class="flex items-center text-sm">
                        <a href="../index.php" class="text-blue-100 hover:text-white transition-colors flex items-center">
                            <i class="fas fa-cogs mr-1"></i>
                            n8n Templates Portal
                        </a>
                        <i class="fas fa-chevron-right mx-2 text-blue-200"></i>
                        <span class="text-white font-medium">n8n Official</span>
                    </nav>
                </div>
                
                <div class="flex justify-between items-start">
                    <div class="flex-1">
                        <h1 class="text-3xl font-bold flex items-center">
                            <i class="fas fa-certificate mr-3"></i>
                            n8n Official - Workflow Templates
                        </h1>
                        <p class="mt-2 text-blue-100">Browse and explore official n8n workflow templates by integration or category</p>
                        <div class="mt-3 text-xs text-blue-200">
                            <p>Official workflow collection from n8n.io showcasing best practices and integrations</p>
                            <p class="mt-1">Made browsable by <a href="https://www.linkedin.com/in/weng-fung/" target="_blank" class="text-blue-100 hover:text-white underline">Weng</a> • Core data from <a href="https://n8n.io/creators/n8n-team/" target="_blank" class="text-blue-100 hover:text-white underline">n8n.io workflows</a></p>
                        </div>
                    </div>
                    <?php if($protectedPage): ?>
                    <a href="?action=logout" class="bg-white bg-opacity-20 hover:bg-opacity-30 text-white px-4 py-2 rounded-lg transition-colors flex items-center ml-4">
                        <i class="fas fa-sign-out-alt mr-2"></i>
                        Logout
                    </a>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Stats -->
            <div class="bg-gray-50 px-6 py-4 border-b">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <div class="text-center">
                        <div class="text-2xl font-bold text-gray-800" id="total-workflows">-</div>
                        <div class="text-sm text-gray-600">Total Workflows</div>
                    </div>
                    <div class="text-center">
                        <div class="text-2xl font-bold text-blue-600" id="total-integrations">-</div>
                        <div class="text-sm text-gray-600">Integrations</div>
                    </div>
                    <div class="text-center">
                        <div class="text-2xl font-bold text-indigo-600" id="total-categories">-</div>
                        <div class="text-sm text-gray-600">Categories</div>
                    </div>
                    <div class="text-center">
                        <div class="text-2xl font-bold text-green-600" id="available-downloads">-</div>
                        <div class="text-sm text-gray-600">Available Downloads</div>
                    </div>
                </div>
            </div>

            <!-- Search and Filter -->
            <div class="p-6 border-b bg-white">
                <div class="flex flex-col md:flex-row gap-4">
                    <div class="flex-1">
                        <input type="text" id="search-input" placeholder="Search workflows, integrations, or functionality..." 
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    </div>
                    <div class="flex gap-2">
                        <select id="integration-filter" class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                            <option value="">All Integrations</option>
                        </select>
                        <select id="category-filter" class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                            <option value="">All Categories</option>
                        </select>
                        <button id="clear-filters" class="px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600 transition-colors">
                            <i class="fas fa-times mr-1"></i> Clear
                        </button>
                    </div>
                </div>
            </div>

            <!-- Workflows Grid -->
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6" id="workflows-grid">
                    <!-- Workflow cards will be populated by JavaScript -->
                </div>
            </div>

            <!-- Footer -->
            <div class="bg-gray-50 px-6 py-4 text-center text-sm text-gray-600">
                <p id="footer-stats">Loading workflow statistics...</p>
            </div>
        </div>
    </div>

    <!-- Workflow View Modal -->
    <div id="workflowModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden z-50 modal-backdrop">
        <div class="flex items-center justify-center min-h-screen p-4" onclick="closeWorkflowModal()">
            <div class="bg-white rounded-lg shadow-xl max-w-4xl w-full max-h-[90vh] overflow-hidden" onclick="event.stopPropagation()">
                <!-- Modal Header -->
                <div class="bg-gradient-to-r from-blue-600 to-indigo-600 text-white p-4 flex justify-between items-center">
                    <h3 class="text-lg font-semibold flex items-center">
                        <i class="fas fa-file-code mr-2"></i>
                        <span id="modalTitle">Workflow JSON</span>
                    </h3>
                    <button onclick="closeWorkflowModal()" class="text-white hover:text-gray-200 transition-colors">
                        <i class="fas fa-times text-xl"></i>
                    </button>
                </div>
                
                <!-- Modal Body -->
                <div class="p-6 overflow-auto max-h-[calc(90vh-140px)]">
                                         <div class="flex justify-between items-center mb-4">
                         <p class="text-gray-600">Workflow JSON Structure</p>
                         <div class="flex gap-2">
                             <button id="viewDocsBtn" onclick="openDocumentation()" class="inline-flex items-center px-4 py-2 bg-gray-100 text-gray-700 text-sm font-medium rounded-lg hover:bg-gray-200 transition-colors">
                                 <i class="fas fa-external-link-alt mr-2"></i>
                                 View Docs
                             </button>
                             <button id="copyJsonBtn" onclick="copyJsonToClipboard()" class="inline-flex items-center px-4 py-2 bg-green-600 text-white text-sm font-medium rounded-lg hover:bg-green-700 transition-colors">
                                 <i class="fas fa-copy mr-2"></i>
                                 Copy JSON
                             </button>
                             <button id="downloadJsonBtn" onclick="downloadJson()" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition-colors">
                                 <i class="fas fa-download mr-2"></i>
                                 Download
                             </button>
                         </div>
                     </div>
                    
                    <div class="bg-gray-50 border border-gray-200 rounded-lg p-4">
                        <pre id="workflowContent" class="text-sm text-gray-800 whitespace-pre-wrap overflow-auto"><code>Loading...</code></pre>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
                 let workflowsData = [];
         let currentJsonContent = '';
         let currentWorkflowName = '';
         let currentWorkflowHref = '';

        $(document).ready(function() {
            loadData();
        });

        async function loadData() {
            try {
                // Load workflows data
                const response = await fetch('context/workflows.json');
                const workflows = await response.json();

                // Process workflows data
                workflowsData = workflows.map(workflow => {
                    const titleCaseName = convertToTitleCase(workflow.filename);
                    return {
                        filename: workflow.filename,
                        name: titleCaseName,
                        href: workflow.href,
                        integration: workflow.integration || '',
                        category: workflow.category || 'Uncategorized',
                        jsonFile: `official-workflows/${workflow.filename}.json`,
                        searchText: (titleCaseName + ' ' + workflow.integration + ' ' + workflow.category).toLowerCase()
                    };
                });

                populateFilters();
                renderWorkflows();
                updateStats();
                setupEventListeners();

            } catch (error) {
                console.error('Error loading data:', error);
                $('#workflows-grid').html('<div class="col-span-full text-center text-red-600"><i class="fas fa-exclamation-triangle mr-2"></i>Error loading workflow data</div>');
            }
        }

        function convertToTitleCase(filename) {
            return filename
                .replace(/^\d+-/, '') // Remove number prefix
                .split('-')
                .map(word => word.charAt(0).toUpperCase() + word.slice(1))
                .join(' ');
        }

        function populateFilters() {
            const integrations = [...new Set(workflowsData.map(w => w.integration).filter(i => i))].sort();
            const categories = [...new Set(workflowsData.map(w => w.category))].sort();

            const integrationSelect = $('#integration-filter');
            const categorySelect = $('#category-filter');

            integrations.forEach(integration => {
                integrationSelect.append(`<option value="${integration}">${integration}</option>`);
            });

            categories.forEach(category => {
                categorySelect.append(`<option value="${category}">${category}</option>`);
            });
        }

        function renderWorkflows(filteredData = workflowsData) {
            const grid = $('#workflows-grid');
            
            if (filteredData.length === 0) {
                grid.html('<div class="col-span-full text-center text-gray-500 py-8"><i class="fas fa-search mr-2"></i>No workflows found matching your criteria</div>');
                return;
            }

                         const cards = filteredData.map(workflow => {
                 const integrationIcon = workflow.integration ? 'fas fa-puzzle-piece' : 'fas fa-cog';
                 const categoryColor = getCategoryColor(workflow.category);

                 return `
                     <div class="workflow-card bg-white rounded-lg shadow-md hover:shadow-lg transition-shadow cursor-pointer border hover:border-blue-200"
                          onclick="viewWorkflow('${workflow.jsonFile}', '${escapeHtml(workflow.name)}', '${workflow.href}')"
                          data-search="${workflow.searchText}"
                          data-integration="${workflow.integration.toLowerCase()}"
                          data-category="${workflow.category.toLowerCase()}">
                         
                         <div class="p-6">
                             <!-- Header -->
                             <div class="flex items-start justify-between mb-4">
                                 <div class="flex items-center">
                                     <i class="${integrationIcon} text-blue-600 mr-2"></i>
                                     <span class="text-sm font-medium text-blue-600">
                                         ${workflow.integration || 'Core Node'}
                                     </span>
                                 </div>
                                 <div class="flex items-center gap-2">
                                     <i class="fas fa-download text-green-500 text-sm" title="JSON Available"></i>
                                     <a href="${workflow.href}" target="_blank" 
                                        onclick="event.stopPropagation()"
                                        class="text-gray-400 hover:text-blue-600 transition-colors text-sm" 
                                        title="View Documentation">
                                         <i class="fas fa-external-link-alt"></i>
                                     </a>
                                 </div>
                             </div>

                             <!-- Workflow Name -->
                             <h3 class="text-lg font-semibold text-gray-900 mb-3 line-clamp-2 hover:text-blue-600 transition-colors">
                                 ${workflow.name}
                             </h3>

                             <!-- Category -->
                             <div class="mb-3">
                                 <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium ${categoryColor}">
                                     ${workflow.category}
                                 </span>
                             </div>

                             <!-- Actions -->
                             <div class="flex items-center justify-between pt-4 border-t border-gray-100">
                                 <a href="${workflow.href}" target="_blank" 
                                    onclick="event.stopPropagation()"
                                    class="inline-flex items-center text-xs text-gray-500 hover:text-gray-700 transition-colors">
                                     <i class="fas fa-external-link-alt mr-1"></i>
                                     View Documentation
                                 </a>
                                 <span class="text-xs text-green-600 font-medium">JSON Available</span>
                             </div>
                         </div>
                     </div>
                 `;
            }).join('');

            grid.html(cards);
        }

        function getCategoryColor(category) {
            const colors = {
                'AI Agent Development': 'bg-purple-100 text-purple-800',
                'Marketing & Advertising Automation': 'bg-pink-100 text-pink-800',
                'CRM & Sales': 'bg-blue-100 text-blue-800',
                'Communication & Messaging': 'bg-green-100 text-green-800',
                'Data Processing & Analysis': 'bg-yellow-100 text-yellow-800',
                'Cloud Storage & File Management': 'bg-indigo-100 text-indigo-800',
                'Technical Infrastructure & DevOps': 'bg-gray-100 text-gray-800',
                'Project Management': 'bg-orange-100 text-orange-800',
                'Financial & Accounting': 'bg-emerald-100 text-emerald-800',
                'Creative Design Automation': 'bg-red-100 text-red-800',
                'Creative Content & Video Automation': 'bg-violet-100 text-violet-800',
                'Social Media Management': 'bg-cyan-100 text-cyan-800',
                'E-commerce & Retail': 'bg-teal-100 text-teal-800',
                'Web Scraping & Data Extraction': 'bg-lime-100 text-lime-800',
                'Business Process Automation': 'bg-amber-100 text-amber-800'
            };
            return colors[category] || 'bg-gray-100 text-gray-800';
        }

        function updateStats() {
            const totalWorkflows = workflowsData.length;
            const totalIntegrations = new Set(workflowsData.map(w => w.integration).filter(i => i)).size;
            const totalCategories = new Set(workflowsData.map(w => w.category)).size;
            const availableDownloads = workflowsData.length; // All have downloads

            $('#total-workflows').text(totalWorkflows);
            $('#total-integrations').text(totalIntegrations);
            $('#total-categories').text(totalCategories);
            $('#available-downloads').text(availableDownloads);

            $('#footer-stats').text(`Total Workflows: ${totalWorkflows} | Integrations: ${totalIntegrations} | Categories: ${totalCategories} | Downloads Available: ${availableDownloads}`);
        }

        function setupEventListeners() {
            // Search functionality
            $('#search-input').on('input', filterWorkflows);
            $('#integration-filter').on('change', filterWorkflows);
            $('#category-filter').on('change', filterWorkflows);

            // Clear filters
            $('#clear-filters').on('click', function() {
                $('#search-input').val('');
                $('#integration-filter').val('');
                $('#category-filter').val('');
                filterWorkflows();
            });

            // Close modal with Escape key
            $(document).on('keydown', function(e) {
                if (e.key === 'Escape' && !$('#workflowModal').hasClass('hidden')) {
                    closeWorkflowModal();
                }
            });
        }

        function filterWorkflows() {
            const searchTerm = $('#search-input').val().toLowerCase();
            const integrationFilter = $('#integration-filter').val().toLowerCase();
            const categoryFilter = $('#category-filter').val().toLowerCase();

            const filtered = workflowsData.filter(workflow => {
                const matchesSearch = !searchTerm || workflow.searchText.includes(searchTerm);
                const matchesIntegration = !integrationFilter || workflow.integration.toLowerCase() === integrationFilter;
                const matchesCategory = !categoryFilter || workflow.category.toLowerCase() === categoryFilter;

                return matchesSearch && matchesIntegration && matchesCategory;
            });

            renderWorkflows(filtered);

            // Update visible count
            if (searchTerm || integrationFilter || categoryFilter) {
                $('#total-workflows').text(`${filtered.length} of ${workflowsData.length}`);
            } else {
                $('#total-workflows').text(workflowsData.length);
            }
        }

                 async function viewWorkflow(jsonFile, name, href) {
             const modal = $('#workflowModal');
             const modalTitle = $('#modalTitle');
             const workflowContent = $('#workflowContent');

             currentWorkflowName = name;
             currentWorkflowHref = href;
             modalTitle.text(name + ' - Workflow JSON');
             modal.removeClass('hidden');

            workflowContent.html('<code>Loading...</code>');

            try {
                const response = await fetch(jsonFile);
                if (!response.ok) {
                    throw new Error('Failed to load workflow file');
                }

                const jsonText = await response.text();
                const jsonObj = JSON.parse(jsonText);
                const formattedJson = JSON.stringify(jsonObj, null, 2);
                
                currentJsonContent = formattedJson;
                workflowContent.html('<code>' + escapeHtml(formattedJson) + '</code>');
            } catch (error) {
                workflowContent.html('<code class="text-red-600">Error loading workflow: ' + escapeHtml(error.message) + '</code>');
                currentJsonContent = '';
            }
        }

        

                 function closeWorkflowModal() {
             $('#workflowModal').addClass('hidden');
         }

         function openDocumentation() {
             if (currentWorkflowHref) {
                 window.open(currentWorkflowHref, '_blank');
             }
         }

        function copyJsonToClipboard() {
            if (!currentJsonContent) {
                alert('No content to copy');
                return;
            }

            navigator.clipboard.writeText(currentJsonContent).then(function() {
                const copyBtn = $('#copyJsonBtn');
                const originalHtml = copyBtn.html();

                copyBtn.html('<i class="fas fa-check mr-2"></i>Copied!');
                copyBtn.removeClass('bg-green-600 hover:bg-green-700').addClass('bg-green-700');

                setTimeout(function() {
                    copyBtn.html(originalHtml);
                    copyBtn.removeClass('bg-green-700').addClass('bg-green-600 hover:bg-green-700');
                }, 2000);
            }).catch(function(err) {
                alert('Failed to copy to clipboard');
            });
        }

        function downloadJson() {
            if (!currentJsonContent) {
                alert('No content to download');
                return;
            }

            const blob = new Blob([currentJsonContent], { type: 'application/json' });
            const url = window.URL.createObjectURL(blob);
            const a = document.createElement('a');
            
            a.style.display = 'none';
            a.href = url;
            a.download = currentWorkflowName.replace(/[^a-z0-9]/gi, '_').toLowerCase() + '.json';
            
            document.body.appendChild(a);
            a.click();
            window.URL.revokeObjectURL(url);
            document.body.removeChild(a);
        }

        function escapeHtml(unsafe) {
            return unsafe
                .replace(/&/g, "&amp;")
                .replace(/</g, "&lt;")
                .replace(/>/g, "&gt;")
                .replace(/"/g, "&quot;")
                .replace(/'/g, "&#039;");
        }

        // Close modal when clicking outside
        $(document).on('click', '#workflowModal', function(e) {
            if (e.target === this) {
                closeWorkflowModal();
            }
        });
    </script>

    <style>
        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
        
        .line-clamp-3 {
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
        
        .workflow-card:hover {
            transform: translateY(-2px);
        }
        
        .workflow-card {
            transition: all 0.2s ease;
        }
    </style>
<?php endif; ?>
</body>
</html>
