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
    <div class="container mx-auto px-4 py-8">
        <div class="bg-white rounded-lg shadow-lg overflow-hidden">
            <!-- Header -->
            <div class="bg-gradient-to-r from-blue-600 to-purple-600 text-white p-6">
                <h1 class="text-3xl font-bold flex items-center">
                    <i class="fas fa-cogs mr-3"></i>
                    n8n Templates Library
                </h1>
                <p class="mt-2 text-blue-100">Browse and download automation templates</p>
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
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Template</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Creator</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Links</th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Download</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200" id="table-body">
                        <?php
                        $csvFile = 'n8n-templates_enriched.csv';
                        $jsonDir = 'json/';
                        $templates = [];
                        $creators = [];
                        $availableDownloads = 0;

                        if (file_exists($csvFile)) {
                            $handle = fopen($csvFile, 'r');
                            $headers = fgetcsv($handle); // Get headers
                            
                            while (($data = fgetcsv($handle)) !== FALSE) {
                                // if (count($data) >= 9) { // Ensure we have enough columns
                                    $template = array_combine($headers, $data);
                                    $templates[] = $template;
                                    
                                    // Collect unique creators for filter
                                    $creator = trim($template['creator'] ?? '');
                                    if (!empty($creator) && !in_array($creator, $creators)) {
                                        $creators[] = $creator;
                                    }
                                    
                                    // Check if JSON file exists
                                    $jsonFile = $jsonDir . ($template['id'] ?? '') . '.json';
                                    if (file_exists($jsonFile)) {
                                        $availableDownloads++;
                                    }
                                // }
                            }
                            fclose($handle);
                        }

                        sort($creators); // Sort creators alphabetically

                        foreach ($templates as $index => $template) {
                            $name = htmlspecialchars($template['name'] ?? '');
                            $title = htmlspecialchars($template['title'] ?? '');
                            $description = htmlspecialchars($template['description'] ?? '');
                            $creator = htmlspecialchars($template['creator'] ?? '');
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
                            
                            echo '<tr class="hover:bg-gray-50 template-row" data-creator="' . strtolower($creator) . '" data-search="' . strtolower($name . ' ' . $title . ' ' . $description . ' ' . $creator) . '">';
                            
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
                            if (!empty($resourceUrl)) {
                                echo '<a href="' . htmlspecialchars($resourceUrl) . '" target="_blank" class="inline-flex items-center text-blue-600 hover:text-blue-800 text-xs">';
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
            
            // Search functionality
            function filterTable() {
                const searchTerm = $('#search-input').val().toLowerCase();
                const creatorFilter = $('#creator-filter').val();
                
                $('.template-row').each(function() {
                    const $row = $(this);
                    const searchData = $row.data('search');
                    const creatorData = $row.data('creator');
                    
                    const matchesSearch = searchTerm === '' || searchData.includes(searchTerm);
                    const matchesCreator = creatorFilter === '' || creatorData === creatorFilter;
                    
                    if (matchesSearch && matchesCreator) {
                        $row.show();
                    } else {
                        $row.hide();
                    }
                });
                
                // Update visible count
                const visibleRows = $('.template-row:visible').length;
                if (searchTerm || creatorFilter) {
                    $('#total-templates').text(`${visibleRows} of ${totalTemplates}`);
                } else {
                    $('#total-templates').text(totalTemplates);
                }
            }
            
            $('#search-input').on('input', filterTable);
            $('#creator-filter').on('change', filterTable);
            
            // Clear filters
            $('#clear-filters').on('click', function() {
                $('#search-input').val('');
                $('#creator-filter').val('');
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
    </script>
</body>
</html>
