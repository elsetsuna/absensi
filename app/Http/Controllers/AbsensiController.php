<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Absensi;
class AbsensiController extends Controller
{
        public function startTimer() {
        $timer = Absensi::create(['start_time' => now()]);
        return response()->json(['message' => 'Timer started!', 'timer' => $timer]);
    }

    public function stopTimer(Request $request) {
        $timer = Absensi::whereNull('stop_time')->latest()->first();
        if ($timer) {
            $timer->update(['stop_time' => now()]);
            return response()->json(['message' => 'Timer stopped!', 'timer' => $timer]);
        }
        return response()->json(['error' => 'No active timer found'], 404);
    }

    public function getActiveTimer() {
        $timer = Absensi::whereNull('stop_time')->latest()->first();
        return response()->json(['timer' => $timer]);
    }

