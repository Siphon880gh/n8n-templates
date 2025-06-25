<?php
// PHP version 8.4.7
session_start();

$csvPath = 'data/n8n-templates_enriched.csv';
$protectedPage = true;
$password = "go";


// Handle login
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
    <title>n8n Templates Library</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-50">

<?php if ($protectedPage && !$isLoggedIn): ?>
    <!-- Login Form -->
    <div class="min-h-screen flex items-center justify-center px-4 py-8">
        <div class="max-w-md w-full">
            <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                <!-- Login Header -->
                <div class="bg-gradient-to-r from-blue-600 to-purple-600 text-white p-6 text-center">
                    <h1 class="text-2xl font-bold flex items-center justify-center">
                        <i class="fas fa-lock mr-3"></i>
                        Login Required
                    </h1>
                    <p class="mt-2 text-blue-100">Access n8n Templates Library</p>
                    <div class="mt-4 text-xs text-blue-200 space-y-1">
                        <p>Made browsable by <a href="https://www.linkedin.com/in/weng-fung/" target="_blank" class="text-white hover:text-blue-100 underline">Weng</a></p>
                        <p>Core data from <a href="https://www.youtube.com/watch?v=yAiCXyGLZ2c" target="_blank" class="text-white hover:text-blue-100 underline">Oleg Melnikov</a></p>
                        <p>Get AI-powered template recommendations at <a href="https://olegfuns.app.n8n.cloud/webhook/cda21b26-b940-4b60-8afa-fd7b8281a96b/chat" target="_blank" class="text-white hover:text-blue-100 underline">Oleg's AI Chat</a></p>
                    </div>
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
                            class="w-full bg-gradient-to-r from-blue-600 to-purple-600 text-white py-3 px-4 rounded-lg font-medium hover:from-blue-700 hover:to-purple-700 transition-all duration-200 transform hover:scale-[1.02] focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2"
                        >
                            <i class="fas fa-sign-in-alt mr-2"></i>
                            Login
                        </button>
                    </form>
                </div>

                <!-- Footer -->
                <div class="bg-gray-50 px-6 py-4 text-center text-sm text-gray-600">
                    <p><i class="fas fa-info-circle mr-1"></i> Enter the correct password to access the templates library</p>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Focus on password field when page loads
        $(document).ready(function() {
            $('#password').focus();
        });

        // Add some visual feedback for the form
        $('#password').on('focus', function() {
            $(this).closest('.max-w-md').addClass('transform scale-[1.02] transition-transform duration-200');
        }).on('blur', function() {
            $(this).closest('.max-w-md').removeClass('transform scale-[1.02] transition-transform duration-200');
        });
    </script>

<?php else: ?>
    <!-- Main Content (existing page content) -->
    <div class="container mx-auto px-4 py-8">
        <div class="bg-white rounded-lg shadow-lg overflow-hidden">
            <!-- Header with Logout -->
            <div class="bg-gradient-to-r from-blue-600 to-purple-600 text-white p-6">
                <div class="flex justify-between items-start">
                    <div class="flex-1">
                        <h1 class="text-3xl font-bold flex items-center">
                            <i class="fas fa-cogs mr-3"></i>
                            n8n Templates Library
                        </h1>
                        <p class="mt-2 text-blue-100">Browse and download automation templates</p>
                        <div class="mt-3 text-xs text-blue-200 space-y-1">
                            <p>Made browsable by <a href="https://www.linkedin.com/in/weng-fung/" target="_blank" class="text-white hover:text-blue-100 underline">Weng</a> • Core data from <a href="https://www.youtube.com/watch?v=yAiCXyGLZ2c" target="_blank" class="text-white hover:text-blue-100 underline">Oleg Melnikov</a></p>
                            <p><i class="fas fa-robot mr-1"></i> Get AI-powered template recommendations at <a href="https://olegfuns.app.n8n.cloud/webhook/cda21b26-b940-4b60-8afa-fd7b8281a96b/chat" target="_blank" class="text-white hover:text-blue-100 underline">Oleg's AI Chat</a></p>
                        </div>
                    </div>
                    <a href="?action=logout" class="bg-white bg-opacity-20 hover:bg-opacity-30 text-white px-4 py-2 rounded-lg transition-colors flex items-center ml-4">
                        <i class="fas fa-sign-out-alt mr-2"></i>
                        Logout
                    </a>
                </div>
            </div>

            <!-- Stats -->
            <div class="bg-gray-50 px-6 py-4 border-b">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="text-center">
                        <div class="text-2xl font-bold text-gray-800" id="total-templates">-</div>
                        <div class="text-sm text-gray-600">Total Templates</div>
                    </div>
                    <div class="text-center">
                        <div class="text-2xl font-bold text-green-600" id="available-downloads">-</div>
                        <div class="text-sm text-gray-600">Available Downloads</div>
                    </div>
                    <div class="text-center">
                        <div class="text-2xl font-bold text-blue-600" id="unique-creators">-</div>
                        <div class="text-sm text-gray-600">Unique Creators</div>
                    </div>
                </div>
            </div>

            <!-- Search and Filter -->
            <div class="p-6 border-b bg-white">
                <div class="flex flex-col md:flex-row gap-4">
                    <div class="flex-1">
                        <input type="text" id="search-input" placeholder="Search templates, creators, or descriptions..." 
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    </div>
                    <div class="flex gap-2">
                        <select id="creator-filter" class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                            <option value="">All Creators</option>
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

            <!-- Table -->
            <div class="overflow-x-auto">
                <table class="w-full" id="templates-table">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider sortable-header cursor-pointer hover:bg-gray-200 transition-colors" data-column="category">
                                <div class="flex items-center justify-between">
                                    <span>Category</span>
                                    <i class="fas fa-sort text-gray-400 sort-icon"></i>
                                </div>
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider sortable-header cursor-pointer hover:bg-gray-200 transition-colors" data-column="template">
                                <div class="flex items-center justify-between">
                                    <span>Template</span>
                                    <i class="fas fa-sort text-gray-400 sort-icon"></i>
                                </div>
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider sortable-header cursor-pointer hover:bg-gray-200 transition-colors" data-column="creator">
                                <div class="flex items-center justify-between">
                                    <span>Creator</span>
                                    <i class="fas fa-sort text-gray-400 sort-icon"></i>
                                </div>
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider sortable-header cursor-pointer hover:bg-gray-200 transition-colors" data-column="date">
                                <div class="flex items-center justify-between">
                                    <span>Date</span>
                                    <i class="fas fa-sort text-gray-400 sort-icon"></i>
                                </div>
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Links</th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider sortable-header cursor-pointer hover:bg-gray-200 transition-colors" data-column="download">
                                <div class="flex items-center justify-center">
                                    <span>Download</span>
                                    <i class="fas fa-sort text-gray-400 sort-icon ml-1"></i>
                                </div>
                            </th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider sortable-header cursor-pointer hover:bg-gray-200 transition-colors" data-column="view">
                                <div class="flex items-center justify-center">
                                    <span>View</span>
                                    <i class="fas fa-sort text-gray-400 sort-icon ml-1"></i>
                                </div>
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200" id="table-body">
                        <?php
                        $jsonDir = 'json/';
                        $templates = [];
                        $creators = [];
                        $categories = [];
                        $availableDownloads = 0;

                        if (file_exists($csvPath)) {
                            $handle = fopen($csvPath, 'r');
                            $headers = fgetcsv($handle, 0, ',', '"', '\\'); // Get headers
                            
                            // Remove BOM (Bye Orer Mark) from headers if present
                            if ($headers && !empty($headers[0])) {
                                $headers[0] = preg_replace('/^\xEF\xBB\xBF/', '', $headers[0]);
                            }
                            
                            if ($headers === FALSE) {
                                // Handle case where headers can't be read
                                fclose($handle);
                            } else {
                                $headerCount = count($headers);
                                
                                while (($data = fgetcsv($handle, 0, ',', '"', '\\')) !== FALSE) {
                                    // Skip empty rows
                                    if (empty(array_filter($data))) {
                                        continue;
                                    }
                                    
                                    $dataCount = count($data);
                                    
                                    // Make arrays the same length
                                    if ($dataCount < $headerCount) {
                                        // Pad data with empty strings if it's shorter
                                        $data = array_pad($data, $headerCount, '');
                                    } elseif ($dataCount > $headerCount) {
                                        // Truncate data if it's longer
                                        $data = array_slice($data, 0, $headerCount);
                                    }
                                    
                                    // Now safely combine arrays
                                    $template = array_combine($headers, $data);
                                    
                                    // Additional validation - ensure we have essential fields
                                    if ($template && isset($template['id']) && !empty(trim($template['id']))) {
                                        $templates[] = $template;
                                        
                                        // Collect unique creators for filter
                                        $creator = trim($template['creator'] ?? '');
                                        if (!empty($creator) && !in_array($creator, $creators)) {
                                            $creators[] = $creator;
                                        }
                                        
                                        // Collect unique categories for filter
                                        $category = trim($template['category'] ?? '');
                                        if (!empty($category) && !in_array($category, $categories)) {
                                            $categories[] = $category;
                                        }
                                        
                                        // Check if JSON file exists
                                        $jsonFile = $jsonDir . ($template['id'] ?? '') . '.json';
                                        if (file_exists($jsonFile)) {
                                            $availableDownloads++;
                                        }
                                    }
                                }
                                fclose($handle);
                            }
                        }

                        sort($creators); // Sort creators alphabetically
                        sort($categories); // Sort categories alphabetically

                        foreach ($templates as $index => $template) {
                            $name = htmlspecialchars($template['name'] ?? '');
                            $title = htmlspecialchars($template['title'] ?? '');
                            $description = htmlspecialchars($template['description'] ?? '');
                            $creator = htmlspecialchars($template['creator'] ?? '');
                            $category = htmlspecialchars($template['category'] ?? '');
                            $youtubeUrl = $template['youtube_url'] ?? '';
                            $templateUrl = $template['template_url'] ?? '';
                            $resourceUrl = $template['resource_url'] ?? '';
                            $datePosted = $template['date_posted'] ?? '';
                            $id = $template['id'] ?? '';
                            
                            // Format date
                            $formattedDate = '';
                            if (!empty($datePosted)) {
                                $date = DateTime::createFromFormat('Y-m-d\TH:i:s.v\Z', $datePosted);
                                if ($date) {
                                    $formattedDate = $date->format('M j, Y');
                                } else {
                                    $formattedDate = date('M j, Y', strtotime($datePosted));
                                }
                            }
                            
                            // Check if JSON file exists
                            $jsonFile = $jsonDir . $id . '.json';
                            $hasJsonFile = file_exists($jsonFile);
                            
                            // Truncate description for display
                            $shortDescription = strlen($description) > 150 ? substr($description, 0, 150) . '...' : $description;
                            
                            echo '<tr class="hover:bg-gray-50 template-row" data-creator="' . strtolower($creator) . '" data-search="' . strtolower($name . ' ' . $title . ' ' . $description . ' ' . $creator . ' ' . $category) . '" data-category="' . strtolower($category) . '" data-template="' . strtolower($name) . '" data-date="' . htmlspecialchars($formattedDate) . '" data-download="' . ($hasJsonFile ? '1' : '0') . '" data-view="' . ($hasJsonFile ? '1' : '0') . '">';
                            
                            // Category column
                            echo '<td class="px-6 py-4 text-center">';
                            if (!empty($category)) {
                                echo '<div class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800 w-fit text-center">' . $category . '</div>';
                            } else {
                                echo '<span class="text-xs text-gray-400">No category</span>';
                            }
                            echo '</td>';
                            
                            // Template column
                            echo '<td class="px-6 py-4">';
                            echo '<div class="flex flex-col">';
                            echo '<div class="text-sm font-medium text-gray-900">' . $name . '</div>';
                            if (!empty($title) && $title !== $name) {
                                echo '<div class="text-sm text-gray-700 font-medium mt-1">' . $title . '</div>';
                            }
                            if (!empty($shortDescription)) {
                                echo '<div class="text-xs text-gray-500 mt-2">' . $shortDescription . '</div>';
                            }
                            echo '</div>';
                            echo '</td>';
                            
                            // Creator column
                            echo '<td class="px-6 py-4 text-sm text-gray-900">' . $creator . '</td>';
                            
                            // Date column
                            echo '<td class="px-6 py-4 text-sm text-gray-500">' . $formattedDate . '</td>';
                            
                            // Links column
                            echo '<td class="px-6 py-4">';
                            echo '<div class="flex flex-col gap-1">';
                            if (!empty($youtubeUrl)) {
                                echo '<a href="' . htmlspecialchars($youtubeUrl) . '" target="_blank" class="inline-flex items-center text-red-600 hover:text-red-800 text-xs">';
                                echo '<i class="fab fa-youtube mr-1"></i> YouTube';
                                echo '</a>';
                            }
                            if (!empty($templateUrl)) {
                                echo '<a href="' . htmlspecialchars($templateUrl) . '" target="_blank" class="inline-flex items-center text-blue-600 hover:text-green-800 text-xs">';
                                echo '<i class="fas fa-download mr-1"></i> GDrive';
                                echo '</a>';
                            }
                            if (!empty($resourceUrl)) {
                                echo '<a href="' . htmlspecialchars($resourceUrl) . '" target="_blank" class="inline-flex items-center text-green-600 hover:text-blue-800 text-xs">';
                                echo '<i class="fas fa-external-link-alt mr-1"></i> Resource';
                                echo '</a>';
                            }
                            echo '</div>';
                            echo '</td>';
                            
                            // Download column
                            echo '<td class="px-6 py-4 text-center">';
                            if ($hasJsonFile) {
                                echo '<a href="' . htmlspecialchars($jsonFile) . '" download class="inline-flex items-center px-3 py-1 bg-green-100 text-green-800 text-xs font-medium rounded-full hover:bg-green-200 transition-colors">';
                                echo '<i class="fas fa-download mr-1"></i> JSON';
                                echo '</a>';
                            } else {
                                echo '<span class="inline-flex items-center px-3 py-1 bg-gray-100 text-gray-500 text-xs font-medium rounded-full">';
                                echo '<i class="fas fa-times mr-1"></i> N/A';
                                echo '</span>';
                            }
                            echo '</td>';
                            
                            // View column
                            echo '<td class="px-6 py-4 text-center">';
                            if ($hasJsonFile) {
                                echo '<button onclick="viewJson(\'' . htmlspecialchars($jsonFile) . '\', \'' . htmlspecialchars(addslashes($name)) . '\')" class="inline-flex items-center px-3 py-1 bg-blue-100 text-blue-800 text-xs font-medium rounded-full hover:bg-blue-200 transition-colors">';
                                echo '<i class="fas fa-eye mr-1"></i> View';
                                echo '</button>';
                            } else {
                                echo '<span class="inline-flex items-center px-3 py-1 bg-gray-100 text-gray-500 text-xs font-medium rounded-full">';
                                echo '<i class="fas fa-times mr-1"></i> N/A';
                                echo '</span>';
                            }
                            echo '</td>';
                            
                            echo '</tr>';
                        }
                        ?>
                    </tbody>
                </table>
            </div>

            <!-- Footer -->
            <div class="bg-gray-50 px-6 py-4 text-center text-sm text-gray-600">
                <p>Total Templates: <?php echo count($templates); ?> | Available Downloads: <?php echo $availableDownloads; ?></p>
            </div>
        </div>
    </div>

    <!-- JSON View Modal -->
    <div id="jsonModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden z-50 modal-backdrop">
        <div class="flex items-center justify-center min-h-screen p-4" onclick="closeJsonModal()">
            <div class="bg-white rounded-lg shadow-xl max-w-4xl w-full max-h-[90vh] overflow-hidden" onclick="event.stopPropagation()">
                <!-- Modal Header -->
                <div class="bg-gradient-to-r from-blue-600 to-purple-600 text-white p-4 flex justify-between items-center">
                    <h3 class="text-lg font-semibold flex items-center">
                        <i class="fas fa-file-code mr-2"></i>
                        <span id="modalTitle">JSON Template</span>
                    </h3>
                    <button onclick="closeJsonModal()" class="text-white hover:text-gray-200 transition-colors">
                        <i class="fas fa-times text-xl"></i>
                    </button>
                </div>
                
                <!-- Modal Body -->
                <div class="p-6 overflow-auto max-h-[calc(90vh-140px)]">
                    <div class="flex justify-between items-center mb-4">
                        <p class="text-gray-600">Template JSON Structure</p>
                        <button id="copyJsonBtn" onclick="copyJsonToClipboard()" class="inline-flex items-center px-4 py-2 bg-green-600 text-white text-sm font-medium rounded-lg hover:bg-green-700 transition-colors">
                            <i class="fas fa-copy mr-2"></i>
                            Copy JSON
                        </button>
                    </div>
                    
                    <div class="bg-gray-50 border border-gray-200 rounded-lg p-4">
                        <pre id="jsonContent" class="text-sm text-gray-800 whitespace-pre-wrap overflow-auto"><code>Loading...</code></pre>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            // Populate stats
            const totalTemplates = <?php echo count($templates); ?>;
            const availableDownloads = <?php echo $availableDownloads; ?>;
            const uniqueCreators = <?php echo count($creators); ?>;
            
            $('#total-templates').text(totalTemplates);
            $('#available-downloads').text(availableDownloads);
            $('#unique-creators').text(uniqueCreators);
            
            // Populate creator filter
            const creators = <?php echo json_encode($creators); ?>;
            const creatorSelect = $('#creator-filter');
            creators.forEach(creator => {
                creatorSelect.append(`<option value="${creator.toLowerCase()}">${creator}</option>`);
            });
            
            // Populate category filter
            const categories = <?php echo json_encode($categories); ?>;
            const categorySelect = $('#category-filter');
            categories.forEach(category => {
                categorySelect.append(`<option value="${category.toLowerCase()}">${category}</option>`);
            });
            
            // Search functionality
            function filterTable() {
                const searchTerm = $('#search-input').val().toLowerCase();
                const creatorFilter = $('#creator-filter').val();
                const categoryFilter = $('#category-filter').val();
                
                $('.template-row').each(function() {
                    const $row = $(this);
                    const searchData = $row.data('search');
                    const creatorData = $row.data('creator');
                    
                    const matchesSearch = searchTerm === '' || searchData.includes(searchTerm);
                    const matchesCreator = creatorFilter === '' || creatorData === creatorFilter;
                    const matchesCategory = categoryFilter === '' || $row.data('category').includes(categoryFilter);
                    
                    if (matchesSearch && matchesCreator && matchesCategory) {
                        $row.show();
                    } else {
                        $row.hide();
                    }
                });
                
                // Update visible count
                const visibleRows = $('.template-row:visible').length;
                if (searchTerm || creatorFilter || categoryFilter) {
                    $('#total-templates').text(`${visibleRows} of ${totalTemplates}`);
                } else {
                    $('#total-templates').text(totalTemplates);
                }
            }
            
            $('#search-input').on('input', filterTable);
            $('#creator-filter').on('change', filterTable);
            $('#category-filter').on('change', filterTable);
            
            // Clear filters
            $('#clear-filters').on('click', function() {
                $('#search-input').val('');
                $('#creator-filter').val('');
                $('#category-filter').val('');
                filterTable();
            });
            
            // Add hover effects and animations
            $('.template-row').hover(
                function() {
                    $(this).addClass('transform scale-[1.01] shadow-sm');
                },
                function() {
                    $(this).removeClass('transform scale-[1.01] shadow-sm');
                }
            );
        });
        
        // Sorting functionality
        let currentSort = { column: null, direction: 'asc' };
        
        $('.sortable-header').on('click', function() {
            const column = $(this).data('column');
            const $icon = $(this).find('.sort-icon');
            
            // Reset all other icons
            $('.sort-icon').removeClass('fa-sort-up fa-sort-down').addClass('fa-sort').removeClass('text-blue-600').addClass('text-gray-400');
            
            // Determine sort direction
            if (currentSort.column === column) {
                currentSort.direction = currentSort.direction === 'asc' ? 'desc' : 'asc';
            } else {
                currentSort.direction = 'asc';
            }
            currentSort.column = column;
            
            // Update icon
            $icon.removeClass('fa-sort text-gray-400').addClass('text-blue-600');
            if (currentSort.direction === 'asc') {
                $icon.addClass('fa-sort-up');
            } else {
                $icon.addClass('fa-sort-down');
            }
            
            // Sort the table
            sortTable(column, currentSort.direction);
        });
        
        function sortTable(column, direction) {
            const $tbody = $('#table-body');
            const $rows = $('.template-row').toArray();
            
            $rows.sort(function(a, b) {
                let valueA, valueB;
                
                switch(column) {
                    case 'category':
                        valueA = $(a).data('category') || '';
                        valueB = $(b).data('category') || '';
                        break;
                    case 'template':
                        valueA = $(a).data('template') || '';
                        valueB = $(b).data('template') || '';
                        break;
                    case 'creator':
                        valueA = $(a).data('creator') || '';
                        valueB = $(b).data('creator') || '';
                        break;
                    case 'date':
                        valueA = $(a).data('date') || '';
                        valueB = $(b).data('date') || '';
                        break;
                    case 'download':
                        valueA = parseInt($(a).data('download')) || 0;
                        valueB = parseInt($(b).data('download')) || 0;
                        break;
                    case 'view':
                        valueA = parseInt($(a).data('view')) || 0;
                        valueB = parseInt($(b).data('view')) || 0;
                        break;
                    default:
                        return 0;
                }
                
                // For download and view columns (boolean values)
                if (column === 'download' || column === 'view') {
                    if (direction === 'asc') {
                        return valueA - valueB;
                    } else {
                        return valueB - valueA;
                    }
                }
                
                // For text columns (alphabetical)
                if (typeof valueA === 'string' && typeof valueB === 'string') {
                    if (direction === 'asc') {
                        return valueA.localeCompare(valueB);
                    } else {
                        return valueB.localeCompare(valueA);
                    }
                }
                
                return 0;
            });
            
            // Clear and re-append sorted rows
            $tbody.empty();
            $rows.forEach(function(row) {
                $tbody.append(row);
            });
            
            // Reapply filtering if any filters are active
            filterTable();
        }
        
        // JSON Modal Functions
        let currentJsonContent = '';
        
        function viewJson(jsonFile, templateName) {
            const modal = $('#jsonModal');
            const modalTitle = $('#modalTitle');
            const jsonContent = $('#jsonContent');
            
            // Set modal title
            modalTitle.text(templateName + ' - JSON Template');
            
            // Show modal
            modal.removeClass('hidden');
            
            // Load JSON content
            jsonContent.html('<code>Loading...</code>');
            
            fetch(jsonFile)
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Failed to load JSON file');
                    }
                    return response.text();
                })
                .then(jsonText => {
                    try {
                        // Parse and pretty-format the JSON
                        const jsonObj = JSON.parse(jsonText);
                        const formattedJson = JSON.stringify(jsonObj, null, 2);
                        currentJsonContent = formattedJson;
                        jsonContent.html('<code>' + escapeHtml(formattedJson) + '</code>');
                    } catch (e) {
                        // If JSON parsing fails, show raw content
                        currentJsonContent = jsonText;
                        jsonContent.html('<code>' + escapeHtml(jsonText) + '</code>');
                    }
                })
                .catch(error => {
                    jsonContent.html('<code class="text-red-600">Error loading JSON: ' + escapeHtml(error.message) + '</code>');
                    currentJsonContent = '';
                });
        }
        
        function closeJsonModal() {
            $('#jsonModal').addClass('hidden');
        }
        
        function copyJsonToClipboard() {
            if (!currentJsonContent) {
                alert('No content to copy');
                return;
            }
            
            navigator.clipboard.writeText(currentJsonContent).then(function() {
                const copyBtn = $('#copyJsonBtn');
                const originalHtml = copyBtn.html();
                
                // Show success feedback
                copyBtn.html('<i class="fas fa-check mr-2"></i>Copied!');
                copyBtn.removeClass('bg-green-600 hover:bg-green-700').addClass('bg-green-700');
                
                // Reset after 2 seconds
                setTimeout(function() {
                    copyBtn.html(originalHtml);
                    copyBtn.removeClass('bg-green-700').addClass('bg-green-600 hover:bg-green-700');
                }, 2000);
            }).catch(function(err) {
                alert('Failed to copy to clipboard');
            });
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
        $(document).on('click', '#jsonModal', function(e) {
            if (e.target === this) {
                closeJsonModal();
            }
        });
        
        // Also handle clicks on the backdrop wrapper
        $(document).on('click', '.modal-backdrop', function(e) {
            if (e.target === this) {
                closeJsonModal();
            }
        });
        
        // Close modal with Escape key
        $(document).on('keydown', function(e) {
            if (e.key === 'Escape' && !$('#jsonModal').hasClass('hidden')) {
                closeJsonModal();
            }
        });
    </script>
<?php endif; ?>
</body>
</html>
