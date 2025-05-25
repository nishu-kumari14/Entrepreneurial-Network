<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Admin Dashboard
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Stats -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4 mb-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-900">Total Users</h3>
                    <p class="text-3xl font-bold text-indigo-600">{{ $stats['users'] }}</p>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-900">Total Projects</h3>
                    <p class="text-3xl font-bold text-indigo-600">{{ $stats['projects'] }}</p>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-900">Forum Posts</h3>
                    <p class="text-3xl font-bold text-indigo-600">{{ $stats['forum_posts'] }}</p>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-900">Messages</h3>
                    <p class="text-3xl font-bold text-indigo-600">{{ $stats['messages'] }}</p>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-900">Reports</h3>
                    <p class="text-3xl font-bold text-indigo-600">{{ $stats['reports'] }}</p>
                </div>
            </div>

            <!-- Recent Activity -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Recent Users -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Recent Users</h3>
                        <div class="space-y-4">
                            @foreach($recentUsers as $user)
                                <div class="flex items-center space-x-3">
                                    <img class="h-8 w-8 rounded-full" src="{{ $user->profile_photo_url }}" alt="{{ $user->name }}">
                                    <div>
                                        <p class="text-sm font-medium text-gray-900">{{ $user->name }}</p>
                                        <p class="text-xs text-gray-500">{{ $user->created_at->diffForHumans() }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Recent Projects -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Recent Projects</h3>
                        <div class="space-y-4">
                            @foreach($recentProjects as $project)
                                <div>
                                    <p class="text-sm font-medium text-gray-900">{{ $project->title }}</p>
                                    <p class="text-xs text-gray-500">By {{ $project->user->name }} • {{ $project->created_at->diffForHumans() }}</p>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Recent Reports -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Recent Reports</h3>
                        <div class="space-y-4">
                            @foreach($recentReports as $report)
                                <div>
                                    <p class="text-sm font-medium text-gray-900">
                                        Reported by {{ $report->reporter->name }}
                                    </p>
                                    <p class="text-xs text-gray-500">
                                        Against {{ $report->reported->name }} • {{ $report->created_at->diffForHumans() }}
                                    </p>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 