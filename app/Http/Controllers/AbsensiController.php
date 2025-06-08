<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Absensi;
use Illuminate\Support\Facades\Auth;
class AbsensiController extends Controller
{
        public function startTimer(request $request) {
            \Log::info($request->keterangan);
        $timer = Absensi::create([
            'user_id' => Auth::user()->id,
            'nama' => Auth::user()->nama,
            'jabatan' => Auth::user()->jabatan,
            'tipe_absensi' => 'istirahat',
            'tanggal' => now()->format('Y-m-d'),
            'status' => 'aktif',
            'keterangan' => $request->input('keterangan', 'Tidak ada keterangan'),
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

    public function historyIstirahat() {

        $today = now()->format('Y-m-d');
        $query = ['user_id' => Auth::user()->id, 'tanggal' => $today, 'tipe_absensi' => 'istirahat', 'status' => 'aktif'];
        $history = Absensi::where($query)->latest()->take(5)->get();

        if ($history->isEmpty()) {
            return response()->json(['message' => 'No history found'], 404);
        }

        return response()->json(['history' => $history]);

    }

}