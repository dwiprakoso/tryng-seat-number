<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Festival Arak Arakan Cheng Ho 2025 - Check-in</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css" rel="stylesheet">
    <style>
        @media print {
            .no-print {
                display: none !important;
            }

            body {
                width: 58mm;
                font-family: monospace;
                font-size: 12px;
                margin: 0;
                padding: 10px;
                background: white;
            }

            .print-area {
                width: 58mm !important;
                font-family: monospace !important;
                font-size: 12px !important;
            }

            .center {
                text-align: center;
            }

            .bold {
                font-weight: bold;
            }

            .line {
                border-top: 1px dashed black;
                margin: 8px 0;
            }

            table {
                width: 100%;
                border-collapse: collapse;
            }

            td {
                vertical-align: top;
                padding: 1px 0;
            }

            .right {
                text-align: right;
            }

            .thankyou {
                margin-top: 10px;
                text-align: center;
            }
        }

        body {
            background: linear-gradient(135deg, #2b2b2b 0%, #1a1a1a 50%, #0f0f0f 100%);
            min-height: 100vh;
        }

        .festival-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border: 2px solid #d1a473;
        }

        .gold-text {
            color: #d1a473;
        }

        .gold-gradient {
            background: linear-gradient(135deg, #d1a473, #b8935f);
        }

        .input-focus:focus {
            outline: none;
            border-color: #d1a473;
            box-shadow: 0 0 0 3px rgba(209, 164, 115, 0.2);
        }

        .format-example {
            background-color: #f8f9fa;
            border: 1px dashed #dee2e6;
            padding: 10px;
            border-radius: 6px;
            font-family: monospace;
            font-size: 0.9em;
            color: #6c757d;
        }

        .mode-active {
            background: linear-gradient(135deg, #d1a473, #b8935f) !important;
            color: white !important;
            transform: scale(1.05);
            box-shadow: 0 2px 8px rgba(209, 164, 115, 0.3);
        }

        .input-large {
            font-size: 2rem !important;
            padding: 1rem !important;
            letter-spacing: 0.1em;
        }

        .pulse-animation {
            animation: pulse 2s infinite;
        }

        @keyframes pulse {

            0%,
            100% {
                opacity: 1;
            }

            50% {
                opacity: 0.7;
            }
        }

        .scan-line {
            height: 2px;
            background: linear-gradient(90deg, transparent, #d1a473, transparent);
            animation: scan 2s linear infinite;
        }

        @keyframes scan {
            0% {
                transform: translateX(-100%);
            }

            100% {
                transform: translateX(100%);
            }
        }
    </style>
</head>

<body>
    <div class="min-h-screen flex items-center justify-center p-4">
        <div class="w-full max-w-md">
            <!-- Header Card -->
            <div class="festival-card rounded-xl shadow-2xl p-6 mb-6 text-center no-print">
                <div class="mb-4">
                    <h1 class="text-2xl font-bold text-gray-800 mb-2">Dhemit</h1>
                </div>
                <div class="border-t-2 border-dashed border-red-200 pt-4">
                    <p class="text-lg font-semibold text-gray-700">CHECK-IN SYSTEM</p>
                    <p class="text-sm text-gray-500 mt-1">Scan atau masukkan kode tiket</p>
                </div>
            </div>

            <!-- Mode Selection -->
            <div class="festival-card rounded-xl shadow-2xl p-4 mb-4 no-print">
                <div class="text-center mb-4">
                    <p class="text-sm font-semibold text-gray-700 mb-3">Pilih Mode Input:</p>
                    <div class="flex gap-3 justify-center">
                        <button onclick="setInputMode('short')"
                            class="px-4 py-2 text-sm bg-gray-200 hover:bg-gray-300 rounded-lg transition-all duration-300"
                            id="btn-short">
                            <div class="font-bold">6 DIGIT</div>
                            <div class="text-xs">Cepat</div>
                        </button>
                        <button onclick="setInputMode('full')"
                            class="px-4 py-2 text-sm bg-gray-200 hover:bg-gray-300 rounded-lg transition-all duration-300"
                            id="btn-full">
                            <div class="font-bold">FULL ID</div>
                            <div class="text-xs">Lengkap</div>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Check-in Form -->
            <div class="festival-card rounded-xl shadow-2xl p-6 mb-6 no-print">
                <form id="checkinForm">
                    @csrf
                    <div class="mb-6">
                        <label class="block text-gray-700 text-sm font-bold mb-3 text-center" id="inputLabel">
                            Masukkan 6 Digit Terakhir
                        </label>

                        <!-- Format Examples -->
                        <div class="mb-4 text-xs" id="formatExample">
                            <div class="format-example mb-2">
                                <strong>Contoh untuk 6 digit:</strong><br>
                                ORDER-20250921-<span class="text-red-600 font-bold">942871</span> → ketik <span
                                    class="bg-yellow-200 px-1 rounded">942871</span><br>
                                ORDER-20250821-<span class="text-red-600 font-bold">825315</span> → ketik <span
                                    class="bg-yellow-200 px-1 rounded">825315</span>
                            </div>
                        </div>

                        <!-- Scanning indicator -->
                        <div class="relative mb-4" id="scanIndicator" style="display: none;">
                            <div class="scan-line"></div>
                            <p class="text-center text-gold-text font-semibold pulse-animation">🔍 Siap untuk scan...
                            </p>
                        </div>

                        <input type="text" id="externalIdInput"
                            class="w-full px-4 py-3 text-center font-mono text-xl font-bold input-focus border-2 border-gray-300 rounded-lg input-large"
                            placeholder="942871" autocomplete="off" autofocus inputmode="numeric">

                        <!-- Character counter for 6-digit mode -->
                        <div class="text-center mt-2" id="charCounter" style="display: none;">
                            <span class="text-sm text-gray-500">
                                <span id="currentCount">0</span>/6 digit
                            </span>
                        </div>
                    </div>

                    <button type="submit" id="submitBtn"
                        class="w-full gold-gradient text-white font-bold py-4 px-6 rounded-lg transition duration-300 transform hover:scale-105 shadow-lg text-lg">
                        <span id="submitText">CHECK-IN SEKARANG</span>
                        <div class="hidden" id="submitLoading">
                            <div class="inline-block animate-spin rounded-full h-4 w-4 border-b-2 border-white mr-2">
                            </div>
                            Memproses...
                        </div>
                    </button>
                </form>

                <!-- Quick Tips -->
                <div class="mt-4 text-center" id="quickTips">
                    <div class="text-xs text-gray-600 bg-gray-50 p-3 rounded-lg">
                        💡 <strong>Tips Cepat:</strong> Ketik 6 digit terakhir akan otomatis submit
                    </div>
                </div>
            </div>

            <!-- Alert Messages -->
            <div id="alertContainer"></div>

            <!-- Statistics (optional) -->
            <div class="festival-card rounded-xl shadow-lg p-4 mb-6 no-print" id="statsCard" style="display: none;">
                <div class="text-center text-sm text-gray-600">
                    <div class="flex justify-between">
                        <span>Total Check-in:</span>
                        <span class="font-bold" id="totalCheckin">0</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        let csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        let currentInputMode = 'short'; // Default to short mode for faster entry
        let autoSubmitTimeout = null;

        document.getElementById('checkinForm').addEventListener('submit', function(e) {
            e.preventDefault();
            processCheckin();
        });

        // Set input mode with enhanced UI feedback
        function setInputMode(mode) {
            currentInputMode = mode;
            const input = document.getElementById('externalIdInput');
            const label = document.getElementById('inputLabel');
            const formatExample = document.getElementById('formatExample');
            const charCounter = document.getElementById('charCounter');
            const quickTips = document.getElementById('quickTips');

            // Reset button styles
            document.getElementById('btn-full').className =
                'px-4 py-2 text-sm bg-gray-200 hover:bg-gray-300 rounded-lg transition-all duration-300';
            document.getElementById('btn-short').className =
                'px-4 py-2 text-sm bg-gray-200 hover:bg-gray-300 rounded-lg transition-all duration-300';

            if (mode === 'short') {
                // 6-digit mode setup
                input.placeholder = '942871';
                input.maxLength = 6;
                input.inputMode = 'numeric';
                input.pattern = '[0-9]{6}';
                label.textContent = 'Masukkan 6 Digit Terakhir';

                formatExample.innerHTML = `
                    <div class="format-example mb-2">
                        <strong>Contoh untuk 6 digit:</strong><br>
                        ORDER-20250921-<span class="text-red-600 font-bold">942871</span> → ketik <span class="bg-yellow-200 px-1 rounded">942871</span><br>
                        ORDER-20250821-<span class="text-red-600 font-bold">825315</span> → ketik <span class="bg-yellow-200 px-1 rounded">825315</span>
                    </div>
                `;

                charCounter.style.display = 'block';
                quickTips.innerHTML = `
                    <div class="text-xs text-gray-600 bg-green-50 p-3 rounded-lg border border-green-200">
                        ⚡ <strong>Mode Cepat:</strong> Ketik 6 digit → otomatis submit
                    </div>
                `;

                document.getElementById('btn-short').className += ' mode-active';

            } else {
                // Full mode setup
                input.placeholder = 'ORDER-20250921-942871';
                input.maxLength = 25;
                input.inputMode = 'text';
                input.pattern = '';
                label.textContent = 'Masukkan External ID Lengkap';

                formatExample.innerHTML = `
                    <div class="format-example mb-2">
                        <strong>Format yang diterima:</strong><br>
                        • ORDER-20250921-942871 (lengkap)<br>
                        • 20250921-942871 (tanpa ORDER)<br>
                        • 942871 (6 digit terakhir)
                    </div>
                `;

                charCounter.style.display = 'none';
                quickTips.innerHTML = `
                    <div class="text-xs text-gray-600 bg-blue-50 p-3 rounded-lg border border-blue-200">
                        📋 <strong>Mode Lengkap:</strong> Semua format diterima
                    </div>
                `;

                document.getElementById('btn-full').className += ' mode-active';
            }

            // Clear input and focus
            input.value = '';
            updateCharCounter();
            input.focus();

            // Clear any pending auto-submit
            if (autoSubmitTimeout) {
                clearTimeout(autoSubmitTimeout);
                autoSubmitTimeout = null;
            }
        }

        // Enhanced input handling with better validation
        document.getElementById('externalIdInput').addEventListener('input', function(e) {
            let value = this.value;

            if (currentInputMode === 'short') {
                // Only allow numbers for 6-digit mode
                value = value.replace(/[^0-9]/g, '');
                this.value = value;
                updateCharCounter();

                // Clear any existing timeout
                if (autoSubmitTimeout) {
                    clearTimeout(autoSubmitTimeout);
                    autoSubmitTimeout = null;
                }

                // Auto submit when 6 digits entered with delay
                if (value.length === 6) {
                    autoSubmitTimeout = setTimeout(() => {
                        if (this.value.length === 6) {
                            processCheckin();
                        }
                    }, 500); // 500ms delay for better UX
                }
            } else {
                // Full mode - convert to uppercase
                this.value = value.toUpperCase();

                // Auto submit for complete formats
                if (autoSubmitTimeout) {
                    clearTimeout(autoSubmitTimeout);
                    autoSubmitTimeout = null;
                }

                if (value.match(/^ORDER-\d{8}-\d{6}$/) ||
                    value.match(/^\d{8}-\d{6}$/) ||
                    (value.match(/^\d{6}$/) && value.length === 6)) {
                    autoSubmitTimeout = setTimeout(() => processCheckin(), 500);
                }
            }
        });

        // Character counter update
        function updateCharCounter() {
            if (currentInputMode === 'short') {
                const count = document.getElementById('externalIdInput').value.length;
                document.getElementById('currentCount').textContent = count;

                const counter = document.getElementById('currentCount');
                if (count === 6) {
                    counter.className = 'text-green-600 font-bold';
                } else if (count > 0) {
                    counter.className = 'text-blue-600';
                } else {
                    counter.className = '';
                }
            }
        }

        // Enhanced paste handling
        document.getElementById('externalIdInput').addEventListener('paste', function(e) {
            setTimeout(() => {
                let value = this.value.toUpperCase().trim();

                if (currentInputMode === 'short') {
                    // Extract 6 digits from any format
                    const match = value.match(/(\d{6})$/);
                    if (match) {
                        this.value = match[1];
                        updateCharCounter();
                        setTimeout(() => processCheckin(), 700);
                    }
                } else {
                    // Auto-detect format and submit
                    if (value.match(/^ORDER-\d{8}-\d{6}$/) ||
                        value.match(/^\d{8}-\d{6}$/) ||
                        value.match(/^\d{6}$/)) {
                        setTimeout(() => processCheckin(), 700);
                    }
                }
            }, 100);
        });

        // Enhanced check-in processing
        function processCheckin() {
            const externalIdNumber = document.getElementById('externalIdInput').value.trim();

            if (!externalIdNumber) {
                showAlert('⚠️ Harap masukkan kode tiket!', 'error');
                return;
            }

            // Validate input format
            if (!validateExternalId(externalIdNumber)) {
                showAlert('❌ Format kode tiket tidak valid!', 'error');
                return;
            }

            // Clear any pending auto-submit
            if (autoSubmitTimeout) {
                clearTimeout(autoSubmitTimeout);
                autoSubmitTimeout = null;
            }

            // Show loading state
            setLoadingState(true);
            showAlert('🔄 Memproses check-in...', 'loading');

            fetch('/checkin/process', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    },
                    body: JSON.stringify({
                        external_id_number: externalIdNumber
                    })
                })
                .then(response => response.json())
                .then(data => {
                    setLoadingState(false);

                    if (data.success) {
                        showAlert('✅ Check-in berhasil! Mengarahkan ke receipt...', 'success');

                        // Add success animation
                        document.getElementById('externalIdInput').className += ' border-green-500 bg-green-50';

                        // Redirect to receipt page
                        setTimeout(() => {
                            window.location.href = '/checkin/receipt/' + data.data.checkin_id;
                        }, 1500);
                    } else {
                        showAlert('❌ ' + data.message, 'error');
                        // Auto focus and select after error
                        setTimeout(() => {
                            const input = document.getElementById('externalIdInput');
                            input.focus();
                            input.select();
                            input.className = input.className.replace(' border-green-500 bg-green-50', '');
                        }, 2000);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    setLoadingState(false);
                    showAlert('❌ Terjadi kesalahan sistem! Silakan coba lagi.', 'error');
                    setTimeout(() => {
                        document.getElementById('externalIdInput').focus();
                    }, 2000);
                });
        }

        // Loading state management
        function setLoadingState(isLoading) {
            const submitBtn = document.getElementById('submitBtn');
            const submitText = document.getElementById('submitText');
            const submitLoading = document.getElementById('submitLoading');

            if (isLoading) {
                submitBtn.disabled = true;
                submitBtn.className = submitBtn.className.replace('hover:scale-105', '');
                submitText.className = 'hidden';
                submitLoading.className = '';
            } else {
                submitBtn.disabled = false;
                submitBtn.className += ' hover:scale-105';
                submitText.className = '';
                submitLoading.className = 'hidden';
            }
        }

        function validateExternalId(value) {
            if (currentInputMode === 'short') {
                return value.match(/^\d{6}$/);
            } else {
                return value.match(/^ORDER-\d{8}-\d{6}$/) ||
                    value.match(/^\d{8}-\d{6}$/) ||
                    value.match(/^\d{6}$/);
            }
        }

        function resetForm() {
            document.getElementById('externalIdInput').value = '';
            document.getElementById('alertContainer').innerHTML = '';
            document.getElementById('externalIdInput').className =
                'w-full px-4 py-3 text-center font-mono text-xl font-bold input-focus border-2 border-gray-300 rounded-lg input-large';
            updateCharCounter();
            document.getElementById('externalIdInput').focus();
        }

        function showAlert(message, type) {
            const alertContainer = document.getElementById('alertContainer');
            const alertClasses = {
                'success': 'bg-green-100 border-2 border-green-500 text-green-800',
                'error': 'bg-red-100 border-2 border-red-500 text-red-800',
                'loading': 'text-white font-semibold'
            };

            const loadingStyle = type === 'loading' ? 'style="background-color: #2b2b2b; border-color: #d1a473;"' : '';
            const icon = type === 'success' ? '🎉' : type === 'error' ? '⚠️' : '⏳';

            alertContainer.innerHTML = `
                <div class="festival-card ${alertClasses[type]} px-4 py-3 rounded-lg mb-4 text-center font-semibold no-print transform transition-all duration-300" ${loadingStyle}>
                    <div class="flex items-center justify-center">
                        <span class="mr-2">${icon}</span>
                        ${message}
                    </div>
                </div>
            `;

            if (type !== 'loading') {
                setTimeout(() => {
                    const alert = alertContainer.firstElementChild;
                    if (alert) {
                        alert.style.opacity = '0';
                        alert.style.transform = 'translateY(-10px)';
                        setTimeout(() => {
                            alertContainer.innerHTML = '';
                            if (type === 'error') {
                                resetForm();
                            }
                        }, 300);
                    }
                }, type === 'success' ? 3000 : 5000);
            }
        }

        // Enhanced inactivity management
        let inactivityTimer;

        function resetInactivityTimer() {
            clearTimeout(inactivityTimer);
            inactivityTimer = setTimeout(() => {
                if (!document.getElementById('externalIdInput').value) {
                    document.getElementById('externalIdInput').focus();
                    // Show pulse animation
                    document.getElementById('externalIdInput').style.animation = 'pulse 1s';
                    setTimeout(() => {
                        document.getElementById('externalIdInput').style.animation = '';
                    }, 1000);
                }
            }, 20000);
        }

        ['click', 'keypress', 'scroll', 'mousemove', 'focus'].forEach(event => {
            document.addEventListener(event, resetInactivityTimer);
        });

        // Keyboard shortcuts
        document.addEventListener('keydown', function(e) {
            // F1 for 6-digit mode, F2 for full mode
            if (e.key === 'F1') {
                e.preventDefault();
                setInputMode('short');
            } else if (e.key === 'F2') {
                e.preventDefault();
                setInputMode('full');
            }
            // Escape to clear
            else if (e.key === 'Escape') {
                resetForm();
            }
        });

        // Initialize on page load
        window.addEventListener('load', () => {
            setInputMode('short'); // Default to 6-digit mode
            resetInactivityTimer();

            // Show scan indicator for a moment
            const scanIndicator = document.getElementById('scanIndicator');
            scanIndicator.style.display = 'block';
            setTimeout(() => {
                scanIndicator.style.display = 'none';
            }, 2000);
        });
    </script>
</body>

</html>
