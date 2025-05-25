<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Skills
            </h2>
            <div class="flex space-x-4">
                <form action="{{ route('skills.search') }}" method="GET" class="flex">
                    <input type="text" name="query" placeholder="Search skills..." 
                        value="{{ request('query') }}"
                        class="rounded-l-lg px-4 py-2 border-t border-b border-l text-gray-800 border-gray-200 bg-white">
                    <select name="category" class="px-4 py-2 border-t border-b border-gray-200 bg-white">
                        <option value="">All Categories</option>
                        @foreach($categories as $category)
                            <option value="{{ $category }}" {{ request('category') == $category ? 'selected' : '' }}>
                                {{ $category }}
                            </option>
                        @endforeach
                    </select>
                    <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-r-lg hover:bg-blue-600">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </button>
                </form>
                @can('create', App\Models\Skill::class)
                    <a href="{{ route('skills.create') }}" class="px-4 py-2 bg-green-500 text-white rounded-lg hover:bg-green-600">
                        Add Skill
                    </a>
                @endcan
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @forelse($skills as $skill)
                            <div class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition">
                                <div class="flex justify-between items-start">
                                    <div>
                                        <h3 class="text-lg font-semibold text-gray-900">{{ $skill->name }}</h3>
                                        <p class="text-sm text-gray-500">{{ $skill->category }}</p>
                                    </div>
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">
                                        {{ $skill->users_count }} users
                                    </span>
                                </div>
                                <p class="mt-2 text-sm text-gray-600">{{ $skill->description }}</p>
                                <div class="mt-4 flex space-x-2">
                                    <a href="{{ route('skills.users', $skill) }}" 
                                       class="text-sm text-blue-500 hover:text-blue-700">
                                        View Users
                                    </a>
                                    <a href="{{ route('skills.projects', $skill) }}" 
                                       class="text-sm text-green-500 hover:text-green-700">
                                        View Projects
                                    </a>
                                </div>
                            </div>
                        @empty
                            <div class="col-span-full text-center py-8">
                                <p class="text-gray-500">No skills found.</p>
                            </div>
                        @endforelse
                    </div>
                    <div class="mt-6">
                        {{ $skills->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 