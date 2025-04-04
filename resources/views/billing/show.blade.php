@extends('layouts.healthcare')

@section('title', 'Bill Details')

@section('header', 'Bill Details #' . $bill->id)

@section('content')
<div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
    <div class="p-6 bg-white border-b border-gray-200">
        <!-- Bill Information -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
            <div class="bg-gray-50 p-4 rounded-lg">
                <h3 class="text-lg font-semibold mb-4">Patient Information</h3>
                <div class="space-y-2">
                    <p><span class="font-medium">Name:</span> {{ $bill->patient->name }}</p>
                    <p><span class="font-medium">Email:</span> {{ $bill->patient->email }}</p>
                    <p><span class="font-medium">Phone:</span> {{ $bill->patient->phone }}</p>
                </div>
            </div>
            <div class="bg-gray-50 p-4 rounded-lg">
                <h3 class="text-lg font-semibold mb-4">Bill Details</h3>
                <div class="space-y-2">
                    <p><span class="font-medium">Amount:</span> ${{ number_format($bill->amount, 2) }}</p>
                    <p><span class="font-medium">Status:</span>
                        @switch($bill->status)
                            @case('paid')
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Paid</span>
                                @break
                            @case('pending')
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">Pending</span>
                                @break
                            @case('overdue')
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">Overdue</span>
                                @break
                            @case('cancelled')
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">Cancelled</span>
                                @break
                        @endswitch
                    </p>
                    <p><span class="font-medium">Due Date:</span> {{ $bill->due_date->format('M d, Y') }}</p>
                    <p><span class="font-medium">Remaining Balance:</span> ${{ number_format($bill->remaining_balance, 2) }}</p>
                </div>
            </div>
        </div>

        <!-- Payment History -->
        <div class="mb-8">
            <h3 class="text-lg font-semibold mb-4">Payment History</h3>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Amount</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Method</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Transaction ID</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($bill->paymentTransactions as $payment)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $payment->payment_date->format('M d, Y H:i') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    ${{ number_format($payment->amount, 2) }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ ucfirst($payment->payment_method) }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $payment->transaction_id }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-4 text-center text-sm text-gray-500">
                                    No payments recorded yet.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Payment Form -->
        @if($bill->status !== 'paid' && $bill->status !== 'cancelled')
            <div id="payment-form" class="bg-gray-50 p-6 rounded-lg">
                <h3 class="text-lg font-semibold mb-4">Make a Payment</h3>
                <form action="{{ route('bills.payment', $bill) }}" method="POST" class="space-y-4">
                    @csrf
                    <div>
                        <label for="amount" class="block text-sm font-medium text-gray-700">Payment Amount</label>
                        <div class="mt-1 relative rounded-md shadow-sm">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <span class="text-gray-500 sm:text-sm">$</span>
                            </div>
                            <input type="number" name="amount" id="amount" step="0.01" max="{{ $bill->remaining_balance }}" class="focus:ring-blue-500 focus:border-blue-500 block w-full pl-7 pr-12 sm:text-sm border-gray-300 rounded-md" placeholder="0.00">
                        </div>
                        <p class="mt-1 text-sm text-gray-500">Maximum amount: ${{ number_format($bill->remaining_balance, 2) }}</p>
                    </div>

                    <div>
                        <label for="payment_method" class="block text-sm font-medium text-gray-700">Payment Method</label>
                        <select name="payment_method" id="payment_method" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md">
                            <option value="credit_card">Credit Card</option>
                            <option value="debit_card">Debit Card</option>
                            <option value="bank_transfer">Bank Transfer</option>
                            <option value="cash">Cash</option>
                        </select>
                    </div>

                    <div class="flex justify-end">
                        <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            Process Payment
                        </button>
                    </div>
                </form>
            </div>
        @endif

        <!-- Back Button -->
        <div class="mt-6 flex justify-end space-x-3">
            @if($bill->status !== 'paid' && $bill->insurance && isset($bill->insurance->coverage_details[$bill->procedure]) && $bill->insurance->coverage_details[$bill->procedure])
                <form action="{{ route('bills.insurance-payment', $bill) }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded-md hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2">
                        Pay with Insurance
                    </button>
                </form>
            @endif
            <a href="{{ route('bills.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded-md hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2">
                Back to Bills
            </a>
        </div>
    </div>
</div>
@endsection
