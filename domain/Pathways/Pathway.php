<?php

namespace Domain\Pathways;

use Domain\KeyPathways\KeyPathway;
use Domain\Keys\Key;
use Domain\Projects\Project;
use Domain\Rooms\Room;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Domain\Pathways\Pathway
 *
 * @method static \Domain\Pathways\PathwayBuilder|\Domain\Pathways\Pathway newModelQuery()
 * @method static \Domain\Pathways\PathwayBuilder|\Domain\Pathways\Pathway newQuery()
 * @method static \Domain\Pathways\PathwayBuilder|\Domain\Pathways\Pathway query()
 * @mixin \Eloquent
 * @property int $id
 * @property int $projectId
 * @property int|null $room1Id
 * @property int|null $room2Id
 * @property string $name
 * @property string $description
 * @property int $difficulty
 * @property string|null $colour
 * @property string|null $imageUrl
 * @property \Illuminate\Support\Carbon|null $createdAt
 * @property \Illuminate\Support\Carbon|null $updatedAt
 * @method static \Illuminate\Database\Eloquent\Builder|\Domain\Pathways\Pathway whereColour($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Domain\Pathways\Pathway whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Domain\Pathways\Pathway whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Domain\Pathways\Pathway whereDifficulty($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Domain\Pathways\Pathway whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Domain\Pathways\Pathway whereImageUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Domain\Pathways\Pathway whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Domain\Pathways\Pathway whereProjectId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Domain\Pathways\Pathway whereRoom1Id($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Domain\Pathways\Pathway whereRoom2Id($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Domain\Pathways\Pathway whereUpdatedAt($value)
 * @property int $projectId
 * @property int|null $room1Id
 * @property int|null $room2Id
 * @property string|null $imageUrl
 * @property \Illuminate\Support\Carbon|null $createdAt
 * @property \Illuminate\Support\Carbon|null $updatedAt
 * @property int $projectId
 * @property int|null $room1Id
 * @property int|null $room2Id
 * @property string|null $imageUrl
 * @property \Illuminate\Support\Carbon|null $createdAt
 * @property \Illuminate\Support\Carbon|null $updatedAt
 * @property int $projectId
 * @property int|null $room1Id
 * @property int|null $room2Id
 * @property string|null $imageUrl
 * @property \Illuminate\Support\Carbon|null $createdAt
 * @property \Illuminate\Support\Carbon|null $updatedAt
 * @property-read \Illuminate\Database\Eloquent\Collection|\Domain\KeyPathways\KeyPathway[] $keyPathways
 * @property-read int|null $keyPathwaysCount
 * @property-read \Domain\Projects\Project $project
 * @property-read \Domain\Rooms\Room $room1
 * @property-read \Domain\Rooms\Room $room2
 * @property int $projectId
 * @property int|null $room1Id
 * @property int|null $room2Id
 * @property string|null $imageUrl
 * @property \Illuminate\Support\Carbon|null $createdAt
 * @property \Illuminate\Support\Carbon|null $updatedAt
 * @property-read \Illuminate\Database\Eloquent\Collection|\Domain\KeyPathways\KeyPathway[] $keyPathways
 * @property-read int|null $keyPathwaysCount
 * @property-read \Domain\Keys\KeyCollection|\Domain\Keys\Key[] $keys
 * @property-read int|null $keysCount
 * @property-read \Domain\Rooms\Room|null $room1
 * @property-read \Domain\Rooms\Room|null $room2
 * @property int $projectId
 * @property int|null $room1Id
 * @property int|null $room2Id
 * @property string|null $imageUrl
 * @property \Illuminate\Support\Carbon|null $createdAt
 * @property \Illuminate\Support\Carbon|null $updatedAt
 * @property-read \Illuminate\Database\Eloquent\Collection|\Domain\KeyPathways\KeyPathway[] $keyPathways
 * @property-read int|null $keyPathwaysCount
 * @property-read int|null $keysCount
 * @property-read \Domain\Rooms\Room|null $room1
 * @property-read \Domain\Rooms\Room|null $room2
 */
class Pathway extends Model
{
    public $dateFormat = 'Y-m-d H:i:s';

    public $table = 'pathways';

    protected $dates = [
        'created_at',
        'updated_at',
    ];

    protected $fillable = [
        'project_id',
        'room_1_id',
        'room_2_id',
        'name',
        'description',
        'difficulty',
        'colour',
        'image_url',
    ];

    // Boot //

    public static function boot(): void
    {
        parent::boot();
        //self::observe(new PathwayObserver);
    }

    // Relationships //

    public function key_pathways(): HasMany
    {
        return $this->hasMany(KeyPathway::class);
    }

    public function keys(): BelongsToMany
    {
        return $this->belongsToMany(Key::class);
    }

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    public function room_1(): BelongsTo
    {
        return $this->belongsTo(Room::class, 'room_1_id');
    }

    public function room_2(): BelongsTo
    {
        return $this->belongsTo(Room::class, 'room_2_id');
    }

    // Magic //

    public function newCollection(array $models = []): PathwayCollection
    {
        return new PathwayCollection($models);
    }

    public function newEloquentBuilder($query): PathwayBuilder
    {
        return new PathwayBuilder($query);
    }
}
