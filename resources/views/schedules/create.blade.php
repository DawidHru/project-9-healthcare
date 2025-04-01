<x-base>
        <div class="container">
            <h1 style="margin-top: 20px">Add a department's schedule</h1>
            <form action="{{ route('schedules.store') }}" method="POST" class="container mt-5 mb-9">
                @csrf
                <div class="mb-3">
                    <label for="start_time" class="form-label">Start time </label>
                    <input type="time" name="start_time" id="start_time" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label for="end_time" class="form-label">End time </label>
                    <input type="time" name="end_time" id="end_time" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label for="department_id" class="form-label">Department</label>
                    <select id="department_id" name="department_id" class="form-control" required>
                        @foreach ($departments as $department)
                            <option value="{{ $department->id }}">{{ $department->name }}</option>
                        @endforeach
                    </select>
                </div>

                <button type="submit" class="btn btn-success" style="margin-bottom: 20px">Create Schedule</button>
            </form> 
        </div>

        @if ($errors->any())
            <div>
                <h1>
                    @foreach ($errors->all() as $error)
                        <li>{{ strtoupper($error) }}</li>
                    @endforeach
                </h1>
            </div>
        @endif
    </x-base>
