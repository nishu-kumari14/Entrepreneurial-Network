<x-app-layout>
    <div class="min-h-screen py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Hero Section -->
            <div class="text-center mb-12">
                <h1 class="text-4xl font-bold text-gray-900 mb-4">Entrepreneurial Network</h1>
                <p class="text-xl text-gray-600">Connect with fellow entrepreneurs, share experiences, and grow together</p>
            </div>

            <!-- Network Stats -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-12">
                <div class="bg-white rounded-lg shadow-lg p-6 transform hover:scale-105 transition-transform duration-300">
                    <div class="text-3xl font-bold text-indigo-600 mb-2">1,000+</div>
                    <div class="text-gray-600">Active Members</div>
                </div>
                <div class="bg-white rounded-lg shadow-lg p-6 transform hover:scale-105 transition-transform duration-300">
                    <div class="text-3xl font-bold text-indigo-600 mb-2">50+</div>
                    <div class="text-gray-600">Industry Experts</div>
                </div>
                <div class="bg-white rounded-lg shadow-lg p-6 transform hover:scale-105 transition-transform duration-300">
                    <div class="text-3xl font-bold text-indigo-600 mb-2">100+</div>
                    <div class="text-gray-600">Success Stories</div>
                </div>
            </div>

            <!-- Features -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-12">
                <div class="bg-white rounded-lg shadow-lg p-6">
                    <h3 class="text-xl font-semibold text-gray-900 mb-4">Networking Events</h3>
                    <p class="text-gray-600 mb-4">Join our regular networking events and meet fellow entrepreneurs in person or virtually.</p>
                    <a href="#" class="text-indigo-600 hover:text-indigo-800">View Upcoming Events →</a>
                </div>
                <div class="bg-white rounded-lg shadow-lg p-6">
                    <h3 class="text-xl font-semibold text-gray-900 mb-4">Mentorship Program</h3>
                    <p class="text-gray-600 mb-4">Get paired with experienced mentors who can guide you through your entrepreneurial journey.</p>
                    <a href="#" class="text-indigo-600 hover:text-indigo-800">Find a Mentor →</a>
                </div>
            </div>

            <!-- Join Network CTA -->
            <div class="text-center bg-white rounded-lg shadow-lg p-8 mb-12">
                <h2 class="text-2xl font-bold text-gray-900 mb-4">Ready to Join Our Network?</h2>
                <p class="text-gray-600 mb-6">Connect with like-minded entrepreneurs and take your business to the next level.</p>
                <a href="{{ route('network.join') }}" class="inline-block bg-indigo-600 text-white px-6 py-3 rounded-lg hover:bg-indigo-700 transition-colors duration-300">
                    Join Now
                </a>
            </div>

            <!-- Success Stories -->
            <div class="mb-12">
                <h2 class="text-2xl font-bold text-gray-900 mb-6 text-center">Success Stories</h2>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="bg-white rounded-lg shadow-lg p-6 transform hover:scale-105 transition-transform duration-300">
                        <div class="flex items-center mb-4">
                            <div class="w-12 h-12 bg-indigo-100 rounded-full flex items-center justify-center">
                                <span class="text-indigo-600 font-bold">JD</span>
                            </div>
                            <div class="ml-4">
                                <h4 class="font-semibold text-gray-900">John Doe</h4>
                                <p class="text-sm text-gray-600">Founder, TechStart</p>
                            </div>
                        </div>
                        <p class="text-gray-600">"The network helped me connect with investors and grow my business exponentially."</p>
                    </div>
                    <div class="bg-white rounded-lg shadow-lg p-6 transform hover:scale-105 transition-transform duration-300">
                        <div class="flex items-center mb-4">
                            <div class="w-12 h-12 bg-indigo-100 rounded-full flex items-center justify-center">
                                <span class="text-indigo-600 font-bold">AS</span>
                            </div>
                            <div class="ml-4">
                                <h4 class="font-semibold text-gray-900">Alice Smith</h4>
                                <p class="text-sm text-gray-600">CEO, GreenTech</p>
                            </div>
                        </div>
                        <p class="text-gray-600">"Found my co-founder through the network. Best decision ever!"</p>
                    </div>
                    <div class="bg-white rounded-lg shadow-lg p-6 transform hover:scale-105 transition-transform duration-300">
                        <div class="flex items-center mb-4">
                            <div class="w-12 h-12 bg-indigo-100 rounded-full flex items-center justify-center">
                                <span class="text-indigo-600 font-bold">RJ</span>
                            </div>
                            <div class="ml-4">
                                <h4 class="font-semibold text-gray-900">Robert Johnson</h4>
                                <p class="text-sm text-gray-600">Founder, HealthTech</p>
                            </div>
                        </div>
                        <p class="text-gray-600">"The mentorship program was invaluable in helping me scale my startup."</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 