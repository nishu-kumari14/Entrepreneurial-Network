<x-app-layout>
    <!-- Hero Section with Animated Background -->
    <div class="relative overflow-hidden bg-gradient-to-r from-indigo-500 via-purple-500 to-pink-500">
        <div class="absolute inset-0">
            <div class="absolute inset-0 bg-gradient-to-r from-indigo-600 to-purple-600 mix-blend-multiply"></div>
            <div class="absolute inset-0 bg-[url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNjAiIGhlaWdodD0iNjAiIHZpZXdCb3g9IjAgMCA2MCA2MCIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj48ZyBmaWxsPSJub25lIiBmaWxsLXJ1bGU9ImV2ZW5vZGQiPjxwYXRoIGQ9Ik0zNiA0NGMwIDYuNjI3LTUuMzczIDEyLTEyIDEyUzEyIDUwLjYyNyAxMiA0NCAxNy4zNzMgMzIgMjQgMzJzMTIgNS4zNzMgMTIgMTJ6IiBmaWxsPSIjZmZmIiBmaWxsLW9wYWNpdHk9Ii4xIi8+PC9nPjwvc3ZnPg==')] opacity-20"></div>
        </div>
        <div class="relative max-w-7xl mx-auto py-24 px-4 sm:py-32 sm:px-6 lg:px-8">
            <h1 class="text-4xl font-extrabold tracking-tight text-white sm:text-5xl lg:text-6xl">Featured Projects</h1>
            <p class="mt-6 text-xl text-indigo-100 max-w-3xl">Discover innovative projects from our entrepreneurial community</p>
        </div>
    </div>

    <!-- Projects Grid -->
    <div class="bg-gray-50 py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 gap-8 sm:grid-cols-2 lg:grid-cols-3">
                <!-- Project Card 1 -->
                <div class="group relative bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                    <div class="absolute inset-0 bg-gradient-to-r from-indigo-600 to-purple-600 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                    <div class="relative p-6">
                        <div class="flex items-center justify-between">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-indigo-100 text-indigo-800">Technology</span>
                            <span class="text-sm text-gray-500">2 days ago</span>
                        </div>
                        <h3 class="mt-4 text-xl font-semibold text-gray-900 group-hover:text-white transition-colors duration-300">AI-Powered Business Analytics</h3>
                        <p class="mt-2 text-gray-600 group-hover:text-indigo-100 transition-colors duration-300">Revolutionary analytics platform using machine learning to predict market trends.</p>
                        <div class="mt-6 flex items-center">
                            <div class="flex-shrink-0">
                                <img class="h-10 w-10 rounded-full" src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80" alt="">
                            </div>
                            <div class="ml-3">
                                <p class="text-sm font-medium text-gray-900 group-hover:text-white">John Doe</p>
                                <p class="text-sm text-gray-500 group-hover:text-indigo-200">Founder & CEO</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Project Card 2 -->
                <div class="group relative bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                    <div class="absolute inset-0 bg-gradient-to-r from-pink-600 to-rose-600 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                    <div class="relative p-6">
                        <div class="flex items-center justify-between">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-pink-100 text-pink-800">Healthcare</span>
                            <span class="text-sm text-gray-500">1 week ago</span>
                        </div>
                        <h3 class="mt-4 text-xl font-semibold text-gray-900 group-hover:text-white transition-colors duration-300">Telemedicine Platform</h3>
                        <p class="mt-2 text-gray-600 group-hover:text-pink-100 transition-colors duration-300">Connecting patients with healthcare providers through an innovative digital platform.</p>
                        <div class="mt-6 flex items-center">
                            <div class="flex-shrink-0">
                                <img class="h-10 w-10 rounded-full" src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80" alt="">
                            </div>
                            <div class="ml-3">
                                <p class="text-sm font-medium text-gray-900 group-hover:text-white">Jane Smith</p>
                                <p class="text-sm text-gray-500 group-hover:text-pink-200">Medical Director</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Project Card 3 -->
                <div class="group relative bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                    <div class="absolute inset-0 bg-gradient-to-r from-cyan-600 to-blue-600 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                    <div class="relative p-6">
                        <div class="flex items-center justify-between">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-cyan-100 text-cyan-800">Education</span>
                            <span class="text-sm text-gray-500">3 days ago</span>
                        </div>
                        <h3 class="mt-4 text-xl font-semibold text-gray-900 group-hover:text-white transition-colors duration-300">E-Learning Platform</h3>
                        <p class="mt-2 text-gray-600 group-hover:text-cyan-100 transition-colors duration-300">Interactive learning platform with personalized content and real-time feedback.</p>
                        <div class="mt-6 flex items-center">
                            <div class="flex-shrink-0">
                                <img class="h-10 w-10 rounded-full" src="https://images.unsplash.com/photo-1519244703995-f4e0f30006d5?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80" alt="">
                            </div>
                            <div class="ml-3">
                                <p class="text-sm font-medium text-gray-900 group-hover:text-white">Mike Johnson</p>
                                <p class="text-sm text-gray-500 group-hover:text-cyan-200">Education Specialist</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- CTA Section -->
    <div class="bg-gradient-to-r from-indigo-600 to-purple-600">
        <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:py-16 lg:px-8 lg:flex lg:items-center lg:justify-between">
            <h2 class="text-3xl font-extrabold tracking-tight text-white sm:text-4xl">
                <span class="block">Ready to showcase your project?</span>
                <span class="block text-indigo-200">Join our community today.</span>
            </h2>
            <div class="mt-8 flex lg:mt-0 lg:flex-shrink-0">
                <div class="inline-flex rounded-md shadow">
                    <a href="/register" class="inline-flex items-center justify-center px-5 py-3 border border-transparent text-base font-medium rounded-md text-indigo-600 bg-white hover:bg-indigo-50 transition-all duration-300 transform hover:scale-105">
                        Get started
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 