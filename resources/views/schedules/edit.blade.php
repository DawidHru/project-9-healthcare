{{-- <x-base> --}}
    <div class="container">
        <h1 style="margin-top: 20px">Update Schedule</h1>
        <form action="{{ route('schedules.update', $schedule->id) }}" method="POST" class="container mt-5 mb-9">
            @csrf
            
            <div class="mb-3">
                <label for="start_time" class="form-label">Start time</label>
                <input type="time" name="start_time" id="start_time" class="form-control" 
                       value="{{ \Carbon\Carbon::parse($schedule->start_time)->format('H:i') }}" required>
            </div>

            <div class="mb-3">
                <label for="end_time" class="form-label">End time</label>
                <input type="time" name="end_time" id="end_time" class="form-control" 
                       value="{{ \Carbon\Carbon::parse($schedule->end_time)->format('H:i') }}" required>
            </div>

            <div class="mb-3">
                <label for="department_id" class="form-label">Department</label>
                <select id="department_id" name="department_id" class="form-control" required>
                    @foreach ($departments as $department)
                        <option value="{{ $department->id }}" 
                            {{ $schedule->department_id == $department->id ? 'selected' : '' }}>
                            {{ $department->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <button type="submit" class="btn btn-success" style="margin-bottom: 20px">Update Schedule</button>
        </form>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
{{-- </x-base> --}}