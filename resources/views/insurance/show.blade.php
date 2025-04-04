@extends('layouts.healthcare')

@section('title', 'Insurance Details')

@section('header')
    Insurance Details
@endsection

@section('content')
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 bg-white border-b border-gray-200">
            <!-- Insurance Header -->
            <div class="flex justify-between items-start mb-6">
                <div>
                    <h2 class="text-2xl font-bold text-gray-900">{{ $insurance->provider }}</h2>
                    <p class="text-sm text-gray-500">Policy #{{ $insurance->policy_number }}</p>
                </div>
                <div class="flex space-x-3">
                    <a href="{{ route('insurance.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Back to Insurances
                    </a>
                    <a href="{{ route('insurance.edit', $insurance) }}" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Edit Insurance
                    </a>
                    <form action="{{ route('insurance.destroy', $insurance) }}" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="inline-flex items-center px-4 py-2 border border-red-300 rounded-md shadow-sm text-sm font-medium text-red-700 bg-white hover:bg-red-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500" onclick="return confirm('Are you sure you want to delete this insurance record?')">
                            Delete Insurance
                        </button>
                    </form>
                </div>
            </div>

            <!-- Insurance Details Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                <!-- Patient Information -->
                <div class="bg-gray-50 p-6 rounded-lg">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Patient Information</h3>
                    <div class="flex items-center mb-4">
                        <img class="h-12 w-12 rounded-full" src="https://ui-avatars.com/api/?name={{ urlencode($insurance->patient->user->name) }}" alt="{{ $insurance->patient->user->name }}">
                        <div class="ml-4">
                            <div class="text-sm font-medium text-gray-900">{{ $insurance->patient->user->name }}</div>
                            <div class="text-sm text-gray-500">Patient ID: {{ $insurance->patient->id }}</div>
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-4">

                        <div>
                            <dt class="text-sm font-medium text-gray-500">Contact</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $insurance->patient->phone }}</dd>
                        </div>
                    </div>
                </div>

                <!-- Insurance Status -->
                <div class="bg-gray-50 p-6 rounded-lg">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Coverage Status</h3>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Start Date</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $insurance->start_date->format('M d, Y') }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">End Date</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $insurance->end_date->format('M d, Y') }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Coverage Percentage</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $insurance->coverage_percentage }}%</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Status</dt>
                            <dd class="mt-1">
                                @php
                                    $now = now();
                                    $status = $now->between($insurance->start_date, $insurance->end_date) ? 'active' : ($now->lt($insurance->start_date) ? 'pending' : 'expired');
                                    $statusClasses = [
                                        'active' => 'bg-green-100 text-green-800',
                                        'pending' => 'bg-yellow-100 text-yellow-800',
                                        'expired' => 'bg-red-100 text-red-800',
                                    ][$status];
                                @endphp
                                <span class="px-2 py-1 text-sm font-semibold rounded-full {{ $statusClasses }}">
                                    {{ ucfirst($status) }}
                                </span>
                            </dd>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Coverage Details -->
            <div class="mb-8">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Coverage Details</h3>
                <div class="bg-gray-50 p-6 rounded-lg">
                    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                        @foreach($insurance->coverage_details ?? [] as $service => $covered)
                            <div class="flex items-center">
                                @if($covered)
                                    <svg class="h-5 w-5 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                @else
                                    <svg class="h-5 w-5 text-red-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                @endif
                                <span class="text-sm text-gray-700">{{ ucwords(str_replace('_', ' ', $service)) }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Related Bills -->
            <div>
                <h3 class="text-lg font-medium text-gray-900 mb-4">Related Bills</h3>
                <div class="bg-white shadow overflow-hidden sm:rounded-md">
                    <ul role="list" class="divide-y divide-gray-200">
                        @forelse($insurance->bills as $bill)
                            <li>
                                <a href="{{ route('bills.show', $bill) }}" class="block hover:bg-gray-50">
                                    <div class="px-4 py-4 sm:px-6">
                                        <div class="flex items-center justify-between">
                                            <div class="truncate">
                                                <div class="flex text-sm">
                                                    <p class="font-medium text-blue-600 truncate">Bill #{{ $bill->id }}</p>
                                                    <p class="ml-1 flex-shrink-0 font-normal text-gray-500">
                                                        {{ $bill->created_at->format('M d, Y') }}
                                                    </p>
                                                </div>
                                            </div>
                                            <div class="ml-2 flex-shrink-0 flex">
                                                <p class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $bill->status === 'paid' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                                    {{ ucfirst($bill->status) }}
                                                </p>
                                            </div>
                                        </div>
                                        <div class="mt-2 sm:flex sm:justify-between">
                                            <div class="sm:flex">
                                                <p class="flex items-center text-sm text-gray-500">
                                                    Amount: ${{ number_format($bill->amount, 2) }}
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </li>
                        @empty
                            <li class="px-4 py-4 sm:px-6 text-sm text-gray-500">
                                No bills found for this insurance policy.
                            </li>
                        @endforelse
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection
