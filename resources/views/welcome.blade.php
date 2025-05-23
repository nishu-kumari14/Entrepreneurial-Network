<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Laravel') }}</title>
            @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
<body class="antialiased bg-gradient-animation min-h-screen">
    <!-- Floating Shapes -->
    <div class="floating-shape shape-1 animate-rotate"></div>
    <div class="floating-shape shape-2 animate-rotate"></div>
    <div class="floating-shape shape-3 animate-rotate"></div>
    <div class="floating-shape shape-4 animate-rotate"></div>

    <!-- Navigation -->
    <nav class="relative z-10 glass-effect border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex">
                    <div class="flex-shrink-0 flex items-center">
                        <a href="{{ url('/') }}" class="hover-scale">
                            <h1 class="text-2xl font-bold text-white neon-glow">{{ config('app.name', 'Laravel') }}</h1>
                        </a>
                    </div>
                </div>
                <div class="flex items-center space-x-4">
                    @if (Route::has('login'))
                    @auth
                            <a href="{{ url('/dashboard') }}" class="nav-link text-white hover:text-gray-200">Dashboard</a>
                    @else
                            <a href="{{ route('login') }}" class="nav-link text-white hover:text-gray-200">Log in</a>
                        @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="nav-link text-white hover:text-gray-200">Register</a>
                        @endif
                    @endauth
                    @endif
                </div>
            </div>
        </div>
                </nav>

    <!-- Hero Section -->
    <div class="relative z-10 pt-16 pb-20 sm:pt-24 sm:pb-24 lg:pt-32 lg:pb-32">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <h1 class="animate-slide-up text-4xl tracking-tight font-extrabold text-white sm:text-5xl md:text-6xl neon-glow">
                    Welcome to Your Entrepreneurial Network
                </h1>
                <p class="animate-slide-up-delay mt-3 max-w-md mx-auto text-base text-gray-100 sm:text-lg md:mt-5 md:text-xl md:max-w-3xl">
                    Connect, collaborate, and grow with fellow entrepreneurs. Join our community to access resources, mentorship, and networking opportunities.
                </p>
                <div class="animate-fade-in-delay mt-5 max-w-md mx-auto sm:flex sm:justify-center md:mt-8">
                    <div class="rounded-md shadow gradient-border">
                        <a href="{{ route('register') }}" class="hover-scale w-full flex items-center justify-center px-8 py-3 border border-transparent text-base font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 md:py-4 md:text-lg md:px-10 animate-pulse">
                            Get Started
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Features Section -->
    <div class="relative z-10 glass-effect py-16 sm:py-24">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <h2 class="text-3xl font-extrabold text-white sm:text-4xl neon-glow">
                    Why Join Our Network?
                </h2>
            </div>
            <div class="mt-12 grid gap-8 sm:grid-cols-2 lg:grid-cols-4">
                <!-- Feature 1 -->
                <div class="feature-card card-hover glass-effect rounded-lg p-6 h-full flex flex-col animate-on-scroll">
                    <div class="text-white flex-grow">
                        <h3 class="text-lg font-semibold text-gradient mb-4">Connect with Peers</h3>
                        <p class="text-gray-100">Network with like-minded entrepreneurs and build valuable relationships.</p>
                    </div>
                </div>
                <!-- Feature 2 -->
                <div class="feature-card card-hover glass-effect rounded-lg p-6 h-full flex flex-col animate-on-scroll">
                    <div class="text-white flex-grow">
                        <h3 class="text-lg font-semibold text-gradient mb-4">Access Resources</h3>
                        <p class="text-gray-100">Get exclusive access to tools, guides, and educational content.</p>
                    </div>
                </div>
                <!-- Feature 3 -->
                <div class="feature-card card-hover glass-effect rounded-lg p-6 h-full flex flex-col animate-on-scroll">
                    <div class="text-white flex-grow">
                        <h3 class="text-lg font-semibold text-gradient mb-4">Grow Your Business</h3>
                        <p class="text-gray-100">Find opportunities for collaboration, funding, and expansion.</p>
                    </div>
                </div>
                <!-- Feature 4 -->
                <div class="feature-card card-hover glass-effect rounded-lg p-6 h-full flex flex-col animate-on-scroll">
                    <div class="text-white flex-grow">
                        <h3 class="text-lg font-semibold text-gradient mb-4">Expert Mentorship</h3>
                        <p class="text-gray-100">Get guidance from experienced entrepreneurs and industry experts.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- CTA Section -->
    <div class="relative z-10 py-16 sm:py-24">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="glass-effect rounded-lg shadow-xl overflow-hidden gradient-border">
                <div class="px-6 py-12 sm:px-12 sm:py-16 lg:flex lg:items-center lg:justify-between">
                    <div>
                        <h2 class="text-3xl font-extrabold tracking-tight text-white sm:text-4xl neon-glow">
                            Ready to get started?
                        </h2>
                        <p class="mt-3 max-w-3xl text-lg text-gray-100">
                            Join our network today and take your entrepreneurial journey to the next level.
                        </p>
                    </div>
                    <div class="mt-8 lg:mt-0 lg:flex-shrink-0">
                        <div class="inline-flex rounded-md shadow">
                            <a href="{{ route('register') }}" class="hover-scale inline-flex items-center justify-center px-5 py-3 border border-transparent text-base font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 animate-bounce">
                                Join Now
                            </a>
                        </div>
                    </div>
                </div>
                </div>
        </div>
    </div>

    <!-- Add Intersection Observer for scroll animations -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('visible');
                    }
                });
            });

            document.querySelectorAll('.animate-on-scroll').forEach((el) => observer.observe(el));
        });
    </script>
    </body>
</html>
