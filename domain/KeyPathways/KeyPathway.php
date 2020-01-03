<?php

namespace Domain\KeyPathways;

use Domain\Keys\Key;
use Domain\Pathways\Pathway;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\Pivot;

/**
 * Domain\KeyPathways\KeyPathway
 *
 * @method static \Domain\KeyPathways\KeyPathwayBuilder|\Domain\KeyPathways\KeyPathway newModelQuery()
 * @method static \Domain\KeyPathways\KeyPathwayBuilder|\Domain\KeyPathways\KeyPathway newQuery()
 * @method static \Domain\KeyPathways\KeyPathwayBuilder|\Domain\KeyPathways\KeyPathway query()
 * @mixin \Eloquent
 * @property-read \Domain\Keys\Key $key
 * @property-read \Domain\Pathways\Pathway $pathway
 * @property int $id
 * @property int $keyId
 * @property int $pathwayId
 * @property \Illuminate\Support\Carbon|null $createdAt
 * @property \Illuminate\Support\Carbon|null $updatedAt
 * @method static \Illuminate\Database\Eloquent\Builder|\Domain\KeyPathways\KeyPathway whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Domain\KeyPathways\KeyPathway whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Domain\KeyPathways\KeyPathway whereKeyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Domain\KeyPathways\KeyPathway wherePathwayId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Domain\KeyPathways\KeyPathway whereUpdatedAt($value)
 * @property int $keyId
 * @property int $pathwayId
 * @property \Illuminate\Support\Carbon|null $createdAt
 * @property \Illuminate\Support\Carbon|null $updatedAt
 * @property int $keyId
 * @property int $pathwayId
 * @property \Illuminate\Support\Carbon|null $createdAt
 * @property \Illuminate\Support\Carbon|null $updatedAt
 * @property int $keyId
 * @property int $pathwayId
 * @property \Illuminate\Support\Carbon|null $createdAt
 * @property \Illuminate\Support\Carbon|null $updatedAt
 */
class KeyPathway extends Pivot
{
    public $dateFormat = 'Y-m-d H:i:s';

    protected $table = 'key_pathway';

    protected $dates = [
        'created_at',
        'updated_at',
    ];

    protected $fillable = [
        'key_id',
        'pathway_id',
    ];

    // Boot //

    public static function boot(): void
    {
        parent::boot();
        //self::observe(new KeyPathwayObserver);
    }

    // Relationships //

    public function key(): BelongsTo
    {
        return $this->belongsTo(Key::class);
    }

    public function pathway(): BelongsTo
    {
        return $this->belongsTo(Pathway::class);
    }
}
