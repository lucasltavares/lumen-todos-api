<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;

class Todo extends Model
{
    use HasFactory;

    protected $table = 'todos';

    protected $fillable = [
        'title',
        'description',
        'done',
        'done_at'
    ];

    public function done() {
        $this->update([
            'done' => true,
            'done_at' => Carbon::now()
        ]);
    }

    // Generate UUID automatically.
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->{$model->getKeyName()} = Uuid::uuid4()->toString();
        });
    }
}
