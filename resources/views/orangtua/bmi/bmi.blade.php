<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Kalkulator BMI & Estimasi Kalori</title>

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body class="bg-gray-100 min-h-screen p-8 flex flex-col items-center">

    {{-- Top Bar --}}
    <div class="bg-gray-800 text-white w-full max-w-5xl p-4 flex justify-between items-center rounded-md shadow-md mb-6">
        <div class="flex items-center space-x-4">
            <a href="{{ route('orangtua.dashboard') }}" class="text-lg hover:underline">&lt;-</a>
            <h1 class="text-xl font-bold">Kalkulator BMI</h1>
        </div>
        <div>
            @auth
                <span>Welcome, {{ Auth::user()->nama_anak }}</span>
            @else
                <span>Silakan login</span>
            @endauth
        </div>
    </div>

    {{-- Alert --}}
    @if ($errors->any())
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4 max-w-5xl w-full">
        <strong class="font-bold">Error!</strong>
        <ul class="list-disc ml-5">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    @if (session('error'))
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4 max-w-5xl w-full">
        <strong class="font-bold">Error!</strong>
        <span>{{ session('error') }}</span>
    </div>
    @endif

    @if (session('success'))
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4 max-w-5xl w-full">
        <strong class="font-bold">Success!</strong>
        <span>{{ session('success') }}</span>
    </div>
    @endif

    {{-- BMI Form --}}
    <div class="bg-white max-w-5xl w-full p-6 rounded-lg shadow mb-10">
        <h2 class="text-2xl font-semibold mb-4">Hitung BMI</h2>

        <div id="bmiFormAlert" class="hidden bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            <strong class="font-bold">Error!</strong>
            <span id="bmiFormAlertMessage">Harap lengkapi semua data terlebih dahulu.</span>
        </div>

        <form id="bmiForm" method="POST" action="{{ route('hitung-bmi') }}">
            @csrf

            <x-dropdown-with-label
                name="gender"
                id="gender"
                label="Gender"
                :options="['pria' => 'Pria', 'wanita' => 'Wanita']"
                :selected="session('gender')"
                required
            />

            <x-input-with-label
                type="number"
                name="tinggi"
                id="tinggi"
                label="Tinggi Badan (cm)"
                :value="session('tinggi')"
                required
            />

            <x-input-with-label
                type="number"
                name="berat"
                id="berat"
                label="Berat Badan (kg)"
                :value="session('berat')"
                required
            />

            <x-input-with-label
                type="text"
                name="bmi"
                label="BMI Score"
                :value="session('bmi')"
                readonly
                class="bg-gray-200"
            />
            <x-input-with-label
                type="text"
                name="status"
                label="Status"
                :value="session('status')"
                readonly
                class="bg-gray-200"
            />

            <div class="flex flex-col space-y-3">
                <button type="button" class="bg-[#005f77] hover:bg-[#014f66] text-white font-semibold text-sm rounded-md px-4 py-2 transition" onclick="validateAndSubmit('{{ route('hitung-bmi') }}')">Hitung</button>
                <button type="button" class="bg-[#005f77] hover:bg-[#014f66] text-white font-semibold text-sm rounded-md px-4 py-2 transition" onclick="validateAndSubmit('{{ route('simpan-bmi') }}', true)">Simpan</button>
                <button type="reset" class="bg-red-600 hover:bg-red-700 text-white font-semibold text-sm rounded-md px-4 py-2 transition" onclick="setFormAction(event, '{{ route('reset-bmi') }}')">Reset</button>
            </div>
        </form>
    </div>

    {{-- Tabel BMI --}}
    <div class="max-w-5xl w-full overflow-x-auto mb-10">
        <h2 class="text-2xl font-semibold mb-4">Riwayat Data BMI</h2>
        <table class="min-w-full bg-white rounded-lg shadow overflow-hidden border border-gray-300">
            <thead class="bg-gray-200 text-gray-700">
                <tr>
                    <th class="text-left py-2 px-3 border border-gray-300">No</th>
                    <th class="text-left py-2 px-3 border border-gray-300">Tanggal</th>
                    <th class="text-left py-2 px-3 border border-gray-300">Gender</th>
                    <th class="text-left py-2 px-3 border border-gray-300">Tinggi (cm)</th>
                    <th class="text-left py-2 px-3 border border-gray-300">Berat (kg)</th>
                    <th class="text-left py-2 px-3 border border-gray-300">BMI</th>
                    <th class="text-left py-2 px-3 border border-gray-300">Status</th>
                    <th class="text-center py-2 px-3 border border-gray-300">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @if(isset($bmiRecords) && $bmiRecords->isNotEmpty())
                    @foreach($bmiRecords as $index => $data)
                    <tr class="border-t border-gray-300">
                        <td class="py-2 px-3 border border-gray-300">{{ $index + 1 }}</td>
                        <td class="py-2 px-3 border border-gray-300">{{ $data->tanggal }}</td>
                        <td class="py-2 px-3 border border-gray-300">{{ ucfirst($data->gender ?? 'tidak diketahui') }}</td>
                        <td class="py-2 px-3 border border-gray-300">{{ $data->tinggi }}</td>
                        <td class="py-2 px-3 border border-gray-300">{{ $data->berat }}</td>
                        <td class="py-2 px-3 border border-gray-300">{{ $data->bmi }}</td>
                        <td class="py-2 px-3 border border-gray-300">{{ $data->status }}</td>
                        <td class="py-2 px-3 border border-gray-300 text-center">
                            <form action="{{ route('hapus-bmi-row', $data->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                                @csrf
                                <button type="submit" class="bg-red-600 hover:bg-red-700 text-white font-semibold text-sm rounded-md px-4 py-2 transition">Hapus</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="7" class="text-center py-4 text-gray-500">Belum ada data BMI.</td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>

    {{-- Grafik BMI --}}
    <div class="max-w-5xl w-full bg-white p-6 rounded-lg shadow mb-10">
        <h2 class="text-2xl font-semibold mb-4">Grafik Perkembangan BMI</h2>
        <canvas id="bmiChart" height="100"></canvas>
    </div>

    
    {{-- Estimasi Kalori --}}
    @if ($lastBmi)
    <div class="max-w-5xl w-full bg-white p-6 rounded-lg shadow mb-10">
        <h2 class="text-2xl font-semibold mb-4">Estimasi Kebutuhan Kalori Harian</h2>


        <div id="kaloriFormAlert" class="hidden bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
            <span id="kaloriFormAlertMessage" class="block sm:inline"></span>
        </div>
        
        <form id="kaloriForm" action="{{ route('hitungKalori') }}" method="POST" class="space-y-4">
            @csrf
            

            <x-dropdown-with-label
            name="gender"
            id="gender_kalori"
            label="Gender"
            :options="['pria' => 'Pria', 'wanita' => 'Wanita']"
            :selected="old('gender', $lastBmi->gender)"
            required
            />
            
            <x-input-with-label
                type="number"
                name="berat"
                id="berat_kalori"
                label="Berat Badan (kg)"
                :value="old('berat', $lastBmi->berat)"
            />
            
            <x-input-with-label
                type="number"
                name="tinggi"
                id="tinggi_kalori"
                label="Tinggi Badan (cm)"
                :value="old('tinggi', $lastBmi->tinggi)"
            />
            

            <x-input-with-label
                type="number"
                name="usia"
                id="usia_kalori"
                label="Usia (tahun)"
                :value="old('usia')"
                min="1"
                required
            />

            <x-dropdown-with-label
                name="activity_level"
                id="activity_level"
                label="Level Aktivitas"
                :options="[
                    'sedentary' => 'Tidak aktif (sedikit atau tidak ada olahraga)',
                    'lightly_active' => 'Sedikit aktif (olahraga ringan 1–3 hari/minggu)',
                    'moderately_active' => 'Cukup aktif (olahraga sedang 3–5 hari/minggu)',
                    'very_active' => 'Sangat aktif (olahraga keras 6–7 hari/minggu)',
                    'extra_active' => 'Ekstra aktif (kerja fisik berat atau 2x olahraga/hari)'
                ]"
                :selected="old('activity_level', $lastBmi->activity_level ?? '')"
                required
            />

            <div>
                <button type="button" id="hitungKaloriBtn" class="bg-[#005f77] hover:bg-[#014f66] text-white font-semibold text-sm rounded-md px-4 py-2 transition w-full">Hitung Estimasi Kalori</button>
            </div>
        </form>

        {{-- Hasil Kalori Ditampilkan --}}
        @if(session('kalori') && session('show_kalori_results'))
        <div class="mt-6 bg-green-100 border border-green-400 text-green-800 p-4 rounded shadow">
            <h2 class="text-lg font-bold">🔥 Estimasi Kebutuhan Kalori Harian</h2>
            <ul class="list-disc ml-5 mt-2">
                <li>Berat: {{ session('berat') }} kg</li>
                <li>Tinggi: {{ session('tinggi') }} cm</li>
                <li>Usia: {{ session('usia') }} tahun</li>
                <li>Gender: {{ ucfirst(session('gender')) }}</li>
                <li>Aktivitas: {{ session('activity_level') }}</li>
            </ul>
            <p class="mt-3 font-semibold">Total Kalori per Hari: {{ session('kalori') }} kcal</p>
        </div>
        @endif
    </div>
    @endif

    {{-- Script --}}
    <script>
        // When the page loads, set up the event listeners
        document.addEventListener('DOMContentLoaded', function() {
            // Set up the gender sync between BMI form and kalori form
            const genderBmiSelect = document.getElementById('gender');
            const genderKaloriSelect = document.getElementById('gender_kalori');
            const tinggiKaloriInput = document.getElementById('tinggi_kalori');
            const beratKaloriInput = document.getElementById('berat_kalori');
            
            // Check if we have saved values from a previous save operation
            const savedGender = localStorage.getItem('bmi_gender');
            const savedTinggi = localStorage.getItem('bmi_tinggi');
            const savedBerat = localStorage.getItem('bmi_berat');
            
            // If we have saved values and the kalori form exists, update it
            if (savedGender && genderKaloriSelect) {
                // Update the gender dropdown in the kalori form
                if (genderKaloriSelect.tagName === 'SELECT') {
                    // For select elements, we need to find the option with the matching value
                    for (let i = 0; i < genderKaloriSelect.options.length; i++) {
                        if (genderKaloriSelect.options[i].value === savedGender) {
                            genderKaloriSelect.selectedIndex = i;
                            break;
                        }
                    }
                } else {
                    // For other input types
                    genderKaloriSelect.value = savedGender;
                }
                
                // Update height and weight if available
                if (savedTinggi && tinggiKaloriInput) {
                    tinggiKaloriInput.value = savedTinggi;
                }
                
                if (savedBerat && beratKaloriInput) {
                    beratKaloriInput.value = savedBerat;
                }
                
                // Clear the localStorage after we've used the values
                localStorage.removeItem('bmi_gender');
                localStorage.removeItem('bmi_tinggi');
                localStorage.removeItem('bmi_berat');
            }
            
            // Set up the change event listener for future changes
            if (genderBmiSelect && genderKaloriInput && genderDisplayInput) {
                genderBmiSelect.addEventListener('change', function() {
                    // Update the hidden gender input in kalori form
                    genderKaloriInput.value = genderBmiSelect.value;
                    // Update the display input with capitalized gender
                    genderDisplayInput.value = genderBmiSelect.value.charAt(0).toUpperCase() + genderBmiSelect.value.slice(1);
                });
            }
        });
        
        function validateAndSubmit(actionUrl, isSave = false) {
            const form = document.getElementById('bmiForm');
            // Get values from the component-based form elements
            const genderSelect = document.getElementById('gender');
            const tinggiInput = document.getElementById('tinggi');
            const beratInput = document.getElementById('berat');
            
            const gender = genderSelect ? genderSelect.value : '';
            const tinggi = tinggiInput ? tinggiInput.value : '';
            const berat = beratInput ? beratInput.value : '';
            const alertDiv = document.getElementById('bmiFormAlert');

            if (!gender || !tinggi || !berat) {
                alertDiv.classList.remove('hidden');
                alertDiv.querySelector('#bmiFormAlertMessage').textContent = 'Harap lengkapi semua data terlebih dahulu.';
                return false;
            }

            alertDiv.classList.add('hidden');
            form.action = actionUrl;
            
            // If this is a save operation, store the values in localStorage before submitting
            // This ensures we can retrieve them after page reload
            if (isSave) {
                localStorage.setItem('bmi_gender', gender);
                localStorage.setItem('bmi_tinggi', tinggi);
                localStorage.setItem('bmi_berat', berat);
            }
            
            form.submit();
            
            // Update the kalori form with the latest values
            updateKaloriForm(gender, tinggi, berat);
        }
        
        // Helper function to update the kalori form with BMI values
        function updateKaloriForm(gender, tinggi, berat) {
            const genderKaloriSelect = document.getElementById('gender_kalori');
            const tinggiKaloriInput = document.getElementById('tinggi_kalori');
            const beratKaloriInput = document.getElementById('berat_kalori');
            
            // Update gender in kalori form
            if (genderKaloriSelect) {
                if (genderKaloriSelect.tagName === 'SELECT') {
                    // For select elements, we need to find the option with the matching value
                    for (let i = 0; i < genderKaloriSelect.options.length; i++) {
                        if (genderKaloriSelect.options[i].value === gender) {
                            genderKaloriSelect.selectedIndex = i;
                            break;
                        }
                    }
                } else {
                    // For other input types
                    genderKaloriSelect.value = gender;
                }
            }
            
            if (tinggiKaloriInput && tinggi) {
                tinggiKaloriInput.value = tinggi;
            }
            
            if (beratKaloriInput && berat) {
                beratKaloriInput.value = berat;
            }
        }

        function setFormAction(event, resetUrl) {
            event.preventDefault();
            const form = document.getElementById('bmiForm');
            form.action = resetUrl;
            form.submit();
        }

        const bmiData = @json($bmiRecords->map(fn($d) => ['tanggal' => $d->tanggal, 'bmi' => $d->bmi]));

        const labels = bmiData.map(item => item.tanggal);
        const data = bmiData.map(item => parseFloat(item.bmi));

        const ctx = document.getElementById('bmiChart').getContext('2d');
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: 'BMI',
                    data: data,
                    borderColor: 'rgba(37, 99, 235, 1)',
                    backgroundColor: 'rgba(37, 99, 235, 0.2)',
                    fill: true,
                    tension: 0.3,
                    pointRadius: 5,
                    pointHoverRadius: 7,
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: false,
                        suggestedMin: 10,
                        suggestedMax: 40
                    }
                }
            }
        });
    
        // Add event listener to the button when the page loads
        document.addEventListener('DOMContentLoaded', function() {
            // Add event listener to the kalori form submit button
            const hitungKaloriBtn = document.getElementById('hitungKaloriBtn');
            if (hitungKaloriBtn) {
                hitungKaloriBtn.addEventListener('click', validateKaloriForm);
            }
        });
        
        // Validation function for the kalori form
        function validateKaloriForm() {
            // Get the form and alert elements
            const form = document.getElementById('kaloriForm');
            const alertDiv = document.getElementById('kaloriFormAlert');
            
            // Initialize error message
            let errorMessage = '';
            
            // Validate weight (berat)
            const beratInputs = form.querySelectorAll('input[name="berat"], #berat, #berat_kalori');
            let beratValue = '';
            for (let i = 0; i < beratInputs.length; i++) {
                if (beratInputs[i] && beratInputs[i].value && beratInputs[i].value.trim() !== '') {
                    beratValue = beratInputs[i].value.trim();
                    break;
                }
            }
            if (!beratValue) {
                errorMessage = 'Berat badan harus diisi.';
            }
            
            // Validate height (tinggi)
            const tinggiInputs = form.querySelectorAll('input[name="tinggi"], #tinggi, #tinggi_kalori');
            let tinggiValue = '';
            for (let i = 0; i < tinggiInputs.length; i++) {
                if (tinggiInputs[i] && tinggiInputs[i].value && tinggiInputs[i].value.trim() !== '') {
                    tinggiValue = tinggiInputs[i].value.trim();
                    break;
                }
            }
            if (!tinggiValue && !errorMessage) {
                errorMessage = 'Tinggi badan harus diisi.';
            }
            
            // Validate age (usia)
            const usiaInputs = form.querySelectorAll('input[name="usia"], #usia, #usia_kalori');
            let usiaValue = '';
            for (let i = 0; i < usiaInputs.length; i++) {
                if (usiaInputs[i] && usiaInputs[i].value && usiaInputs[i].value.trim() !== '') {
                    usiaValue = usiaInputs[i].value.trim();
                    break;
                }
            }
            if (!usiaValue && !errorMessage) {
                errorMessage = 'Usia harus diisi.';
            }
            
            // Validate activity level
            const activityLevelSelect = form.querySelector('select[name="activity_level"], #activity_level');
            let activityLevelValue = '';
            if (activityLevelSelect && activityLevelSelect.value) {
                activityLevelValue = activityLevelSelect.value;
            }
            if (!activityLevelValue && !errorMessage) {
                errorMessage = 'Level aktivitas harus dipilih.';
            }
            
            // If any validation error, show it
            if (errorMessage) {
                alertDiv.classList.remove('hidden');
                alertDiv.querySelector('#kaloriFormAlertMessage').textContent = errorMessage;
                
                // Scroll to the alert
                alertDiv.scrollIntoView({ behavior: 'smooth', block: 'start' });
                return false;
            }
            
            // If all validations pass, submit the form
            alertDiv.classList.add('hidden');
            form.submit();
        }
    </script>

</body>
</html>