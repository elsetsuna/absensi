<?php

namespace App\Models;

// use Jenssegers\Mongodb\Eloquent\Model;
use MongoDB\Laravel\Eloquent\Model;
use Carbon\Carbon;
use App\Traits\MongoTimestamps;

class Attendance extends Model
{
    use MongoTimestamps;
    protected $connection = 'mongodb';
    protected $collection = 'attendances';
    
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
        'user_id',
        'date',
        'check_in',
        'check_out',
        'check_in_location',
        'check_out_location',
        'check_in_ip',
        'check_out_ip',
        'total_hours',
        'overtime_hours',
        'status',
        'notes',
        'late_minutes',
        'early_leave_minutes',
        'approved_by',
        'approval_status',
        'created_at',
        'updated_at',
    ];

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'date' => 'date',
        'check_in' => 'datetime',
        'check_out' => 'datetime',
        'total_hours' => 'decimal:2',
        'overtime_hours' => 'decimal:2',
        'late_minutes' => 'integer',
        'early_leave_minutes' => 'integer',
        'check_in_location' => 'array',
        'check_out_location' => 'array',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Boot method
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($attendance) {
            if (empty($attendance->date)) {
                $attendance->date = today();
            }
            
            if (empty($attendance->status)) {
                $attendance->status = 'present';
            }

            if (empty($attendance->approval_status)) {
                $attendance->approval_status = 'pending';
            }
            
            // Ensure timestamps are set
            $attendance->created_at = now();
            $attendance->updated_at = now();
        });

        static::updating(function ($attendance) {
            // Ensure updated_at is set
            $attendance->updated_at = now();
            
            if ($attendance->check_in && $attendance->check_out) {
                $attendance->calculateTotalHours();
                $attendance->calculateLateAndEarlyLeave();
            }
        });
    }

    /**
     * Relationship with user
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Relationship with break records
     */
    public function breakRecords()
    {
        return $this->hasMany(BreakRecord::class, 'attendance_id');
    }

    /**
     * Calculate total working hours
     */
    public function calculateTotalHours()
    {
        if (!$this->check_in || !$this->check_out) {
            return;
        }

        $checkIn = Carbon::parse($this->check_in);
        $checkOut = Carbon::parse($this->check_out);
        
        $totalMinutes = $checkOut->diffInMinutes($checkIn);
        
        // Subtract break time
        $breakMinutes = $this->getTotalBreakMinutes();
        $workingMinutes = $totalMinutes - $breakMinutes;
        
        $this->total_hours = round($workingMinutes / 60, 2);
        
        // Calculate overtime (assuming 8 hours is standard)
        $standardHours = 8;
        if ($this->total_hours > $standardHours) {
            $this->overtime_hours = round($this->total_hours - $standardHours, 2);
        } else {
            $this->overtime_hours = 0;
        }
    }

    /**
     * Calculate late and early leave minutes
     */
    public function calculateLateAndEarlyLeave()
    {
        // Standard work hours (can be made configurable)
        $standardStartTime = '09:00:00';
        $standardEndTime = '17:00:00';

        if ($this->check_in) {
            $checkIn = Carbon::parse($this->check_in);
            $standardStart = Carbon::parse($this->date . ' ' . $standardStartTime);
            
            if ($checkIn->gt($standardStart)) {
                $this->late_minutes = $checkIn->diffInMinutes($standardStart);
            } else {
                $this->late_minutes = 0;
            }
        }

        if ($this->check_out) {
            $checkOut = Carbon::parse($this->check_out);
            $standardEnd = Carbon::parse($this->date . ' ' . $standardEndTime);
            
            if ($checkOut->lt($standardEnd)) {
                $this->early_leave_minutes = $standardEnd->diffInMinutes($checkOut);
            } else {
                $this->early_leave_minutes = 0;
            }
        }
    }

    /**
     * Get total break minutes for this attendance
     */
    public function getTotalBreakMinutes()
    {
        return $this->breakRecords()
                    ->whereNotNull('break_end')
                    ->get()
                    ->sum(function ($break) {
                        $start = Carbon::parse($break->break_start);
                        $end = Carbon::parse($break->break_end);
                        return $end->diffInMinutes($start);
                    });
    }

    /**
     * Check if attendance is late
     */
    public function isLate()
    {
        return $this->late_minutes > 0;
    }

    /**
     * Check if attendance has early leave
     */
    public function hasEarlyLeave()
    {
        return $this->early_leave_minutes > 0;
    }

    /**
     * Get formatted total hours
     */
    public function getFormattedTotalHoursAttribute()
    {
        if (!$this->total_hours) {
            return '0h 0m';
        }

        $hours = floor($this->total_hours);
        $minutes = round(($this->total_hours - $hours) * 60);
        
        return "{$hours}h {$minutes}m";
    }

    /**
     * Get status badge class
     */
    public function getStatusBadgeClassAttribute()
    {
        switch ($this->status) {
            case 'present':
                return 'bg-success';
            case 'absent':
                return 'bg-danger';
            case 'late':
                return 'bg-warning';
            case 'half_day':
                return 'bg-info';
            default:
                return 'bg-secondary';
        }
    }

    /**
     * Scope for today's attendance
     */
    public function scopeToday($query)
    {
        return $query->whereDate('date', today());
    }

    /**
     * Scope for this month's attendance
     */
    public function scopeThisMonth($query)
    {
        return $query->whereMonth('date', now()->month)
                    ->whereYear('date', now()->year);
    }

    /**
     * Scope for specific user
     */
    public function scopeForUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }
}