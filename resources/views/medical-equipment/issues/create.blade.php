@extends('layouts.app')

@section('title', 'Report Equipment Issue')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
            <h2 class="text-lg font-medium text-gray-700">Report Issue for {{ $equipment->name }}</h2>
        </div>
        
        <div class="p-6">
            <form action="{{ route('equipment-issues.store', $equipment) }}" method="POST" enctype="multipart/form-data">
                @csrf
                
                <div class="space-y-6">
                    <input type="hidden" name="reported_by" value="1">
                    <div>
                        <label for="severity" class="block text-sm font-medium text-gray-700">Severity*</label>
                        <select name="severity" id="severity" required class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                            <option value="">Select Severity</option>
                            <option value="low">Low</option>
                            <option value="medium">Medium</option>
                            <option value="high">High</option>
                            <option value="critical">Critical</option>
                        </select>
                    </div>
                    
                    <div>
                        <label for="description" class="block text-sm font-medium text-gray-700">Description*</label>
                        <textarea name="description" id="description" rows="5" required class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500"></textarea>
                    </div>
                </div>
                
                <div class="mt-6 flex justify-end">
                    {{-- @dd($equipment) --}}
                    <a href="{{ route('medical-equipment.show', $equipment) }}" class="bg-white py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Cancel
                    </a>
                    <button type="submit" class="ml-3 inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                        Report Issue
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection