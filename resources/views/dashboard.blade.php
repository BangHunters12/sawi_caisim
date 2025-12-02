@extends('layouts.app')

@section('header-actions')
<button onclick="simulateData()" class="px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-medium rounded-lg transition-colors shadow-sm flex items-center gap-2">
    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.384-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path>
    </svg>
    Simulate Data
</button>
@endsection

@section('content')
    <!-- Stats Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        {{-- CARD 1: TEMPERATURE --}}
        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100 hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-gray-500 text-sm font-medium">Temperature</h3>
                <div class="p-2 bg-orange-50 rounded-lg">
                    <svg class="w-6 h-6 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                    </svg>
                </div>
            </div>
            <div class="flex items-baseline gap-2">
                <span id="tempValue" class="text-3xl font-bold text-gray-800">
                    {{ $latest->temperature ?? '--' }}
                </span>
                <span class="text-sm text-gray-500">°C</span>
            </div>
            <p class="text-xs text-green-500 mt-2 flex items-center gap-1">
                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                </svg>
                Latest Reading
            </p>
        </div>

        {{-- CARD 2: pH --}}
        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100 hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-gray-500 text-sm font-medium">pH Level</h3>
                <div class="p-2 bg-emerald-50 rounded-lg">
                    <svg class="w-6 h-6 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10M12 3l4 8H8l4-8z"></path>
                    </svg>
                </div>
            </div>
            <div class="flex items-baseline gap-2">
                <span id="phValue" class="text-3xl font-bold text-gray-800">
                    {{ $latest->ph ?? '--' }}
                </span>
            </div>
            <p class="text-xs text-green-500 mt-2 flex items-center gap-1">
                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                </svg>
                Optimal range: 5.5 – 6.5
            </p>
        </div>

        {{-- CARD 3: TDS --}}
        <div class="bg-white rounded-xl shadow-sm p-6 border-l-4 {{ ($latest->tds_value ?? 0) > 1200 ? 'border-yellow-500 bg-yellow-50' : 'border-purple-500' }} hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between mb-4">
                <div class="flex items-center gap-3">
                    <div class="p-2 bg-purple-100 rounded-lg text-purple-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path>
                        </svg>
                    </div>
                    <h3 class="text-gray-500 font-medium">TDS Value</h3>
                </div>
                @if(($latest->tds_value ?? 0) > 1200)
                    <span class="text-xs font-bold text-yellow-700 bg-yellow-100 px-2 py-1 rounded-full">HIGH</span>
                @endif
            </div>
            <div class="flex items-end gap-2">
                <span id="tdsValue" class="text-3xl font-bold text-gray-800">
                    {{ $latest->tds_value ?? 0 }}
                </span>
                <span class="text-gray-500 mb-1">ppm</span>
            </div>
            <p class="text-sm {{ ($latest->tds_value ?? 0) > 1200 ? 'text-yellow-600' : 'text-purple-600' }} mt-2">
                {{ ($latest->tds_value ?? 0) > 1200 ? 'Check Nutrient Concentration' : 'Nutrient Level OK' }}
            </p>
        </div>

        {{-- CARD 4: WATER LEVEL --}}
        <div class="bg-white rounded-xl shadow-sm p-6 border-l-4 {{ ($latest->water_level ?? 0) < 20 ? 'border-red-500 bg-red-50' : 'border-blue-500' }} hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between mb-4">
                <div class="flex items-center gap-3">
                    <div class="p-2 bg-blue-100 rounded-lg text-blue-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 22s8-4 8-10a8 8 0 10-16 0c0 6 8 10 8 10z"></path>
                        </svg>
                    </div>
                    <h3 class="text-gray-500 font-medium">Water Level</h3>
                </div>
                @if(($latest->water_level ?? 0) < 20)
                    <span class="text-xs font-bold text-red-600 bg-red-100 px-2 py-1 rounded-full animate-pulse">LOW</span>
                @endif
            </div>
            <div class="flex items-end gap-2">
                <span id="waterValue" class="text-3xl font-bold text-gray-800">
                    {{ $latest->water_level ?? 0 }}
                </span>
                <span class="text-gray-500 mb-1">cm</span>
            </div>
            <p class="text-sm {{ ($latest->water_level ?? 0) < 20 ? 'text-red-600' : 'text-blue-600' }} mt-2">
                {{ ($latest->water_level ?? 0) < 20 ? 'Refill Tank' : 'Tank Level OK' }}
            </p>
        </div>
    </div>

    {{-- Charts Section --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Temperature & pH History</h3>
            <canvas id="tempPhChart" height="200"></canvas>
        </div>
        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">TDS & Water Level History</h3>
            <canvas id="tdsWaterChart" height="200"></canvas>
        </div>
    </div>

    <!-- Recent Alerts/Logs -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
            <h3 class="text-lg font-semibold text-gray-800">Recent Alerts</h3>
            <button class="text-sm text-emerald-600 hover:text-emerald-700 font-medium">View All</button>
        </div>
        <div class="divide-y divide-gray-100">
            <div class="px-6 py-4 flex items-center gap-4">
                <div class="w-2 h-2 bg-green-500 rounded-full"></div>
                <div class="flex-1">
                    <p class="text-sm font-medium text-gray-900">System Online</p>
                    <p class="text-xs text-gray-500">Monitoring started</p>
                </div>
                <span class="px-2 py-1 bg-green-50 text-green-700 text-xs rounded-md">Info</span>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    {{-- Kalau Chart.js belum di-include di layout, aktifkan baris ini: --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    {{-- MQTT client (browser) --}}
    <script src="https://unpkg.com/mqtt/dist/mqtt.min.js"></script>

    <script>
        // ================== DATA HISTORY AWAL DARI LARAVEL ==================
        const historyData = @json($history);

        const labels    = historyData.map(item => new Date(item.created_at).toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'}));
        const tempData  = historyData.map(item => item.temperature);
        const phData    = historyData.map(item => item.ph);
        const tdsData   = historyData.map(item => item.tds_value);
        const waterData = historyData.map(item => item.water_level);

        // ================== CHART 1: TEMP & PH ==================
        const ctx1 = document.getElementById('tempPhChart').getContext('2d');
        const tempPhChart = new Chart(ctx1, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Temperature (°C)',
                    data: tempData,
                    borderColor: '#f97316',
                    tension: 0.4
                }, {
                    label: 'pH',
                    data: phData,
                    borderColor: '#10b981',
                    tension: 0.4
                }]
            },
            options: {
                responsive: true,
                plugins: { legend: { position: 'bottom' } },
                scales: {
                    y: { beginAtZero: false }
                }
            }
        });

        // ================== CHART 2: TDS & WATER LEVEL ==================
        const ctx2 = document.getElementById('tdsWaterChart').getContext('2d');
        const tdsWaterChart = new Chart(ctx2, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: 'TDS (ppm)',
                    data: tdsData,
                    borderColor: '#a855f7',
                    tension: 0.4,
                    yAxisID: 'y'
                }, {
                    label: 'Water Level (cm)',
                    data: waterData,
                    borderColor: '#3b82f6',
                    tension: 0.4,
                    yAxisID: 'y1'
                }]
            },
            options: {
                responsive: true,
                plugins: { legend: { position: 'bottom' } },
                scales: {
                    y: {
                        type: 'linear',
                        display: true,
                        position: 'left',
                        title: { display: true, text: 'TDS (ppm)' }
                    },
                    y1: {
                        type: 'linear',
                        display: true,
                        position: 'right',
                        title: { display: true, text: 'Water Level (cm)' },
                        grid: { drawOnChartArea: false }
                    }
                }
            }
        });

        // ================== MQTT CONFIG (WEB CLIENT) ==================
        // GANTI USERNAME/PASSWORD sesuai HiveMQ Cloud kamu
        const MQTT_WS_URL  = "wss://c19cb715626944f6991e5ad93c7c93f2.s1.eu.hivemq.cloud:8884/mqtt";
        const MQTT_USER    = "dendi";   // TODO: ganti
        const MQTT_PASS    = "Dendi123";   // TODO: ganti

        const TOPIC_DATA   = "hydro/sistem1/data";
        const MAX_POINTS   = 20; // jumlah maksimum titik di chart

        const mqttOptions = {
            username: MQTT_USER,
            password: MQTT_PASS,
            clean: true,
            reconnectPeriod: 1000, // 1 detik
        };

        console.log("Connecting to MQTT broker from dashboard...");
        const mqttClient = mqtt.connect(MQTT_WS_URL, mqttOptions);

        mqttClient.on("connect", () => {
            console.log("MQTT connected (web dashboard)");
            mqttClient.subscribe(TOPIC_DATA, (err) => {
                if (err) {
                    console.error("Failed to subscribe:", err);
                } else {
                    console.log("Subscribed to", TOPIC_DATA);
                }
            });
        });

        mqttClient.on("reconnect", () => {
            console.log("MQTT reconnecting...");
        });

        mqttClient.on("error", (err) => {
            console.error("MQTT error:", err);
        });

        mqttClient.on("close", () => {
            console.log("MQTT connection closed");
        });

        // ================== HANDLE MESSAGE DARI ESP32 ==================
        mqttClient.on("message", (topic, message) => {
            if (topic !== TOPIC_DATA) return;

            let data;
            try {
                data = JSON.parse(message.toString());
                // Format dari ESP32:
                // {
                //   "temp": 25.3,
                //   "tds": 900,
                //   "ph": 6.50,
                //   "dist": 12.3,
                //   "pA": 1,
                //   "pB": 0,
                //   "pR": 0
                // }
            } catch (e) {
                console.error("Failed to parse MQTT JSON:", e);
                return;
            }

            // Update kartu
            if (typeof data.temp !== "undefined") {
                document.getElementById("tempValue").textContent = data.temp.toFixed(1);
            }
            if (typeof data.ph !== "undefined") {
                document.getElementById("phValue").textContent = data.ph.toFixed(2);
            }
            if (typeof data.tds !== "undefined") {
                document.getElementById("tdsValue").textContent = Math.round(data.tds);
            }
            if (typeof data.dist !== "undefined") {
                document.getElementById("waterValue").textContent = data.dist.toFixed(1);
            }

            // Update chart realtime
            const nowLabel = new Date().toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'});

            // Chart 1: Temp & pH
            tempPhChart.data.labels.push(nowLabel);
            tempPhChart.data.datasets[0].data.push(data.temp ?? null);
            tempPhChart.data.datasets[1].data.push(data.ph ?? null);

            if (tempPhChart.data.labels.length > MAX_POINTS) {
                tempPhChart.data.labels.shift();
                tempPhChart.data.datasets.forEach(ds => ds.data.shift());
            }
            tempPhChart.update('none');

            // Chart 2: TDS & Water Level
            tdsWaterChart.data.labels.push(nowLabel);
            tdsWaterChart.data.datasets[0].data.push(data.tds ?? null);
            tdsWaterChart.data.datasets[1].data.push(data.dist ?? null);

            if (tdsWaterChart.data.labels.length > MAX_POINTS) {
                tdsWaterChart.data.labels.shift();
                tdsWaterChart.data.datasets.forEach(ds => ds.data.shift());
            }
            tdsWaterChart.update('none');
        });

        // ================== SIMULASI DATA KE BACKEND (OPSIONAL) ==================
        function simulateData() {
            const data = {
                temperature: (Math.random() * (32 - 24) + 24).toFixed(1),
                ph: (Math.random() * (6.8 - 5.5) + 5.5).toFixed(2),
                tds_value: (Math.random() * (1200 - 500) + 500).toFixed(0),
                water_level: (Math.random() * (40 - 10) + 10).toFixed(1)
            };

            fetch('/api/sensors', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify(data)
            })
            .then(response => response.json())
            .then(data => {
                alert('Data simulated! Reloading page...');
                window.location.reload();
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Simulation failed');
            });
        }
    </script>
@endpush
