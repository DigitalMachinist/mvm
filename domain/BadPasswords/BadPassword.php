<?php

namespace Domain\BadPasswords;

use Illuminate\Database\Eloquent\Model;

/**
 * Domain\BadPasswords\BadPassword
 *
 * @property int $id
 * @property string $password
 * @method static \Illuminate\Database\Eloquent\Builder|\Domain\BadPasswords\BadPassword newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\Domain\BadPasswords\BadPassword newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\Domain\BadPasswords\BadPassword query()
 * @method static \Illuminate\Database\Eloquent\Builder|\Domain\BadPasswords\BadPassword whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Domain\BadPasswords\BadPassword wherePassword($value)
 * @mixin \Eloquent
 */
class BadPassword extends Model
{
    protected $table = 'bad_passwords';

    protected $fillable = [
        'password',
    ];

    public $timestamps = false;
}
