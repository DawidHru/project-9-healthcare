@extends('layouts.healthcare')

@section('title', 'Billing Report')

@section('header', 'Billing Report')

@section('content')
<div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
    <div class="p-6 bg-white border-b border-gray-200">
        <!-- Summary Cards -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
            <div class="bg-blue-50 p-4 rounded-lg">
                <h3 class="text-sm font-medium text-blue-800">Total Revenue</h3>
                <p class="mt-2 text-2xl font-semibold text-blue-900">${{ number_format($totalRevenue, 2) }}</p>
            </div>
            <div class="bg-green-50 p-4 rounded-lg">
                <h3 class="text-sm font-medium text-green-800">Paid Bills</h3>
                <p class="mt-2 text-2xl font-semibold text-green-900">{{ $paidBills }}</p>
            </div>
            <div class="bg-yellow-50 p-4 rounded-lg">
                <h3 class="text-sm font-medium text-yellow-800">Pending Bills</h3>
                <p class="mt-2 text-2xl font-semibold text-yellow-900">{{ $pendingBills }}</p>
            </div>
            <div class="bg-red-50 p-4 rounded-lg">
                <h3 class="text-sm font-medium text-red-800">Overdue Bills</h3>
                <p class="mt-2 text-2xl font-semibold text-red-900">{{ $overdueBills }}</p>
            </div>
        </div>

        <!-- Revenue Chart -->
        <div class="mb-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Revenue Over Time</h3>
            <div class="bg-white p-4 rounded-lg border border-gray-200">
                <canvas id="revenueChart"></canvas>
            </div>
        </div>

        <!-- Recent Bills Table -->
        <div>
            <h3 class="text-lg font-medium text-gray-900 mb-4">Recent Bills</h3>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Patient</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Amount</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Due Date</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($recentBills as $bill)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                    {{ $bill->patient->name }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    ${{ number_format($bill->amount, 2) }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                        @if($bill->status === 'paid') bg-green-100 text-green-800
                                        @elseif($bill->status === 'pending') bg-yellow-100 text-yellow-800
                                        @elseif($bill->status === 'overdue') bg-red-100 text-red-800
                                        @else bg-gray-100 text-gray-800 @endif">
                                        {{ ucfirst($bill->status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $bill->due_date->format('M d, Y') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <a href="{{ route('bills.show', $bill) }}" class="text-blue-600 hover:text-blue-900">View</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Revenue Chart
    const ctx = document.getElementById('revenueChart').getContext('2d');
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: {!! json_encode($revenueData->pluck('month')) !!},
            datasets: [{
                label: 'Revenue',
                data: {!! json_encode($revenueData->pluck('amount')) !!},
                borderColor: 'rgb(59, 130, 246)',
                tension: 0.1
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return '$' + value;
                        }
                    }
                }
            }
        }
    });
</script>
@endpush
@endsection
