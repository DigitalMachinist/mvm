<?php

namespace Domain\Keys;

use Domain\KeyPathways\KeyPathway;
use Domain\KeyRooms\KeyRoom;
use Domain\Pathways\Pathway;
use Domain\Projects\Project;
use Domain\Rooms\Room;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Domain\Keys\Key
 *
 * @method static \Domain\Keys\KeyBuilder|\Domain\Keys\Key newModelQuery()
 * @method static \Domain\Keys\KeyBuilder|\Domain\Keys\Key newQuery()
 * @method static \Domain\Keys\KeyBuilder|\Domain\Keys\Key query()
 * @mixin \Eloquent
 * @property int $id
 * @property int $projectId
 * @property string $name
 * @property string $description
 * @property string|null $colour
 * @property string|null $imageUrl
 * @property \Illuminate\Support\Carbon|null $createdAt
 * @property \Illuminate\Support\Carbon|null $updatedAt
 * @method static \Illuminate\Database\Eloquent\Builder|\Domain\Keys\Key whereColour($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Domain\Keys\Key whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Domain\Keys\Key whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Domain\Keys\Key whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Domain\Keys\Key whereImageUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Domain\Keys\Key whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Domain\Keys\Key whereProjectId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Domain\Keys\Key whereUpdatedAt($value)
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
 * @property-read \Illuminate\Database\Eloquent\Collection|\Domain\KeyPathways\KeyPathway[] $keyPathways
 * @property-read int|null $keyPathwaysCount
 * @property-read \Illuminate\Database\Eloquent\Collection|\Domain\KeyRooms\KeyRoom[] $keyRooms
 * @property-read int|null $keyRoomsCount
 * @property-read \Domain\Pathways\PathwayCollection|\Domain\Pathways\Pathway[] $pathways
 * @property-read int|null $pathwaysCount
 * @property-read \Domain\Projects\Project $project
 * @property-read \Domain\Rooms\RoomCollection|\Domain\Rooms\Room[] $rooms
 * @property-read int|null $roomsCount
 * @property int $projectId
 * @property string|null $imageUrl
 * @property \Illuminate\Support\Carbon|null $createdAt
 * @property \Illuminate\Support\Carbon|null $updatedAt
 * @property-read \Illuminate\Database\Eloquent\Collection|\Domain\KeyPathways\KeyPathway[] $keyPathways
 * @property-read int|null $keyPathwaysCount
 * @property-read \Illuminate\Database\Eloquent\Collection|\Domain\KeyRooms\KeyRoom[] $keyRooms
 * @property-read int|null $keyRoomsCount
 * @property-read int|null $pathwaysCount
 * @property-read int|null $roomsCount
 * @property int $projectId
 * @property string|null $imageUrl
 * @property \Illuminate\Support\Carbon|null $createdAt
 * @property \Illuminate\Support\Carbon|null $updatedAt
 * @property-read \Illuminate\Database\Eloquent\Collection|\Domain\KeyPathways\KeyPathway[] $keyPathways
 * @property-read int|null $keyPathwaysCount
 * @property-read \Illuminate\Database\Eloquent\Collection|\Domain\KeyRooms\KeyRoom[] $keyRooms
 * @property-read int|null $keyRoomsCount
 * @property-read int|null $pathwaysCount
 * @property-read int|null $roomsCount
 * @property int $projectId
 * @property string|null $imageUrl
 * @property \Illuminate\Support\Carbon|null $createdAt
 * @property \Illuminate\Support\Carbon|null $updatedAt
 * @property-read \Illuminate\Database\Eloquent\Collection|\Domain\KeyPathways\KeyPathway[] $keyPathways
 * @property-read int|null $keyPathwaysCount
 * @property-read \Illuminate\Database\Eloquent\Collection|\Domain\KeyRooms\KeyRoom[] $keyRooms
 * @property-read int|null $keyRoomsCount
 * @property-read int|null $pathwaysCount
 * @property-read int|null $roomsCount
 */
class Key extends Model
{
    public $dateFormat = 'Y-m-d H:i:s';

    public $table = 'keys';

    protected $dates = [
        'created_at',
        'updated_at',
    ];

    protected $fillable = [
        'project_id',
        'name',
        'description',
        'colour',
        'image_url',
    ];

    // Boot //

    public static function boot(): void
    {
        parent::boot();
        //self::observe(new KeyObserver);
    }

    // Relationships //

    public function key_pathways(): HasMany
    {
        return $this->hasMany(KeyPathway::class);
    }

    public function key_rooms(): HasMany
    {
        return $this->hasMany(KeyRoom::class);
    }

    public function pathways(): BelongsToMany
    {
        return $this->belongsToMany(Pathway::class);
    }

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    public function rooms(): BelongsToMany
    {
        return $this->belongsToMany(Room::class);
    }

    // Magic //

    public function newCollection(array $models = []): KeyCollection
    {
        return new KeyCollection($models);
    }

    public function newEloquentBuilder($query): KeyBuilder
    {
        return new KeyBuilder($query);
    }
}
