<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Post New Job
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">

            @if ($errors->any())
                <div class="mb-4 p-4 bg-red-100 text-red-700 rounded">
                    <ul class="list-disc ml-5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="bg-white shadow rounded p-6">
                <form method="POST" action="{{ route('employer.jobs.store') }}">
                    @csrf

                    <div class="mb-4">
                        <label class="block font-medium">Job Title</label>
                        <input type="text" name="title" value="{{ old('title') }}" class="w-full rounded border-gray-300" required>
                    </div>

                    <div class="mb-4">
                        <label class="block font-medium">Category</label>
                        <select name="job_category_id" class="w-full rounded border-gray-300">
                            <option value="">-- Select Category --</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}" @selected(old('job_category_id') == $category->id)>
                                    {{ $category->category_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-4">
                        <label class="block font-medium">Description</label>
                        <textarea name="description" rows="4" class="w-full rounded border-gray-300" required>{{ old('description') }}</textarea>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div class="mb-4">
                            <label class="block font-medium">Daily Wage</label>
                            <input type="number" step="0.01" name="daily_wage" value="{{ old('daily_wage') }}" class="w-full rounded border-gray-300" required>
                        </div>

                        <div class="mb-4">
                            <label class="block font-medium">Vacancies</label>
                            <input type="number" name="vacancies" value="{{ old('vacancies', 1) }}" class="w-full rounded border-gray-300" required>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="block font-medium">Location</label>
                        <input type="text" name="location" value="{{ old('location') }}" class="w-full rounded border-gray-300">
                    </div>

                    <div class="mb-4">
                        <label class="block font-medium">Deadline</label>
                        <input type="date" name="deadline" value="{{ old('deadline') }}" class="w-full rounded border-gray-300">
                    </div>

                    <div class="mb-4">
                        <label class="block font-medium mb-2">Required Skills</label>

                        <div class="grid grid-cols-2 gap-2">
                            @foreach ($skills as $skill)
                                <label class="flex items-center gap-2">
                                    <input
                                        type="checkbox"
                                        name="skill_ids[]"
                                        value="{{ $skill->id }}"
                                        @checked(in_array($skill->id, old('skill_ids', [])))
                                    >
                                    <span>{{ $skill->skill_name }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>

                    <div class="flex justify-between">
                        <a href="{{ route('employer.dashboard') }}" class="px-4 py-2 bg-gray-500 text-white rounded">
                            Cancel
                        </a>

                        <button class="px-4 py-2 bg-blue-600 text-white rounded">
                            Save Job Post
                        </button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</x-app-layout>