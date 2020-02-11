<?php

declare(strict_types=1);

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property-read string $name
 * @property-read int $user_id
 * @property-read int $balance
 */
class Account extends Model
{
    /** @var array<int, string> */
    protected $fillable = ['name', 'user_id', 'balance'];

    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
