<?php

namespace Domain\KeyRooms;

use Domain\Keys\Key;
use Domain\Rooms\Room;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\Pivot;

/**
 * Domain\KeyRooms\KeyRoom
 *
 * @method static \Domain\KeyRooms\KeyRoomBuilder|\Domain\KeyRooms\KeyRoom newModelQuery()
 * @method static \Domain\KeyRooms\KeyRoomBuilder|\Domain\KeyRooms\KeyRoom newQuery()
 * @method static \Domain\KeyRooms\KeyRoomBuilder|\Domain\KeyRooms\KeyRoom query()
 * @mixin \Eloquent
 * @property-read \Domain\Keys\Key $key
 * @property-read \Domain\Rooms\Room $room
 * @property int $id
 * @property int $keyId
 * @property int $roomId
 * @property int $x
 * @property int $y
 * @property \Illuminate\Support\Carbon|null $createdAt
 * @property \Illuminate\Support\Carbon|null $updatedAt
 * @method static \Illuminate\Database\Eloquent\Builder|\Domain\KeyRooms\KeyRoom whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Domain\KeyRooms\KeyRoom whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Domain\KeyRooms\KeyRoom whereKeyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Domain\KeyRooms\KeyRoom whereRoomId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Domain\KeyRooms\KeyRoom whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Domain\KeyRooms\KeyRoom whereX($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Domain\KeyRooms\KeyRoom whereY($value)
 * @property int $keyId
 * @property int $roomId
 * @property \Illuminate\Support\Carbon|null $createdAt
 * @property \Illuminate\Support\Carbon|null $updatedAt
 * @property int $keyId
 * @property int $roomId
 * @property \Illuminate\Support\Carbon|null $createdAt
 * @property \Illuminate\Support\Carbon|null $updatedAt
 * @property int $keyId
 * @property int $roomId
 * @property \Illuminate\Support\Carbon|null $createdAt
 * @property \Illuminate\Support\Carbon|null $updatedAt
 */
class KeyRoom extends Pivot
{
    public $dateFormat = 'Y-m-d H:i:s';

    protected $table = 'key_room';

    protected $primaryKey = 'id';

    protected $dates = [
        'created_at',
        'updated_at',
    ];

    protected $fillable = [
        'key_id',
        'room_id',
    ];

    // Boot //

    public static function boot(): void
    {
        parent::boot();
        //self::observe(new KeyRoomObserver);
    }

    // Relationships //

    public function key(): BelongsTo
    {
        return $this->belongsTo(Key::class);
    }

    public function room(): BelongsTo
    {
        return $this->belongsTo(Room::class);
    }
}
