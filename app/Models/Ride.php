<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ride extends Model
{
    use HasFactory;

    const ROLE_PASSENGER = 'passenger';
    const ROLE_DRIVER = 'driver';

    const VEHICLE_CAR = 'Car';
    const VEHICLE_BIKE = 'Bike';
    const VEHICLE_VAN = 'Van';

    const TRIP_TYPE_SINGLE = 'One Way';
    const TRIP_TYPE_ROUND = 'Round Trip';

    protected $fillable = [
        'pick_location_id',
        'pick_time',
        'drop_location_id',
        'return_time',
        'start_date',
        'end_date',
        'trip_type',
        'offer',
        // 'gender',
        'user_id',
        'vehicle_type',
        'role',
        'mon',
        'tue',
        'wed',
        'thu',
        'fri',
        'sat',
        'sun',
        'status',
        'note'
    ];

    public function interested_users()
    {
        return $this->hasManyThrough(
            User::class,
            Interest::class,
            'ride_id',  // Foreign key on Interest table...
            'id',       // Foreign key on User table (typically the primary key)...
            'id',       // Local key on Ride table (typically the primary key)...
            'user_id'   // Local key on Interest table...
        );
    }

    public function isUserInterested($userId)
    {
        return $this->interested_users()->where('user_id', $userId)->exists();
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function pick_location(){
        return $this->belongsTo(Address::class);
    }

    public function drop_location(){
        return $this->belongsTo(Address::class);
    }

    public function comments(){
        return $this->hasMany(Comment::class);
    }

    public function latestComment()
    {
        return $this->hasOne(Comment::class)->latestOfMany(); // Returns the latest comment for each ride
    }

    public function stops(){
        return $this->hasMany(Stop::class);
    }

    public function commentors()
    {
        return $this->belongsToMany(User::class, 'comments', 'ride_id', 'user_id')
                    ->distinct();
    }
}
