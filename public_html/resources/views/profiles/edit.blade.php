<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6">Edit Profile</h2>

                    <form method="POST" action="{{ route('profiles.update') }}" enctype="multipart/form-data" class="space-y-6">
                        @csrf
                        @method('PUT')

                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                            <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}"
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            @error('name')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                            <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}"
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            @error('email')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="bio" class="block text-sm font-medium text-gray-700">Bio</label>
                            <textarea name="bio" id="bio" rows="3"
                                      class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">{{ old('bio', $user->bio) }}</textarea>
                            @error('bio')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="location" class="block text-sm font-medium text-gray-700">Location</label>
                            <input type="text" name="location" id="location" value="{{ old('location', $user->location) }}"
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            @error('location')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="skills" class="block text-sm font-medium text-gray-700">Skills</label>
                            <div class="mt-1">
                                <div id="skills-container" class="flex flex-wrap gap-2 mb-2">
                                    @foreach(old('skills', $user->skills ?? []) as $skill)
                                        <span class="skill-tag px-3 py-1 rounded-full text-sm bg-blue-100 text-blue-800">
                                            {{ $skill }}
                                            <button type="button" class="ml-2 text-blue-600 hover:text-blue-800">&times;</button>
                                        </span>
                                    @endforeach
                                </div>
                                <div class="flex">
                                    <input type="text" id="skill-input" 
                                           class="flex-1 rounded-l-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    <button type="button" id="add-skill" 
                                            class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-r-md text-white bg-blue-600 hover:bg-blue-700">
                                        Add
                                    </button>
                                </div>
                                <input type="hidden" name="skills" id="skills-input" 
                                       value="{{ json_encode(old('skills', $user->skills ?? [])) }}">
                            </div>
                            @error('skills')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="interests" class="block text-sm font-medium text-gray-700">Interests</label>
                            <div class="mt-1">
                                <div id="interests-container" class="flex flex-wrap gap-2 mb-2">
                                    @foreach(old('interests', $user->interests ?? []) as $interest)
                                        <span class="interest-tag px-3 py-1 rounded-full text-sm bg-green-100 text-green-800">
                                            {{ $interest }}
                                            <button type="button" class="ml-2 text-green-600 hover:text-green-800">&times;</button>
                                        </span>
                                    @endforeach
                                </div>
                                <div class="flex">
                                    <input type="text" id="interest-input" 
                                           class="flex-1 rounded-l-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    <button type="button" id="add-interest" 
                                            class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-r-md text-white bg-green-600 hover:bg-green-700">
                                        Add
                                    </button>
                                </div>
                                <input type="hidden" name="interests" id="interests-input" 
                                       value="{{ json_encode(old('interests', $user->interests ?? [])) }}">
                            </div>
                            @error('interests')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="company" class="block text-sm font-medium text-gray-700">Company</label>
                            <input type="text" name="company" id="company" value="{{ old('company', $user->company) }}"
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            @error('company')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="website" class="block text-sm font-medium text-gray-700">Website</label>
                            <input type="url" name="website" id="website" value="{{ old('website', $user->website) }}"
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            @error('website')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="linkedin" class="block text-sm font-medium text-gray-700">LinkedIn</label>
                            <input type="url" name="linkedin" id="linkedin" value="{{ old('linkedin', $user->linkedin) }}"
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            @error('linkedin')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="twitter" class="block text-sm font-medium text-gray-700">Twitter</label>
                            <input type="url" name="twitter" id="twitter" value="{{ old('twitter', $user->twitter) }}"
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            @error('twitter')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="profile_image" class="block text-sm font-medium text-gray-700">Profile Image</label>
                            <input type="file" name="profile_image" id="profile_image" accept="image/*"
                                   class="mt-1 block w-full">
                            @error('profile_image')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex items-center justify-end">
                            <button type="submit"
                                    class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700">
                                Save Changes
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        // Skills management
        const skillsContainer = document.getElementById('skills-container');
        const skillInput = document.getElementById('skill-input');
        const skillsInput = document.getElementById('skills-input');
        const addSkillButton = document.getElementById('add-skill');

        function updateSkillsInput() {
            const skills = Array.from(skillsContainer.getElementsByClassName('skill-tag'))
                .map(tag => tag.textContent.trim().slice(0, -1));
            skillsInput.value = JSON.stringify(skills);
        }

        addSkillButton.addEventListener('click', () => {
            const skill = skillInput.value.trim();
            if (skill) {
                const tag = document.createElement('span');
                tag.className = 'skill-tag px-3 py-1 rounded-full text-sm bg-blue-100 text-blue-800';
                tag.innerHTML = `${skill}<button type="button" class="ml-2 text-blue-600 hover:text-blue-800">&times;</button>`;
                skillsContainer.appendChild(tag);
                skillInput.value = '';
                updateSkillsInput();
            }
        });

        skillsContainer.addEventListener('click', (e) => {
            if (e.target.tagName === 'BUTTON') {
                e.target.parentElement.remove();
                updateSkillsInput();
            }
        });

        // Interests management
        const interestsContainer = document.getElementById('interests-container');
        const interestInput = document.getElementById('interest-input');
        const interestsInput = document.getElementById('interests-input');
        const addInterestButton = document.getElementById('add-interest');

        function updateInterestsInput() {
            const interests = Array.from(interestsContainer.getElementsByClassName('interest-tag'))
                .map(tag => tag.textContent.trim().slice(0, -1));
            interestsInput.value = JSON.stringify(interests);
        }

        addInterestButton.addEventListener('click', () => {
            const interest = interestInput.value.trim();
            if (interest) {
                const tag = document.createElement('span');
                tag.className = 'interest-tag px-3 py-1 rounded-full text-sm bg-green-100 text-green-800';
                tag.innerHTML = `${interest}<button type="button" class="ml-2 text-green-600 hover:text-green-800">&times;</button>`;
                interestsContainer.appendChild(tag);
                interestInput.value = '';
                updateInterestsInput();
            }
        });

        interestsContainer.addEventListener('click', (e) => {
            if (e.target.tagName === 'BUTTON') {
                e.target.parentElement.remove();
                updateInterestsInput();
            }
        });
    </script>
    @endpush
</x-app-layout> 