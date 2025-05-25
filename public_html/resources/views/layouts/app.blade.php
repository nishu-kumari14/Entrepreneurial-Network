<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>EN Connects - Entrepreneurial Network</title>

        <!-- Favicon -->
        <link rel="icon" type="image/svg+xml" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'><text y='.9em' font-size='90' fill='%234f46e5'>EN</text></svg>">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
            /* Global hover effects */
            a, button, .btn, .card, .nav-link, .dropdown-item {
                transition: all 0.3s ease-in-out;
            }

            /* Card hover effect */
            .card {
                transition: transform 0.3s ease, box-shadow 0.3s ease;
            }

            .card:hover {
                transform: translateY(-5px);
                box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
            }

            /* Button hover effect */
            .btn-primary, .btn-secondary {
                position: relative;
                overflow: hidden;
            }

            .btn-primary:hover, .btn-secondary:hover {
                transform: translateY(-2px);
                box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            }

            /* Input focus effect */
            input:focus, textarea:focus, select:focus {
                transform: scale(1.01);
                transition: transform 0.3s ease;
            }

            /* Table row hover effect */
            tr {
                transition: background-color 0.3s ease;
            }

            tr:hover {
                background-color: rgba(0, 0, 0, 0.02);
            }

            /* Image hover effect */
            img {
                transition: transform 0.3s ease;
            }

            img:hover {
                transform: scale(1.05);
            }

            /* Smooth scroll */
            html {
                scroll-behavior: smooth;
            }

            /* Custom scrollbar */
            ::-webkit-scrollbar {
                width: 8px;
            }

            ::-webkit-scrollbar-track {
                background: #f1f1f1;
            }

            ::-webkit-scrollbar-thumb {
                background: #888;
                border-radius: 4px;
            }

            ::-webkit-scrollbar-thumb:hover {
                background: #555;
            }

            .bg-pattern {
                background-image: 
                    radial-gradient(circle at 25px 25px, rgba(255, 255, 255, 0.1) 2%, transparent 0%),
                    radial-gradient(circle at 75px 75px, rgba(255, 255, 255, 0.1) 2%, transparent 0%);
                background-size: 100px 100px;
            }

            /* Logo styles */
            .logo-container {
                display: flex;
                align-items: center;
                gap: 0.5rem;
            }

            .logo-svg {
                width: 2.5rem;
                height: 2.5rem;
                background-color: #4f46e5;
                border-radius: 0.5rem;
                display: flex;
                align-items: center;
                justify-content: center;
                transition: transform 0.3s ease;
            }

            .logo-svg:hover {
                transform: scale(1.1);
            }

            .logo-text {
                font-size: 1.25rem;
                font-weight: 700;
                color: #1f2937;
                transition: color 0.3s ease;
            }

            .logo-container:hover .logo-text {
                color: #4f46e5;
            }
        </style>
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @if (isset($header))
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endif

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>

            <!-- Footer -->
            <footer class="bg-white mt-12">
                <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                        <div>
                            <div class="logo-container">
                                <div class="logo-svg">
                                    <span class="text-white font-bold text-lg">EN</span>
                                </div>
                                <span class="logo-text">EN Connects</span>
                            </div>
                            <p class="mt-4 text-sm text-gray-500">
                                Connecting entrepreneurs worldwide to create meaningful partnerships and opportunities.
                            </p>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900">Quick Links</h3>
                            <ul class="mt-4 space-y-2">
                                <li><a href="/about" class="text-sm text-gray-500 hover:text-gray-900">About Us</a></li>
                                <li><a href="/network" class="text-sm text-gray-500 hover:text-gray-900">Our Network</a></li>
                                <li><a href="/contact" class="text-sm text-gray-500 hover:text-gray-900">Contact</a></li>
                            </ul>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900">Connect With Us</h3>
                            <div class="mt-4 flex space-x-6">
                                <a href="#" class="text-gray-400 hover:text-gray-500">
                                    <span class="sr-only">Facebook</span>
                                    <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24">
                                        <path fill-rule="evenodd" d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z" clip-rule="evenodd" />
                                    </svg>
                                </a>
                                <a href="#" class="text-gray-400 hover:text-gray-500">
                                    <span class="sr-only">Twitter</span>
                                    <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M8.29 20.251c7.547 0 11.675-6.253 11.675-11.675 0-.178 0-.355-.012-.53A8.348 8.348 0 0022 5.92a8.19 8.19 0 01-2.357.646 4.118 4.118 0 001.804-2.27 8.224 8.224 0 01-2.605.996 4.107 4.107 0 00-6.993 3.743 11.65 11.65 0 01-8.457-4.287 4.106 4.106 0 001.27 5.477A4.072 4.072 0 012.8 9.713v.052a4.105 4.105 0 003.292 4.022 4.095 4.095 0 01-1.853.07 4.108 4.108 0 003.834 2.85A8.233 8.233 0 012 18.407a11.616 11.616 0 006.29 1.84" />
                                    </svg>
                                </a>
                                <a href="#" class="text-gray-400 hover:text-gray-500">
                                    <span class="sr-only">LinkedIn</span>
                                    <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24">
                                        <path fill-rule="evenodd" d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z" clip-rule="evenodd" />
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="mt-8 border-t border-gray-200 pt-8">
                        <p class="text-base text-gray-400 text-center">
                            &copy; {{ date('Y') }} EN Connects. All rights reserved.
                        </p>
                    </div>
                </div>
            </footer>
        </div>

        <!-- Mobile menu -->
        <div class="hidden mobile-menu">
            <div class="px-2 pt-2 pb-3 space-y-1">
                <div class="flex items-center px-3 py-2">
                    <div class="w-8 h-8 rounded-lg bg-indigo-600 flex items-center justify-center">
                        <span class="text-white font-bold text-lg">EN</span>
                    </div>
                    <span class="ml-2 text-xl font-bold text-gray-900">Connects</span>
                </div>
                <a href="/" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-gray-900 hover:bg-gray-50">Home</a>
                <a href="/about" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-gray-900 hover:bg-gray-50">About</a>
                <a href="/network" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-gray-900 hover:bg-gray-50">Network</a>
            </div>
        </div>

        <script>
            // Mobile menu toggle
            document.addEventListener('DOMContentLoaded', function() {
                const mobileMenuButton = document.querySelector('.mobile-menu-button');
                const mobileMenu = document.querySelector('.mobile-menu');

                mobileMenuButton.addEventListener('click', function() {
                    mobileMenu.classList.toggle('hidden');
                });
            });
        </script>
    </body>
</html>
