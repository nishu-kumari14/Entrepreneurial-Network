<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Location Search
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form action="{{ route('location.search') }}" method="GET" class="space-y-4">
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                            <div>
                                <label for="query" class="block text-sm font-medium text-gray-700">Search</label>
                                <input type="text" name="query" id="query" value="{{ request('query') }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            </div>
                            <div>
                                <label for="country" class="block text-sm font-medium text-gray-700">Country</label>
                                <select name="country" id="country" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    <option value="">Select Country</option>
                                </select>
                            </div>
                            <div>
                                <label for="state" class="block text-sm font-medium text-gray-700">State</label>
                                <select name="state" id="state" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    <option value="">Select State</option>
                                </select>
                            </div>
                            <div>
                                <label for="city" class="block text-sm font-medium text-gray-700">City</label>
                                <select name="city" id="city" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    <option value="">Select City</option>
                                </select>
                            </div>
                        </div>
                        <div class="flex justify-end">
                            <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600">
                                Search
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @forelse($users as $user)
                            <div class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition">
                                <div class="flex items-center space-x-4">
                                    <img class="h-12 w-12 rounded-full" src="{{ $user->profile_picture_url }}" alt="{{ $user->name }}">
                                    <div>
                                        <h3 class="text-lg font-semibold text-gray-900">{{ $user->name }}</h3>
                                        <p class="text-sm text-gray-500">
                                            {{ $user->city }}, {{ $user->state }}, {{ $user->country }}
                                        </p>
                                    </div>
                                </div>
                                <div class="mt-4">
                                    <p class="text-sm text-gray-600">{{ $user->bio }}</p>
                                </div>
                                <div class="mt-4 flex space-x-2">
                                    <a href="{{ route('profile.show', $user) }}" 
                                       class="text-sm text-blue-500 hover:text-blue-700">
                                        View Profile
                                    </a>
                                    @if(isset($user->distance))
                                        <span class="text-sm text-gray-500">
                                            {{ number_format($user->distance, 1) }} km away
                                        </span>
                                    @endif
                                </div>
                            </div>
                        @empty
                            <div class="col-span-full text-center py-8">
                                <p class="text-gray-500">No users found.</p>
                            </div>
                        @endforelse
                    </div>
                    <div class="mt-6">
                        {{ $users->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const countrySelect = document.getElementById('country');
            const stateSelect = document.getElementById('state');
            const citySelect = document.getElementById('city');

            // Load countries
            fetch('{{ route("location.countries") }}')
                .then(response => response.json())
                .then(countries => {
                    countries.forEach(country => {
                        const option = document.createElement('option');
                        option.value = country;
                        option.textContent = country;
                        if (country === '{{ request("country") }}') {
                            option.selected = true;
                        }
                        countrySelect.appendChild(option);
                    });
                });

            // Load states when country changes
            countrySelect.addEventListener('change', function() {
                stateSelect.innerHTML = '<option value="">Select State</option>';
                citySelect.innerHTML = '<option value="">Select City</option>';
                
                if (this.value) {
                    fetch(`{{ route("location.states", ":country") }}`.replace(':country', this.value))
                        .then(response => response.json())
                        .then(states => {
                            states.forEach(state => {
                                const option = document.createElement('option');
                                option.value = state;
                                option.textContent = state;
                                if (state === '{{ request("state") }}') {
                                    option.selected = true;
                                }
                                stateSelect.appendChild(option);
                            });
                        });
                }
            });

            // Load cities when state changes
            stateSelect.addEventListener('change', function() {
                citySelect.innerHTML = '<option value="">Select City</option>';
                
                if (this.value) {
                    fetch(`{{ route("location.cities", ":state") }}`.replace(':state', this.value))
                        .then(response => response.json())
                        .then(cities => {
                            cities.forEach(city => {
                                const option = document.createElement('option');
                                option.value = city;
                                option.textContent = city;
                                if (city === '{{ request("city") }}') {
                                    option.selected = true;
                                }
                                citySelect.appendChild(option);
                            });
                        });
                }
            });

            // Trigger change event if country is pre-selected
            if (countrySelect.value) {
                countrySelect.dispatchEvent(new Event('change'));
            }
        });
    </script>
    @endpush
</x-app-layout> 