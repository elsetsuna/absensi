<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AttendanceRecord extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_id',
        'date',
        'check_in_time',
        'check_out_time',
        'total_work_minutes',
        'total_break_minutes',
        'status',
        'location_data',
        'device_info'
    ];

    protected $casts = [
        'check_in_time' => 'datetime',
        'check_out_time' => 'datetime',
        'date' => 'date',
        'location_data' => 'array',
        'device_info' => 'array'
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id', 'employee_id');
    }

    public function breakRecords()
    {
        return $this->hasMany(BreakRecord::class);
    }

    public function getTotalWorkHoursAttribute()
    {
        return round($this->total_work_minutes / 60, 2);
    }

    public function getTotalBreakHoursAttribute()
    {
        return round($this->total_break_minutes / 60, 2);
    }

    public function getIsCheckedInAttribute()
    {
        return !is_null($this->check_in_time) && is_null($this->check_out_time);
    }

    public function getCurrentBreakAttribute()
    {
        return $this->breakRecords()->whereNull('break_end')->first();
    }

    public function getIsOnBreakAttribute()
    {
        return !is_null($this->current_break);
    }
}