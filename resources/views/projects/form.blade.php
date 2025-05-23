<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ isset($project) ? __('Edit Project') : __('Create New Project') }}
            </h2>
            <a href="{{ route('projects.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700">
                {{ __('Back to Projects') }}
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form method="POST" action="{{ isset($project) ? route('projects.update', $project) : route('projects.store') }}" class="space-y-6">
                        @csrf
                        @if(isset($project))
                            @method('PATCH')
                        @endif

                        <!-- Project Title -->
                        <div>
                            <x-input-label for="title" :value="__('Project Title')" />
                            <x-text-input id="title" name="title" type="text" class="mt-1 block w-full" 
                                :value="old('title', $project->title ?? '')" required autofocus />
                            <x-input-error class="mt-2" :messages="$errors->get('title')" />
                        </div>

                        <!-- Project Description -->
                        <div>
                            <x-input-label for="description" :value="__('Project Description')" />
                            <x-textarea id="description" name="description" class="mt-1 block w-full" rows="5" required>{{ trim(old('description', $project->description ?? '')) }}</x-textarea>
                            <x-input-error class="mt-2" :messages="$errors->get('description')" />
                        </div>

                        <!-- Required Skills -->
                        <div>
                            <x-input-label for="skills_required" :value="__('Required Skills')" />
                            <div class="mt-1">
                                <div class="relative">
                                    <select name="skills_required[]" id="skills_required" multiple 
                                        class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                        <option value="" disabled>Select skills</option>
                                        @foreach($skills as $skill)
                                            <option value="{{ $skill->name }}" 
                                                {{ isset($project) && in_array($skill->name, $project->skills_required ?? []) ? 'selected' : '' }}>
                                                {{ $skill->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <p class="mt-1 text-sm text-gray-500">Hold Ctrl (Windows) or Command (Mac) to select multiple skills</p>
                                <x-input-error :messages="$errors->get('skills_required')" class="mt-2" />
                            </div>
                        </div>

                        <!-- Project Status -->
                        <div>
                            <x-input-label for="status" :value="__('Project Status')" />
                            <select name="status" id="status" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                                <option value="">{{ __('Select a status') }}</option>
                                <option value="active" {{ old('status', $project->status ?? '') === 'active' ? 'selected' : '' }}>
                                    {{ __('Active') }}
                                </option>
                                <option value="completed" {{ old('status', $project->status ?? '') === 'completed' ? 'selected' : '' }}>
                                    {{ __('Completed') }}
                                </option>
                                <option value="on_hold" {{ old('status', $project->status ?? '') === 'on_hold' ? 'selected' : '' }}>
                                    {{ __('On Hold') }}
                                </option>
                            </select>
                            <x-input-error class="mt-2" :messages="$errors->get('status')" />
                        </div>

                        <!-- Project Timeline -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Start Date -->
                            <div>
                                <x-input-label for="start_date" :value="__('Start Date')" />
                                <x-text-input id="start_date" name="start_date" type="date" class="mt-1 block w-full" 
                                    :value="old('start_date', isset($project) ? $project->start_date?->format('Y-m-d') : '')" required />
                                <x-input-error class="mt-2" :messages="$errors->get('start_date')" />
                            </div>

                            <!-- End Date -->
                            <div>
                                <x-input-label for="end_date" :value="__('End Date')" />
                                <x-text-input id="end_date" name="end_date" type="date" class="mt-1 block w-full" 
                                    :value="old('end_date', isset($project) ? $project->end_date?->format('Y-m-d') : '')" required />
                                <x-input-error class="mt-2" :messages="$errors->get('end_date')" />
                            </div>
                        </div>

                        <div class="flex items-center justify-end">
                            <x-primary-button>
                                {{ isset($project) ? __('Update Project') : __('Create Project') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        // Add some styling to make the select look better
        document.addEventListener('DOMContentLoaded', function() {
            const select = document.getElementById('skills_required');
            if (select) {
                select.style.height = 'auto';
                select.style.minHeight = '100px';
                select.style.padding = '0.5rem';
            }
        });
    </script>
    @endpush
</x-app-layout> 