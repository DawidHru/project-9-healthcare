<!DOCTYPE html>
<html>
<head>
    <title>Doctor's Appointment Calendar</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.css' rel='stylesheet' />
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js'></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        .calendar-container {
            padding: 20px;
            max-width: 1200px;
            margin: 0 auto;
        }
        .header-section {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }
        .doctor-select {
            padding: 8px;
            border-radius: 4px;
            border: 1px solid #ddd;
            font-size: 14px;
        }
        .appointment-details {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            z-index: 1000;
            max-width: 500px;
            width: 90%;
            max-height: 80vh;
            overflow-y: auto;
        }
        .appointment-list {
            margin-top: 20px;
        }
        .appointment-item {
            padding: 10px;
            border-bottom: 1px solid #eee;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .appointment-actions {
            display: flex;
            gap: 10px;
        }
        .btn {
            padding: 8px 16px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-weight: 500;
        }
        .btn-approve {
            background: #4CAF50;
            color: white;
        }
        .btn-reschedule {
            background: #2196F3;
            color: white;
        }
        .btn-cancel {
            background: #f44336;
            color: white;
        }
        .overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0,0,0,0.5);
            z-index: 999;
        }
        .legend {
            display: flex;
            gap: 20px;
            margin: 20px 0;
            padding: 10px;
            background: #f5f5f5;
            border-radius: 4px;
        }
        .legend-item {
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .legend-color {
            width: 20px;
            height: 20px;
            border-radius: 4px;
        }
    </style>
</head>
<body>
    <div class="calendar-container">
        <div class="header-section">
            <h1>Appointment Management</h1>
            <select id="doctorSelect" class="doctor-select" onchange="updateCalendar()">
                <option value="">All Doctors</option>
                @foreach ($doctors as $doctor)
                    <option value="{{ $doctor->id }}" {{ request('doctor_id') == $doctor->id ? 'selected' : '' }}>
                        {{ $doctor->user->name }}
                    </option>
                @endforeach
            </select>
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
        <h2>Appointments for <span id="selectedDate"></span></h2>
        <div class="appointment-list" id="appointmentList">
            <!-- Appointments will be loaded here -->
        </div>
        <button class="btn" onclick="closeAppointmentDetails()">Close</button>
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
