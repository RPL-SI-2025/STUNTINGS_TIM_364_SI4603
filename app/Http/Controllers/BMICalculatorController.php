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

        // Return the view with the BMI data
        return view('bmi', compact('bmiRecords'));
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
        $user = Auth::user();  // Get the authenticated user
        $gender = strtolower($request->input('gender'));
        $tinggi = $request->input('tinggi') / 100;
        $berat = $request->input('berat');
        $tanggal = now()->format('Y-m-d H:i');

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

        Bmi::create([
            'user_id' => $user->id,  // Associate the BMI with the authenticated user
            'tanggal' => $tanggal,
            'tinggi' => $request->input('tinggi'),
            'berat' => $berat,
            'bmi' => number_format($bmi, 2),
            'status' => $status
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

}
