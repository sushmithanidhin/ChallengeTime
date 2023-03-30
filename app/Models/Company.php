<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Company extends Model
{
    use HasFactory;

    /**
     * Indicates if the model's ID is auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id',
        'name',
        'started_at',
    ];

        /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'started_at' => 'datetime',
    ];

    protected $appends = ['age'];

    protected $hidden = ['created_at', 'updated_at', 'pivot'];
    /**
     *
     * @return string
     */
    public function getAgeAttribute(): string
    {
        return $this->started_at->diffInYears(now()) . ' year/s';
    }
    /**
     * The users that belong to the role.
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class)->withTimestamps();
    }

    /**
     * Filter data with optional min and max age parameter
     * @param $query
     * @param $min
     * @param $max
     * @return mixed
     */
    public function scopeFilterByUsersAge($query, $min = null, $max = null)
    {
            return $query->whereHas('users', function ($query) use ($min, $max) {
                if ($min) {
                    $query->where('age', '>=', $min);
                }
                if ($max) {
                    $query->where('age', '<=', $max);
                }
            })->with('users', function ($query) use ($min, $max) {
                if ($min) {
                    $query->where('age', '>=', $min);
                }
                if ($max) {
                    $query->where('age', '<=', $max);
                }
            });
    }
}
