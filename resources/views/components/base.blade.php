<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Healthcare&trade;</title>
        <link href="{{ asset('css/styles.css') }}" rel="stylesheet" />
        <h1 class="header-text">Healthcare&trade;</h1>
        <style>
            .logo-container{
                text-align: left;  
                margin-left: 30px
            }
            .logo{
                width: 20%;
                height: 100px;
            }
            .wrapper {
                display: flex;
                flex-direction: column;
                min-height: 100vh;
            }
            .content {
                flex: 1;
            }
        </style>
    </head>
    <body>
        <div class="wrapper"> 
            <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
                <div class="container">
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse justify-content-center" id="navbarSupportedContent">
                        <ul class="navbar-nav mb-2 mb-lg-0">
                            <li class="nav-item mx-3"><a class="nav-link" href="/">Home</a></li>

                            <li class="nav-item dropdown mx-3">
                                <a class="nav-link dropdown-toggle" role="button" data-bs-toggle="dropdown" aria-expanded="false">Doctors</a>
                                <ul class="dropdown-menu" aria-labelledby="doctorsDropdown">
                                    <li><a class="dropdown-item" href="/doctors">Doctors</a></li>
                                    <li><a class="dropdown-item" href="/schedules">Schedule</a></li>
                                    <li><a class="dropdown-item" href="/appointments">Appointments</a></li>
                                    <li><a class="dropdown-item" href="/medical_records">Medical Records</a></li>
                                </ul>
                            </li>
                            <li class="nav-item dropdown mx-3">
                                <a class="nav-link dropdown-toggle" role="button" data-bs-toggle="dropdown" aria-expanded="false">Patients</a>
                                <ul class="dropdown-menu" aria-labelledby="patientsDropdown">
                                    <li><a class="dropdown-item" href="/patients">Patients</a></li>
                                    <li><a class="dropdown-item" href="/appointments">Appointments</a></li>
                                    <li><a class="dropdown-item" href="/medical_records">Medical Records</a></li>
                                </ul>
                            </li>
                            <li class="nav-item dropdown mx-3">
                                <a class="nav-link dropdown-toggle" role="button" data-bs-toggle="dropdown" aria-expanded="false">Inventory</a>
                                <ul class="dropdown-menu" aria-labelledby="inventoryDropdown">
                                    <li><a class="dropdown-item" href="/inventory_items">Inventory Items</a></li>
                                    <li><a class="dropdown-item" href="/supplies">Supply requests </a></li>
                                    <li><a class="dropdown-item" href="/inventory_managers">Inventory Managers</a></li>
                                </ul>
                            </li>
                            <li class="nav-item mx-3"><a class="nav-link" href="/dashboard">Profile</a></li>
                        </ul>
                    </div>
                </div>
            </nav>
            
            {{-- Content --}}
            <div class="content">
                {{ $slot }}
            </div>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
        <script src="js/scripts.js"></script>
    </body>
    
    <footer class="py-3 bg-dark" style="margin-top: 50px">
    </footer>
</html>
