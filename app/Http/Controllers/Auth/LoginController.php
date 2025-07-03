<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    /**
     * Login user
     */
    public function login(Request $request): JsonResponse
    {
        // Simple validation
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Please provide email and password',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            // Find user by email
            $user = User::where('email', $request->email)->first();

            // Check if user exists and password is correct
            if (!$user || !Hash::check($request->password, $user->password)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid email or password'
                ], 401);
            }

            // Check if user is active
            if ($user->status !== 'active') {
                return response()->json([
                    'success' => false,
                    'message' => 'Account is not active. Please contact administrator.'
                ], 403);
            }

            // Delete old tokens and create new one
            $user->tokens()->delete();
            $token = $user->createToken('auth-token')->plainTextToken;

            // Update last login
            $user->update(['last_login' => now()]);

            return response()->json([
                'success' => true,
                'message' => 'Login successful!',
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
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Login failed: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Logout user
     */
    public function logout(Request $request): JsonResponse
    {
        try {
            // Delete current token
            $request->user()->currentAccessToken()->delete();

            return response()->json([
                'success' => true,
                'message' => 'Logged out successfully'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Logout failed: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get current user info
     */
    public function me(Request $request): JsonResponse
    {
        try {
            $user = $request->user();

            return response()->json([
                'success' => true,
                'data' => [
                    'user' => [
                        'id' => $user->id,
                        'username' => $user->username,
                        'email' => $user->email,
                        'nama_lengkap' => $user->nama_lengkap,
                        'employee_id' => $user->employee_id,
                        'telegram' => $user->telegram,
                        'jenis_kelamin' => $user->jenis_kelamin,
                        'agama' => $user->agama,
                        'bo_web' => $user->bo_web,
                        'jabatan' => $user->jabatan,
                        'tanggal_bergabung' => $user->tanggal_bergabung->format('Y-m-d'),
                        'status' => $user->status,
                        'last_login' => $user->last_login?->format('Y-m-d H:i:s'),
                        'created_at' => $user->created_at->format('Y-m-d H:i:s'),
                    ]
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to get user info: ' . $e->getMessage()
            ], 500);
        }
    }
}