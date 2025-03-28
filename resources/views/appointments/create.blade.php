<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <style>
        .container {
            max-width: 600px;
            margin: 40px auto;
            padding: 20px;
            background: white;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
            font-family: Arial;
        }
        h1 {
            text-align: center;
            font-size: 24px;
            color: #333;
        }
        a {
            display: inline-block;
            margin-bottom: 15px;
            text-decoration: none;
            color: #007bff;
            font-weight: bold;
        }
        form {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }
        label {
            font-weight: bold;
        }
        select, input, textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        button {
            padding: 10px;
            background: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: 0.3s;
        }
        button:hover {
            background: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <a href="{{ route('appointments.index') }}">&larr; Back</a>
        <h1>Create New Appointment</h1>
        <form action="{{ route('appointments.store') }}" method="POST">
            @csrf

            <label for="doctor_id">Select Doctor:</label>
            <select name="doctor_id" id="doctor_id" required>
                @foreach ($doctors as $doctor)
                <option value="{{ $doctor->id }}">{{ $doctor->user->name }}</option>
                @endforeach
            </select>

            <label for="scheduled_time">Scheduled Time:</label>
            <input type="datetime-local" name="scheduled_time" id="scheduled_time" required>

            <label for="reason">Reason for Appointment:</label>
            <textarea name="reason" id="reason" required></textarea>

            <button type="submit">Schedule</button>
        </form>
    </div>
</body>
</html>
