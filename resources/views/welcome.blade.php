
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Healthcare Homepage</title>
</head>
<body>
    <h1>Welcome to the Healthcare System</h1>
    <ul>
        <li><a href="{{ route('dashboard') }}">Dashboard</a></li>
        <li><a href="{{ route('profile.edit') }}">Edit Profile</a></li>
        <li><a href="{{ route('appointments.index') }}">View Appointments</a></li>
        <li><a href="{{ route('appointments.create') }}">Schedule Appointment</a></li>
        <li><a href="{{ route('appointments.manage') }}">Manage Appointments</a></li>
        <li><a href="{{ route('vaccinations.index') }}">Vaccinations</a></li>
        <li><a href="{{ route('vaccinations.create') }}">Create Vaccination</a></li>
        <li><a href="{{ route('lab-results.index') }}">Lab Results</a></li>
        <li><a href="{{ route('inventory_items.index') }}">Inventory Items</a></li>
        <li><a href="{{ route('supplies.index') }}">Supplies</a></li>
    </ul>
</body>
</html>