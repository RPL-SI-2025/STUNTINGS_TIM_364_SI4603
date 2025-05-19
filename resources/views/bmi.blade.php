<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kalkulator BMI</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body class="bg-gray-100 justify-center items-center min-h-screen p-12">
    <!-- Top Bar -->
    <div class="bg-gray-800 text-white p-4 flex justify-between items-center">
        <div class="flex items-center">
            <!-- Logout Button Form -->
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="mr-2 text-lg">&lt;-</button>
            </form>
            <h1 class="text-xl font-bold">Kalkulator BMI</h1>
        </div>
      
        <!-- Display User's Name if logged in -->
        @if(Auth::check())
            <div class="text-lg">
                Welcome, {{ Auth::user()->nama_anak }}
            </div>
        @else
            <div class="text-lg">
                Please log in
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

    </div>

    <!-- BMI Form Section -->
    <div class="bg-gray-200 p-4 rounded-lg mt-4">
        <form id="bmiForm" action="{{ route('hitung-bmi') }}" method="POST">
            @csrf
            <select name="gender" class="w-full p-2 mb-2 border border-gray-300 rounded" required>
                <option value="" disabled {{ session('gender') == null ? 'selected' : '' }}>Pilih Gender</option>
                <option value="pria" {{ session('gender') == 'pria' ? 'selected' : '' }}>Pria</option>
                <option value="wanita" {{ session('gender') == 'wanita' ? 'selected' : '' }}>Wanita</option>
            </select>
            
            <input type="number" name="tinggi" placeholder="Tinggi Badan (cm)" value="{{ session('tinggi') }}" class="w-full p-2 mb-2 border border-gray-300 rounded" required>
            <input type="number" name="berat" placeholder="Berat Badan (kg)" value="{{ session('berat') }}" class="w-full p-2 mb-2 border border-gray-300 rounded" required>
            <input type="text" value="{{ session('bmi') }}" placeholder="BMI Score" class="w-full p-2 mb-2 border border-gray-400 bg-gray-300 rounded" readonly>
            <input type="text" value="{{ session('status') }}" placeholder="Status" class="w-full p-2 mb-2 border border-gray-400 bg-gray-300 rounded" readonly>

            <button type="submit" class="w-full bg-blue-500 text-white py-2 rounded mb-2" onclick="setFormAction(event, '{{ route('hitung-bmi') }}')">Hitung</button>
            <button type="submit" class="w-full bg-pink-500 text-white py-2 rounded mb-2" onclick="setFormAction(event, '{{ route('simpan-bmi') }}')">Simpan</button>
            <button type="reset" class="w-full bg-red-500 text-white py-2 rounded" onclick="setFormAction(event, '{{ route('reset-bmi') }}')">Reset</button>
        </form>
    </div>

   <!-- BMI Data Table -->
    <div class="mt-10">
        <table class="w-full border-collapse border border-gray-300 text-left text-sm">
            <thead>
                <tr class="bg-gray-200">
                    <th class="border border-gray-300 px-2 py-1">No</th>
                    <th class="border border-gray-300 px-2 py-1">Tanggal</th>
                    <th class="border border-gray-300 px-2 py-1">Tinggi</th>
                    <th class="border border-gray-300 px-2 py-1">Berat Badan</th>
                    <th class="border border-gray-300 px-2 py-1">BMI Score</th>
                    <th class="border border-gray-300 px-2 py-1">Status</th>
                    <th class="border border-gray-300 px-2 py-1"> </th>
                </tr>
            </thead>
            <tbody>
                @isset($bmiRecords)
                    @if($bmiRecords->isNotEmpty())
                        @foreach($bmiRecords as $index => $data)
                            <tr class="border border-gray-300">
                                <td class="border border-gray-300 px-2 py-1">{{ $index + 1 }}</td>
                                <td class="border border-gray-300 px-2 py-1">{{ $data->tanggal }}</td>
                                <td class="border border-gray-300 px-2 py-1">{{ $data->tinggi }} cm</td>
                                <td class="border border-gray-300 px-2 py-1">{{ $data->berat }} kg</td>
                                <td class="border border-gray-300 px-2 py-1">{{ $data->bmi }}</td>
                                <td class="border border-gray-300 px-2 py-1">{{ $data->status }}</td>
                                <td class="border border-gray-300 px-2 py-1">
                                    <form action="{{ route('hapus-bmi-row', $data->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="bg-red-500 text-white px-2 py-1 rounded">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="7" class="text-center border border-gray-300 px-2 py-1">Belum ada data</td>
                        </tr>
                    @endif
                @else
                    <tr>
                        <td colspan="7" class="text-center border border-gray-300 px-2 py-1">Data tidak tersedia</td>
                    </tr>
                @endisset
            </tbody>
        </table>
        
    </div>
    <div class="mt-10 bg-white p-4 rounded-lg shadow-md">
    <h2 class="text-lg font-semibold mb-2">Grafik Perkembangan BMI</h2>
    <canvas id="bmiChart" height="100"></canvas>
    </div>

    <script>
        function setFormAction(event, actionUrl) {
            event.preventDefault(); // Prevent default form submission
            document.getElementById('bmiForm').action = actionUrl;
            document.getElementById('bmiForm').submit(); // Submit the form with new action
        }
    </script>

    <script>
    const labels = @json($bmiRecords->pluck('tanggal'));
    const data = @json($bmiRecords->pluck('bmi'));

    const ctx = document.getElementById('bmiChart').getContext('2d');
    const bmiChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: labels,
            datasets: [{
                label: 'BMI Score',
                data: data,
                borderColor: 'rgb(75, 192, 192)',
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                fill: true,
                tension: 0.3,
                pointRadius: 5,
                pointHoverRadius: 7
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: false
                }
             }
          }
        });
    </script>

@if ($lastBmi)
<div class="max-w-5xl w-full mx-auto bg-gray-200 p-8 rounded-lg shadow-lg mt-8">
    <h2 class="text-2xl font-semibold mb-6 text-gray-800">🔥 Estimasi Kebutuhan Kalori Harian</h2>

    <form method="POST" action="{{ route('hitungKalori') }}" class="space-y-6">
        @csrf

        {{-- Gender (otomatis dari data terakhir, tapi masih bisa diubah) --}}
        <div>
            <label for="gender" class="block mb-2 font-medium text-gray-700">Jenis Kelamin</label>
            <select id="gender" name="gender" required
            class="w-full p-3 rounded-md border border-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500">
            <option value="pria" {{ old('gender', $lastBmi->gender) == 'pria' ? 'selected' : '' }}>Pria</option>
            <option value="wanita" {{ old('gender', $lastBmi->gender) == 'wanita' ? 'selected' : '' }}>Wanita</option>
            </select>
        </div>

        {{-- Berat Badan --}}
        <div>
            <label for="berat" class="block mb-2 font-medium text-gray-700">Berat Badan (kg)</label>
            <input id="berat" name="berat" type="number" step="0.1" required
            value="{{ old('berat', $lastBmi->berat) }}"
            class="w-full p-3 rounded-md border border-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500" />
        </div>

        {{-- Tinggi Badan --}}
        <div>
            <label for="tinggi" class="block mb-2 font-medium text-gray-700">Tinggi Badan (cm)</label>
            <input id="tinggi" name="tinggi" type="number" step="0.1" required
            value="{{ old('tinggi', $lastBmi->tinggi) }}"
            class="w-full p-3 rounded-md border border-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500" />
        </div>

        {{-- Usia --}}
        <div>
            <label for="usia" class="block mb-2 font-medium text-gray-700">Usia (tahun)</label>
            <input id="usia" name="usia" type="number" required
            value="{{ old('usia', $lastBmi->usia) }}"
            class="w-full p-3 rounded-md border border-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500" />
        </div>

        {{-- Level Aktivitas --}}
        <div>
            <label for="activity_level" class="block mb-2 font-medium text-gray-700">Level Aktivitas</label>
            <select id="activity_level" name="activity_level" class="w-full p-3 rounded-md border border-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500" required>
                <option value="sedentary" {{ ($lastBmi->activity_level == 'sedentary') ? 'selected' : '' }}>Tidak aktif (sedikit atau tidak ada olahraga)</option>
                <option value="lightly_active" {{ ($lastBmi->activity_level == 'lightly_active') ? 'selected' : '' }}>Sedikit aktif (olahraga ringan 1–3 hari/minggu)</option>
                <option value="moderately_active" {{ ($lastBmi->activity_level == 'moderately_active') ? 'selected' : '' }}>Cukup aktif (olahraga sedang 3–5 hari/minggu)</option>
                <option value="very_active" {{ ($lastBmi->activity_level == 'very_active') ? 'selected' : '' }}>Sangat aktif (olahraga keras 6–7 hari/minggu)</option>
                <option value="extra_active" {{ ($lastBmi->activity_level == 'extra_active') ? 'selected' : '' }}>Ekstra aktif (kerja fisik berat atau 2x olahraga/hari)</option>
            </select>
        </div>

        {{-- Tombol Hitung --}}
        <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-3 rounded-md transition">Hitung Estimasi Kalori</button>
    </form>
      @endif
    {{-- Hasil Kalori Ditampilkan --}}
    @if(session('kalori'))
        <div class="mt-6 bg-green-100 border border-green-400 text-green-800 p-4 rounded shadow">
            <h2 class="text-lg font-bold">🔥 Estimasi Kebutuhan Kalori Harian</h2>
            <ul class="list-disc ml-5 mt-2">
                <li>Berat: {{ session('berat') }} kg</li>
                <li>Tinggi: {{ session('tinggi') }} cm</li>
                <li>Usia: {{ session('usia') }} tahun</li>
                <li>Gender: {{ session('gender') }}</li>
                <li>Aktivitas: {{ session('activity_level') }}</li>
            </ul>
            <p class="mt-3 font-semibold">Total Kalori per Hari: {{ session('kalori') }} kcal</p>
        </div>
    @endif


</body>
</html>
