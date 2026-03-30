<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Survey extends Model
{
    protected $fillable = [
        'title',
        'description',
        'status',
        'type',
        'start_date',
        'end_date',
        'created_by',
        'public_id',
        'slug',
    ];

    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
    ];

    protected static function booted()
    {
        static::creating(function ($survey) {
            if (empty($survey->slug)) {
                $survey->slug = Str::slug($survey->title);
                
                // Ensure unique slug
                $originalSlug = $survey->slug;
                $count = 1;
                while (static::where('slug', $survey->slug)->exists()) {
                    $survey->slug = "{$originalSlug}-{$count}";
                    $count++;
                }
            }

            do {
                $pool = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
                $public_id = substr(str_shuffle(str_repeat($pool, 5)), 0, 5);

                // Check if it has at least one letter and one number
                $hasLetter = preg_match('/[A-Z]/', $public_id);
                $hasNumber = preg_match('/[0-9]/', $public_id);
                $isUnique = !static::where('public_id', $public_id)->exists();

            } while (!$isUnique || !$hasLetter || !$hasNumber);

            $survey->public_id = $public_id;
        });

        static::updating(function ($survey) {
            if ($survey->isDirty('title') && empty($survey->slug)) {
                 $survey->slug = Str::slug($survey->title);
            }
        });
    }

    public function setStartDateAttribute($value)
    {
        $this->attributes['start_date'] = empty($value) ? null : $value;
    }

    public function setEndDateAttribute($value)
    {
        $this->attributes['end_date'] = empty($value) ? null : $value;
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function questions()
    {
        return $this->hasMany(SurveyQuestion::class);
    }

    public function sections()
    {
        return $this->hasMany(SurveySection::class)->orderBy('order');
    }

    public function responses()
    {
        return $this->hasMany(SurveyResponse::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
