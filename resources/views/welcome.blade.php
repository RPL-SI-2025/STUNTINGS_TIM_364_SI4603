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
        <form id="bmiForm" method="POST">
                @csrf
                <input type="text" name="gender" placeholder="Gender (Pria/Wanita)"  class="w-full p-2 mb-2 border border-gray-300 rounded" required>
                <input type="number" name="tinggi" placeholder="Tinggi Badan (cm)" class="w-full p-2 mb-2 border border-gray-300 rounded" required>
                <input type="number" name="berat" placeholder="Berat Badan (kg)"class="w-full p-2 mb-2 border border-gray-300 rounded" required>
                <input type="text" placeholder="BMI Score" class="w-full p-2 mb-2 border border-gray-400 bg-gray-300 rounded" readonly>
                <input type="text" placeholder="Status" class="w-full p-2 mb-2 border border-gray-400 bg-gray-300 rounded" readonly>

    </form>
</body>
</html>
