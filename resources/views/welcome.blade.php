<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ config('app.name', 'Laravel') }} - Members Management API</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

        <!-- Styles / Scripts -->
        @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
            @vite(['resources/css/app.css', 'resources/js/app.js'])
        @else
            <style>
                /*! tailwindcss v4.0.7 | MIT License | https://tailwindcss.com */
                /* Your existing CSS styles here - keeping them for brevity */
                /* ... existing CSS ... */
                
                /* Additional custom styles */
                .api-endpoint {
                    transition: all 0.3s ease;
                }
                .api-endpoint:hover {
                    transform: translateY(-2px);
                }
                .response-area {
                    font-family: 'Courier New', monospace;
                    white-space: pre-wrap;
                    word-break: break-all;
                }
                .loading {
                    opacity: 0.7;
                    pointer-events: none;
                }
                .status-success {
                    border-left: 4px solid #10b981;
                }
                .status-error {
                    border-left: 4px solid #ef4444;
                }
                .fade-in {
                    animation: fadeIn 0.5s ease-in;
                }
                @keyframes fadeIn {
                    from { opacity: 0; transform: translateY(10px); }
                    to { opacity: 1; transform: translateY(0); }
                }
            </style>
        @endif
    </head>
    <body class="bg-gray-50 dark:bg-gray-900 min-h-screen">
        <div class="container mx-auto px-4 py-8">
            <!-- Header -->
            <div class="text-center mb-12 fade-in">
                <h1 class="text-4xl font-bold text-gray-900 dark:text-white mb-4">
                    Members Management API
                </h1>
                <p class="text-xl text-gray-600 dark:text-gray-300 mb-2">
                    Backend API for <span class="font-semibold text-blue-600">Protec Damayan Web App</span>
                </p>
                <p class="text-gray-500 dark:text-gray-400">
                    Comprehensive member management system with analytics and filtering capabilities
                </p>
            </div>

            <!-- API Base URL -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6 mb-8 fade-in">
                <h2 class="text-2xl font-semibold text-gray-900 dark:text-white mb-4">Base URL</h2>
                <div class="bg-gray-100 dark:bg-gray-700 p-4 rounded-lg">
                    <code class="text-lg font-mono text-blue-600 dark:text-blue-400">
                        http://127.0.0.1:8000/api/members
                    </code>
                </div>
            </div>

            <!-- API Endpoints -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
                <!-- Basic CRUD Operations -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6 api-endpoint fade-in">
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">Basic CRUD Operations</h3>
                    
                    <div class="space-y-4">
                        <!-- GET All Members -->
                        <div class="border border-gray-200 dark:border-gray-600 rounded-lg p-4">
                            <div class="flex items-center justify-between mb-2">
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">
                                    GET
                                </span>
                                <code class="text-sm font-mono text-gray-700 dark:text-gray-300">
                                    /api/members
                                </code>
                            </div>
                            <p class="text-gray-600 dark:text-gray-400 text-sm mb-3">
                                Retrieve all members
                            </p>
                            <button onclick="testEndpoint('GET', '/api/members')" 
                                    class="w-full bg-green-600 hover:bg-green-700 text-white py-2 px-4 rounded-lg transition-colors duration-200">
                                Test Endpoint
                            </button>
                        </div>

                        <!-- GET Single Member -->
                        <div class="border border-gray-200 dark:border-gray-600 rounded-lg p-4">
                            <div class="flex items-center justify-between mb-2">
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">
                                    GET
                                </span>
                                <code class="text-sm font-mono text-gray-700 dark:text-gray-300">
                                    /api/members/{id}
                                </code>
                            </div>
                            <p class="text-gray-600 dark:text-gray-400 text-sm mb-3">
                                Retrieve specific member by ID
                            </p>
                            <div class="flex space-x-2 mb-3">
                                <input type="number" id="memberId" placeholder="Enter member ID" 
                                       class="flex-1 border border-gray-300 dark:border-gray-600 rounded-lg px-3 py-2 text-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                            </div>
                            <button onclick="testEndpoint('GET', `/api/members/${document.getElementById('memberId').value || 1}`)" 
                                    class="w-full bg-green-600 hover:bg-green-700 text-white py-2 px-4 rounded-lg transition-colors duration-200">
                                Test Endpoint
                            </button>
                        </div>

                        <!-- POST Create Member -->
                        <div class="border border-gray-200 dark:border-gray-600 rounded-lg p-4">
                            <div class="flex items-center justify-between mb-2">
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200">
                                    POST
                                </span>
                                <code class="text-sm font-mono text-gray-700 dark:text-gray-300">
                                    /api/members
                                </code>
                            </div>
                            <p class="text-gray-600 dark:text-gray-400 text-sm mb-3">
                                Create a new member
                            </p>
                            <button onclick="testCreateMember()" 
                                    class="w-full bg-blue-600 hover:bg-blue-700 text-white py-2 px-4 rounded-lg transition-colors duration-200">
                                Test Endpoint
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Filter Endpoints -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6 api-endpoint fade-in">
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">Filter Endpoints</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <!-- Seniors -->
                        <div class="border border-gray-200 dark:border-gray-600 rounded-lg p-4">
                            <div class="flex items-center justify-between mb-2">
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">
                                    GET
                                </span>
                                <code class="text-sm font-mono text-gray-700 dark:text-gray-300">
                                    /seniors
                                </code>
                            </div>
                            <p class="text-gray-600 dark:text-gray-400 text-sm mb-3">
                                Members aged 60+
                            </p>
                            <button onclick="testEndpoint('GET', '/api/members/seniors')" 
                                    class="w-full bg-purple-600 hover:bg-purple-700 text-white py-2 px-4 rounded-lg transition-colors duration-200 text-sm">
                                Test Endpoint
                            </button>
                        </div>

                        <!-- Minors -->
                        <div class="border border-gray-200 dark:border-gray-600 rounded-lg p-4">
                            <div class="flex items-center justify-between mb-2">
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">
                                    GET
                                </span>
                                <code class="text-sm font-mono text-gray-700 dark:text-gray-300">
                                    /minors
                                </code>
                            </div>
                            <p class="text-gray-600 dark:text-gray-400 text-sm mb-3">
                                Members under 18
                            </p>
                            <button onclick="testEndpoint('GET', '/api/members/minors')" 
                                    class="w-full bg-purple-600 hover:bg-purple-700 text-white py-2 px-4 rounded-lg transition-colors duration-200 text-sm">
                                Test Endpoint
                            </button>
                        </div>

                        <!-- Search -->
                        <div class="border border-gray-200 dark:border-gray-600 rounded-lg p-4 md:col-span-2">
                            <div class="flex items-center justify-between mb-2">
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">
                                    GET
                                </span>
                                <code class="text-sm font-mono text-gray-700 dark:text-gray-300">
                                    /search?q={query}
                                </code>
                            </div>
                            <p class="text-gray-600 dark:text-gray-400 text-sm mb-3">
                                Search members by name
                            </p>
                            <div class="flex space-x-2 mb-3">
                                <input type="text" id="searchQuery" placeholder="Enter search term" 
                                       class="flex-1 border border-gray-300 dark:border-gray-600 rounded-lg px-3 py-2 text-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                            </div>
                            <button onclick="testEndpoint('GET', `/api/members/search?q=${document.getElementById('searchQuery').value || 'john'}`)" 
                                    class="w-full bg-purple-600 hover:bg-purple-700 text-white py-2 px-4 rounded-lg transition-colors duration-200">
                                Test Endpoint
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Analytics Endpoints -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6 api-endpoint fade-in">
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">Analytics Endpoints</h3>
                    
                    <div class="space-y-4">
                        <!-- Statistics -->
                        <div class="border border-gray-200 dark:border-gray-600 rounded-lg p-4">
                            <div class="flex items-center justify-between mb-2">
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">
                                    GET
                                </span>
                                <code class="text-sm font-mono text-gray-700 dark:text-gray-300">
                                    /statistics
                                </code>
                            </div>
                            <p class="text-gray-600 dark:text-gray-400 text-sm mb-3">
                                Get comprehensive member statistics
                            </p>
                            <button onclick="testEndpoint('GET', '/api/members/statistics')" 
                                    class="w-full bg-indigo-600 hover:bg-indigo-700 text-white py-2 px-4 rounded-lg transition-colors duration-200">
                                Test Endpoint
                            </button>
                        </div>

                        <!-- Age Distribution -->
                        <div class="border border-gray-200 dark:border-gray-600 rounded-lg p-4">
                            <div class="flex items-center justify-between mb-2">
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">
                                    GET
                                </span>
                                <code class="text-sm font-mono text-gray-700 dark:text-gray-300">
                                    /age-distribution
                                </code>
                            </div>
                            <p class="text-gray-600 dark:text-gray-400 text-sm mb-3">
                                Get age group distribution
                            </p>
                            <button onclick="testEndpoint('GET', '/api/members/age-distribution')" 
                                    class="w-full bg-indigo-600 hover:bg-indigo-700 text-white py-2 px-4 rounded-lg transition-colors duration-200">
                                Test Endpoint
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Additional Filters -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6 api-endpoint fade-in">
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">Additional Filters</h3>
                    
                    <div class="grid grid-cols-1 gap-3">
                        <button onclick="testEndpoint('GET', '/api/members/active')" 
                                class="w-full bg-gray-600 hover:bg-gray-700 text-white py-2 px-4 rounded-lg transition-colors duration-200 text-sm">
                            GET /active - Active members
                        </button>
                        <button onclick="testEndpoint('GET', '/api/members/inactive')" 
                                class="w-full bg-gray-600 hover:bg-gray-700 text-white py-2 px-4 rounded-lg transition-colors duration-200 text-sm">
                            GET /inactive - Inactive members
                        </button>
                        <button onclick="testEndpoint('GET', '/api/members/male')" 
                                class="w-full bg-gray-600 hover:bg-gray-700 text-white py-2 px-4 rounded-lg transition-colors duration-200 text-sm">
                            GET /male - Male members
                        </button>
                        <button onclick="testEndpoint('GET', '/api/members/female')" 
                                class="w-full bg-gray-600 hover:bg-gray-700 text-white py-2 px-4 rounded-lg transition-colors duration-200 text-sm">
                            GET /female - Female members
                        </button>
                        <div class="flex space-x-2">
                            <input type="text" id="purokQuery" placeholder="Enter purok" 
                                   class="flex-1 border border-gray-300 dark:border-gray-600 rounded-lg px-3 py-2 text-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                            <button onclick="testEndpoint('GET', `/api/members/purok/${document.getElementById('purokQuery').value || '1'}`)" 
                                    class="bg-gray-600 hover:bg-gray-700 text-white py-2 px-4 rounded-lg transition-colors duration-200 text-sm whitespace-nowrap">
                                GET /purok/{purok}
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Response Area -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6 fade-in">
                <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">API Response</h3>
                <div class="mb-4 flex items-center space-x-4">
                    <div class="flex items-center space-x-2">
                        <div class="w-3 h-3 rounded-full bg-green-500 animate-pulse" id="statusIndicator"></div>
                        <span class="text-sm font-medium text-gray-700 dark:text-gray-300" id="statusText">Ready</span>
                    </div>
                    <div class="text-sm text-gray-500 dark:text-gray-400" id="requestUrl">
                        No request made yet
                    </div>
                </div>
                <div class="bg-gray-900 rounded-lg p-4 max-h-96 overflow-y-auto">
                    <pre id="responseArea" class="response-area text-green-400 text-sm">
                        // Response will appear here...
                    </pre>
                </div>
            </div>
        </div>

        <!-- Axios CDN -->
        <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
        
        <script>
            const baseURL = 'http://127.0.0.1:8000';
            let currentRequest = null;

            function testEndpoint(method, endpoint, data = null) {
                // Cancel previous request if it exists
                if (currentRequest) {
                    currentRequest.cancel('Request cancelled');
                }

                const CancelToken = axios.CancelToken;
                const source = CancelToken.source();
                currentRequest = source;

                // Update UI
                document.getElementById('statusText').textContent = 'Loading...';
                document.getElementById('statusIndicator').className = 'w-3 h-3 rounded-full bg-yellow-500 animate-pulse';
                document.getElementById('requestUrl').textContent = `${method} ${baseURL}${endpoint}`;
                document.getElementById('responseArea').textContent = 'Loading...';

                // Prepare request config
                const config = {
                    method: method.toLowerCase(),
                    url: baseURL + endpoint,
                    cancelToken: source.token
                };

                if (data && (method === 'POST' || method === 'PUT')) {
                    config.data = data;
                }

                // Make request
                axios(config)
                    .then(response => {
                        document.getElementById('statusText').textContent = `Success (${response.status})`;
                        document.getElementById('statusIndicator').className = 'w-3 h-3 rounded-full bg-green-500';
                        document.getElementById('responseArea').textContent = JSON.stringify(response.data, null, 2);
                    })
                    .catch(error => {
                        if (axios.isCancel(error)) {
                            document.getElementById('statusText').textContent = 'Cancelled';
                            document.getElementById('statusIndicator').className = 'w-3 h-3 rounded-full bg-gray-500';
                            document.getElementById('responseArea').textContent = 'Request was cancelled';
                        } else {
                            document.getElementById('statusText').textContent = `Error (${error.response?.status || 'Network'})`;
                            document.getElementById('statusIndicator').className = 'w-3 h-3 rounded-full bg-red-500';
                            document.getElementById('responseArea').textContent = error.response ? 
                                JSON.stringify(error.response.data, null, 2) : 
                                error.message;
                        }
                    })
                    .finally(() => {
                        currentRequest = null;
                    });
            }

            function testCreateMember() {
                const sampleData = {
                    first_name: "Juan",
                    last_name: "Dela Cruz",
                    middle_name: "Santos",
                    address: "123 Main Street, Barangay Damayan",
                    contact_number: "09123456789",
                    date_of_birth: "1990-05-15",
                    registration_date: "2024-01-15",
                    purok: "1",
                    status: "active",
                    occupation: "Farmer"
                };

                testEndpoint('POST', '/api/members', sampleData);
            }

            // Add loading states to buttons
            document.addEventListener('click', function(e) {
                if (e.target.tagName === 'BUTTON' && e.target.onclick) {
                    const button = e.target;
                    const originalText = button.textContent;
                    
                    button.classList.add('loading');
                    button.disabled = true;
                    button.textContent = 'Loading...';

                    // Reset button after request completes (with a delay to show loading state)
                    setTimeout(() => {
                        button.classList.remove('loading');
                        button.disabled = false;
                        button.textContent = originalText;
                    }, 1000);
                }
            });
        </script>
    </body>
</html>