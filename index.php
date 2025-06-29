<?php
// PHP version 8.4.7
session_start();

// Suppress deprecation warnings
error_reporting(E_ALL & ~E_DEPRECATED & ~E_STRICT);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>n8n Templates Portal</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-50">

    <div class="min-h-screen">
        <!-- Header -->
        <div class="bg-gradient-to-r from-blue-600 to-purple-600 text-white">
            <div class="container mx-auto px-4 py-12">
                <div class="text-center">
                    <h1 class="text-4xl md:text-6xl font-bold flex items-center justify-center mb-4">
                        <i class="fas fa-cogs mr-4"></i>
                        n8n Templates Portal
                    </h1>
                    <p class="text-xl md:text-2xl text-blue-100 mb-6">Your Gateway to Automation Excellence</p>
                    <div class="max-w-3xl mx-auto text-blue-200 text-sm md:text-base leading-relaxed">
                        <p>Discover, browse, and download comprehensive n8n workflow templates from three expertly curated collections. Whether you're looking for official third-party integrations, battle-tested templates from n8n YouTubers and influencers, or community organized workflow archives, we've got you covered.</p>
                    </div>
                    <div class="mt-6 text-xs text-blue-200">
                        <p>Curated by <a href="https://www.linkedin.com/in/weng-fung/" target="_blank" class="text-white hover:text-blue-100 underline">Weng Fei Fung</a></p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="container mx-auto px-4 py-12">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 max-w-7xl mx-auto">
                
                <!-- n8n Partners Section -->
                <div class="bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition-shadow duration-300 transform hover:scale-[1.02]">
                    <div class="bg-gradient-to-r from-green-600 to-blue-600 text-white p-6">
                        <div class="flex items-center mb-4">
                            <i class="fas fa-handshake text-3xl mr-4"></i>
                            <div>
                                <h2 class="text-2xl font-bold">n8n Integration Partner Workflows</h2>
                                <p class="text-green-100 text-sm">Official Workflows supporting integration</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="p-6">
                        <div class="space-y-4">
                            <div class="flex items-start">
                                <i class="fas fa-plug text-green-600 mr-3 mt-1"></i>
                                <div>
                                    <h3 class="font-semibold text-gray-800">Third-Party Integrations</h3>
                                    <p class="text-gray-600 text-sm">Explore workflows showcasing integrations with external platforms and APIs</p>
                                </div>
                            </div>
                            
                            <div class="flex items-start">
                                <i class="fas fa-search text-blue-600 mr-3 mt-1"></i>
                                <div>
                                    <h3 class="font-semibold text-gray-800">Find Specific Integrations</h3>
                                    <p class="text-gray-600 text-sm">Quickly locate workflows for particular third-party services</p>
                                </div>
                            </div>
                            
                            <div class="flex items-start">
                                <i class="fas fa-compass text-purple-600 mr-3 mt-1"></i>
                                <div>
                                    <h3 class="font-semibold text-gray-800">Discover New Integrations</h3>
                                    <p class="text-gray-600 text-sm">Browse n8n's comprehensive collection of integration examples</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="mt-6 pt-4 border-t border-gray-200">
                            <div class="flex items-center justify-between">
                                <div class="text-sm text-gray-500">
                                    <i class="fas fa-info-circle mr-1"></i>
                                    Official n8n test workflows supporting integration
                                </div>
                                <a href="n8n-partners/" 
                                   class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-green-600 to-blue-600 text-white font-medium rounded-lg hover:from-green-700 hover:to-blue-700 transition-all duration-200 transform hover:scale-105">
                                    <i class="fas fa-arrow-right mr-2"></i>
                                    Browse Partners
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Oleg Browser Section -->
                <div class="bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition-shadow duration-300 transform hover:scale-[1.02]">
                    <div class="bg-gradient-to-r from-blue-600 to-purple-600 text-white p-6">
                        <div class="flex items-center mb-4">
                            <i class="fas fa-video text-3xl mr-4"></i>
                            <div>
                                <h2 class="text-2xl font-bold">Oleg's Workflows with Explanations</h2>
                                <p class="text-blue-100 text-sm">YouTubers & Influencers Templates</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="p-6">
                        <div class="space-y-4">
                            <div class="flex items-start">
                                <i class="fas fa-download text-blue-600 mr-3 mt-1"></i>
                                <div>
                                    <h3 class="font-semibold text-gray-800">Direct Downloads</h3>
                                    <p class="text-gray-600 text-sm">Download 150+ battle-tested JSON workflows from n8n content creators</p>
                                </div>
                            </div>
                            
                            <div class="flex items-start">
                                <i class="fas fa-search text-purple-600 mr-3 mt-1"></i>
                                <div>
                                    <h3 class="font-semibold text-gray-800">Advanced Search & Filtering</h3>
                                    <p class="text-gray-600 text-sm">Find templates by creator, category, or specific automation use case</p>
                                </div>
                            </div>
                            
                            <div class="flex items-start">
                                <i class="fas fa-play-circle text-green-600 mr-3 mt-1"></i>
                                <div>
                                    <h3 class="font-semibold text-gray-800">Video Tutorials Included</h3>
                                    <p class="text-gray-600 text-sm">Most templates include YouTube tutorials from their creators</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="mt-6 pt-4 border-t border-gray-200">
                            <div class="flex items-center justify-between">
                                <div class="text-sm text-gray-500">
                                    <i class="fas fa-info-circle mr-1"></i>
                                    Curated from n8n YouTubers & Influencers
                                </div>
                                <a href="oleg-browser/" 
                                   class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-blue-600 to-purple-600 text-white font-medium rounded-lg hover:from-blue-700 hover:to-purple-700 transition-all duration-200 transform hover:scale-105">
                                    <i class="fas fa-arrow-right mr-2"></i>
                                    Browse Templates
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- zie619 Browser Section -->
                <div class="bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition-shadow duration-300 transform hover:scale-[1.02]">
                    <div class="bg-gradient-to-r from-purple-600 to-pink-600 text-white p-6">
                        <div class="flex items-center mb-4">
                            <i class="fas fa-database text-3xl mr-4"></i>
                            <div>
                                <h2 class="text-2xl font-bold">zie619's Community Collection</h2>
                                <p class="text-purple-100 text-sm">Massive Workflows Archive</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="p-6">
                        <div class="space-y-4">
                            <div class="flex items-start">
                                <i class="fas fa-archive text-purple-600 mr-3 mt-1"></i>
                                <div>
                                    <h3 class="font-semibold text-gray-800">Massive Collection</h3>
                                    <p class="text-gray-600 text-sm">2,000+ organized n8n workflows in one place</p>
                                </div>
                            </div>
                            
                            <div class="flex items-start">
                                <i class="fas fa-download text-pink-600 mr-3 mt-1"></i>
                                <div>
                                    <h3 class="font-semibold text-gray-800">Direct Downloads</h3>
                                    <p class="text-gray-600 text-sm">Download workflow JSON files directly from the organized archive</p>
                                </div>
                            </div>
                            
                            <div class="flex items-start">
                                <i class="fas fa-project-diagram text-indigo-600 mr-3 mt-1"></i>
                                <div>
                                    <h3 class="font-semibold text-gray-800">Visual Flow Diagrams</h3>
                                    <p class="text-gray-600 text-sm">Preview workflow structures with interactive Mermaid diagrams in your browser</p>
                                </div>
                            </div>
                            <div style="height: 20px;"></div>
                        </div>
                        
                        <div class="mt-6 pt-4 border-t border-gray-200">
                            <div class="flex items-center justify-between">
                                <div class="text-sm text-gray-500">
                                    <i class="fas fa-info-circle mr-1"></i>
                                    Developed by zie619 and the community
                                </div>
                                <a href="zie619-community/" 
                                   class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-purple-600 to-pink-600 text-white font-medium rounded-lg hover:from-purple-700 hover:to-pink-700 transition-all duration-200 transform hover:scale-105">
                                    <i class="fas fa-arrow-right mr-2"></i>
                                    Browse Archive
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Stats Section -->
            <div class="mt-12 bg-white rounded-lg shadow-lg overflow-hidden">
                <div class="bg-gradient-to-r from-gray-600 to-gray-800 text-white p-6 text-center">
                    <h3 class="text-2xl font-bold mb-2">Triple Collection Overview</h3>
                    <p class="text-gray-200">Three comprehensive resources for n8n automation mastery</p>
                </div>
                
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                        <div class="text-center p-4 bg-gradient-to-br from-green-50 to-blue-50 rounded-lg border border-green-200">
                            <div class="text-3xl font-bold text-green-600 mb-2">
                                <i class="fas fa-handshake"></i>
                            </div>
                            <div class="text-lg font-semibold text-gray-800">Official Partners</div>
                            <div class="text-sm text-gray-600">Third-party integrations from n8n's official test workflows</div>
                        </div>
                        
                        <div class="text-center p-4 bg-gradient-to-br from-blue-50 to-purple-50 rounded-lg border border-blue-200">
                            <div class="text-3xl font-bold text-blue-600 mb-2">
                                <i class="fas fa-video"></i>
                            </div>
                            <div class="text-lg font-semibold text-gray-800">YouTuber Collection</div>
                            <div class="text-sm text-gray-600">Battle-tested templates from n8n content creators and influencers</div>
                        </div>
                        
                        <div class="text-center p-4 bg-gradient-to-br from-purple-50 to-pink-50 rounded-lg border border-purple-200">
                            <div class="text-3xl font-bold text-purple-600 mb-2">
                                <i class="fas fa-database"></i>
                            </div>
                            <div class="text-lg font-semibold text-gray-800">Community Archive</div>
                            <div class="text-sm text-gray-600">2,000+ systematically organized workflows by zie619</div>
                        </div>
                        
                        <div class="text-center p-4 bg-gradient-to-br from-indigo-50 to-cyan-50 rounded-lg border border-indigo-200">
                            <div class="text-3xl font-bold text-indigo-600 mb-2">
                                <i class="fas fa-robot"></i>
                            </div>
                            <div class="text-lg font-semibold text-gray-800">AI-Powered Help</div>
                            <div class="text-sm text-gray-600">
                                Get recommendations at 
                                <a href="https://olegfuns.app.n8n.cloud/webhook/cda21b26-b940-4b60-8afa-fd7b8281a96b/chat" 
                                   target="_blank" 
                                   class="text-indigo-600 hover:text-indigo-800 underline">Oleg's AI Chat</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Footer -->
            <div class="mt-12 text-center text-gray-600">
                <div class="flex justify-center items-center space-x-6 mb-4">
                    <a href="https://github.com/Siphon880gh" target="_blank" class="hover:text-blue-600 transition-colors">
                        <i class="fab fa-github text-xl mr-1"></i>
                        GitHub
                    </a>
                    <a href="https://www.linkedin.com/in/weng-fung/" target="_blank" class="hover:text-blue-600 transition-colors">
                        <i class="fab fa-linkedin text-xl mr-1"></i>
                        LinkedIn
                    </a>
                    <a href="https://www.youtube.com/@WayneTeachesCode/" target="_blank" class="hover:text-red-600 transition-colors">
                        <i class="fab fa-youtube text-xl mr-1"></i>
                        YouTube
                    </a>
                </div>
                <p class="text-sm">Made with ❤️ by Weng Fei Fung</p>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            // Add smooth scrolling to anchor links
            $('a[href^="#"]').on('click', function(event) {
                var target = $(this.getAttribute('href'));
                if( target.length ) {
                    event.preventDefault();
                    $('html, body').stop().animate({
                        scrollTop: target.offset().top - 80
                    }, 800);
                }
            });

            // Add hover effects to cards
            $('.hover\\:shadow-xl').hover(
                function() {
                    $(this).addClass('shadow-2xl');
                },
                function() {
                    $(this).removeClass('shadow-2xl');
                }
            );

            // Add loading state to buttons
            $('a[href*="/"]').on('click', function() {
                const $btn = $(this);
                const originalHtml = $btn.html();
                
                $btn.html('<i class="fas fa-spinner fa-spin mr-2"></i>Loading...');
                
                // Reset after 3 seconds in case of navigation issues
                setTimeout(function() {
                    $btn.html(originalHtml);
                }, 3000);
            });
        });
    </script>
</body>
</html>
