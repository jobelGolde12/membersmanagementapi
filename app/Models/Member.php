<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
     protected $fillable = [
        'first_name',
        'last_name',
        'middle_name',
        'address',
        'contact_number',
        'date_of_birth',
        'registration_date',
        'purok',
        'age',
        'status',
        'occupation',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'date_of_birth' => 'date',
        'registration_date' => 'date',
    ];

    /**
     * Automatically calculate age from date_of_birth when setting the attribute
     */
    protected function age(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $value ?? $this->calculateAge(),
            set: fn ($value) => $value ?? $this->calculateAge(),
        );
    }

    /**
     * Calculate age from date_of_birth
     */
    private function calculateAge(): int
    {
        return Carbon::parse($this->date_of_birth)->age;
    }

    /**
     * Get the full name of the member
     */
    public function getFullNameAttribute(): string
    {
        $names = [
            $this->first_name,
            $this->middle_name,
            $this->last_name
        ];

        return implode(' ', array_filter($names));
    }

    /**
     * Scope a query to only include senior members (age 60 and above)
     */
    public function scopeSeniors($query)
    {
        return $query->where('age', '>=', 60);
    }

    /**
     * Scope a query to only include minor members (age below 18)
     */
    public function scopeMinors($query)
    {
        return $query->where('age', '<', 18);
    }

    /**
     * Scope a query to only include active members
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    /**
     * Scope a query to only include inactive members
     */
    public function scopeInactive($query)
    {
        return $query->where('status', 'inactive');
    }

    /**
     * Scope a query to only include members from a specific purok
     */
    public function scopeByPurok($query, $purok)
    {
        return $query->where('purok', $purok);
    }

    /**
     * Scope a query to search members by name
     */
    public function scopeSearch($query, $searchTerm)
    {
        return $query->where(function ($q) use ($searchTerm) {
            $q->where('first_name', 'LIKE', "%{$searchTerm}%")
              ->orWhere('last_name', 'LIKE', "%{$searchTerm}%")
              ->orWhere('middle_name', 'LIKE', "%{$searchTerm}%");
        });
    }

    /**
     * Check if member is a senior
     */
    public function isSenior(): bool
    {
        return $this->age >= 60;
    }

    /**
     * Check if member is a minor
     */
    public function isMinor(): bool
    {
        return $this->age < 18;
    }

    /**
     * Check if member is active
     */
    public function isActive(): bool
    {
        return $this->status === 'active';
    }

    /**
     * Boot the model and register model events
     */
    protected static function boot()
    {
        parent::boot();

        // Automatically calculate age before saving if date_of_birth is set
        static::saving(function ($member) {
            if ($member->date_of_birth && !$member->age) {
                $member->age = $member->calculateAge();
            }
        });

        // Automatically calculate age after retrieving if not set
        static::retrieved(function ($member) {
            if ($member->date_of_birth && !$member->age) {
                $member->age = $member->calculateAge();
            }
        });
    }
}
