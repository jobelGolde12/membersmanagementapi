<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ config('app.name', 'Laravel') }} - Members Management API</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
        
        <!-- Styles -->
        @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
            @vite(['resources/css/app.css', 'resources/js/app.js'])
        @else
            <style>
                /* Modern CSS Reset */
                *, *::before, *::after {
                    box-sizing: border-box;
                    margin: 0;
                    padding: 0;
                }

                .main-container{
                    margin-top: 5rem;
                }
                /* Custom Properties */
                :root {
                    --primary: #6366f1;
                    --primary-dark: #4f46e5;
                    --secondary: #10b981;
                    --accent: #8b5cf6;
                    --background: #0f172a;
                    --surface: #1e293b;
                    --surface-light: #334155;
                    --text-primary: #f8fafc;
                    --text-secondary: #cbd5e1;
                    --text-muted: #94a3b8;
                    --border: #475569;
                    --success: #10b981;
                    --warning: #f59e0b;
                    --error: #ef4444;
                    --info: #3b82f6;
                    
                    /* Glassmorphism */
                    --glass-bg: rgba(255, 255, 255, 0.05);
                    --glass-border: rgba(255, 255, 255, 0.1);
                    --glass-shadow: 0 8px 32px 0 rgba(0, 0, 0, 0.36);
                    
                    /* Gradients */
                    --gradient-primary: linear-gradient(135deg, #6366f1 0%, #8b5cf6 100%);
                    --gradient-surface: linear-gradient(135deg, #1e293b 0%, #334155 100%);
                    
                    /* Spacing */
                    --space-xs: 0.5rem;
                    --space-sm: 1rem;
                    --space-md: 1.5rem;
                    --space-lg: 2rem;
                    --space-xl: 3rem;
                    
                    /* Border Radius */
                    --radius-sm: 0.5rem;
                    --radius-md: 0.75rem;
                    --radius-lg: 1rem;
                    --radius-xl: 1.5rem;
                    
                    /* Transitions */
                    --transition-fast: 0.15s ease;
                    --transition-normal: 0.3s ease;
                    --transition-slow: 0.5s ease;
                }

                /* Base Styles */
                body {
                    font-family: 'Inter', 'Instrument Sans', sans-serif;
                    background: var(--background);
                    color: var(--text-primary);
                    line-height: 1.6;
                    min-height: 100vh;
                    overflow-x: hidden;
                }

                /* Background Animation */
                body::before {
                    content: '';
                    position: fixed;
                    top: 0;
                    left: 0;
                    width: 100%;
                    height: 100%;
                    background: 
                        radial-gradient(circle at 15% 50%, rgba(99, 102, 241, 0.1) 0%, transparent 50%),
                        radial-gradient(circle at 85% 30%, rgba(139, 92, 246, 0.1) 0%, transparent 50%),
                        radial-gradient(circle at 50% 80%, rgba(16, 185, 129, 0.05) 0%, transparent 50%);
                    z-index: -1;
                }

                /* Container */
                .container {
                    max-width: 1200px;
                    margin: 0 auto;
                    padding: 0 var(--space-md);
                }

                /* Typography */
                h1, h2, h3, h4, h5, h6 {
                    font-weight: 600;
                    line-height: 1.2;
                    margin-bottom: var(--space-sm);
                }

                h1 {
                    font-size: 2.5rem;
                    background: var(--gradient-primary);
                    -webkit-background-clip: text;
                    background-clip: text;
                    -webkit-text-fill-color: transparent;
                    position: relative;
                    display: inline-block;
                }

                h1::after {
                    content: '';
                    position: absolute;
                    bottom: -5px;
                    left: 0;
                    width: 100%;
                    height: 2px;
                    background: var(--gradient-primary);
                    border-radius: 2px;
                }

                h2 {
                    font-size: 1.75rem;
                }

                h3 {
                    font-size: 1.25rem;
                }

                p {
                    margin-bottom: var(--space-sm);
                    color: var(--text-secondary);
                }

                /* Cards */
                .card {
                    background: var(--glass-bg);
                    backdrop-filter: blur(10px);
                    border: 1px solid var(--glass-border);
                    border-radius: var(--radius-lg);
                    box-shadow: var(--glass-shadow);
                    padding: var(--space-lg);
                    transition: all var(--transition-normal);
                    position: relative;
                    overflow: hidden;
                }

                .card::before {
                    content: '';
                    position: absolute;
                    top: 0;
                    left: 0;
                    width: 100%;
                    height: 100%;
                    background: var(--gradient-surface);
                    opacity: 0.7;
                    z-index: -1;
                }

                .card:hover {
                    transform: translateY(-5px);
                    box-shadow: 0 12px 40px 0 rgba(0, 0, 0, 0.4);
                }

                /* API Endpoint Cards */
                .endpoint-card {
                    background: var(--surface);
                    border-radius: var(--radius-md);
                    padding: var(--space-md);
                    border-left: 4px solid var(--primary);
                    transition: all var(--transition-normal);
                    margin-bottom: var(--space-sm);
                }

                .endpoint-card:hover {
                    transform: translateY(-3px);
                    box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.3);
                }

                /* Method Badges */
                .method-badge {
                    display: inline-flex;
                    align-items: center;
                    justify-content: center;
                    padding: 0.25rem 0.75rem;
                    border-radius: var(--radius-sm);
                    font-size: 0.75rem;
                    font-weight: 600;
                    text-transform: uppercase;
                    letter-spacing: 0.5px;
                }

                .method-get {
                    background: rgba(16, 185, 129, 0.2);
                    color: var(--success);
                    border: 1px solid rgba(16, 185, 129, 0.3);
                }

                .method-post {
                    background: rgba(59, 130, 246, 0.2);
                    color: var(--info);
                    border: 1px solid rgba(59, 130, 246, 0.3);
                }

                .method-put {
                    background: rgba(245, 158, 11, 0.2);
                    color: var(--warning);
                    border: 1px solid rgba(245, 158, 11, 0.3);
                }

                .method-delete {
                    background: rgba(239, 68, 68, 0.2);
                    color: var(--error);
                    border: 1px solid rgba(239, 68, 68, 0.3);
                }

                /* Buttons */
                .btn {
                    display: inline-flex;
                    align-items: center;
                    justify-content: center;
                    padding: 0.75rem 1.5rem;
                    border: none;
                    border-radius: var(--radius-md);
                    font-weight: 500;
                    font-size: 0.875rem;
                    cursor: pointer;
                    transition: all var(--transition-normal);
                    position: relative;
                    overflow: hidden;
                }

                .btn::before {
                    content: '';
                    position: absolute;
                    top: 0;
                    left: -100%;
                    width: 100%;
                    height: 100%;
                    background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
                    transition: left var(--transition-slow);
                }

                .btn:hover::before {
                    left: 100%;
                }

                .btn-primary {
                    background: var(--gradient-primary);
                    color: white;
                }

                .btn-primary:hover {
                    transform: translateY(-2px);
                    box-shadow: 0 10px 20px -5px rgba(99, 102, 241, 0.4);
                }

                .btn-secondary {
                    background: var(--surface-light);
                    color: var(--text-primary);
                }

                .btn-secondary:hover {
                    background: var(--surface);
                    transform: translateY(-2px);
                }

                /* Inputs */
                .input {
                    width: 100%;
                    padding: 0.75rem 1rem;
                    background: var(--surface);
                    border: 1px solid var(--border);
                    border-radius: var(--radius-md);
                    color: var(--text-primary);
                    font-size: 0.875rem;
                    transition: all var(--transition-fast);
                }

                .input:focus {
                    outline: none;
                    border-color: var(--primary);
                    box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.2);
                }

                /* Response Area */
                .response-area {
                    background: #1a1f36;
                    border-radius: var(--radius-md);
                    padding: var(--space-md);
                    font-family: 'Fira Code', 'Courier New', monospace;
                    font-size: 0.875rem;
                    color: #7fdbca;
                    max-height: 400px;
                    overflow-y: auto;
                    border: 1px solid var(--border);
                    position: relative;
                }

                .response-area::before {
                    content: '';
                    position: absolute;
                    top: 0;
                    left: 0;
                    width: 100%;
                    height: 100%;
                    background: linear-gradient(transparent 95%, #1a1f36);
                    pointer-events: none;
                }

                /* Status Indicators */
                .status-indicator {
                    width: 12px;
                    height: 12px;
                    border-radius: 50%;
                    display: inline-block;
                    margin-right: 0.5rem;
                }

                .status-ready {
                    background: var(--success);
                    box-shadow: 0 0 10px var(--success);
                }

                .status-loading {
                    background: var(--warning);
                    animation: pulse 1.5s infinite;
                }

                .status-error {
                    background: var(--error);
                    box-shadow: 0 0 10px var(--error);
                }

                /* Grid */
                .grid {
                    display: grid;
                    gap: var(--space-lg);
                }

                .grid-cols-1 {
                    grid-template-columns: 1fr;
                }

                .grid-cols-2 {
                    grid-template-columns: repeat(2, 1fr);
                }

                .grid-cols-3 {
                    grid-template-columns: repeat(3, 1fr);
                }

                @media (max-width: 1024px) {
                    .grid-cols-2, .grid-cols-3 {
                        grid-template-columns: 1fr;
                    }
                }

                /* Animations */
                @keyframes fadeIn {
                    from { opacity: 0; transform: translateY(20px); }
                    to { opacity: 1; transform: translateY(0); }
                }

                @keyframes pulse {
                    0% { opacity: 1; }
                    50% { opacity: 0.5; }
                    100% { opacity: 1; }
                }

                @keyframes slideIn {
                    from { transform: translateX(-20px); opacity: 0; }
                    to { transform: translateX(0); opacity: 1; }
                }

                .fade-in {
                    animation: fadeIn 0.6s ease-out;
                }

                .slide-in {
                    animation: slideIn 0.5s ease-out;
                }

                /* Utility Classes */
                .text-center { text-align: center; }
                .text-right { text-align: right; }
                .mb-0 { margin-bottom: 0; }
                .mb-1 { margin-bottom: var(--space-xs); }
                .mb-2 { margin-bottom: var(--space-sm); }
                .mb-3 { margin-bottom: var(--space-md); }
                .mb-4 { margin-bottom: var(--space-lg); }
                .mb-5 { margin-bottom: var(--space-xl); }
                .mt-1 { margin-top: var(--space-xs); }
                .mt-2 { margin-top: var(--space-sm); }
                .mt-3 { margin-top: var(--space-md); }
                .mt-4 { margin-top: var(--space-lg); }
                .mt-5 { margin-top: var(--space-xl); }
                .flex { display: flex; }
                .items-center { align-items: center; }
                .justify-between { justify-content: space-between; }
                .space-x-2 > * + * { margin-left: 0.5rem; }
                .space-y-2 > * + * { margin-top: 0.5rem; }
                .w-full { width: 100%; }

                /* Loading State */
                .loading {
                    opacity: 0.7;
                    pointer-events: none;
                    position: relative;
                }

                .loading::after {
                    content: '';
                    position: absolute;
                    top: 50%;
                    left: 50%;
                    width: 20px;
                    height: 20px;
                    margin: -10px 0 0 -10px;
                    border: 2px solid transparent;
                    border-top: 2px solid var(--primary);
                    border-radius: 50%;
                    animation: spin 1s linear infinite;
                }

                @keyframes spin {
                    0% { transform: rotate(0deg); }
                    100% { transform: rotate(360deg); }
                }

                /* Scrollbar Styling */
                ::-webkit-scrollbar {
                    width: 8px;
                }

                ::-webkit-scrollbar-track {
                    background: var(--surface);
                    border-radius: 4px;
                }

                ::-webkit-scrollbar-thumb {
                    background: var(--surface-light);
                    border-radius: 4px;
                }

                ::-webkit-scrollbar-thumb:hover {
                    background: var(--primary);
                }
                .title{
                    margin-top: 5rem;
                }
            </style>
        @endif
    </head>
    <body>
        <div class="container main-container">
            <!-- Header -->
            <div class="text-center pt-5 pb-5 mb-5 fade-in">
                <h1 class="mb-2 title">Members Management API</h1>
                <p class="text-lg mb-1">
                    Backend API for <span class="text-accent">Protec Damayan Web App</span>
                </p>
                <p class="text-muted">
                    Comprehensive member management system with analytics and filtering capabilities
                </p>
            </div>

            <!-- API Base URL -->
            <div class="card mb-4 fade-in">
                <h2 class="mb-2">Base URL</h2>
                <div class="bg-surface rounded-md p-3">
                    <code class="text-lg font-mono text-primary">
                        http://127.0.0.1:8000/api/members
                    </code>
                </div>
            </div>

            <!-- API Endpoints -->
            <div class="grid grid-cols-2 mb-4">
                <!-- Basic CRUD Operations -->
                <div class="card slide-in">
                    <h3 class="mb-3">Basic CRUD Operations</h3>
                    
                    <div class="space-y-2">
                        <!-- GET All Members -->
                        <div class="endpoint-card">
                            <div class="flex items-center justify-between mb-2">
                                <span class="method-badge method-get">
                                    GET
                                </span>
                                <code class="text-sm font-mono">
                                    /api/members
                                </code>
                            </div>
                            <p class="text-sm mb-2">
                                Retrieve all members
                            </p>
                            <button onclick="testEndpoint('GET', '/api/members')" 
                                    class="btn btn-primary w-full">
                                Test Endpoint
                            </button>
                        </div>

                        <!-- GET Single Member -->
                        <div class="endpoint-card">
                            <div class="flex items-center justify-between mb-2">
                                <span class="method-badge method-get">
                                    GET
                                </span>
                                <code class="text-sm font-mono">
                                    /api/members/{id}
                                </code>
                            </div>
                            <p class="text-sm mb-2">
                                Retrieve specific member by ID
                            </p>
                            <div class="flex space-x-2 mb-2">
                                <input type="number" id="memberId" placeholder="Enter member ID" 
                                       class="input">
                            </div>
                            <button onclick="testEndpoint('GET', `/api/members/${document.getElementById('memberId').value || 1}`)" 
                                    class="btn btn-primary w-full">
                                Test Endpoint
                            </button>
                        </div>

                        <!-- POST Create Member -->
                        <div class="endpoint-card">
                            <div class="flex items-center justify-between mb-2">
                                <span class="method-badge method-post">
                                    POST
                                </span>
                                <code class="text-sm font-mono">
                                    /api/members
                                </code>
                            </div>
                            <p class="text-sm mb-2">
                                Create a new member
                            </p>
                            <pre>
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
                            </pre>
                            <button onclick="testCreateMember()" 
                                    class="btn btn-primary w-full">
                                Test Endpoint
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Filter Endpoints -->
                <div class="card slide-in">
                    <h3 class="mb-3">Filter Endpoints</h3>
                    
                    <div class="grid grid-cols-2 gap-2">
                        <!-- Seniors -->
                        <div class="endpoint-card">
                            <div class="flex items-center justify-between mb-2">
                                <span class="method-badge method-get">
                                    GET
                                </span>
                                <code class="text-sm font-mono">
                                    /seniors
                                </code>
                            </div>
                            <p class="text-sm mb-2">
                                Members aged 60+
                            </p>
                            <button onclick="testEndpoint('GET', '/api/members/seniors')" 
                                    class="btn btn-secondary w-full text-sm">
                                Test Endpoint
                            </button>
                        </div>

                        <!-- Minors -->
                        <div class="endpoint-card">
                            <div class="flex items-center justify-between mb-2">
                                <span class="method-badge method-get">
                                    GET
                                </span>
                                <code class="text-sm font-mono">
                                    /minors
                                </code>
                            </div>
                            <p class="text-sm mb-2">
                                Members under 18
                            </p>
                            <button onclick="testEndpoint('GET', '/api/members/minors')" 
                                    class="btn btn-secondary w-full text-sm">
                                Test Endpoint
                            </button>
                        </div>

                        <!-- Search -->
                        <div class="endpoint-card col-span-2">
                            <div class="flex items-center justify-between mb-2">
                                <span class="method-badge method-get">
                                    GET
                                </span>
                                <code class="text-sm font-mono">
                                    /search?q={query}
                                </code>
                            </div>
                            <p class="text-sm mb-2">
                                Search members by name
                            </p>
                            <div class="flex space-x-2 mb-2">
                                <input type="text" id="searchQuery" placeholder="Enter search term" 
                                       class="input">
                            </div>
                            <button onclick="testEndpoint('GET', `/api/members/search?q=${document.getElementById('searchQuery').value || 'john'}`)" 
                                    class="btn btn-secondary w-full">
                                Test Endpoint
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Analytics Endpoints -->
                <div class="card slide-in">
                    <h3 class="mb-3">Analytics Endpoints</h3>
                    
                    <div class="space-y-2">
                        <!-- Statistics -->
                        <div class="endpoint-card">
                            <div class="flex items-center justify-between mb-2">
                                <span class="method-badge method-get">
                                    GET
                                </span>
                                <code class="text-sm font-mono">
                                    /statistics
                                </code>
                            </div>
                            <p class="text-sm mb-2">
                                Get comprehensive member statistics
                            </p>
                            <button onclick="testEndpoint('GET', '/api/members/statistics')" 
                                    class="btn btn-primary w-full">
                                Test Endpoint
                            </button>
                        </div>

                        <!-- Age Distribution -->
                        <div class="endpoint-card">
                            <div class="flex items-center justify-between mb-2">
                                <span class="method-badge method-get">
                                    GET
                                </span>
                                <code class="text-sm font-mono">
                                    /age-distribution
                                </code>
                            </div>
                            <p class="text-sm mb-2">
                                Get age group distribution
                            </p>
                            <button onclick="testEndpoint('GET', '/api/members/age-distribution')" 
                                    class="btn btn-primary w-full">
                                Test Endpoint
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Additional Filters -->
                <div class="card slide-in">
                    <h3 class="mb-3">Additional Filters</h3>
                    
                    <div class="grid grid-cols-1 gap-2">
                        <button onclick="testEndpoint('GET', '/api/members/active')" 
                                class="btn btn-secondary w-full text-sm">
                            GET /active - Active members
                        </button>
                        <button onclick="testEndpoint('GET', '/api/members/inactive')" 
                                class="btn btn-secondary w-full text-sm">
                            GET /inactive - Inactive members
                        </button>
                        <button onclick="testEndpoint('GET', '/api/members/male')" 
                                class="btn btn-secondary w-full text-sm">
                            GET /male - Male members
                        </button>
                        <button onclick="testEndpoint('GET', '/api/members/female')" 
                                class="btn btn-secondary w-full text-sm">
                            GET /female - Female members
                        </button>
                        <div class="flex space-x-2">
                            <input type="text" id="purokQuery" placeholder="Enter purok" 
                                   class="input">
                            <button onclick="testEndpoint('GET', `/api/members/purok/${document.getElementById('purokQuery').value || '1'}`)" 
                                    class="btn btn-secondary text-sm whitespace-nowrap">
                                GET /purok/{purok}
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Response Area -->
            <div class="card fade-in">
                <h3 class="mb-3">API Response</h3>
               <div class="mb-3 flex flex-col items-center space-y-4" style="flex-direction: column; justify-content: left; align-items: start;">
                    <div class="flex items-center">
                        <div class="status-indicator status-ready" id="statusIndicator"></div>
                        <span class="text-sm font-medium" id="statusText">Ready</span>
                    </div>
                    <div class="text-sm text-muted" id="requestUrl">
                        No request made yet
                    </div>
                </div>
                <div class="response-area">
                    <pre id="responseArea" class="text-sm">
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
                document.getElementById('statusIndicator').className = 'status-indicator status-loading';
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
                        document.getElementById('statusIndicator').className = 'status-indicator status-ready';
                        document.getElementById('responseArea').textContent = JSON.stringify(response.data, null, 2);
                    })
                    .catch(error => {
                        if (axios.isCancel(error)) {
                            document.getElementById('statusText').textContent = 'Cancelled';
                            document.getElementById('statusIndicator').className = 'status-indicator';
                            document.getElementById('responseArea').textContent = 'Request was cancelled';
                        } else {
                            document.getElementById('statusText').textContent = `Error (${error.response?.status || 'Network'})`;
                            document.getElementById('statusIndicator').className = 'status-indicator status-error';
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

            // Add staggered animations for cards
            document.addEventListener('DOMContentLoaded', function() {
                const cards = document.querySelectorAll('.card');
                cards.forEach((card, index) => {
                    card.style.animationDelay = `${index * 0.1}s`;
                });
            });
        </script>
    </body>
</html>