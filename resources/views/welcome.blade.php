<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kalkulator BMI</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 justify-center items-center min-h-screen p-12">
    <!-- <div class="bg-white p-6 rounded-lg shadow-md w-[500px]"> -->
        <div class="flex items-center mb-4">
            <button class="mr-2 text-lg"><-</button>
            <h1 class="text-xl font-bold">Kalkulator BMI</h1>
        </div>
        <div class="bg-gray-200 p-4 rounded-lg">
        <form id="bmiForm" action="{{ route('hitung-bmi') }}" method="POST">
                @csrf
                <input type="text" name="gender" placeholder="Gender (Pria/Wanita)" value="{{ session('gender') }}" class="w-full p-2 mb-2 border border-gray-300 rounded" required>
                <input type="number" name="tinggi" placeholder="Tinggi Badan (cm)" value="{{ session('tinggi') }}" class="w-full p-2 mb-2 border border-gray-300 rounded" required>
                <input type="number" name="berat" placeholder="Berat Badan (kg)" value="{{ session('berat') }}" class="w-full p-2 mb-2 border border-gray-300 rounded" required>
                <input type="text" value="{{ session('bmi') }}" placeholder="BMI Score" class="w-full p-2 mb-2 border border-gray-400 bg-gray-300 rounded" readonly>
                <input type="text" value="{{ session('status') }}" placeholder="Status" class="w-full p-2 mb-2 border border-gray-400 bg-gray-300 rounded" readonly>


                <button type="submit" class="w-full bg-gray-500 text-white py-2 rounded mb-2" onclick="setFormAction(event, '{{ route('hitung-bmi') }}')">Hitung</button>
                <button type="submit" class="w-full bg-gray-500 text-white py-2 rounded mb-2" onclick="setFormAction(event, '{{ route('simpan-bmi') }}')">Simpan</button>
                <button type="reset" class="w-full bg-gray-500 text-white py-2 rounded" onclick="setFormAction(event, '{{ route('reset-bmi') }}')">Reset</button>

    </form>

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
                @if(session('bmiData'))
                    @foreach(session('bmiData') as $index => $data)
                        <tr class="border border-gray-300">
                            <td class="border border-gray-300 px-2 py-1">{{ $index + 1 }}</td>
                            <td class="border border-gray-300 px-2 py-1">{{ $data['tanggal'] }}</td>
                            <td class="border border-gray-300 px-2 py-1">{{ $data['tinggi'] }} cm</td>
                            <td class="border border-gray-300 px-2 py-1">{{ $data['berat'] }} kg</td>
                            <td class="border border-gray-300 px-2 py-1">{{ $data['bmi'] }}</td>
                            <td class="border border-gray-300 px-2 py-1">{{ $data['status'] }}</td>
                            <td class="border border-gray-300 px-2 py-1">
                                <form action="{{ route('hapus-bmi-row', $index) }}" method="POST">
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
            </tbody>
            </table>
        <!-- </div> -->
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
