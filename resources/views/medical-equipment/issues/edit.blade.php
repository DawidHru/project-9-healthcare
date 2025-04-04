@extends('layouts.app')

@section('title', 'Edit Equipment Issue')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-white">Edit Issue #{{ $issue->id }}</h1>
        <a href="{{ route('equipment-issues.show', $issue) }}" class="text-white hover:text-gray-600">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </a>
    </div>

    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
            <h2 class="text-lg font-medium text-gray-700">Edit Issue Details</h2>
        </div>
        
        <div class="p-6">
            <form action="{{ route('equipment-issues.update', $issue) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                <div class="space-y-6">
                    <div>
                        <label for="severity" class="block text-sm font-medium text-gray-700">Severity*</label>
                        <select name="severity" id="severity" required class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                            <option value="low" {{ $issue->severity == 'low' ? 'selected' : '' }}>Low</option>
                            <option value="medium" {{ $issue->severity == 'medium' ? 'selected' : '' }}>Medium</option>
                            <option value="high" {{ $issue->severity == 'high' ? 'selected' : '' }}>High</option>
                            <option value="critical" {{ $issue->severity == 'critical' ? 'selected' : '' }}>Critical</option>
                        </select>
                    </div>
                    
                    <div>
                        <label for="description" class="block text-sm font-medium text-gray-700">Description*</label>
                        <textarea name="description" id="description" rows="5" required class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500">{{ old('description', $issue->description) }}</textarea>
                    </div>
                </div>
                
                <div class="mt-6 flex justify-end">
                    <a href="{{ route('equipment-issues.show', $issue) }}" class="bg-white py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Cancel
                    </a>
                    <button type="submit" class="ml-3 inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Update Issue
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection