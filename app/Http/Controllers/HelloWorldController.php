<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HelloWorldController extends Controller
{
    public function index()
    {
        // Anda bisa mengubah teks '10' menjadi '13' menyesuaikan versi yang Anda gunakan saat ini.
        return "Selamat Belajar Framework Laravel 13";
    }

    public function ambilfile()
    {
        return view('ambilfile');
    }
}