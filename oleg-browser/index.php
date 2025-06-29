<?php
// PHP version 8.4.7
session_start();

$csvPath = 'data/n8n-templates_enriched.csv';
$protectedPage = false;
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
    <title>Oleg's Templates Collection</title>
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
                <!-- Breadcrumb Navigation -->
                <div class="mb-4">
                    <nav class="flex items-center text-sm">
                        <a href="../index.php" class="text-blue-100 hover:text-white transition-colors flex items-center">
                            <i class="fas fa-cogs mr-1"></i>
                            n8n Templates Portal
                        </a>
                        <i class="fas fa-chevron-right mx-2 text-blue-200"></i>
                        <span class="text-white font-medium">Oleg's</span>
                    </nav>
                </div>
                
                <div class="flex justify-between items-start">
                    <div class="flex-1">
                        <h1 class="text-3xl font-bold flex items-center">
                            <i class="fas fa-cogs mr-3"></i>
                            Oleg's Templates Collection
                        </h1>
                        <p class="mt-2 text-blue-100">Browse and download automation templates</p>
                        <div class="mt-3 text-xs text-blue-200 space-y-1">
                            <p>Made browsable by <a href="https://www.linkedin.com/in/weng-fung/" target="_blank" class="text-white hover:text-blue-100 underline">Weng</a> • Core data from <a href="https://www.youtube.com/watch?v=yAiCXyGLZ2c" target="_blank" class="text-white hover:text-blue-100 underline">Oleg Melnikov</a></p>
                            <p><i class="fas fa-robot mr-1"></i> Get AI-powered template recommendations at <a href="https://olegfuns.app.n8n.cloud/webhook/cda21b26-b940-4b60-8afa-fd7b8281a96b/chat" target="_blank" class="text-white hover:text-blue-100 underline">Oleg's AI Chat</a></p>
                        </div>
                    </div>
                    <?php if($protectedPage) echo '
                    <a href="?action=logout" class="bg-white bg-opacity-20 hover:bg-opacity-30 text-white px-4 py-2 rounded-lg transition-colors flex items-center ml-4">
                        <i class="fas fa-sign-out-alt mr-2"></i>
                        Logout
                    </a>
                    ';
                    ?>
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

                        // Function to find all JSON files for a given template ID
                        function findJsonFiles($jsonDir, $templateId) {
                            $jsonFiles = [];
                            if (empty($templateId)) return $jsonFiles;
                            
                            // Check for base file first
                            $baseFile = $jsonDir . $templateId . '.json';
                            if (file_exists($baseFile)) {
                                $jsonFiles[] = $baseFile;
                            }
                            
                            // Check for numbered variants
                            $counter = 1;
                            while (true) {
                                $numberedFile = $jsonDir . $templateId . '_' . $counter . '.json';
                                if (file_exists($numberedFile)) {
                                    $jsonFiles[] = $numberedFile;
                                    $counter++;
                                } else {
                                    break;
                                }
                            }
                            
                            return $jsonFiles;
                        }

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
                        
                        // Check if JSON files exist (including numbered variants)
                        $templateId = $template['id'] ?? '';
                        $jsonFiles = findJsonFiles($jsonDir, $templateId);
                        if (!empty($jsonFiles)) {
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
                            
                            // Check if JSON files exist (including numbered variants)
                            $jsonFiles = findJsonFiles($jsonDir, $id);
                            $hasJsonFiles = !empty($jsonFiles);
                            
                            // Truncate description for display
                            $shortDescription = strlen($description) > 150 ? substr($description, 0, 150) . '...' : $description;
                            
                            echo '<tr class="hover:bg-gray-50 template-row" data-creator="' . strtolower($creator) . '" data-search="' . strtolower($name . ' ' . $title . ' ' . $description . ' ' . $creator . ' ' . $category) . '" data-category="' . strtolower($category) . '" data-template="' . strtolower($name) . '" data-date="' . htmlspecialchars($formattedDate) . '" data-download="' . ($hasJsonFiles ? '1' : '0') . '" data-view="' . ($hasJsonFiles ? '1' : '0') . '">';
                            
                            // Category column
                            echo '<td class="px-6 py-4 text-center">';
                            if (!empty($category)) {
                                echo '<div class="inline-flex md:items-center px-2 py-1 rounded-full text-xs font-medium md:bg-blue-100 md:text-blue-800 w-fit md:text-center">' . $category . '</div>';
                            } else {
                                echo '<span class="text-xs text-gray-400">No category</span>';
                            }
                            echo '</td>';
                            
                            // Template column
                            echo '<td class="px-6 py-4">';
                            echo '<div class="flex flex-col cursor-pointer hover:bg-blue-50 p-2 rounded-lg transition-colors" onclick="viewTemplateDetails(\'' . htmlspecialchars(addslashes($id)) . '\')">';
                            echo '<div class="text-sm font-medium text-gray-900 hover:text-blue-600">' . $name . '</div>';
                            if (!empty($title) && $title !== $name) {
                                echo '<div class="text-sm text-gray-700 font-medium mt-1">' . $title . '</div>';
                            }
                            if (!empty($shortDescription)) {
                                echo '<div class="text-xs text-gray-500 mt-2 hidden md:block">' . $shortDescription . '</div>';
                            }
                            echo '<div class="text-xs text-blue-500 mt-1 opacity-0 hover:opacity-100 transition-opacity">';
                            echo '<i class="fas fa-eye mr-1"></i>Click to view details';
                            echo '</div>';
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
                            if ($hasJsonFiles) {
                                if (count($jsonFiles) == 1) {
                                    // Single file
                                    echo '<a href="' . htmlspecialchars($jsonFiles[0]) . '" download class="inline-flex items-center px-3 py-1 bg-green-100 text-green-800 text-xs font-medium rounded-full hover:bg-green-200 transition-colors">';
                                    echo '<i class="fas fa-download mr-1"></i> JSON';
                                    echo '</a>';
                                } else {
                                    // Multiple files - show dropdown
                                    echo '<div class="relative inline-block text-left">';
                                    echo '<button onclick="toggleDropdown(\'download-' . htmlspecialchars($id) . '\')" class="inline-flex items-center px-3 py-1 bg-green-100 text-green-800 text-xs font-medium rounded-full hover:bg-green-200 transition-colors">';
                                    echo '<i class="fas fa-download mr-1"></i> JSON (' . count($jsonFiles) . ')';
                                    echo '<i class="fas fa-chevron-down ml-1"></i>';
                                    echo '</button>';
                                    echo '<div id="download-' . htmlspecialchars($id) . '" class="hidden absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg ring-1 ring-black ring-opacity-5 z-10">';
                                    echo '<div class="py-1">';
                                    foreach ($jsonFiles as $index => $jsonFile) {
                                        $filename = basename($jsonFile);
                                        $label = str_replace($id, '', str_replace('.json', '', $filename));
                                        if (empty($label)) {
                                            $label = 'Main';
                                        } else {
                                            $label = 'Part ' . ltrim($label, '_');
                                        }
                                        echo '<a href="' . htmlspecialchars($jsonFile) . '" download class="block px-4 py-2 text-xs text-gray-700 hover:bg-gray-100">';
                                        echo '<i class="fas fa-download mr-2"></i>' . htmlspecialchars($label);
                                        echo '</a>';
                                    }
                                    echo '</div>';
                                    echo '</div>';
                                    echo '</div>';
                                }
                            } else {
                                echo '<span class="inline-flex items-center px-3 py-1 bg-gray-100 text-gray-500 text-xs font-medium rounded-full">';
                                echo '<i class="fas fa-times mr-1"></i> N/A';
                                echo '</span>';
                            }
                            echo '</td>';
                            
                            // View column
                            echo '<td class="px-6 py-4 text-center">';
                            if ($hasJsonFiles) {
                                if (count($jsonFiles) == 1) {
                                    // Single file
                                    echo '<button onclick="viewJson(\'' . htmlspecialchars($jsonFiles[0]) . '\', \'' . htmlspecialchars(addslashes($name)) . '\')" class="inline-flex items-center px-3 py-1 bg-blue-100 text-blue-800 text-xs font-medium rounded-full hover:bg-blue-200 transition-colors">';
                                    echo '<i class="fas fa-eye mr-1"></i> View';
                                    echo '</button>';
                                } else {
                                    // Multiple files - show dropdown
                                    echo '<div class="relative inline-block text-left">';
                                    echo '<button onclick="toggleDropdown(\'view-' . htmlspecialchars($id) . '\')" class="inline-flex items-center px-3 py-1 bg-blue-100 text-blue-800 text-xs font-medium rounded-full hover:bg-blue-200 transition-colors">';
                                    echo '<i class="fas fa-eye mr-1"></i> View (' . count($jsonFiles) . ')';
                                    echo '<i class="fas fa-chevron-down ml-1"></i>';
                                    echo '</button>';
                                    echo '<div id="view-' . htmlspecialchars($id) . '" class="hidden absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg ring-1 ring-black ring-opacity-5 z-10">';
                                    echo '<div class="py-1">';
                                    foreach ($jsonFiles as $index => $jsonFile) {
                                        $filename = basename($jsonFile);
                                        $label = str_replace($id, '', str_replace('.json', '', $filename));
                                        if (empty($label)) {
                                            $label = 'Main';
                                        } else {
                                            $label = 'Part ' . ltrim($label, '_');
                                        }
                                        echo '<button onclick="viewJson(\'' . htmlspecialchars($jsonFile) . '\', \'' . htmlspecialchars(addslashes($name . ' - ' . $label)) . '\')" class="block w-full text-left px-4 py-2 text-xs text-gray-700 hover:bg-gray-100">';
                                        echo '<i class="fas fa-eye mr-2"></i>' . htmlspecialchars($label);
                                        echo '</button>';
                                    }
                                    echo '</div>';
                                    echo '</div>';
                                    echo '</div>';
                                }
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

    <!-- Template Details Modal -->
    <div id="templateModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden z-50 modal-backdrop">
        <div class="flex items-center justify-center min-h-screen p-4" onclick="closeTemplateModal()">
            <div class="bg-white rounded-lg shadow-xl max-w-4xl w-full max-h-[90vh] overflow-hidden" onclick="event.stopPropagation()">
                <!-- Modal Header -->
                <div class="bg-gradient-to-r from-green-600 to-blue-600 text-white p-4 flex justify-between items-center">
                    <h3 class="text-lg font-semibold flex items-center">
                        <i class="fas fa-info-circle mr-2"></i>
                        <span id="templateModalTitle">Template Details</span>
                    </h3>
                    <button onclick="closeTemplateModal()" class="text-white hover:text-gray-200 transition-colors">
                        <i class="fas fa-times text-xl"></i>
                    </button>
                </div>
                
                <!-- Modal Body -->
                <div class="p-6 overflow-auto max-h-[calc(90vh-140px)]">
                    <div id="templateDetailsContent">
                        <!-- Content will be populated by JavaScript -->
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Template data for modal display
        const templateData = {
            <?php
            foreach ($templates as $index => $template) {
                $templateId = $template['id'] ?? '';
                if (!empty($templateId)) {
                    echo '"' . htmlspecialchars($templateId) . '": {';
                    echo '"name": "' . htmlspecialchars($template['name'] ?? '') . '",';
                    echo '"title": "' . htmlspecialchars($template['title'] ?? '') . '",';
                    echo '"description": "' . htmlspecialchars($template['description'] ?? '') . '",';
                    echo '"creator": "' . htmlspecialchars($template['creator'] ?? '') . '",';
                    echo '"category": "' . htmlspecialchars($template['category'] ?? '') . '",';
                    echo '"youtube_url": "' . htmlspecialchars($template['youtube_url'] ?? '') . '",';
                    echo '"template_url": "' . htmlspecialchars($template['template_url'] ?? '') . '",';
                    echo '"resource_url": "' . htmlspecialchars($template['resource_url'] ?? '') . '",';
                    echo '"date_posted": "' . htmlspecialchars($template['date_posted'] ?? '') . '",';
                    echo '"id": "' . htmlspecialchars($templateId) . '"';
                    echo '}';
                    if ($index < count($templates) - 1) echo ',';
                }
            }
            ?>
        };

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
            if (e.key === 'Escape' && !$('#templateModal').hasClass('hidden')) {
                closeTemplateModal();
            }
        });
        
        // Dropdown toggle function for multiple JSON files
        function toggleDropdown(dropdownId) {
            const dropdown = document.getElementById(dropdownId);
            const isHidden = dropdown.classList.contains('hidden');
            
            // Close all other dropdowns first
            document.querySelectorAll('[id^="download-"], [id^="view-"]').forEach(d => {
                if (d.id !== dropdownId) {
                    d.classList.add('hidden');
                }
            });
            
            // Toggle current dropdown
            if (isHidden) {
                dropdown.classList.remove('hidden');
            } else {
                dropdown.classList.add('hidden');
            }
        }
        
        // Close dropdowns when clicking outside
        $(document).on('click', function(e) {
            if (!$(e.target).closest('.relative').length) {
                $('[id^="download-"], [id^="view-"]').addClass('hidden');
            }
        });

        // Template Details Modal Functions
        function viewTemplateDetails(templateId) {
            const template = templateData[templateId];
            if (!template) {
                alert('Template data not found');
                return;
            }

            const modal = $('#templateModal');
            const modalTitle = $('#templateModalTitle');
            const detailsContent = $('#templateDetailsContent');

            // Set modal title
            modalTitle.text(template.name || 'Template Details');

            // Format date
            let formattedDate = 'Not specified';
            if (template.date_posted) {
                const date = new Date(template.date_posted);
                if (!isNaN(date.getTime())) {
                    formattedDate = date.toLocaleDateString('en-US', { 
                        year: 'numeric', 
                        month: 'long', 
                        day: 'numeric' 
                    });
                }
            }

            // Build the content HTML
            let contentHtml = `
                <div class="space-y-6">
                    <!-- Template Header -->
                    <div class="border-b pb-4">
                        <h2 class="text-2xl font-bold text-gray-900 mb-2">${template.name || 'Unnamed Template'}</h2>
                        ${template.title && template.title !== template.name ? 
                            `<h3 class="text-lg font-semibold text-gray-700 mb-3">${template.title}</h3>` : ''}
                        <div class="flex flex-wrap gap-4 text-sm text-gray-600">
                            <div class="flex items-center">
                                <i class="fas fa-user mr-2 text-blue-500"></i>
                                <span><strong>Creator:</strong> ${template.creator || 'Unknown'}</span>
                            </div>
                            <div class="flex items-center">
                                <i class="fas fa-tag mr-2 text-green-500"></i>
                                <span><strong>Category:</strong> ${template.category || 'Uncategorized'}</span>
                            </div>
                            <div class="flex items-center">
                                <i class="fas fa-calendar mr-2 text-purple-500"></i>
                                <span><strong>Date:</strong> ${formattedDate}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Description -->
                    ${template.description ? `
                        <div>
                            <h4 class="text-lg font-semibold text-gray-800 mb-3 flex items-center">
                                <i class="fas fa-file-text mr-2 text-blue-500"></i>
                                Description
                            </h4>
                            <div class="bg-gray-50 rounded-lg p-4 border">
                                <p class="text-gray-700 leading-relaxed whitespace-pre-wrap">${template.description}</p>
                            </div>
                        </div>
                    ` : ''}

                    <!-- Links -->
                    <div>
                        <h4 class="text-lg font-semibold text-gray-800 mb-3 flex items-center">
                            <i class="fas fa-link mr-2 text-blue-500"></i>
                            Related Links
                        </h4>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            ${template.youtube_url ? `
                                <a href="${template.youtube_url}" target="_blank" 
                                   class="flex items-center p-3 bg-red-50 border border-red-200 rounded-lg hover:bg-red-100 transition-colors">
                                    <i class="fab fa-youtube text-red-600 mr-3 text-xl"></i>
                                    <div>
                                        <div class="font-medium text-red-800">YouTube Video</div>
                                        <div class="text-xs text-red-600">Watch tutorial</div>
                                    </div>
                                </a>
                            ` : ''}
                            ${template.template_url ? `
                                <a href="${template.template_url}" target="_blank" 
                                   class="flex items-center p-3 bg-blue-50 border border-blue-200 rounded-lg hover:bg-blue-100 transition-colors">
                                    <i class="fas fa-download text-blue-600 mr-3 text-xl"></i>
                                    <div>
                                        <div class="font-medium text-blue-800">Download Template</div>
                                        <div class="text-xs text-blue-600">Google Drive</div>
                                    </div>
                                </a>
                            ` : ''}
                            ${template.resource_url ? `
                                <a href="${template.resource_url}" target="_blank" 
                                   class="flex items-center p-3 bg-green-50 border border-green-200 rounded-lg hover:bg-green-100 transition-colors">
                                    <i class="fas fa-external-link-alt text-green-600 mr-3 text-xl"></i>
                                    <div>
                                        <div class="font-medium text-green-800">Additional Resource</div>
                                        <div class="text-xs text-green-600">Learn more</div>
                                    </div>
                                </a>
                            ` : ''}
                        </div>
                        ${!template.youtube_url && !template.template_url && !template.resource_url ? 
                            '<p class="text-gray-500 italic">No external links available</p>' : ''}
                    </div>

                    <!-- Template ID -->
                    <div class="pt-4 border-t">
                        <div class="flex items-center text-sm text-gray-500">
                            <i class="fas fa-hashtag mr-2"></i>
                            <span><strong>Template ID:</strong> ${template.id}</span>
                        </div>
                    </div>
                </div>
            `;

            detailsContent.html(contentHtml);
            modal.removeClass('hidden');
        }

        function closeTemplateModal() {
            $('#templateModal').addClass('hidden');
        }

        // Close template modal when clicking outside
        $(document).on('click', '#templateModal', function(e) {
            if (e.target === this) {
                closeTemplateModal();
            }
        });

        // Also handle clicks on the template modal backdrop wrapper
        $(document).on('click', '#templateModal .modal-backdrop', function(e) {
            if (e.target === this) {
                closeTemplateModal();
            }
        });
    </script>
<?php endif; ?>
</body>
</html>
