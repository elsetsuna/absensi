<?php

namespace App\Models;

// use Jenssegers\Mongodb\Eloquent\Model;
use MongoDB\Laravel\Eloquent\Model;
use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Traits\MongoTimestamps;

class User extends Model implements AuthenticatableContract
{
    use HasApiTokens, HasFactory, Notifiable, Authenticatable, MongoTimestamps;

    protected $connection = 'mongodb';
    protected $collection = 'users';
    
    /**
     * Indicates if the model should be timestamped.
     */
    public $timestamps = true;
    
    /**
     * The name of the "created at" column.
     */
    const CREATED_AT = 'created_at';
    
    /**
     * The name of the "updated at" column.
     */
    const UPDATED_AT = 'updated_at';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'username',
        'email',
        'password',
        'nama_lengkap',
        'telegram',
        'jenis_kelamin',
        'agama',
        'bo_web',
        'jabatan',
        'tanggal_bergabung',
        'profile_picture',
        'phone',
        'address',
        'emergency_contact',
        'employee_id',
        'department',
        'salary',
        'status',
        'last_login',
        'email_verified_at',
        'remember_token',
        'created_at',
        'updated_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'tanggal_bergabung' => 'date',
        'last_login' => 'datetime',
        'salary' => 'decimal:2',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Boot method to generate employee ID
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($user) {
            if (empty($user->employee_id)) {
                $user->employee_id = self::generateEmployeeId();
            }
            
            if (empty($user->status)) {
                $user->status = 'active';
            }
            
            // Ensure timestamps are set
            $user->created_at = now();
            $user->updated_at = now();
        });
        
        static::updating(function ($user) {
            // Ensure updated_at is set
            $user->updated_at = now();
        });
    }

    /**
     * Generate unique employee ID
     */
    private static function generateEmployeeId()
    {
        $year = date('Y');
        $lastEmployee = self::where('employee_id', 'like', "EMP{$year}%")
                           ->orderBy('employee_id', 'desc')
                           ->first();

        if ($lastEmployee) {
            $lastNumber = (int) substr($lastEmployee->employee_id, -4);
            $newNumber = $lastNumber + 1;
        } else {
            $newNumber = 1;
        }

        return "EMP{$year}" . str_pad($newNumber, 4, '0', STR_PAD_LEFT);
    }

    /**
     * Relationship with attendances
     */
    public function attendances()
    {
        return $this->hasMany(Attendance::class, 'user_id');
    }

    /**
     * Relationship with breaks
     */
    public function breaks()
    {
        return $this->hasMany(BreakRecord::class, 'user_id');
    }

    /**
     * Get today's attendance
     */
    public function todayAttendance()
    {
        return $this->attendances()
                    ->whereDate('date', today())
                    ->first();
    }

    /**
     * Check if user is currently on break
     */
    public function isOnBreak()
    {
        return $this->breaks()
                    ->whereDate('date', today())
                    ->whereNull('break_end')
                    ->exists();
    }

    /**
     * Get active break
     */
    public function activeBreak()
    {
        return $this->breaks()
                    ->whereDate('date', today())
                    ->whereNull('break_end')
                    ->first();
    }

    /**
     * Get full name attribute
     */
    public function getFullNameAttribute()
    {
        return $this->nama_lengkap ?: $this->username;
    }

    /**
     * Check if user has checked in today
     */
    public function hasCheckedInToday()
    {
        $todayAttendance = $this->todayAttendance();
        return $todayAttendance && $todayAttendance->check_in;
    }

    /**
     * Check if user has checked out today
     */
    public function hasCheckedOutToday()
    {
        $todayAttendance = $this->todayAttendance();
        return $todayAttendance && $todayAttendance->check_out;
    }
}