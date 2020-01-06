<?php

namespace Domain\Users;

use Domain\Projects\Project;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;

/**
 * Domain\Users\User
 *
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read int|null $notificationsCount
 * @method static \Illuminate\Database\Eloquent\Builder|\Domain\Users\User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\Domain\Users\User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\Domain\Users\User query()
 * @mixin \Eloquent
 * @property int $id
 * @property string $name
 * @property string $email
 * @property \Illuminate\Support\Carbon|null $emailVerifiedAt
 * @property string $password
 * @property string|null $rememberToken
 * @property \Illuminate\Support\Carbon|null $createdAt
 * @property \Illuminate\Support\Carbon|null $updatedAt
 * @property-read int|null $notificationsCount
 * @method static \Illuminate\Database\Eloquent\Builder|\Domain\Users\User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Domain\Users\User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Domain\Users\User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Domain\Users\User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Domain\Users\User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Domain\Users\User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Domain\Users\User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Domain\Users\User whereUpdatedAt($value)
 * @property-read \Domain\Projects\ProjectCollection|\Domain\Projects\Project[] $projects
 * @property-read int|null $projectsCount
 * @property \Illuminate\Support\Carbon|null $emailVerifyExpiresAt
 * @property \Illuminate\Support\Carbon|null $passwordResetAt
 * @property \Illuminate\Support\Carbon|null $passwordResetExpiresAt
 * @property string|null $emailVerifyToken
 * @property string|null $passwordResetToken
 * @method static \Illuminate\Database\Eloquent\Builder|\Domain\Users\User whereEmailVerifyExpiresAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Domain\Users\User whereEmailVerifyToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Domain\Users\User wherePasswordResetAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Domain\Users\User wherePasswordResetExpiresAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Domain\Users\User wherePasswordResetToken($value)
 */
class User extends Authenticatable implements JWTSubject
{
    use Notifiable;

    public $dateFormat = 'Y-m-d H:i:s';

    protected $table = 'users';

    protected $primaryKey = 'id';

    protected $dates = [
        'created_at',
        'updated_at',
        'email_verified_at',
        'email_verify_expires_at',
        'password_reset_at',
        'password_reset_expires_at',
    ];

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
        'password_reset_token',
        'email_verify_token'
    ];

    // Boot //

    public static function boot(): void
    {
        parent::boot();
        //self::observe(new UserObserver);
    }

    // Relationships //

    public function projects(): HasMany
    {
        return $this->hasMany(Project::class);
    }

    // Magic //

    public function newCollection(array $models = []): UserCollection
    {
        return new UserCollection($models);
    }

    public function newEloquentBuilder($query): UserBuilder
    {
        return new UserBuilder($query);
    }

    // JWTSubject Implementation //

    public function getJWTCustomClaims()
    {
        return [];
    }

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    // Notifications //

    public function routeNotificationForMail()
    {
        return $this->email;
    }

    // Helpers //

    public function isEmailVerified(): bool
    {
        return $this->email_verified_at !== null;
    }

    public function isEmailVerifyExpired(): bool
    {
        return $this->email_verify_expires_at
            ? $this->email_verify_expires_at->lte(now())
            : false;
    }

    public function isPasswordResetExpired(): bool
    {
        return $this->password_reset_expires_at
            ? $this->password_reset_expires_at->lte(now())
            : false;
    }
}
