@extends('layouts.healthcare')

@section('title', 'Insurance Management')

@section('header', 'Insurance Management')

@section('content')
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 bg-white border-b border-gray-200">
            <!-- Header with Create Button -->
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-lg font-medium text-gray-900">Insurance Records</h2>
                <a href="{{ route('insurance.create') }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    Add New Insurance
                </a>
            </div>

            <!-- Insurance Records Table -->
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Provider</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Policy Number</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Patient</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Coverage</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($insurances as $insurance)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                    {{ $insurance->provider }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $insurance->policy_number }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $insurance->patient->user->name }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $insurance->coverage_percentage }}%
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                        @if($insurance->end_date->isFuture()) bg-green-100 text-green-800
                                        @elseif($insurance->end_date->diffInDays(now()) <= 30) bg-yellow-100 text-yellow-800
                                        @else bg-red-100 text-red-800 @endif">
                                        {{ $insurance->end_date->isFuture() ? 'Active' : 'Expired' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <div class="flex space-x-3">
                                        <a href="{{ route('insurance.show', $insurance) }}" class="text-blue-600 hover:text-blue-900">View</a>
                                        <a href="{{ route('insurance.edit', $insurance) }}" class="text-indigo-600 hover:text-indigo-900">Edit</a>
                                        <form action="{{ route('insurance.destroy', $insurance) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('Are you sure you want to delete this insurance record?')">
                                                Delete
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">
                                    No insurance records found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="mt-4">
                {{ $insurances->links() }}
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    // Add any JavaScript for filtering functionality here
    document.addEventListener('DOMContentLoaded', function() {
        // Status filter
        const statusFilter = document.getElementById('status-filter');
        statusFilter.addEventListener('change', function() {
            // Add filter logic here
        });

        // Provider filter
        const providerFilter = document.getElementById('provider-filter');
        providerFilter.addEventListener('input', function() {
            // Add filter logic here
        });

        // Date filter
        const dateFilter = document.getElementById('date-filter');
        dateFilter.addEventListener('change', function() {
            // Add filter logic here
        });
    });
</script>
@endpush
