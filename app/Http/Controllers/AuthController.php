<?php

namespace App\Http\Controllers;

use ApiHelper;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        try {
            // Mengambil token dari API
            
            $url = env('API_URL');
            $apiHelper = new ApiHelper();
            $response = $apiHelper->loginToApi($url, $request->username, $request->password);
            
            // Menyimpan token ke sesi
            $request->session()->put('token', $response);
            
            return redirect()->route('home');
        } catch (\Exception $e) {
            return back()->withErrors(['message' => 'Login failed: ' . $e->getMessage()]);
        }
    }
}