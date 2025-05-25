<x-app-layout>
    <div class="min-h-screen py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="max-w-3xl mx-auto">
                <!-- Header -->
                <div class="text-center mb-12">
                    <h1 class="text-4xl font-bold text-gray-900 mb-4">Join Our Network</h1>
                    <p class="text-xl text-gray-600">Take the first step towards connecting with fellow entrepreneurs</p>
                </div>

                <!-- Registration Form -->
                <div class="bg-white rounded-lg shadow-lg p-8">
                    @if (session('success'))
                        <div class="mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                            <span class="block sm:inline">{{ session('success') }}</span>
                        </div>
                    @endif

                    <form action="{{ route('network.join.store') }}" method="POST" class="space-y-6">
                        @csrf
                        <!-- Personal Information -->
                        <div>
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Personal Information</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="first_name" class="block text-sm font-medium text-gray-700">First Name</label>
                                    <input type="text" name="first_name" id="first_name" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                </div>
                                <div>
                                    <label for="last_name" class="block text-sm font-medium text-gray-700">Last Name</label>
                                    <input type="text" name="last_name" id="last_name" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                </div>
                            </div>
                        </div>

                        <!-- Contact Information -->
                        <div>
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Contact Information</h3>
                            <div class="space-y-6">
                                <div>
                                    <label for="email" class="block text-sm font-medium text-gray-700">Email Address</label>
                                    <input type="email" name="email" id="email" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                </div>
                                <div>
                                    <label for="phone" class="block text-sm font-medium text-gray-700">Phone Number</label>
                                    <input type="tel" name="phone" id="phone" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                </div>
                            </div>
                        </div>

                        <!-- Professional Information -->
                        <div>
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Professional Information</h3>
                            <div class="space-y-6">
                                <div>
                                    <label for="company" class="block text-sm font-medium text-gray-700">Company Name</label>
                                    <input type="text" name="company" id="company" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                </div>
                                <div>
                                    <label for="position" class="block text-sm font-medium text-gray-700">Position</label>
                                    <input type="text" name="position" id="position" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                </div>
                                <div>
                                    <label for="industry" class="block text-sm font-medium text-gray-700">Industry</label>
                                    <select name="industry" id="industry" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                        <option value="">Select an industry</option>
                                        <option value="tech">Technology</option>
                                        <option value="healthcare">Healthcare</option>
                                        <option value="finance">Finance</option>
                                        <option value="education">Education</option>
                                        <option value="other">Other</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- Interests -->
                        <div>
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Interests</h3>
                            <div class="space-y-4">
                                <div class="flex items-center">
                                    <input type="checkbox" name="interests[]" id="mentorship" value="mentorship" class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                                    <label for="mentorship" class="ml-3 block text-sm font-medium text-gray-700">Mentorship Program</label>
                                </div>
                                <div class="flex items-center">
                                    <input type="checkbox" name="interests[]" id="networking" value="networking" class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                                    <label for="networking" class="ml-3 block text-sm font-medium text-gray-700">Networking Events</label>
                                </div>
                                <div class="flex items-center">
                                    <input type="checkbox" name="interests[]" id="investment" value="investment" class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                                    <label for="investment" class="ml-3 block text-sm font-medium text-gray-700">Investment Opportunities</label>
                                </div>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="pt-6">
                            <button type="submit" class="w-full bg-indigo-600 text-white px-6 py-3 rounded-lg hover:bg-indigo-700 transition-colors duration-300">
                                Join Network
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Benefits Section -->
                <div class="mt-12">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6 text-center">Network Benefits</h2>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div class="bg-white rounded-lg shadow-lg p-6 transform hover:scale-105 transition-transform duration-300">
                            <div class="text-indigo-600 mb-4">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                </svg>
                            </div>
                            <h3 class="text-lg font-semibold text-gray-900 mb-2">Connect with Peers</h3>
                            <p class="text-gray-600">Build relationships with fellow entrepreneurs and industry experts.</p>
                        </div>
                        <div class="bg-white rounded-lg shadow-lg p-6 transform hover:scale-105 transition-transform duration-300">
                            <div class="text-indigo-600 mb-4">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />
                                </svg>
                            </div>
                            <h3 class="text-lg font-semibold text-gray-900 mb-2">Access Resources</h3>
                            <p class="text-gray-600">Get exclusive access to tools, templates, and expert advice.</p>
                        </div>
                        <div class="bg-white rounded-lg shadow-lg p-6 transform hover:scale-105 transition-transform duration-300">
                            <div class="text-indigo-600 mb-4">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                                </svg>
                            </div>
                            <h3 class="text-lg font-semibold text-gray-900 mb-2">Grow Your Business</h3>
                            <p class="text-gray-600">Learn from successful entrepreneurs and scale your startup.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 