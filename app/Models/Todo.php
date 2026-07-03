<?php

namespace App\Models;

use Database\Factories\TodoFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Todo extends Model
{
    /** @use HasFactory<TodoFactory> */
    use HasFactory;

    use SoftDeletes;
    protected $dates = ['deleted_at'];

    /** protected fillable is a whitelist for mass asignment*/
    protected $fillable = [
        'title',
        'completed'
    ];

    protected $primaryKey = 'todo_id';

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function getRouteKeyName(): string
    {
        return 'todo_id';
    }
}
