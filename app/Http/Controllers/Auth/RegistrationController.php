<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class RegistrationController extends Controller
{
    /**
     * Register a new employee
     */
    public function register(Request $request): JsonResponse
    {
        // Simple validation
        $validator = Validator::make($request->all(), [
            'username' => 'required|string|min:3|max:50|unique:users',
            'password' => 'required|string|min:6',
            'nama_lengkap' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'telegram' => 'required|string|max:100',
            'jenis_kelamin' => 'required|in:laki-laki,perempuan',
            'agama' => 'required|in:islam,kristen,katolik,hindu,buddha,konghucu,lainnya',
            'bo_web' => 'required|in:web-a,web-b,web-c,bo-main,bo-backup',
            'jabatan' => 'required|in:admin,cs,marketing,finance,tech-support,manager,supervisor',
            'tanggal_bergabung' => 'required|date|before_or_equal:today',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            // Create user
            $user = User::create([
                'username' => $request->username,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'nama_lengkap' => $request->nama_lengkap,
                'telegram' => $this->formatTelegram($request->telegram),
                'jenis_kelamin' => $request->jenis_kelamin,
                'agama' => $request->agama,
                'bo_web' => $request->bo_web,
                'jabatan' => $request->jabatan,
                'tanggal_bergabung' => Carbon::parse($request->tanggal_bergabung),
                'status' => 'active',
            ]);

            // Generate simple API token
            $token = $user->createToken('auth-token')->plainTextToken;

            return response()->json([
                'success' => true,
                'message' => 'Registration successful!',
                'data' => [
                    'user' => [
                        'id' => $user->id,
                        'username' => $user->username,
                        'email' => $user->email,
                        'nama_lengkap' => $user->nama_lengkap,
                        'employee_id' => $user->employee_id,
                        'jabatan' => $user->jabatan,
                        'status' => $user->status,
                    ],
                    'token' => $token,
                ]
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Registration failed: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Format telegram username
     */
    private function formatTelegram(string $telegram): string
    {
        return '@' . ltrim($telegram, '@');
    }

    /**
     * Get form options for dropdowns
     */
    public function getFormOptions(): JsonResponse
    {
        return response()->json([
            'success' => true,
            'data' => [
                'jenis_kelamin' => [
                    'laki-laki' => 'Laki-laki',
                    'perempuan' => 'Perempuan'
                ],
                'agama' => [
                    'islam' => 'Islam',
                    'kristen' => 'Kristen',
                    'katolik' => 'Katolik',
                    'hindu' => 'Hindu',
                    'buddha' => 'Buddha',
                    'konghucu' => 'Konghucu',
                    'lainnya' => 'Lainnya'
                ],
                'bo_web' => [
                    'web-a' => 'Web A',
                    'web-b' => 'Web B',
                    'web-c' => 'Web C',
                    'bo-main' => 'BO Main',
                    'bo-backup' => 'BO Backup'
                ],
                'jabatan' => [
                    'admin' => 'Admin',
                    'cs' => 'Customer Service',
                    'marketing' => 'Marketing',
                    'finance' => 'Finance',
                    'tech-support' => 'Tech Support',
                    'manager' => 'Manager',
                    'supervisor' => 'Supervisor'
                ]
            ]
        ]);
    }
}