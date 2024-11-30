<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stop extends Model
{
    use HasFactory;

    const TYPE_PICK = 'pick';
    const TYPE_STOP = 'stop';
    const TYPE_DROP = 'drop';

    protected $fillable = [
        'ride_id',
        'address_id',
        'type'
    ];

    public function address(){
        return $this->belongsTo(Address::class);
    }

    public function rides(){
        return $this->belongsTo(Ride::class,'ride_id');
    }

}
