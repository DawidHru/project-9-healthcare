<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Lab Result</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <div class="container mx-auto px-4 py-8">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Edit Lab Result</h1>
            <a href="{{ route('lab-results.index') }}" class="text-gray-600 hover:text-gray-800">Back to List</a>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <form method="POST" action="{{ route('lab-results.update', $labResult) }}">
                @csrf
                @method('PUT')

                <div class="mb-4">
                    <label for="patient_id" class="block text-gray-700 text-sm font-bold mb-2">Patient</label>
                    <select name="patient_id" id="patient_id" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                        @foreach($patients as $patient)
                            <option value="{{ $patient->id }}" {{ $labResult->patient_id == $patient->id ? 'selected' : '' }}>
                                {{ $patient->user->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-4">
                    <label for="doctor_id" class="block text-gray-700 text-sm font-bold mb-2">Doctor</label>
                    <select name="doctor_id" id="doctor_id" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                        @foreach($doctors as $doctor)
                            <option value="{{ $doctor->id }}" {{ $labResult->doctor_id == $doctor->id ? 'selected' : '' }}>
                                {{ $doctor->user->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-4">
                    <label for="lab_technician_id" class="block text-gray-700 text-sm font-bold mb-2">Lab Technician</label>
                    <select name="lab_technician_id" id="lab_technician_id" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                        @foreach($labTechnicians as $technician)
                            <option value="{{ $technician->id }}" {{ $labResult->lab_technician_id == $technician->id ? 'selected' : '' }}>
                                {{ $technician->staff->user->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-4">
                    <label for="test_name" class="block text-gray-700 text-sm font-bold mb-2">Test Name</label>
                    <input type="text" name="test_name" id="test_name" value="{{ old('test_name', $labResult->test_name) }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                </div>

                <div class="mb-4">
                    <label for="test_category" class="block text-gray-700 text-sm font-bold mb-2">Test Category</label>
                    <input type="text" name="test_category" id="test_category" value="{{ old('test_category', $labResult->test_category) }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                </div>

                <div class="mb-4">
                    <label for="result_value" class="block text-gray-700 text-sm font-bold mb-2">Result Value</label>
                    <textarea name="result_value" id="result_value" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">{{ old('result_value', $labResult->result_value) }}</textarea>
                </div>

                <div class="mb-4">
                    <label for="reference_range" class="block text-gray-700 text-sm font-bold mb-2">Reference Range</label>
                    <input type="text" name="reference_range" id="reference_range" value="{{ old('reference_range', $labResult->reference_range) }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                </div>

                <div class="mb-4">
                    <label for="test_date" class="block text-gray-700 text-sm font-bold mb-2">Test Date</label>
                    <input type="date" name="test_date" id="test_date" value="{{ old('test_date', $labResult->test_date->format('Y-m-d')) }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                </div>

                <div class="mb-4">
                    <label for="status" class="block text-gray-700 text-sm font-bold mb-2">Status</label>
                    <select name="status" id="status" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                        <option value="pending" {{ $labResult->status === 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="completed" {{ $labResult->status === 'completed' ? 'selected' : '' }}>Completed</option>
                        <option value="reviewed" {{ $labResult->status === 'reviewed' ? 'selected' : '' }}>Reviewed</option>
                    </select>
                </div>

                <div class="mb-4">
                    <label class="flex items-center">
                        <input type="checkbox" name="is_abnormal" value="1" {{ old('is_abnormal', $labResult->is_abnormal) ? 'checked' : '' }} class="form-checkbox h-4 w-4 text-blue-600">
                        <span class="ml-2 text-gray-700">Abnormal Result</span>
                    </label>
                </div>

                <div class="mb-4">
                    <label for="doctor_notes" class="block text-gray-700 text-sm font-bold mb-2">Doctor's Notes</label>
                    <textarea name="doctor_notes" id="doctor_notes" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">{{ old('doctor_notes', $labResult->doctor_notes) }}</textarea>
                </div>

                <div class="flex items-center justify-between">
                    <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                        Update Lab Result
                    </button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
