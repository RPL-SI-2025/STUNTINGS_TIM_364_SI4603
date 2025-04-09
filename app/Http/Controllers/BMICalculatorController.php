<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BMICalculatorController extends Controller
{
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


        return redirect()->back();
    }
}
