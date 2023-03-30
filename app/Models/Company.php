<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
    /**
     * @var mixed
     */
    private $id;

    public function getAgeAttribute()
    {
        // $features = $this->features()->get();
        // if (count($features) > 0 ) {
        //     foreach ($features as $feature) {
        //         if (isset($feature->pivot) && $feature->name == "Artysta") {
        //             return $feature->pivot->custom_value;
        //         }
        //     }
        // }
        $dateDiff = date_diff(new Datetime(),$this->started_at);
        return $dateDiff->y . 'year/s';
    }

    public function getId()
    {
        return $this->id;
    }
    /**
     * The users that belong to the role.
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }

}
