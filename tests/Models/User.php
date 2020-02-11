<?php

declare(strict_types=1);

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * @property-read string $name
 * @property-read string $email
 */
class User extends Model
{
    /** @var array<int, string> */
    protected $fillable = ['name', 'email'];

    public function account() : HasOne
    {
        return $this->hasOne(Account::class);
    }
}
