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
                font-family: 'Courier New', monospace !important;
                background: white !important;
                -webkit-print-color-adjust: exact;
                color-adjust: exact;
                margin: 0 !important;
                padding: 0 !important;
                font-size: 10px !important;
            }

            * {
                box-sizing: border-box !important;
            }

            .print-area {
                width: 58mm !important;
                max-width: 58mm !important;
                font-size: 9px !important;
                line-height: 1.2 !important;
                margin: 0 !important;
                padding: 2mm !important;
                color: black !important;
            }

            /* Override semua styling untuk print */
            #resultCard {
                background: white !important;
                border: none !important;
                box-shadow: none !important;
                border-radius: 0 !important;
                padding: 0 !important;
                margin: 0 !important;
                width: 58mm !important;
                max-width: 58mm !important;
            }

            /* Border dashed untuk thermal printer */
            .border-dashed {
                border-style: dashed !important;
                border-width: 1px !important;
                border-color: #000 !important;
            }

            .border-t {
                border-top: 1px dashed #000 !important;
            }

            .border-b {
                border-bottom: 1px dashed #000 !important;
            }

            .border-gray-600 {
                border-color: #000 !important;
            }

            /* Text alignment */
            .text-center {
                text-align: center !important;
            }

            .text-right {
                text-align: right !important;
            }

            /* Spacing untuk thermal printer */
            .mb-2 {
                margin-bottom: 2mm !important;
            }

            .py-1 {
                padding-top: 1mm !important;
                padding-bottom: 1mm !important;
            }

            .pt-2 {
                padding-top: 2mm !important;
            }

            .pb-2 {
                padding-bottom: 2mm !important;
            }

            .ml-4 {
                margin-left: 4mm !important;
            }

            /* Font sizes */
            .text-sm {
                font-size: 8px !important;
            }

            .text-xs {
                font-size: 7px !important;
            }

            .font-bold {
                font-weight: bold !important;
            }

            .font-mono {
                font-family: 'Courier New', monospace !important;
            }

            /* Flex untuk justify between */
            .flex {
                display: flex !important;
            }

            .justify-between {
                justify-content: space-between !important;
            }

            /* Hide everything except print area */
            body>* {
                display: none !important;
            }

            .print-area {
                display: block !important;
            }

            .print-area * {
                display: block !important;
            }

            .print-area .flex {
                display: flex !important;
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
    </style>
</head>

<body>
    <div class="min-h-screen flex items-center justify-center p-4">
        <div class="w-full max-w-md">
            <!-- Header Card -->
            <div class="festival-card rounded-xl shadow-2xl p-6 mb-6 text-center no-print">
                <div class="mb-4">
                    <h1 class="text-2xl font-bold text-gray-800 mb-2">Festival Arak Arakan</h1>
                    <h2 class="text-xl gold-text font-bold mb-1">Cheng Ho 2025</h2>
                    <p class="text-sm text-gray-600">Wisata Sampookong Semarang</p>
                </div>
                <div class="border-t-2 border-dashed border-red-200 pt-4">
                    <p class="text-lg font-semibold text-gray-700">CHECK-IN SYSTEM</p>
                    <p class="text-sm text-gray-500 mt-1">Masukkan 6 digit External ID</p>
                </div>
            </div>

            <!-- Check-in Form -->
            <div class="festival-card rounded-xl shadow-2xl p-6 mb-6 no-print">
                <form id="checkinForm">
                    @csrf
                    <div class="mb-6">
                        <label class="block text-gray-700 text-sm font-bold mb-3 text-center">
                            External ID
                        </label>
                        <div class="flex items-center border-2 border-gray-300 rounded-lg overflow-hidden">
                            <span class="bg-gray-800 text-white px-3 py-3 font-mono text-sm font-bold"
                                style="background-color: #2b2b2b;">SAMPOOKONG-</span>
                            <input type="text" id="externalIdInput"
                                class="flex-1 px-4 py-3 text-center font-mono text-xl font-bold input-focus border-0"
                                placeholder="199008" maxlength="6" pattern="[0-9]{6}" autocomplete="off" autofocus>
                        </div>
                    </div>
                    <button type="submit"
                        class="w-full gold-gradient text-white font-bold py-4 px-6 rounded-lg transition duration-300 transform hover:scale-105 shadow-lg text-lg">
                        CHECK-IN SEKARANG
                    </button>
                </form>
            </div>

            <!-- Alert Messages -->
            <div id="alertContainer"></div>

            <!-- Result Card -->
            <div id="resultCard" class="festival-card rounded-xl shadow-2xl p-6 hidden">
                <div class="print-area">
                    <!-- Print Header -->
                    <div class="text-center pb-2 mb-2">
                        <div class="text-sm font-bold">Ticketify ID</div>
                    </div>

                    <div class="border-t border-b border-dashed border-gray-600 py-1 mb-2">
                        <div class="text-xs text-center">.</div>
                    </div>

                    <!-- Buyer Details -->
                    <div id="buyerDetails" class="font-mono text-xs mb-3">
                        <!-- Details will be populated here -->
                    </div>

                    <!-- Print Footer -->
                    <div class="border-t border-dashed border-gray-600 pt-2 text-center">
                        <div class="text-xs">Terima kasih</div>
                        <div class="text-xs">~ Semoga puas ~</div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="mt-6 flex gap-3 no-print">
                    <button onclick="printReceipt()"
                        class="flex-1 bg-green-500 hover:bg-green-600 text-white font-bold py-3 px-4 rounded-lg transition duration-200">
                        🖨️ Print
                    </button>
                    <button onclick="resetForm()"
                        class="flex-1 bg-gray-500 hover:bg-gray-600 text-white font-bold py-3 px-4 rounded-lg transition duration-200">
                        🔄 Reset
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        let csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        document.getElementById('checkinForm').addEventListener('submit', function(e) {
            e.preventDefault();
            processCheckin();
        });

        // Auto submit when 6 digits entered
        document.getElementById('externalIdInput').addEventListener('input', function(e) {
            // Only allow numbers
            this.value = this.value.replace(/[^0-9]/g, '');

            if (this.value.length === 6) {
                setTimeout(() => processCheckin(), 300);
            }
        });

        function processCheckin() {
            const externalIdNumber = document.getElementById('externalIdInput').value;

            if (externalIdNumber.length !== 6) {
                showAlert('Harap masukkan 6 digit angka!', 'error');
                return;
            }

            // Show loading
            showAlert('Memproses check-in...', 'loading');

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
                    if (data.success) {
                        showAlert('✅ Check-in berhasil!', 'success');
                        displayResult(data.data);
                    } else {
                        showAlert('❌ ' + data.message, 'error');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showAlert('❌ Terjadi kesalahan sistem!', 'error');
                });
        }

        function displayResult(data) {
            const resultCard = document.getElementById('resultCard');
            const buyerDetails = document.getElementById('buyerDetails');

            buyerDetails.innerHTML = `
                <div class="mb-2">
                    <div>11. ${data.external_id}</div>
                    <div class="ml-4">Tlp: ${data.no_handphone}</div>
                </div>
                <div class="border-t border-b border-dashed border-gray-600 py-1 mb-2">
                    <div class="text-xs text-center">.</div>
                </div>
                <div class="mb-2">
                    <div>Kasir&nbsp;&nbsp;&nbsp;&nbsp;: System</div>
                    <div>Tanggal&nbsp;: ${data.checked_in_at}</div>
                    <div>No. Nota : #CHK${data.external_id.split('-')[1]}</div>
                </div>
                <div class="border-t border-b border-dashed border-gray-600 py-1 mb-2">
                    <div class="text-xs text-center">.</div>
                </div>
                <div class="mb-2">
                    <div>${data.ticket_name}</div>
                    <div class="text-right">${data.quantity}.000</div>
                </div>
            `;

            resultCard.classList.remove('hidden');

            // Scroll to result
            setTimeout(() => {
                resultCard.scrollIntoView({
                    behavior: 'smooth',
                    block: 'center'
                });
            }, 100);
        }

        function printReceipt() {
            window.print();
        }

        function resetForm() {
            document.getElementById('externalIdInput').value = '';
            document.getElementById('resultCard').classList.add('hidden');
            document.getElementById('alertContainer').innerHTML = '';
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

            alertContainer.innerHTML = `
                <div class="festival-card ${alertClasses[type]} px-4 py-3 rounded-lg mb-4 text-center font-semibold no-print" ${loadingStyle}>
                    ${message}
                </div>
            `;

            if (type !== 'loading') {
                setTimeout(() => {
                    alertContainer.innerHTML = '';
                }, type === 'success' ? 3000 : 5000);
            }
        }

        // Auto focus back to input after inactivity
        let inactivityTimer;

        function resetInactivityTimer() {
            clearTimeout(inactivityTimer);
            inactivityTimer = setTimeout(() => {
                if (document.getElementById('resultCard').classList.contains('hidden')) {
                    document.getElementById('externalIdInput').focus();
                }
            }, 15000);
        }

        ['click', 'keypress', 'scroll', 'mousemove'].forEach(event => {
            document.addEventListener(event, resetInactivityTimer);
        });

        resetInactivityTimer();

        // Focus input on page load
        window.addEventListener('load', () => {
            document.getElementById('externalIdInput').focus();
        });
    </script>
</body>

</html>
