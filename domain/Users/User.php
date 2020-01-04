<?php

namespace Domain\Users;

use Domain\Projects\Project;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

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
 * @property \Illuminate\Support\Carbon|null $emailVerifiedAt
 * @property string|null $rememberToken
 * @property \Illuminate\Support\Carbon|null $createdAt
 * @property \Illuminate\Support\Carbon|null $updatedAt
 * @property-read int|null $notificationsCount
 * @property \Illuminate\Support\Carbon|null $emailVerifiedAt
 * @property string|null $rememberToken
 * @property \Illuminate\Support\Carbon|null $createdAt
 * @property \Illuminate\Support\Carbon|null $updatedAt
 * @property-read int|null $notificationsCount
 * @property \Illuminate\Support\Carbon|null $emailVerifiedAt
 * @property string|null $rememberToken
 * @property \Illuminate\Support\Carbon|null $createdAt
 * @property \Illuminate\Support\Carbon|null $updatedAt
 * @property-read int|null $notificationsCount
 * @property \Illuminate\Support\Carbon|null $emailVerifiedAt
 * @property string|null $rememberToken
 * @property \Illuminate\Support\Carbon|null $createdAt
 * @property \Illuminate\Support\Carbon|null $updatedAt
 * @property-read int|null $notificationsCount
 * @property \Illuminate\Support\Carbon|null $emailVerifiedAt
 * @property string|null $rememberToken
 * @property \Illuminate\Support\Carbon|null $createdAt
 * @property \Illuminate\Support\Carbon|null $updatedAt
 * @property-read int|null $notificationsCount
 * @property \Illuminate\Support\Carbon|null $emailVerifiedAt
 * @property string|null $rememberToken
 * @property \Illuminate\Support\Carbon|null $createdAt
 * @property \Illuminate\Support\Carbon|null $updatedAt
 * @property-read int|null $notificationsCount
 * @property \Illuminate\Support\Carbon|null $emailVerifiedAt
 * @property string|null $rememberToken
 * @property \Illuminate\Support\Carbon|null $createdAt
 * @property \Illuminate\Support\Carbon|null $updatedAt
 * @property-read int|null $notificationsCount
 * @property \Illuminate\Support\Carbon|null $emailVerifiedAt
 * @property string|null $rememberToken
 * @property \Illuminate\Support\Carbon|null $createdAt
 * @property \Illuminate\Support\Carbon|null $updatedAt
 * @property-read int|null $notificationsCount
 * @property \Illuminate\Support\Carbon|null $emailVerifiedAt
 * @property string|null $rememberToken
 * @property \Illuminate\Support\Carbon|null $createdAt
 * @property \Illuminate\Support\Carbon|null $updatedAt
 * @property-read int|null $notificationsCount
 * @property \Illuminate\Support\Carbon|null $emailVerifiedAt
 * @property string|null $rememberToken
 * @property \Illuminate\Support\Carbon|null $createdAt
 * @property \Illuminate\Support\Carbon|null $updatedAt
 * @property-read int|null $notificationsCount
 * @property \Illuminate\Support\Carbon|null $emailVerifiedAt
 * @property string|null $rememberToken
 * @property \Illuminate\Support\Carbon|null $createdAt
 * @property \Illuminate\Support\Carbon|null $updatedAt
 * @property-read int|null $notificationsCount
 * @property-read \Domain\Projects\ProjectCollection|\Domain\Projects\Project[] $projects
 * @property-read int|null $projectsCount
 * @property \Illuminate\Support\Carbon|null $emailVerifiedAt
 * @property string|null $rememberToken
 * @property \Illuminate\Support\Carbon|null $createdAt
 * @property \Illuminate\Support\Carbon|null $updatedAt
 * @property-read int|null $notificationsCount
 * @property-read int|null $projectsCount
 * @property \Illuminate\Support\Carbon|null $emailVerifiedAt
 * @property string|null $rememberToken
 * @property \Illuminate\Support\Carbon|null $createdAt
 * @property \Illuminate\Support\Carbon|null $updatedAt
 * @property-read int|null $notificationsCount
 * @property-read int|null $projectsCount
 * @property \Illuminate\Support\Carbon|null $emailVerifiedAt
 * @property string|null $rememberToken
 * @property \Illuminate\Support\Carbon|null $createdAt
 * @property \Illuminate\Support\Carbon|null $updatedAt
 * @property-read int|null $notificationsCount
 * @property-read int|null $projectsCount
 * @property \Illuminate\Support\Carbon|null $emailVerifiedAt
 * @property string|null $rememberToken
 * @property \Illuminate\Support\Carbon|null $createdAt
 * @property \Illuminate\Support\Carbon|null $updatedAt
 * @property-read int|null $notificationsCount
 * @property-read int|null $projectsCount
 * @property \Illuminate\Support\Carbon|null $emailVerifiedAt
 * @property string|null $rememberToken
 * @property \Illuminate\Support\Carbon|null $createdAt
 * @property \Illuminate\Support\Carbon|null $updatedAt
 * @property-read int|null $notificationsCount
 * @property-read int|null $projectsCount
 */
class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable;

    public $dateFormat = 'Y-m-d H:i:s';

    protected $table = 'users';

    protected $dates = [
        'email_verified_at',
        'created_at',
        'updated_at',
    ];

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
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
}
