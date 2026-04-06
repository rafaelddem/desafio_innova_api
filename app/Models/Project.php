<?php

namespace App\Models;

use App\Enums\Status;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'status',
        'goals',
        'user_id',
    ];

    protected $appends = ['hero_name'];

    protected $hidden = [
        'user',
        'created_at',
        'updated_at',
    ];

    protected $casts = [
        'status' => Status::class,
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function getHeroNameAttribute(): string
    {
        return $this->user->hero_name;
    }
}
