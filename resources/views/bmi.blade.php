<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kalkulator BMI</title>
    <script src="https://cdn.tailwindcss.com"></script>
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


    <script>
        function setFormAction(event, actionUrl) {
            event.preventDefault(); // Prevent default form submission
            document.getElementById('bmiForm').action = actionUrl;
            document.getElementById('bmiForm').submit(); // Submit the form with new action
        }
    </script>
</body>
</html>
