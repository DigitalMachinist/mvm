<?php

namespace Domain\Rooms;

use Domain\KeyRooms\KeyRoom;
use Domain\Keys\Key;
use Domain\Projects\Project;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Domain\Rooms\Room
 *
 * @method static \Domain\Rooms\RoomBuilder|\Domain\Rooms\Room newModelQuery()
 * @method static \Domain\Rooms\RoomBuilder|\Domain\Rooms\Room newQuery()
 * @method static \Domain\Rooms\RoomBuilder|\Domain\Rooms\Room query()
 * @mixin \Eloquent
 * @property int $id
 * @property int $projectId
 * @property string $name
 * @property string $description
 * @property int $difficulty
 * @property int $x
 * @property int $y
 * @property int $width
 * @property int $height
 * @property string|null $colour
 * @property string|null $imageUrl
 * @property \Illuminate\Support\Carbon|null $createdAt
 * @property \Illuminate\Support\Carbon|null $updatedAt
 * @method static \Illuminate\Database\Eloquent\Builder|\Domain\Rooms\Room whereColour($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Domain\Rooms\Room whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Domain\Rooms\Room whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Domain\Rooms\Room whereDifficulty($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Domain\Rooms\Room whereHeight($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Domain\Rooms\Room whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Domain\Rooms\Room whereImageUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Domain\Rooms\Room whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Domain\Rooms\Room whereProjectId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Domain\Rooms\Room whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Domain\Rooms\Room whereWidth($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Domain\Rooms\Room whereX($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Domain\Rooms\Room whereY($value)
 * @property int $projectId
 * @property string|null $imageUrl
 * @property \Illuminate\Support\Carbon|null $createdAt
 * @property \Illuminate\Support\Carbon|null $updatedAt
 * @property int $projectId
 * @property string|null $imageUrl
 * @property \Illuminate\Support\Carbon|null $createdAt
 * @property \Illuminate\Support\Carbon|null $updatedAt
 * @property int $projectId
 * @property string|null $imageUrl
 * @property \Illuminate\Support\Carbon|null $createdAt
 * @property \Illuminate\Support\Carbon|null $updatedAt
 * @property-read \Illuminate\Database\Eloquent\Collection|\Domain\KeyRooms\KeyRoom[] $keyRooms
 * @property-read int|null $keyRoomsCount
 * @property-read \Domain\Projects\Project $project
 * @property int $projectId
 * @property string|null $imageUrl
 * @property \Illuminate\Support\Carbon|null $createdAt
 * @property \Illuminate\Support\Carbon|null $updatedAt
 * @property-read \Illuminate\Database\Eloquent\Collection|\Domain\KeyRooms\KeyRoom[] $keyRooms
 * @property-read int|null $keyRoomsCount
 * @property-read \Domain\Keys\KeyCollection|\Domain\Keys\Key[] $keys
 * @property-read int|null $keysCount
 * @property int $projectId
 * @property string|null $imageUrl
 * @property \Illuminate\Support\Carbon|null $createdAt
 * @property \Illuminate\Support\Carbon|null $updatedAt
 * @property-read \Illuminate\Database\Eloquent\Collection|\Domain\KeyRooms\KeyRoom[] $keyRooms
 * @property-read int|null $keyRoomsCount
 * @property-read int|null $keysCount
 */
class Room extends Model
{
    public $dateFormat = 'Y-m-d H:i:s';

    public $table = 'rooms';

    protected $dates = [
        'created_at',
        'updated_at',
    ];

    protected $fillable = [
        'project_id',
        'name',
        'description',
        'difficulty',
        'x',
        'y',
        'width',
        'height',
        'colour',
        'image_url',
    ];

    // Boot //

    public static function boot(): void
    {
        parent::boot();
        //self::observe(new RoomObserver);
    }

    // Relationships //

    public function key_rooms(): HasMany
    {
        return $this->hasMany(KeyRoom::class);
    }

    public function keys(): BelongsToMany
    {
        return $this->belongsToMany(Key::class);
    }

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    // Magic //

    public function newCollection(array $models = []): RoomCollection
    {
        return new RoomCollection($models);
    }

    public function newEloquentBuilder($query): RoomBuilder
    {
        return new RoomBuilder($query);
    }
}
