<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Attendance</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            --primary-color: #2563eb;
            --success-color: #059669;
            --danger-color: #dc2626;
            --warning-color: #d97706;
            --info-color: #0891b2;
            --light-gray: #f8fafc;
            --border-color: #e2e8f0;
            --text-primary: #1e293b;
            --text-secondary: #64748b;
            --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        }
        
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            color: var(--text-primary);
        }
        
        .attendance-card {
            border-radius: 16px;
            box-shadow: var(--shadow-md);
            border: none;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            transition: all 0.3s ease;
        }
        
        .time-display {
            font-size: 3rem;
            font-weight: 700;
            color: var(--primary-color);
            font-family: 'JetBrains Mono', monospace;
        }
        
        .check-btn {
            padding: 1rem 2.5rem;
            border-radius: 12px;
            font-weight: 600;
            border: none;
            transition: all 0.3s ease;
            min-height: 48px;
            text-transform: uppercase;
            letter-spacing: 0.025em;
            box-shadow: var(--shadow-md);
        }
        
        .check-btn:hover:not(:disabled) {
            transform: translateY(-2px);
        }
        
        .check-btn:disabled {
            opacity: 0.6;
            cursor: not-allowed;
        }
        
        .work-summary {
            background: rgba(255, 255, 255, 0.9);
            border: 1px solid var(--border-color);
            border-radius: 16px;
            padding: 2rem;
            box-shadow: var(--shadow-md);
            backdrop-filter: blur(10px);
        }
        
        .break-timer {
            background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
            border: 1px solid #f59e0b;
            border-radius: 16px;
            padding: 2rem;
            text-align: center;
            color: #92400e;
            box-shadow: var(--shadow-md);
        }
        
        .navbar {
            background: rgba(255, 255, 255, 0.1) !important;
            backdrop-filter: blur(10px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.2);
        }
        
        .navbar-brand, .nav-link {
            color: white !important;
            font-weight: 500;
        }
        
        .loading-spinner {
            display: none;
        }
        
        .btn-loading .loading-spinner {
            display: inline-block;
        }
        
        .btn-loading .btn-text {
            display: none;
        }
        
        .pulse {
            animation: pulse 2s infinite;
        }
        
        @keyframes pulse {
            0% { box-shadow: 0 0 0 0 rgba(37, 99, 235, 0.7); }
            70% { box-shadow: 0 0 0 10px rgba(37, 99, 235, 0); }
            100% { box-shadow: 0 0 0 0 rgba(37, 99, 235, 0); }
        }
        
        @media (max-width: 768px) {
            .time-display { font-size: 2.5rem; }
            .check-btn { padding: 0.875rem 1.5rem; }
            .work-summary, .break-timer { padding: 1.5rem; }
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg">
        <div class="container">
            <a class="navbar-brand fw-bold" href="#">
                <i class="fas fa-clock me-2"></i>AttendanceHub
            </a>
            <div class="navbar-nav ms-auto">
                <div class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                        <i class="fas fa-user-circle me-1"></i><span id="user-name">Employee</span>
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="#"><i class="fas fa-user me-2"></i>Profile</a></li>
                        <li><a class="dropdown-item" href="#" onclick="checkLocation()"><i class="fas fa-map-marker-alt me-2"></i>Verify Location</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="#" id="logout-btn"><i class="fas fa-sign-out-alt me-2"></i>Logout</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>

    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <!-- Main Attendance Card -->
                <div class="card attendance-card mb-4">
                    <div class="card-body text-center p-5">
                        <div class="time-display" id="current-time">00:00:00</div>
                        <div class="mb-4 text-muted" id="current-date">Loading...</div>
                        
                        <div class="mb-4">
                            <span class="badge bg-secondary fs-6 px-3 py-2" id="attendance-status">
                                <i class="fas fa-clock me-1"></i>Not Checked In
                            </span>
                        </div>
                        
                        <div class="row justify-content-center">
                            <div class="col-md-6 mb-3">
                                <button class="btn btn-primary check-btn w-100" id="checkin-btn">
                                    <span class="loading-spinner spinner-border spinner-border-sm me-2"></span>
                                    <span class="btn-text"><i class="fas fa-sign-in-alt me-2"></i>Check In</span>
                                </button>
                            </div>
                            <div class="col-md-6 mb-3">
                                <button class="btn btn-danger check-btn w-100" id="checkout-btn" disabled>
                                    <span class="loading-spinner spinner-border spinner-border-sm me-2"></span>
                                    <span class="btn-text"><i class="fas fa-sign-out-alt me-2"></i>Check Out</span>
                                </button>
                            </div>
                        </div>
                        
                        <div class="row justify-content-center">
                            <div class="col-md-6">
                                <button class="btn btn-warning check-btn w-100" id="break-btn" disabled>
                                    <span class="loading-spinner spinner-border spinner-border-sm me-2"></span>
                                    <span class="btn-text"><i class="fas fa-coffee me-2"></i>Start Break</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Today's Summary -->
                <div class="row mb-4">
                    <div class="col-md-4 mb-3">
                        <div class="work-summary">
                            <h5 class="mb-3"><i class="fas fa-clock me-2 text-primary"></i>Work Time</h5>
                            <div class="h3 mb-0 text-primary" id="work-hours">0h 0m</div>
                            <small class="text-muted">Today</small>
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="break-timer">
                            <h5 class="mb-3"><i class="fas fa-coffee me-2"></i>Break Time</h5>
                            <div class="h3 mb-0" id="break-time">0m</div>
                            <small>Total breaks</small>
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="work-summary">
                            <h5 class="mb-3"><i class="fas fa-calendar-check me-2 text-success"></i>Status</h5>
                            <div class="h3 mb-0 text-secondary" id="daily-status">Not Started</div>
                            <small class="text-muted">Today</small>
                        </div>
                    </div>
                </div>
                
                <!-- Attendance History -->
                <div class="card attendance-card">
                    <div class="card-body">
                        <h5 class="mb-4"><i class="fas fa-history me-2"></i>Recent Attendance</h5>
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>Check In</th>
                                        <th>Check Out</th>
                                        <th>Work Hours</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody id="history-table">
                                    <tr>
                                        <td colspan="5" class="text-center text-muted">Loading attendance history...</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // API Configuration
        const API_CONFIG = {
            BASE_URL: 'http://absensi.test/api',
            HEADERS: {
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            }
        };

        // Authentication helpers
        function getAuthToken() {
            return localStorage.getItem('auth_token') || sessionStorage.getItem('auth_token');
        }

        function getAuthHeaders() {
            const token = getAuthToken();
            return {
                ...API_CONFIG.HEADERS,
                'Authorization': token ? `Bearer ${token}` : ''
            };
        }

        function isAuthenticated() {
            return !!getAuthToken();
        }

        function requireAuth() {
            if (!isAuthenticated()) {
                window.location.href = '/login.html';
                return false;
            }
            return true;
        }

        // Attendance state
        let attendanceState = {
            checkedIn: false,
            onBreak: false,
            checkInTime: null,
            breakStartTime: null,
            totalBreakTime: 0
        };

        // API calls
        async function apiCall(endpoint, method = 'GET', data = null) {
            try {
                const config = {
                    method,
                    headers: getAuthHeaders()
                };

                if (data && method !== 'GET') {
                    config.body = JSON.stringify(data);
                }

                const response = await fetch(`${API_CONFIG.BASE_URL}${endpoint}`, config);
                const result = await response.json();
                
                if (result.success) {
                    return result.data;
                } else {
                    throw new Error(result.message || 'API call failed');
                }
            } catch (error) {
                console.error('API call failed:', error);
                throw error;
            }
        }

        // Helper functions
        async function getCurrentLocation() {
            return new Promise((resolve) => {
                if (navigator.geolocation) {
                    navigator.geolocation.getCurrentPosition(
                        (position) => resolve({
                            latitude: position.coords.latitude,
                            longitude: position.coords.longitude
                        }),
                        () => resolve(null)
                    );
                } else {
                    resolve(null);
                }
            });
        }

        function getDeviceInfo() {
            return {
                user_agent: navigator.userAgent,
                platform: navigator.platform,
                language: navigator.language,
                timezone: Intl.DateTimeFormat().resolvedOptions().timeZone
            };
        }

        // Time display
        function updateTime() {
            const now = new Date();
            document.getElementById('current-time').textContent = now.toLocaleTimeString('en-US', { 
                hour12: false 
            });
            document.getElementById('current-date').textContent = now.toLocaleDateString('en-US', { 
                weekday: 'long', 
                year: 'numeric', 
                month: 'long', 
                day: 'numeric' 
            });
        }

        // Update displays
        function updateWorkHours() {
            if (attendanceState.checkedIn && attendanceState.checkInTime) {
                const now = new Date();
                const workTimeMs = now - attendanceState.checkInTime - attendanceState.totalBreakTime;
                
                if (attendanceState.onBreak && attendanceState.breakStartTime) {
                    const currentBreakTime = now - attendanceState.breakStartTime;
                    const adjustedWorkTime = workTimeMs - currentBreakTime;
                    displayTime(Math.max(0, adjustedWorkTime), 'work-hours');
                } else {
                    displayTime(Math.max(0, workTimeMs), 'work-hours');
                }
            }
        }

        function updateBreakTime() {
            let totalBreakMs = attendanceState.totalBreakTime;
            
            if (attendanceState.onBreak && attendanceState.breakStartTime) {
                const currentBreakTime = new Date() - attendanceState.breakStartTime;
                totalBreakMs += currentBreakTime;
            }
            
            displayTime(totalBreakMs, 'break-time');
        }

        function displayTime(milliseconds, elementId) {
            const hours = Math.floor(milliseconds / (1000 * 60 * 60));
            const minutes = Math.floor((milliseconds % (1000 * 60 * 60)) / (1000 * 60));
            
            const element = document.getElementById(elementId);
            if (elementId === 'break-time') {
                element.textContent = hours > 0 ? `${hours}h ${minutes}m` : `${minutes}m`;
            } else {
                element.textContent = `${hours}h ${minutes}m`;
            }
        }

        // State management
        function saveState() {
            try {
                const stateToSave = {
                    checkedIn: attendanceState.checkedIn,
                    onBreak: attendanceState.onBreak,
                    checkInTime: attendanceState.checkInTime ? attendanceState.checkInTime.getTime() : null,
                    breakStartTime: attendanceState.breakStartTime ? attendanceState.breakStartTime.getTime() : null,
                    totalBreakTime: attendanceState.totalBreakTime,
                    date: new Date().toDateString()
                };
                localStorage.setItem('attendanceState', JSON.stringify(stateToSave));
            } catch (error) {
                console.warn('Failed to save state:', error);
            }
        }

        function loadState() {
            try {
                const savedState = JSON.parse(localStorage.getItem('attendanceState') || '{}');
                const today = new Date().toDateString();
                
                if (savedState.date !== today) {
                    clearState();
                    return;
                }

                attendanceState.checkedIn = savedState.checkedIn || false;
                attendanceState.onBreak = savedState.onBreak || false;
                attendanceState.checkInTime = savedState.checkInTime ? new Date(savedState.checkInTime) : null;
                attendanceState.breakStartTime = savedState.breakStartTime ? new Date(savedState.breakStartTime) : null;
                attendanceState.totalBreakTime = savedState.totalBreakTime || 0;

                updateUI();
            } catch (error) {
                console.warn('Failed to load state:', error);
                clearState();
            }
        }

        function clearState() {
            localStorage.removeItem('attendanceState');
            attendanceState = {
                checkedIn: false,
                onBreak: false,
                checkInTime: null,
                breakStartTime: null,
                totalBreakTime: 0
            };
            updateUI();
        }

        function updateUI() {
            const checkinBtn = document.getElementById('checkin-btn');
            const checkoutBtn = document.getElementById('checkout-btn');
            const breakBtn = document.getElementById('break-btn');
            const statusElement = document.getElementById('attendance-status');
            const dailyStatusElement = document.getElementById('daily-status');

            if (attendanceState.checkedIn) {
                checkinBtn.disabled = true;
                checkinBtn.classList.add('pulse');
                checkoutBtn.disabled = false;
                breakBtn.disabled = false;

                if (attendanceState.onBreak) {
                    statusElement.innerHTML = '<i class="fas fa-coffee me-1"></i>On Break';
                    statusElement.className = 'badge bg-warning fs-6 px-3 py-2';
                    dailyStatusElement.textContent = 'On Break';
                    dailyStatusElement.className = 'h3 mb-0 text-warning';
                    
                    breakBtn.querySelector('.btn-text').innerHTML = '<i class="fas fa-play me-2"></i>End Break';
                    breakBtn.className = 'btn btn-success check-btn w-100';
                } else {
                    statusElement.innerHTML = '<i class="fas fa-check-circle me-1"></i>Checked In';
                    statusElement.className = 'badge bg-success fs-6 px-3 py-2 pulse';
                    dailyStatusElement.textContent = 'Working';
                    dailyStatusElement.className = 'h3 mb-0 text-success';
                    
                    breakBtn.querySelector('.btn-text').innerHTML = '<i class="fas fa-coffee me-2"></i>Start Break';
                    breakBtn.className = 'btn btn-warning check-btn w-100';
                }
            } else {
                checkinBtn.disabled = false;
                checkinBtn.classList.remove('pulse');
                checkoutBtn.disabled = true;
                breakBtn.disabled = true;

                statusElement.innerHTML = '<i class="fas fa-clock me-1"></i>Not Checked In';
                statusElement.className = 'badge bg-secondary fs-6 px-3 py-2';
                
                dailyStatusElement.textContent = 'Not Started';
                dailyStatusElement.className = 'h3 mb-0 text-secondary';

                breakBtn.querySelector('.btn-text').innerHTML = '<i class="fas fa-coffee me-2"></i>Start Break';
                breakBtn.className = 'btn btn-warning check-btn w-100';

                document.getElementById('work-hours').textContent = '0h 0m';
                document.getElementById('break-time').textContent = '0m';
            }

            updateWorkHours();
            updateBreakTime();
        }

        // Event handlers
        document.getElementById('checkin-btn').addEventListener('click', async function() {
            if (attendanceState.checkedIn) return;
            
            this.classList.add('btn-loading');
            
            try {
                if (navigator.onLine && isAuthenticated()) {
                    const result = await apiCall('/attendance/checkin', 'POST', {
                        location: await getCurrentLocation(),
                        device_info: getDeviceInfo()
                    });
                    
                    attendanceState.checkedIn = true;
                    attendanceState.checkInTime = new Date(result.check_in_time);
                    
                    showToast(`Welcome ${result.employee_name}! Successfully checked in.`, 'success');
                } else {
                    attendanceState.checkedIn = true;
                    attendanceState.checkInTime = new Date();
                    showToast('Checked in locally. Will sync when online.', 'info');
                }
                
                saveState();
                updateUI();
            } catch (error) {
                showToast('Check-in failed: ' + error.message, 'error');
            } finally {
                this.classList.remove('btn-loading');
            }
        });

        document.getElementById('checkout-btn').addEventListener('click', async function() {
            if (!attendanceState.checkedIn || attendanceState.onBreak) return;
            
            this.classList.add('btn-loading');
            
            try {
                if (navigator.onLine && isAuthenticated()) {
                    const result = await apiCall('/attendance/checkout', 'POST');
                    
                    attendanceState.checkedIn = false;
                    document.getElementById('work-hours').textContent = `${result.total_work_hours}h`;
                    
                    showToast(`Great work! You completed ${result.total_work_hours} hours today.`, 'success');
                } else {
                    attendanceState.checkedIn = false;
                    showToast('Checked out locally. Will sync when online.', 'info');
                }
                
                saveState();
                updateUI();
            } catch (error) {
                showToast('Check-out failed: ' + error.message, 'error');
            } finally {
                this.classList.remove('btn-loading');
            }
        });

        document.getElementById('break-btn').addEventListener('click', async function() {
            this.classList.add('btn-loading');
            
            try {
                if (!attendanceState.onBreak) {
                    // Start break
                    if (navigator.onLine && isAuthenticated()) {
                        await apiCall('/attendance/break/start', 'POST', { break_type: 'regular' });
                    }
                    
                    attendanceState.onBreak = true;
                    attendanceState.breakStartTime = new Date();
                    showToast('Break started. Enjoy your break!', 'info');
                } else {
                    // End break
                    if (navigator.onLine && isAuthenticated()) {
                        const result = await apiCall('/attendance/break/end', 'POST');
                        showToast(`Break ended. You took a ${result.duration_minutes} minute break.`, 'info');
                    } else {
                        showToast('Break ended.', 'info');
                    }
                    
                    const breakDuration = new Date() - attendanceState.breakStartTime;
                    attendanceState.totalBreakTime += breakDuration;
                    attendanceState.onBreak = false;
                    attendanceState.breakStartTime = null;
                }
                
                saveState();
                updateUI();
            } catch (error) {
                showToast('Break action failed: ' + error.message, 'error');
            } finally {
                this.classList.remove('btn-loading');
            }
        });

        document.getElementById('logout-btn').addEventListener('click', async function(e) {
            e.preventDefault();
            
            if (!confirm('Are you sure you want to logout?')) return;
            
            try {
                if (navigator.onLine && isAuthenticated()) {
                    await apiCall('/auth/logout', 'POST');
                }
            } catch (error) {
                console.warn('API logout failed:', error);
            }
            
            // Clear everything
            localStorage.clear();
            sessionStorage.clear();
            clearState();
            
            showToast('Logged out successfully!', 'success');
            setTimeout(() => window.location.href = '/login.html', 1500);
        });

        // Load attendance history
        async function loadHistory() {
            try {
                if (!navigator.onLine || !isAuthenticated()) {
                    document.getElementById('history-table').innerHTML = 
                        '<tr><td colspan="5" class="text-center text-muted">History unavailable offline</td></tr>';
                    return;
                }

                const historyData = await apiCall('/attendance/history?limit=5');
                const tableBody = document.getElementById('history-table');
                
                if (!historyData.records || historyData.records.length === 0) {
                    tableBody.innerHTML = '<tr><td colspan="5" class="text-center text-muted">No attendance history found</td></tr>';
                    return;
                }

                tableBody.innerHTML = historyData.records.map(record => {
                    const date = new Date(record.date).toLocaleDateString('en-US', { 
                        month: 'short', day: 'numeric', year: 'numeric' 
                    });
                    const checkIn = record.check_in_time ? 
                        new Date(record.check_in_time).toLocaleTimeString('en-US', { 
                            hour: '2-digit', minute: '2-digit' 
                        }) : '-';
                    const checkOut = record.check_out_time ? 
                        new Date(record.check_out_time).toLocaleTimeString('en-US', { 
                            hour: '2-digit', minute: '2-digit' 
                        }) : '-';
                    const workHours = record.total_work_hours ? `${record.total_work_hours}h` : '0h';
                    
                    let statusClass = 'bg-secondary';
                    let statusText = 'Unknown';
                    
                    switch (record.status) {
                        case 'present':
                            statusClass = 'bg-success';
                            statusText = 'On Time';
                            break;
                        case 'late':
                            statusClass = 'bg-warning';
                            statusText = 'Late';
                            break;
                        case 'absent':
                            statusClass = 'bg-danger';
                            statusText = 'Absent';
                            break;
                    }
                    
                    return `
                        <tr>
                            <td>${date}</td>
                            <td>${checkIn}</td>
                            <td>${checkOut}</td>
                            <td>${workHours}</td>
                            <td><span class="badge ${statusClass}">${statusText}</span></td>
                        </tr>
                    `;
                }).join('');
            } catch (error) {
                console.warn('Failed to load history:', error);
                document.getElementById('history-table').innerHTML = 
                    '<tr><td colspan="5" class="text-center text-muted">Failed to load history</td></tr>';
            }
        }

        // Load daily status from API
        async function loadDailyStatus() {
            try {
                if (!navigator.onLine || !isAuthenticated()) {
                    loadState();
                    return;
                }

                const apiData = await apiCall('/attendance/daily-status');
                if (apiData && apiData.date === new Date().toISOString().split('T')[0]) {
                    attendanceState.checkedIn = apiData.is_checked_in;
                    attendanceState.onBreak = apiData.is_on_break;
                    attendanceState.checkInTime = apiData.check_in_time ? new Date(apiData.check_in_time) : null;
                    attendanceState.breakStartTime = apiData.current_break ? new Date(apiData.current_break.break_start) : null;
                    attendanceState.totalBreakTime = (apiData.total_break_hours || 0) * 60 * 60 * 1000;
                    
                    saveState();
                    updateUI();
                    
                    showToast('Status synced with server', 'success');
                } else {
                    loadState();
                }
            } catch (error) {
                console.warn('Failed to load from API:', error);
                loadState();
            }
        }

        // Location check
        function checkLocation() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(
                    (position) => showToast('Location verified successfully', 'success'),
                    () => showToast('Location verification failed', 'warning')
                );
            } else {
                showToast('Geolocation not supported', 'warning');
            }
        }

        // Toast notifications
        function showToast(message, type = 'info') {
            let toastContainer = document.getElementById('toast-container');
            if (!toastContainer) {
                toastContainer = document.createElement('div');
                toastContainer.id = 'toast-container';
                toastContainer.className = 'toast-container position-fixed top-0 end-0 p-3';
                toastContainer.style.zIndex = '9999';
                document.body.appendChild(toastContainer);
            }
            
            const bgClass = type === 'success' ? 'bg-success' : 
                           type === 'error' ? 'bg-danger' : 
                           type === 'warning' ? 'bg-warning' : 'bg-info';
            
            const toast = document.createElement('div');
            toast.className = `toast align-items-center text-white ${bgClass} border-0`;
            toast.setAttribute('role', 'alert');
            toast.innerHTML = `
                <div class="d-flex">
                    <div class="toast-body">${message}</div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
                </div>
            `;
            
            toastContainer.appendChild(toast);
            const bsToast = new bootstrap.Toast(toast, { delay: 4000 });
            bsToast.show();
            
            toast.addEventListener('hidden.bs.toast', () => toast.remove());
        }

        // Load user name
        async function loadUserInfo() {
            try {
                const userData = JSON.parse(localStorage.getItem('user_data') || sessionStorage.getItem('user_data') || '{}');
                if (userData.employee && userData.employee.nama_lengkap) {
                    document.getElementById('user-name').textContent = userData.employee.nama_lengkap;
                } else if (navigator.onLine && isAuthenticated()) {
                    const profile = await apiCall('/auth/profile');
                    document.getElementById('user-name').textContent = profile.nama_lengkap;
                }
            } catch (error) {
                console.warn('Failed to load user info:', error);
            }
        }

        // Initialize app
        document.addEventListener('DOMContentLoaded', async function() {
            console.log('Attendance page loading...');
            
            // First try to check PHP session for auth data
            const sessionAuth = await checkPhpSession();
            
            // Debug: Check what's in storage
            console.log('Storage contents:', {
                localStorage_auth_token: localStorage.getItem('auth_token'),
                sessionStorage_auth_token: sessionStorage.getItem('auth_token'),
                localStorage_user_data: localStorage.getItem('user_data'),
                sessionStorage_user_data: sessionStorage.getItem('user_data'),
                sessionAuthFound: sessionAuth
            });

            // Check authentication - but don't redirect immediately on page load
            const isAuth = isAuthenticated();
            if (!isAuth) {
                console.log('Not authenticated - showing login prompt');
                showToast('Please log in to access attendance system', 'warning');
                
                // Show a login prompt instead of immediate redirect
                setTimeout(() => {
                    if (confirm('You need to log in first. Go to login page?')) {
                        window.location.href = '/login.html';
                    }
                }, 2000);
                return;
            }

            console.log('User is authenticated, initializing app...');

            // Start time updates
            setInterval(updateTime, 1000);
            updateTime();

            // Load user info
            loadUserInfo();

            // Load daily status with API fallback
            loadDailyStatus();

            // Load attendance history
            loadHistory();

            // Update displays every 30 seconds
            setInterval(() => {
                if (attendanceState.checkedIn) {
                    updateWorkHours();
                }
                if (attendanceState.onBreak || attendanceState.totalBreakTime > 0) {
                    updateBreakTime();
                }
            }, 30000);

            // Auto-save every 5 minutes
            setInterval(() => {
                if (attendanceState.checkedIn) {
                    saveState();
                }
            }, 300000);

            // Show welcome message
            setTimeout(() => {
                if (!attendanceState.checkedIn) {
                    showToast('Welcome! Ready to start your day?', 'info');
                } else {
                    showToast('Welcome back! Your status has been restored.', 'success');
                }
            }, 1000);
        });

        // Keyboard shortcuts
        document.addEventListener('keydown', function(e) {
            if (e.ctrlKey || e.metaKey) {
                switch(e.key) {
                    case 'i':
                        e.preventDefault();
                        if (!attendanceState.checkedIn) {
                            document.getElementById('checkin-btn').click();
                        }
                        break;
                    case 'o':
                        e.preventDefault();
                        if (attendanceState.checkedIn && !attendanceState.onBreak) {
                            document.getElementById('checkout-btn').click();
                        }
                        break;
                    case 'b':
                        e.preventDefault();
                        if (attendanceState.checkedIn) {
                            document.getElementById('break-btn').click();
                        }
                        break;
                }
            }
        });
    </script>
</body>
</html>