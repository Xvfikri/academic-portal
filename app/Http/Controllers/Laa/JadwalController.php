<?php

namespace App\Http\Controllers\Laa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class JadwalController extends Controller
{
    public function index()
    {
        // Placeholder: later this will fetch schedules
        return view('laa.jadwal.index', ['jadwals' => []]);
    }

    public function create()
    {
        return view('laa.jadwal.create');
    }

    public function store(Request $request)
    {
        // Placeholder storage logic
        return redirect()->route('laa.jadwal.index')->with('success', 'Jadwal berhasil ditambahkan (Dummy).');
    }
}
