@extends('layouts.app')

@section('content')
<div class="profile-foreground position-relative mx-n4 mt-n4">
    <div class="profile-wid-bg">
        <img src="assets/images/profile-bg.jpg" alt="" class="profile-wid-img" />
    </div>
</div>
<div class="pt-4 mb-4 mb-lg-3 pb-lg-4 profile-wrapper">
    <div class="row g-4">
        <div class="col-auto">
            <div class="avatar-lg">
                <img src="assets/images/users/avatar-1.jpg" alt="user-img" class="img-thumbnail rounded-circle" />
            </div>
        </div>
        <!--end col-->
    </div>
    <!--end row-->
</div>
<div class="row">
    <div class="col-lg-12">
        <div>
            <div class="d-flex profile-wrapper">
                <!-- Nav tabs -->
                <ul class="nav nav-pills animation-nav profile-nav gap-2 gap-lg-3 flex-grow-1" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link fs-14 active" data-bs-toggle="tab" href="#overview-tab" role="tab">
                            <i class="ri-airplay-fill d-inline-block d-md-none"></i> <span class="d-none d-md-inline-block">Overview</span>
                        </a>
                    </li>
                </ul>
                <div class="flex-shrink-0">
                    <a href="{{ route('logout')}}" class="btn btn-success"><i class="ri-edit-box-line align-bottom" data-key="t-logout"></i> Edit Profile</a>
                </div>
            </div>
            <!-- Tab panes -->
            <div class="tab-content pt-4 text-muted">
                <div class="tab-pane active" id="overview-tab" role="tabpanel">
                    <div class="row">
                        <div class="col-xxl-3">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title mb-3">Info</h5>
                                    <div class="table-responsive">
                                        <table class="table table-borderless mb-0">
                                            <tbody>
                                                <tr>
                                                    <th class="ps-0" scope="row">Full Name :</th>
                                                    <td class="text-muted">{{ auth()->user()->nama }}</td>
                                                </tr>
                                                <tr>
                                                    <th class="ps-0" scope="row">Jabatan :</th>
                                                    <td class="text-muted">{{ auth()->user()->jabatan }}</td>
                                                </tr>
                                                <tr>
                                                    <th class="ps-0" scope="row">Status :</th>
                                                    <td class="text-muted">{{ auth()->user()->email }}</td>
                                                </tr>
                                                <tr>
                                                    <th class="ps-0" scope="row">Joining Date</th>
                                                    <td class="text-muted">24 Nov 2021</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div><!-- end card body -->
                            </div><!-- end card -->
                        </div>
                        <!--end col-->
                        <div class="col-xxl-9">
                            <div class="row">
                                <div class="col-lg-5">
                                    <div class="card">
                                        <div class="card-header align-items-center d-flex">
                                            <h4 class="card-title mb-0 me-2 align-items-center" >Waktu Istirahat</h4>
                                        </div>
                                        <div class="card-body">
                                            <div class="clock time text-center mb-4">
                                                <p id="time">0:00</p>
                                            </div>
                                            <form id="myForm">
                                                <div class="row">
                                                    <div class="col-12 col-md-12">
                                                        <!-- Buttons Grid -->
                                                        <div class="d-grid" >
                                                            <textarea class="form-control" id="keterangan" name="keterangan" rows="3" placeholder="Masukkan komentar" style="margin-bottom: 10px;"></textarea>
                                                        </div>
                                                    </div>
                                                    <!--end col-->
                                                </div>
                                                <div class="row">
                                                    <div class="col-6 col-md-6">
                                                        <!-- Buttons Grid -->
                                                        <div class="d-grid" >
                                                            <button class="btn btn-primary" type="button" onclick="startTimer()" id="startbtn">Start</button>
                                                        </div>
                                                    </div>
                                                    <!--end col-->
                                                    <div class="col-6 col-md-6">
                                                        <!-- Buttons Grid -->
                                                        <div class="d-grid" >
                                                            <button class="btn btn-primary" type="button" onclick="stopTimer()" id="stopbtn">Stop</button>
                                                        </div>
                                                    </div>
                                                    <!--end col-->
                                                </div>
                                                <!--end row-->
                                            </form>
                                        </div>
                                    <!--end card-body-->
                                    </div><!-- end card -->
                                </div>
                                <div class="col-lg-7">
                                    <div class="card">
                                        <div class="card-header align-items-center d-flex">
                                            <h4 class="card-title mb-0 me-2">History Istirahat</h4>
                                        </div>
                                        <div class="card-body">
                                            <table id="dataTable" class="table table-nowrap">
                                                <thead>
                                                    <tr>
                                                        <th scope="col">Tanggal</th>
                                                        <th scope="col">Waktu Mulai</th>
                                                        <th scope="col">Waktu Selesai</th>
                                                        <th scope="col">Keterangan</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                </tbody>
                                            </table>
                                        </div>
                                    <!--end card-body-->
                                    </div><!-- end card -->
                                </div>
                            </div>
                        </div>
                        <!--end col-->
                    </div>
                    <!--end row-->
                </div>
            </div>
            <!--end tab-content-->
        </div>
    </div>
    <!--end col-->
</div>
<!--end row-->
<!-- <script>
            let timer;
        let startTime = localStorage.getItem('startTime') ? parseInt(localStorage.getItem('startTime')) : null;
        let secondsElapsed = 0;

        function updateTimerDisplay() {
            let currentTime = startTime ? Math.floor((Date.now() - startTime) / 1000) : secondsElapsed;
            let minutes = Math.floor(currentTime / 60);
            let seconds = currentTime % 60;
            document.getElementById('time').innerText = minutes + ":" + (seconds < 10 ? "0" : "") + seconds;
        }

        function startTimer() {
            if (!startTime) {
                startTime = Date.now();
                localStorage.setItem('startTime', startTime);
            }
            timer = setInterval(updateTimerDisplay, 1000);
            const startbutton = document.getElementById('startbtn');
            startbutton.disabled = true;
            const stopbutton = document.getElementById('stopbtn');
            stopbutton.disabled = false;
        }

        function stopTimer() {
            clearInterval(timer);
            localStorage.removeItem('startTime');
            startTime = null;

            const stopbutton = document.getElementById('stopbtn');
            stopbutton.disabled = true;
            const startbutton = document.getElementById('startbtn');
            startbutton.disabled = false;
        }

        if (startTime) {
            startTimer();
        }

</script> -->
<script>
        let timer;

    function updateTimerDisplay() {
        let startTime = localStorage.getItem("startTime");
        if (startTime) {
            let elapsed = Math.floor((Date.now() - parseInt(startTime)) / 1000);
            let minutes = Math.floor(elapsed / 60);
            let seconds = elapsed % 60;
            document.getElementById('time').innerText = minutes + ":" + (seconds < 10 ? "0" : "") + seconds;
        }
    }

    function startTimer() {
            let keteranganValue = document.querySelector('textarea[id="keterangan"]')?.value;

        fetch('/api/start-timer', {
            method: 'POST',
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
            body: JSON.stringify({
                keterangan: keteranganValue
                })
            })
        .then(response => response.json())
        .then(data => {
            localStorage.setItem("startTime", Date.now());
            setInterval(updateTimerDisplay, 1000);
            showSuccessPopup("Data saved successfully!");
        });

            timer = setInterval(updateTimerDisplay, 1000);
            const startbutton = document.getElementById('startbtn');
            startbutton.disabled = true;
            const stopbutton = document.getElementById('stopbtn');
            stopbutton.disabled = false;
    }

    function stopTimer() {
        fetch('/api/stop-timer', { 
            method: 'POST',
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
        })
        .then(response => response.json())
        .then(() => {
            localStorage.removeItem("startTime");
        });

            const stopbutton = document.getElementById('stopbtn');
            stopbutton.disabled = true;
            const startbutton = document.getElementById('startbtn');
            startbutton.disabled = false;
    }

    function fetchActiveTimer() {
        setInterval(updateTimerDisplay, 1000);
    }


    document.addEventListener("DOMContentLoaded", fetchActiveTimer);
</script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        fetch('/api/history-istirahat')
        .then(response => response.json())
        .then(data => {
            let tableBody = document.querySelector("#dataTable tbody");
                tableBody.innerHTML = "";
            data.history.forEach(item => {
                let row = `<tr>
                    <td>${item.tanggal}</td>
                    <td>${item.waktu_mulai}</td>
                    <td>${item.waktu_selesai}</td>
                    <td>${item.keterangan}</td>
                </tr>`;
                
                tableBody.innerHTML += row;
            });
        })
        .catch(error => console.error("Error fetching data:", error));
    });

    setInterval(function() {
        document.dispatchEvent(new Event("DOMContentLoaded"));
    }, 5000);
</script>

@endsection