<?php

namespace App\Models;

// use Jenssegers\Mongodb\Eloquent\Model;
use MongoDB\Laravel\Eloquent\Model;
use Carbon\Carbon;
use App\Traits\MongoTimestamps;

class BreakRecord extends Model
{
    use MongoTimestamps;
    protected $connection = 'mongodb';
    protected $collection = 'break_records';
    
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
        'attendance_id',
        'date',
        'break_start',
        'break_end',
        'break_type',
        'duration_minutes',
        'reason',
        'location',
        'ip_address',
        'status',
        'approved_by',
        'notes',
        'created_at',
        'updated_at',
    ];

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'date' => 'date',
        'break_start' => 'datetime',
        'break_end' => 'datetime',
        'duration_minutes' => 'integer',
        'location' => 'array',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Boot method
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($breakRecord) {
            if (empty($breakRecord->date)) {
                $breakRecord->date = today();
            }
            
            if (empty($breakRecord->status)) {
                $breakRecord->status = 'active';
            }

            if (empty($breakRecord->break_type)) {
                $breakRecord->break_type = 'regular';
            }
            
            // Ensure timestamps are set
            $breakRecord->created_at = now();
            $breakRecord->updated_at = now();
        });

        static::updating(function ($breakRecord) {
            // Ensure updated_at is set
            $breakRecord->updated_at = now();
            
            if ($breakRecord->break_start && $breakRecord->break_end) {
                $breakRecord->calculateDuration();
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
     * Relationship with attendance
     */
    public function attendance()
    {
        return $this->belongsTo(Attendance::class, 'attendance_id');
    }

    /**
     * Calculate break duration
     */
    public function calculateDuration()
    {
        if (!$this->break_start || !$this->break_end) {
            return;
        }

        $start = Carbon::parse($this->break_start);
        $end = Carbon::parse($this->break_end);
        
        $this->duration_minutes = $end->diffInMinutes($start);
    }

    /**
     * End the break
     */
    public function endBreak()
    {
        $this->break_end = now();
        $this->status = 'completed';
        $this->updated_at = now();
        $this->calculateDuration();
        $this->save();
    }

    /**
     * Check if break is active
     */
    public function isActive()
    {
        return $this->status === 'active' && is_null($this->break_end);
    }

    /**
     * Check if break is overtime (longer than allowed)
     */
    public function isOvertime($allowedMinutes = 60)
    {
        if (!$this->duration_minutes) {
            return false;
        }
        
        return $this->duration_minutes > $allowedMinutes;
    }

    /**
     * Get formatted duration
     */
    public function getFormattedDurationAttribute()
    {
        if (!$this->duration_minutes) {
            return '0m';
        }

        if ($this->duration_minutes < 60) {
            return $this->duration_minutes . 'm';
        }

        $hours = floor($this->duration_minutes / 60);
        $minutes = $this->duration_minutes % 60;
        
        return $hours . 'h ' . $minutes . 'm';
    }

    /**
     * Get current break duration (for active breaks)
     */
    public function getCurrentDurationAttribute()
    {
        if (!$this->break_start) {
            return 0;
        }

        $start = Carbon::parse($this->break_start);
        $end = $this->break_end ? Carbon::parse($this->break_end) : now();
        
        return $end->diffInMinutes($start);
    }

    /**
     * Get formatted current duration
     */
    public function getFormattedCurrentDurationAttribute()
    {
        $minutes = $this->getCurrentDurationAttribute();
        
        if ($minutes < 60) {
            return $minutes . 'm';
        }

        $hours = floor($minutes / 60);
        $remainingMinutes = $minutes % 60;
        
        return $hours . 'h ' . $remainingMinutes . 'm';
    }

    /**
     * Get break type badge class
     */
    public function getBreakTypeBadgeClassAttribute()
    {
        switch ($this->break_type) {
            case 'lunch':
                return 'bg-primary';
            case 'coffee':
                return 'bg-info';
            case 'prayer':
                return 'bg-success';
            case 'personal':
                return 'bg-warning';
            case 'meeting':
                return 'bg-secondary';
            default:
                return 'bg-light';
        }
    }

    /**
     * Get status badge class
     */
    public function getStatusBadgeClassAttribute()
    {
        switch ($this->status) {
            case 'active':
                return 'bg-warning';
            case 'completed':
                return 'bg-success';
            case 'cancelled':
                return 'bg-danger';
            default:
                return 'bg-secondary';
        }
    }

    /**
     * Scope for active breaks
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active')
                    ->whereNull('break_end');
    }

    /**
     * Scope for today's breaks
     */
    public function scopeToday($query)
    {
        return $query->whereDate('date', today());
    }

    /**
     * Scope for specific user
     */
    public function scopeForUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    /**
     * Scope for specific break type
     */
    public function scopeOfType($query, $type)
    {
        return $query->where('break_type', $type);
    }
}