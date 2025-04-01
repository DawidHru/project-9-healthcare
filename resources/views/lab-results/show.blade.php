<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lab Result Details</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <div class="container mx-auto px-4 py-8">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Lab Result Details</h1>
            <div>
                <a href="{{ route('lab-results.edit', $labResult) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mr-2">
                    Edit Result
                </a>
                <a href="{{ route('lab-results.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                    Back to List
                </a>
            </div>
        </div>

        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif

        <div class="bg-white rounded-lg shadow overflow-hidden mb-6">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-xl font-semibold text-gray-800">Current Result</h2>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Basic Information</h3>
                        <dl class="grid grid-cols-1 gap-4">
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Patient</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $labResult->patient->user->name }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Doctor</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $labResult->doctor->user->name }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Lab Technician</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $labResult->labTechnician->staff->user->name }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Test Date</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $labResult->test_date->format('Y-m-d') }}</dd>
                            </div>
                        </dl>
                    </div>
                    <div>
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Test Details</h3>
                        <dl class="grid grid-cols-1 gap-4">
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Test Name</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $labResult->test_name }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Category</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $labResult->test_category }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Result Value</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $labResult->result_value ?: 'Not Available' }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Reference Range</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $labResult->reference_range ?: 'Not Available' }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Status</dt>
                                <dd class="mt-1">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                        {{ $labResult->status === 'completed' ? 'bg-green-100 text-green-800' :
                                           ($labResult->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 'bg-blue-100 text-blue-800') }}">
                                        {{ ucfirst($labResult->status) }}
                                    </span>
                                </dd>
                            </div>
                        </dl>
                    </div>
                </div>
            </div>
        </div>

        <!-- Previous Results Comparison -->
        <div class="bg-white rounded-lg shadow overflow-hidden mb-6">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-xl font-semibold text-gray-800">Previous Results Comparison</h2>
            </div>
            <div class="p-6">
                @if($previousResults->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Result Value</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Reference Range</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Change</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($previousResults as $result)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $result->test_date->format('Y-m-d') }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $result->result_value ?: 'Not Available' }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $result->reference_range ?: 'Not Available' }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                                {{ $result->status === 'completed' ? 'bg-green-100 text-green-800' :
                                                   ($result->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 'bg-blue-100 text-blue-800') }}">
                                                {{ ucfirst($result->status) }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                                            @php
                                                $currentValue = floatval($labResult->result_value);
                                                $previousValue = floatval($result->result_value);
                                                $change = $currentValue - $previousValue;

                                                // Handle division by zero and invalid numeric values
                                                if ($previousValue != 0 && is_numeric($currentValue) && is_numeric($previousValue)) {
                                                    $changePercentage = ($change / $previousValue) * 100;
                                                    $displayChange = number_format($changePercentage, 1) . '%';
                                                } else {
                                                    $displayChange = 'N/A';
                                                }
                                            @endphp
                                            <span class="{{ $change > 0 ? 'text-red-600' : ($change < 0 ? 'text-green-600' : 'text-gray-600') }}">
                                                {{ $change > 0 ? '+' : '' }}{{ $displayChange }}
                                            </span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <p class="text-gray-500">No previous results found for this test.</p>
                @endif
            </div>
        </div>
    </div>
</body>
</html>
