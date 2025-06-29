<?php
// PHP version 8.4.7
session_start();

// Suppress deprecation warnings
error_reporting(E_ALL & ~E_DEPRECATED & ~E_STRICT);

// Function to parse markdown content
function parseMarkdown($content) {
    // Normalize line endings
    $content = str_replace("\r\n", "\n", $content);
    $content = str_replace("\r", "\n", $content);
    
    // Convert code blocks first (before other processing)
    $content = preg_replace('/```(\w+)?\s*\n(.*?)\n```/s', '<pre class="bg-gray-800 text-green-400 p-4 rounded-lg mb-6 overflow-x-auto font-mono text-sm"><code>$2</code></pre>', $content);
    
    // Convert headers
    $content = preg_replace('/^# (.+)$/m', '<h1 class="text-3xl font-bold text-gray-800 mb-6 mt-8 first:mt-0">$1</h1>', $content);
    $content = preg_replace('/^## (.+)$/m', '<h2 class="text-2xl font-semibold text-gray-700 mb-4 mt-8 border-b border-gray-200 pb-2">$1</h2>', $content);
    $content = preg_replace('/^### (.+)$/m', '<h3 class="text-xl font-medium text-gray-600 mb-3 mt-6">$1</h3>', $content);
    
    // Convert numbered lists
    $content = preg_replace('/^\d+\.\s+(.+)$/m', '<div class="mb-3"><span class="inline-flex items-center justify-center w-6 h-6 bg-purple-600 text-white text-sm font-semibold rounded-full mr-2">$0</span><strong class="text-gray-800">$1</strong></div>', $content);
    $content = preg_replace('/<span class="inline-flex items-center justify-center w-6 h-6 bg-purple-600 text-white text-sm font-semibold rounded-full mr-2">(\d+)\.\s+(.+)<\/span><strong class="text-gray-800">\2<\/strong>/', '<span class="inline-flex items-center justify-center w-6 h-6 bg-purple-600 text-white text-sm font-semibold rounded-full mr-2">$1</span><strong class="text-gray-800">$2</strong>', $content);
    
    // Convert bold text
    $content = preg_replace('/\*\*([^*]+)\*\*/', '<strong class="font-semibold text-gray-800">$1</strong>', $content);
    
    // Convert inline code
    $content = preg_replace('/`([^`]+)`/', '<code class="bg-gray-100 px-2 py-1 rounded text-sm font-mono text-purple-700">$1</code>', $content);
    
    // Convert links
    $content = preg_replace('/\[([^\]]+)\]\(([^)]+)\)/', '<a href="$2" class="text-blue-600 hover:text-blue-800 underline font-medium" target="_blank">$1</a>', $content);
    
    // Split content into blocks by double newlines
    $blocks = preg_split('/\n\s*\n/', $content);
    $processedBlocks = [];
    
    foreach ($blocks as $block) {
        $block = trim($block);
        if (empty($block)) continue;
        
        // Skip if it's already HTML (headers, code blocks, etc.)
        if (preg_match('/^<(h[1-6]|pre|div)/', $block)) {
            $processedBlocks[] = $block;
        } else {
            // Convert remaining newlines to <br> and wrap in paragraph
            $block = str_replace("\n", '<br>', $block);
            if (!empty($block)) {
                $processedBlocks[] = '<p class="mb-4 text-gray-700 leading-relaxed">' . $block . '</p>';
            }
        }
    }
    
    return implode("\n\n", $processedBlocks);
}

// Read README.md content
$readmeContent = '';
if (file_exists('README.md')) {
    $readmeContent = file_get_contents('README.md');
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>zie619 Community Workflows - Setup</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-50">

    <div class="min-h-screen">
        <!-- Header -->
        <div class="bg-gradient-to-r from-purple-600 to-pink-600 text-white">
            <div class="container mx-auto px-4 py-8">
                <div class="text-center">
                    <h1 class="text-4xl md:text-5xl font-bold flex items-center justify-center mb-4">
                        <i class="fas fa-database mr-4"></i>
                        zie619 Community Workflows
                    </h1>
                    <p class="text-xl text-purple-100 mb-4">Setup Instructions for Community Collection</p>
                    <div class="text-sm text-purple-200">
                        <p>Part of the <a href="../" class="text-white hover:text-purple-100 underline">n8n Templates Portal</a></p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="container mx-auto px-4 py-12 max-w-4xl">
            <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                
                <!-- Content Section -->
                <div class="p-8">
                    <?php if ($readmeContent): ?>
                        <div class="prose prose-lg max-w-none">
                            <?php echo parseMarkdown($readmeContent); ?>
                        </div>
                    <?php else: ?>
                        <div class="text-center py-12">
                            <i class="fas fa-exclamation-triangle text-4xl text-yellow-500 mb-4"></i>
                            <h2 class="text-2xl font-bold text-gray-800 mb-2">README.md not found</h2>
                            <p class="text-gray-600">Could not load the setup instructions.</p>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- Action Buttons -->
                <div class="bg-gray-50 px-8 py-6 border-t">
                    <div class="flex flex-col sm:flex-row gap-4 justify-between items-center">
                        <a href="../" 
                           class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-purple-600 to-pink-600 text-white font-medium rounded-lg hover:from-purple-700 hover:to-pink-700 transition-all duration-200 transform hover:scale-105">
                            <i class="fas fa-arrow-left mr-2"></i>
                            Back to Portal
                        </a>
                        
                        <div class="flex gap-3">
                            <a href="https://github.com/Zie619/n8n-workflows" 
                               target="_blank"
                               class="inline-flex items-center px-4 py-2 bg-gray-600 text-white font-medium rounded-lg hover:bg-gray-700 transition-colors">
                                <i class="fab fa-github mr-2"></i>
                                GitHub Repository
                            </a>
                            
                            <button onclick="window.location.reload();" 
                                    class="inline-flex items-center px-4 py-2 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700 transition-colors">
                                <i class="fas fa-refresh mr-2"></i>
                                Refresh
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Additional Info Card -->
            <div class="mt-8 bg-blue-50 border border-blue-200 rounded-lg p-6">
                <div class="flex items-start">
                    <i class="fas fa-info-circle text-blue-600 text-xl mr-3 mt-1"></i>
                    <div>
                        <h3 class="font-semibold text-blue-800 mb-2">About This Collection</h3>
                        <p class="text-blue-700 text-sm leading-relaxed">
                            This is a placeholder page for zie619's community workflow collection. 
                            Once you complete the setup instructions above and configure your reverse proxy, 
                            this portal will seamlessly connect to zie619's browsable interface featuring 
                            over 2,000 organized n8n workflows.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            // Add some interactive effects
            $('a[href^="http"]').each(function() {
                $(this).addClass('transition-colors duration-200');
            });
            
            // Smooth scroll for internal links
            $('a[href^="#"]').on('click', function(e) {
                e.preventDefault();
                var target = $(this.getAttribute('href'));
                if (target.length) {
                    $('html, body').animate({
                        scrollTop: target.offset().top - 80
                    }, 500);
                }
            });
        });
    </script>

</body>
</html>
