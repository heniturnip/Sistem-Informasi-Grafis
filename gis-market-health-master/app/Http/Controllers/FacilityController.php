<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Facility;

class FacilityController extends Controller{
    
    public function index()
    {
        // Ambil data dari tabel 'facilities'
        $facilities = Facility::all();

        // Kirim data ke view 'index.blade.php'
        return view('index', compact('facilities'));
    }
}

