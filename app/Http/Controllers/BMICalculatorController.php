<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use App\Models\Bmi;



use Illuminate\Http\Request;

class BMICalculatorController extends Controller
{
    public function showBmiData()
    {
        // Get the authenticated user
        $user = Auth::user();

        // Fetch the BMI records associated with the authenticated user
        $bmiRecords = Bmi::where('user_id', $user->id)->get();

        // Ambil data terakhir
   $lastBmi = Bmi::where('user_id', $user->id)->latest('created_at')->first();


    $estimatedCalories = null;
    $saranKalori = null;

    if ($lastBmi && $lastBmi->usia && $lastBmi->activity_level) {
        $weight = $lastBmi->berat;
        $height = $lastBmi->tinggi;
        $usia = $lastBmi->usia;
        $activityLevel = $lastBmi->activity_level;
        $gender = $lastBmi->gender ?? session('gender', 'pria');

        $bmr = $gender === 'pria'
            ? 10 * $weight + 6.25 * $height - 5 * $usia + 5
            : 10 * $weight + 6.25 * $height - 5 * $usia - 161;

        $activityFactors = [
            'sedentary' => 1.2,
            'lightly_active' => 1.375,
            'moderately_active' => 1.55,
            'very_active' => 1.725,
            'extra_active' => 1.9,
        ];

        $factor = $activityFactors[$activityLevel] ?? 1.2;
        $estimatedCalories = round($bmr * $factor);

        // Sesuaikan saran kalori berdasarkan status BMI
        $status = $lastBmi->status;
        $saranKalori = match($status) {
            'Underweight' => $estimatedCalories + 500,
            'Overweight', 'Obese' => $estimatedCalories - 500,
            default => $estimatedCalories
        };
    }


    return view('bmi', [
        'bmiRecords' => $bmiRecords,
        'lastBmi' => $lastBmi,
        'estimatedCalories' => $estimatedCalories,
        'saranKalori' => $saranKalori
    ]);

    }

    public function calculate(Request $request)
    {
        $gender = strtolower($request->input('gender'));
        $rawTinggi = $request->input('tinggi');
        $tinggi = $request->input('tinggi') / 100;
        $berat = $request->input('berat');

         if ($tinggi > 0) {
                $bmi = $berat / ($tinggi * $tinggi);
            } else {
                $bmi = 0;
            }

        if ($gender == 'pria' || $gender == 'laki-laki') {
            $status = $this->statusBmiPria($bmi);
        } elseif ($gender == 'wanita' || $gender == 'perempuan') {
            $status = $this->statusBmiWanita($bmi);
        } else {
            $status = "Gender tidak valid";
        }

        session(['bmi'=> number_format($bmi, 2)]);
        session(['status'=> $status]);
        session(['tinggi'=> $rawTinggi]);
        session(['gender'=> $gender]);
        session(['berat'=> $berat]);


        return redirect('/bmi');
    }
    
    public function reset()
    {
        session(['bmi'=> ""]);
        session(['status'=> ""]);
        session(['tinggi'=> ""]);
        session(['gender'=> ""]);
        session(['berat'=> ""]);
        return redirect('/bmi');
    }

    public function save(Request $request)
    {
        $tinggiCm = $request->input('tinggi'); // ✅ untuk BMR
        $tinggi = $tinggiCm / 100;             // ✅ untuk BMI
        $user = Auth::user();  // Get the authenticated user
        $gender = strtolower($request->input('gender'));
        $tinggi = $request->input('tinggi') / 100;
        $berat = $request->input('berat');
        $usia = $request->input('usia');
        $activity_level = $request->input('activity_level');
        $tanggal = now()->format('Y-m-d H:i');

        if ($tinggi <= 0 || $berat <= 0) {
            return redirect()->back()->withErrors(['message' => 'Data tidak lengkap'])->withInput();
        }

        if ($tinggi > 0) {
            $bmi = $berat / ($tinggi * $tinggi);
        } else {
            $bmi = 0;
        }

        if ($gender == 'pria' || $gender == 'laki-laki') {
            $status = $this->statusBmiPria($bmi);
            $bmr = 66 + (13.7 * $berat) + (5 * $tinggiCm) - (6.8 * $usia); // ⬅️ definisikan $bmr
        } elseif ($gender == 'wanita' || $gender == 'perempuan') {
            $status = $this->statusBmiWanita($bmi);
             $bmr = 655 + (9.6 * $berat) + (1.8 * $tinggiCm) - (4.7 * $usia); // ⬅️ definisikan $bmr
        } else {
            $status = "Gender tidak valid";
            $bmr = 0;
        }

            // ✅ Tambahkan perhitungan kalori
        $activity_factors = [
            'sedentary' => 1.2,
            'lightly_active' => 1.375,
            'moderately_active' => 1.55,
            'very_active' => 1.725,
            'extra_active' => 1.9,
        ];
        $factor = $activity_factors[$activity_level] ?? 1.2;
        $kalori = round($bmr * $factor);

        Bmi::create([
            'user_id' => $user->id,  // Associate the BMI with the authenticated user
            'tanggal' => $tanggal,
            'tinggi' => $request->input('tinggi'),
            'berat' => $berat,
            'bmi' => number_format($bmi, 2),
            'status' => $status,
            'usia' => $usia,
            'activity_level' => $activity_level,
            'gender' => $gender,
            'kalori' => $kalori,
        ]);

        return redirect('/bmi');
    }



    private function statusBmiPria($bmi)
    {
        if ($bmi < 18.5) {
            return "Underweight";
        } elseif ($bmi >= 18.5 && $bmi < 24.9) {
            return "Normal";
        } elseif ($bmi >= 25 && $bmi < 29.9) {
            return "Overweight";
        } else {
            return "Obese";
        }
    }

    private function statusBmiWanita($bmi)
    {
        if ($bmi < 17.5) {
            return "Underweight";
        } elseif ($bmi >= 17.5 && $bmi < 23.9) {
            return "Normal";
        } elseif ($bmi >= 24 && $bmi < 28.9) {
            return "Overweight";
        } else {
            return "Obese";
        }
    }

    public function deleteRow($id)
{
   $bmiRecord = Bmi::findOrFail($id);
    $bmiRecord->delete();

    return redirect('/bmi');
}

public function hitungKalori(Request $request)
{
    $validated = $request->validate([
        'gender' => 'required|in:pria,wanita',
        'berat' => 'required|numeric|min:10',
        'tinggi' => 'required|numeric|min:50',
        'usia' => 'required|numeric|min:1',
        'activity_level' => 'required|in:sedentary,lightly_active,moderately_active,very_active,extra_active',
    ]);

    $gender = $validated['gender'];
    $berat = $validated['berat'];
    $tinggi = $validated['tinggi'];
    $usia = $validated['usia'];
    $activity_level = $validated['activity_level'];

    // Hitung BMR
    if ($gender == 'pria') {
        $bmr = 66 + (13.7 * $berat) + (5 * $tinggi) - (6.8 * $usia);
    } else {
        $bmr = 655 + (9.6 * $berat) + (1.8 * $tinggi) - (4.7 * $usia);
    }

    $activity_factors = [
        'sedentary' => 1.2,
        'lightly_active' => 1.375,
        'moderately_active' => 1.55,
        'very_active' => 1.725,
        'extra_active' => 1.9,
    ];

    $kalori = round($bmr * $activity_factors[$activity_level]);

    // Simpan data ke session untuk ditampilkan di view
    session([
        'kalori' => $kalori,
        'berat' => $berat,
        'tinggi' => $tinggi,
        'usia' => $usia,
        'gender' => $gender,
        'activity_level' => $activity_level,
    ]);

    return redirect()->back()->withInput();
}


}
