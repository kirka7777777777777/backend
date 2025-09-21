<?php
namespace Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $fillable = [
        'name',
        'type_id',
        'building_id',
        'area',
        'seats'
    ];

    public function building()
    {
        return $this->belongsTo(Building::class, 'building_id');
    }

    public function type()
    {
        return $this->belongsTo(RoomType::class, 'type_id');
    }
}