<?php

namespace App\Traits;

use Carbon\Carbon;

trait MongoTimestamps
{
    /**
     * Update the model's update timestamp.
     */
    public function touch()
    {
        if (!$this->usesTimestamps()) {
            return false;
        }

        $this->updateTimestamps();

        return $this->save();
    }

    /**
     * Update the creation and update timestamps.
     */
    protected function updateTimestamps()
    {
        $time = $this->freshTimestamp();

        if (!$this->isDirty(static::UPDATED_AT)) {
            $this->setUpdatedAt($time);
        }

        if (!$this->exists && !$this->isDirty(static::CREATED_AT)) {
            $this->setCreatedAt($time);
        }
    }

    /**
     * Set the value of the "created at" attribute.
     */
    public function setCreatedAt($value)
    {
        $this->{static::CREATED_AT} = $value;

        return $this;
    }

    /**
     * Set the value of the "updated at" attribute.
     */
    public function setUpdatedAt($value)
    {
        $this->{static::UPDATED_AT} = $value;

        return $this;
    }

    /**
     * Get a fresh timestamp for the model.
     */
    public function freshTimestamp()
    {
        return Carbon::now();
    }

    /**
     * Get a fresh timestamp for the model as MongoDB UTCDateTime.
     */
    public function freshTimestampString()
    {
        return $this->fromDateTime(Carbon::now());
    }

    /**
     * Determine if the model uses timestamps.
     */
    public function usesTimestamps()
    {
        return $this->timestamps;
    }

    /**
     * Get the name of the "created at" column.
     */
    public function getCreatedAtColumn()
    {
        return static::CREATED_AT;
    }

    /**
     * Get the name of the "updated at" column.
     */
    public function getUpdatedAtColumn()
    {
        return static::UPDATED_AT;
    }

    /**
     * Get the fully qualified "created at" column.
     */
    public function getQualifiedCreatedAtColumn()
    {
        return $this->qualifyColumn($this->getCreatedAtColumn());
    }

    /**
     * Get the fully qualified "updated at" column.
     */
    public function getQualifiedUpdatedAtColumn()
    {
        return $this->qualifyColumn($this->getUpdatedAtColumn());
    }

    /**
     * Scope a query to only include models created after a given date.
     */
    public function scopeCreatedAfter($query, $date)
    {
        return $query->where($this->getCreatedAtColumn(), '>', $date);
    }

    /**
     * Scope a query to only include models created before a given date.
     */
    public function scopeCreatedBefore($query, $date)
    {
        return $query->where($this->getCreatedAtColumn(), '<', $date);
    }

    /**
     * Scope a query to only include models updated after a given date.
     */
    public function scopeUpdatedAfter($query, $date)
    {
        return $query->where($this->getUpdatedAtColumn(), '>', $date);
    }

    /**
     * Scope a query to only include models updated before a given date.
     */
    public function scopeUpdatedBefore($query, $date)
    {
        return $query->where($this->getUpdatedAtColumn(), '<', $date);
    }

    /**
     * Scope a query to only include models created today.
     */
    public function scopeCreatedToday($query)
    {
        return $query->whereDate($this->getCreatedAtColumn(), today());
    }

    /**
     * Scope a query to only include models updated today.
     */
    public function scopeUpdatedToday($query)
    {
        return $query->whereDate($this->getUpdatedAtColumn(), today());
    }

    /**
     * Scope a query to only include models created this week.
     */
    public function scopeCreatedThisWeek($query)
    {
        return $query->whereBetween($this->getCreatedAtColumn(), [
            now()->startOfWeek(),
            now()->endOfWeek()
        ]);
    }

    /**
     * Scope a query to only include models created this month.
     */
    public function scopeCreatedThisMonth($query)
    {
        return $query->whereMonth($this->getCreatedAtColumn(), now()->month)
                    ->whereYear($this->getCreatedAtColumn(), now()->year);
    }

    /**
     * Scope a query to only include models created this year.
     */
    public function scopeCreatedThisYear($query)
    {
        return $query->whereYear($this->getCreatedAtColumn(), now()->year);
    }

    /**
     * Get formatted created at date.
     */
    public function getFormattedCreatedAtAttribute()
    {
        return $this->created_at ? $this->created_at->format('Y-m-d H:i:s') : null;
    }

    /**
     * Get formatted updated at date.
     */
    public function getFormattedUpdatedAtAttribute()
    {
        return $this->updated_at ? $this->updated_at->format('Y-m-d H:i:s') : null;
    }

    /**
     * Get human readable created at date.
     */
    public function getCreatedAtForHumansAttribute()
    {
        return $this->created_at ? $this->created_at->diffForHumans() : null;
    }

    /**
     * Get human readable updated at date.
     */
    public function getUpdatedAtForHumansAttribute()
    {
        return $this->updated_at ? $this->updated_at->diffForHumans() : null;
    }
}