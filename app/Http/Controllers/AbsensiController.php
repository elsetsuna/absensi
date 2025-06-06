<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Absensi;
use Illuminate\Support\Facades\Auth;
class AbsensiController extends Controller
{
        public function startTimer() {
        $timer = Absensi::create([
            'nama' => Auth::user()->nama,
            'jabatan' => Auth::user()->jabatan,
            'tipe_absensi' => 'istirahat',
            'tanggal' => now()->format('Y-m-d'),
            'status' => 'aktif',
            'keterangan' => 'nothing',
            'waktu_mulai' => now()
        ]);
        \Log::info($timer);
        return response()->json(['message' => 'Timer started!', 'timer' => $timer]);
    }

    public function stopTimer() {
        $timer = Absensi::whereNull('waktu_selesai')->latest()->first();
        \Log::info($timer);
        if ($timer) {
            $timer->update(['waktu_selesai' => now()]);
            return response()->json(['message' => 'Timer stopped!', 'timer' => $timer]);
        }
        return response()->json(['error' => 'No active timer found'], 404);
    }

    public function getActiveTimer() {
        $timer = Absensi::whereNull('waktu_mulai')->latest()->first();
        return response()->json(['timer' => $timer]);
    }

}