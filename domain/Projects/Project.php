<?php

namespace Domain\Projects;

use Domain\Keys\Key;
use Domain\Pathways\Pathway;
use Domain\Rooms\Room;
use Domain\Users\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Domain\Projects\Project
 *
 * @method static \Domain\Projects\ProjectBuilder|\Domain\Projects\Project newModelQuery()
 * @method static \Domain\Projects\ProjectBuilder|\Domain\Projects\Project newQuery()
 * @method static \Domain\Projects\ProjectBuilder|\Domain\Projects\Project query()
 * @mixin \Eloquent
 * @property int $id
 * @property int $userId
 * @property int|null $startRoomId
 * @property bool $isPublic
 * @property string $name
 * @property string $description
 * @property string|null $colour
 * @property string|null $imageUrl
 * @property \Illuminate\Support\Carbon|null $createdAt
 * @property \Illuminate\Support\Carbon|null $updatedAt
 * @method static \Illuminate\Database\Eloquent\Builder|\Domain\Projects\Project whereColour($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Domain\Projects\Project whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Domain\Projects\Project whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Domain\Projects\Project whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Domain\Projects\Project whereImageUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Domain\Projects\Project whereIsPublic($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Domain\Projects\Project whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Domain\Projects\Project whereStartRoomId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Domain\Projects\Project whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Domain\Projects\Project whereUserId($value)
 * @property int $userId
 * @property int|null $startRoomId
 * @property bool $isPublic
 * @property string|null $imageUrl
 * @property \Illuminate\Support\Carbon|null $createdAt
 * @property \Illuminate\Support\Carbon|null $updatedAt
 * @property int $userId
 * @property int|null $startRoomId
 * @property bool $isPublic
 * @property string|null $imageUrl
 * @property \Illuminate\Support\Carbon|null $createdAt
 * @property \Illuminate\Support\Carbon|null $updatedAt
 * @property int $userId
 * @property int|null $startRoomId
 * @property bool $isPublic
 * @property string|null $imageUrl
 * @property \Illuminate\Support\Carbon|null $createdAt
 * @property \Illuminate\Support\Carbon|null $updatedAt
 * @property-read \Domain\Keys\KeyCollection|\Domain\Keys\Key[] $keys
 * @property-read int|null $keysCount
 * @property-read \Domain\Pathways\PathwayCollection|\Domain\Pathways\Pathway[] $pathways
 * @property-read int|null $pathwaysCount
 * @property-read \Domain\Rooms\RoomCollection|\Domain\Rooms\Room[] $rooms
 * @property-read int|null $roomsCount
 * @property-read \Domain\Rooms\Room|null $startRoom
 * @property-read \Domain\Users\User $user
 * @property int $userId
 * @property int|null $startRoomId
 * @property bool $isPublic
 * @property string|null $imageUrl
 * @property \Illuminate\Support\Carbon|null $createdAt
 * @property \Illuminate\Support\Carbon|null $updatedAt
 * @property-read int|null $keysCount
 * @property-read int|null $pathwaysCount
 * @property-read int|null $roomsCount
 * @property-read \Domain\Rooms\Room|null $startRoom
 * @property int $userId
 * @property int|null $startRoomId
 * @property bool $isPublic
 * @property string|null $imageUrl
 * @property \Illuminate\Support\Carbon|null $createdAt
 * @property \Illuminate\Support\Carbon|null $updatedAt
 * @property-read int|null $keysCount
 * @property-read int|null $pathwaysCount
 * @property-read int|null $roomsCount
 * @property-read \Domain\Rooms\Room|null $startRoom
 */
class Project extends Model
{
    public $dateFormat = 'Y-m-d H:i:s';

    public $table = 'projects';

    protected $casts = [
        'is_public' => 'boolean',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
    ];

    protected $fillable = [
        'user_id',
        'start_room_id',
        'is_public',
        'name',
        'description',
        'colour',
        'image_url',
    ];

    // Boot //

    public static function boot(): void
    {
        parent::boot();
        //self::observe(new ProjectObserver);
    }

    // Relationships //

    public function keys(): HasMany
    {
        return $this->hasMany(Key::class);
    }

    public function pathways(): HasMany
    {
        return $this->hasMany(Pathway::class);
    }

    public function rooms(): HasMany
    {
        return $this->hasMany(Room::class);
    }

    public function start_room(): BelongsTo
    {
        return $this->belongsTo(Room::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // Magic //

    public function newCollection(array $models = []): ProjectCollection
    {
        return new ProjectCollection($models);
    }

    public function newEloquentBuilder($query): ProjectBuilder
    {
        return new ProjectBuilder($query);
    }
}
