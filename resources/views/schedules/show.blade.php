{{-- <x-base> --}}
    <div class="container">
        <h1>Schedule Details</h1>
        <a href="{{ route('schedules.index') }}" style="width: 150px;">Back to Schedules</a>
        <table class="table table-bordered" style="width: 100%; margin: 0 auto;">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Start Time</th>
                    <th>End Time</th>
                    <th style="width:320px;">Actions</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>{{ $schedule->date }}</td>
                    <td>{{ $schedule->start_time }}</td>
                    <td>{{ $schedule->end_time }}</td>
                    <td>
                        <div style="display: flex; justify-content: space-between; gap: 20px;">
                            <a href="{{ route('schedules.edit', $schedule->id) }}" style="width: 150px">Edit</a>
                            <form action="{{ route('schedules.destroy', $schedule->id) }}" method="POST" style="display: inline"; onsubmit="return confirmDelete();">
                                @csrf
                                @method('DELETE')
                                <button type="submit" style="width: 150px;">Delete</button>
                            </form>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
{{-- </x-base> --}}

<script>
    function confirmDelete() {
        return confirm('Are you sure you want to get rid of this shift?');}
</script>