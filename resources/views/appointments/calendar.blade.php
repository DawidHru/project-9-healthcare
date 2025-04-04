<!DOCTYPE html>
<html>
<head>
    <title>Doctor's Appointment Calendar</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.css' rel='stylesheet' />
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js'></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            background-color: #f3f4f6;
            margin: 0;
            padding: 0;
        }
        .calendar-container {
            padding: 1rem;
            max-width: 1400px; /* Increased width */
            margin: 0 auto;
        }
        .header-section {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
            background: white;
            padding: 1.5rem;
            border-radius: 0.5rem;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }
        .doctor-select {
            padding: 0.5rem 1rem;
            border-radius: 0.375rem;
            border: 1px solid #e5e7eb;
            font-size: 0.875rem;
            color: #374151;
            background-color: white;
            transition: border-color 0.15s ease-in-out;
        }
        .doctor-select:focus {
            outline: none;
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }
        .appointment-details {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background: white;
            padding: 2rem;
            border-radius: 0.5rem;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            z-index: 1000;
            max-width: 600px;
            width: 90%;
            max-height: 80vh;
            overflow-y: auto;
        }
        .appointment-list {
            margin-top: 1.5rem;
        }
        .appointment-item {
            padding: 1rem;
            border-bottom: 1px solid #e5e7eb;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .appointment-item:last-child {
            border-bottom: none;
        }
        .appointment-actions {
            display: flex;
            gap: 0.5rem;
        }
        .btn {
            padding: 0.5rem 1rem;
            border: none;
            border-radius: 0.375rem;
            cursor: pointer;
            font-weight: 500;
            font-size: 0.875rem;
            transition: all 0.15s ease-in-out;
        }
        .btn-approve {
            background: #10b981;
            color: white;
        }
        .btn-approve:hover {
            background: #059669;
        }
        .btn-reschedule {
            background: #3b82f6;
            color: white;
        }
        .btn-reschedule:hover {
            background: #2563eb;
        }
        .btn-cancel {
            background: #ef4444;
            color: white;
        }
        .btn-cancel:hover {
            background: #dc2626;
        }
        .overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.5);
            z-index: 999;
        }
        .legend {
            display: flex;
            gap: 1.5rem;
            margin: 1.5rem 0;
            padding: 1rem;
            background: white;
            border-radius: 0.5rem;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }
        .legend-item {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.875rem;
            color: #374151;
        }
        .legend-color {
            width: 1rem;
            height: 1rem;
            border-radius: 0.25rem;
        }
        #calendar {
            background: white;
            padding: 1rem;
            border-radius: 0.5rem;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            width: 100%; /* Ensure it takes full width of the container */
        }
        .fc {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
        }
        .fc-button {
            background-color: white !important;
            border: 1px solid #e5e7eb !important;
            color: #374151 !important;
            padding: 0.5rem 1rem !important;
            border-radius: 0.375rem !important;
            font-weight: 500 !important;
            transition: all 0.15s ease-in-out !important;
            font-size: 0.875rem !important;
            margin: 0 0.25rem !important;
        }
        .fc-button:hover {
            background-color: white !important;
            border-color: #3b82f6 !important;
            color: #3b82f6 !important;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1) !important;
        }
        .fc-button-active {
            background-color: #3b82f6 !important;
            border-color: #3b82f6 !important;
            color: white !important;
        }
        .fc-button-active:hover {
            background-color: #2563eb !important;
            border-color: #2563eb !important;
            color: white !important;
            box-shadow: none !important;
        }
        .fc-button-primary:not(:disabled).fc-button-active,
        .fc-button-primary:not(:disabled):active {
            background-color: #3b82f6 !important;
            border-color: #3b82f6 !important;
        }
        .fc-button-primary:disabled {
            opacity: 0.5 !important;
            cursor: not-allowed !important;
        }
        .fc-button-group {
            margin: 0 0.25rem !important;
        }
        .fc-event {
            border-radius: 0.25rem;
            padding: 0.25rem;
            font-size: 0.875rem;
        }
        .fc-toolbar-title {
            font-size: 1.25rem !important;
            font-weight: 600 !important;
            color: #111827 !important;
        }
        .fc-day-today {
            background-color: #eff6ff !important;
        }
        .fc-highlight {
            background-color: #dbeafe !important;
        }
    </style>
</head>

<body>
    <div class="calendar-container">
        <div class="header-section">
            <div class="flex items-center space-x-4">
                <a href="{{ route('appointments.index') }}" class="text-blue-500 hover:text-blue-700 flex items-center">
                    <span class="ml-2">Back to List</span>
                </a>
                <h1 class="text-2xl font-bold text-gray-900">Doctor's Appointment Calendar</h1>
            </div>
            <div class="flex items-center space-x-4">
                <select id="doctorSelect" class="doctor-select" onchange="updateCalendar()">
                    <option value="">All Doctors</option>
                    @foreach ($doctors as $doctor)
                        <option value="{{ $doctor->id }}">{{ $doctor->user->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="legend">
            <div class="legend-item">
                <div class="legend-color" style="background: #FFA500;"></div>
                <span>Pending</span>
            </div>
            <div class="legend-item">
                <div class="legend-color" style="background: #4CAF50;"></div>
                <span>Confirmed</span>
            </div>
            <div class="legend-item">
                <div class="legend-color" style="background: #f44336;"></div>
                <span>Cancelled</span>
            </div>
        </div>

        <div id="calendar"></div>
    </div>

    <div class="overlay" id="overlay"></div>
    <div class="appointment-details" id="appointmentDetails">
        <h2 class="text-xl font-semibold text-gray-900 mb-4">Appointments for <span id="selectedDate"></span></h2>
        <div class="appointment-list" id="appointmentList">
            <!-- Appointments will be loaded here -->
        </div>
        <button class="btn bg-gray-500 hover:bg-gray-600 text-white mt-4" onclick="closeAppointmentDetails()">Close</button>
    </div>

    <script>
        let calendar;

        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');
            calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay'
                },
                events: function(info, successCallback, failureCallback) {
                    const doctorId = document.getElementById('doctorSelect').value;
                    fetch(`/appointments/calendar-events?doctor_id=${doctorId}`)
                        .then(response => response.json())
                        .then(data => successCallback(data))
                        .catch(error => failureCallback(error));
                },
                eventClick: function(info) {
                    showAppointmentsForDate(info.event.start);
                },
                dateClick: function(info) {
                    showAppointmentsForDate(info.date);
                },
                eventDidMount: function(info) {
                    info.el.title = info.event.title;
                },
                timeZone: 'UTC'
            });
            calendar.render();
        });

        function updateCalendar() {
            calendar.refetchEvents();
        }

        function showAppointmentsForDate(date) {
            const formattedDate = date.toISOString().split('T')[0];
            const doctorId = document.getElementById('doctorSelect').value;
            document.getElementById('selectedDate').textContent = formattedDate;

            fetch(`/appointments/date/${formattedDate}?doctor_id=${doctorId}`)
                .then(response => response.json())
                .then(appointments => {
                    const appointmentList = document.getElementById('appointmentList');
                    appointmentList.innerHTML = '';

                    appointments.forEach(appointment => {
                        const time = new Date(appointment.scheduled_time).toLocaleTimeString();
                        const appointmentEl = document.createElement('div');
                        appointmentEl.className = 'appointment-item';
                        appointmentEl.innerHTML = `
                            <div>
                                <strong>${time}</strong> - ${appointment.patient.user.name}
                                <br>
                                <small>${appointment.reason}</small>
                            </div>
                            <div class="appointment-actions">
                                ${appointment.confirmation_status === 'pending' ?
                                    `<button class="btn btn-approve" onclick="approveAppointment(${appointment.id})">Approve</button>` : ''}
                                <button class="btn btn-reschedule" onclick="showRescheduleForm(${appointment.id})">Reschedule</button>
                                <button class="btn btn-cancel" onclick="cancelAppointment(${appointment.id})">Cancel</button>
                            </div>
                        `;
                        appointmentList.appendChild(appointmentEl);
                    });

                    document.getElementById('appointmentDetails').style.display = 'block';
                    document.getElementById('overlay').style.display = 'block';
                });
        }

        function closeAppointmentDetails() {
            document.getElementById('appointmentDetails').style.display = 'none';
            document.getElementById('overlay').style.display = 'none';
        }

        function approveAppointment(appointmentId) {
            if (confirm('Are you sure you want to approve this appointment?')) {
                fetch(`/appointments/${appointmentId}/approve`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Content-Type': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        calendar.refetchEvents();
                        closeAppointmentDetails();
                    }
                });
            }
        }

        function showRescheduleForm(appointmentId) {
            const newTime = prompt('Enter new date and time (YYYY-MM-DD HH:mm):');
            if (newTime) {
                fetch(`/appointments/${appointmentId}/reschedule`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({ rescheduled_time: newTime })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        calendar.refetchEvents();
                        closeAppointmentDetails();
                    }
                });
            }
        }

        function cancelAppointment(appointmentId) {
            if (confirm('Are you sure you want to cancel this appointment?')) {
                fetch(`/appointments/${appointmentId}/cancel`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Content-Type': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        calendar.refetchEvents();
                        closeAppointmentDetails();
                    }
                });
            }
        }
    </script>
</body>
</html>
