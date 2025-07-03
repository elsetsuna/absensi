<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegistrationController;
use App\Http\Controllers\Auth\LoginController;

/*
|--------------------------------------------------------------------------
| Simple API Routes for Internal Team
|--------------------------------------------------------------------------
*/

// Public routes (no authentication required)
Route::prefix('api')->group(function () {
    
    // Authentication routes
    Route::post('/register', [RegistrationController::class, 'register']);
    Route::post('/login', [LoginController::class, 'login']);
    
    // Form data
    Route::get('/form-options', [RegistrationController::class, 'getFormOptions']);
    
    // Health check
    Route::get('/health', function () {
        return response()->json([
            'status' => 'ok',
            'service' => 'attendance-hub',
            'timestamp' => now()->toISOString()
        ]);
    });
});

// Protected routes (require authentication)
Route::prefix('api')->middleware('auth:sanctum')->group(function () {
    
    // User routes
    Route::post('/logout', [LoginController::class, 'logout']);
    Route::get('/me', [LoginController::class, 'me']);
    
    // Profile update (simple)
    Route::put('/profile', function (Request $request) {
        $user = $request->user();
        
        $validated = $request->validate([
            'nama_lengkap' => 'sometimes|string|max:255',
            'telegram' => 'sometimes|string|max:100',
            'phone' => 'sometimes|nullable|string|max:20',
            'address' => 'sometimes|nullable|string|max:500',
        ]);
        
        $user->update($validated);
        
        return response()->json([
            'success' => true,
            'message' => 'Profile updated successfully',
            'data' => ['user' => $user->fresh()]
        ]);
    });
});