<x-base>
<div class="container">
    <h1 style="margin-top: 20px">Schedules per department</h1>
    <a href="schedules/create" class="btn btn-primary mb-3" style="width: 200px;">Add a schedule</a>
    <h4>Here we can look at the schedules of each department</h4>
    <br></br>
</div>

<div class="container">
    <table id="scheduleTable" class="table table-bordered">
        <thead>
            <tr>
                <th>Department</th>
                <th>Work days</th>
                <th>Schedule</th>
                <th>Actions</th>
            </tr>
        </thead>

        <tbody>
            @foreach ($schedules as $schedule)
                <tr>
                    <td>{{ $schedule->department->name}}</td>
                    <td>{{ $schedule->department->work_days}}</td>
                    <td>{{ $schedule->start_time }} - {{ $schedule->end_time }}</td>
                    <td>
                        <a href="schedules/{{$schedule->id}}">show more</a>
                        <a href="schedules/edit/{{$schedule->id}}/">edit</a>
                        <form action="schedules/{{$schedule->id}}/destroy" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-link">delete</button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
</x-base>