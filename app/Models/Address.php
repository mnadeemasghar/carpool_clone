<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'lat',
        'lng',
        'user_id'
    ];

    public static function getActivePickAddresses()
    {
        // Get pick location IDs from active rides
        $pickLocationIds = Ride::where('status', 'active')
                                ->where('end_date', '>=', Carbon::today()->toDateString())
                                ->pluck('pick_location_id')
                                ->toArray();
    
        // Get drop location IDs from active rides
        // $dropLocationIds = Ride::where('status', 'active')->pluck('drop_location_id')->toArray();
    
        // Merge and get unique IDs
        // $allLocationIds = array_unique(array_merge($pickLocationIds, $dropLocationIds));
        $allLocationIds = array_unique(array_merge($pickLocationIds));
    
        // Return addresses with the merged IDs
        return self::whereIn('id', $allLocationIds)->orderBy('title', 'ASC')->get();
    }

    public static function getActiveDropAddresses($pick_location_id = null)
    {
        // Get pick location IDs from active rides
        // $pickLocationIds = Ride::where('status', 'active')->pluck('pick_location_id')->toArray();
    
        // Get drop location IDs from active rides
        if($pick_location_id != null){
            $dropLocationIds = Ride::where('status', 'active')->where('pick_location_id',$pick_location_id)->pluck('drop_location_id')->toArray();
        }
        else{
            $dropLocationIds = Ride::where('status', 'active')->pluck('drop_location_id')->toArray();
        }
    
        // Merge and get unique IDs
        // $allLocationIds = array_unique(array_merge($pickLocationIds, $dropLocationIds));
        $allLocationIds = array_unique(array_merge($dropLocationIds));
    
        // Return addresses with the merged IDs
        return self::whereIn('id', $allLocationIds)->orderBy('title', 'ASC')->get();
    }

    public function rides(){
        return $this->hasManyThrough(
            Ride::class,       // The final model we want to access (Ride)
            Stop::class,       // The intermediate model (Stop)
            'address_id',      // Foreign key on the stops table linking to addresses
            'id',              // Foreign key on the rides table linking to stops (using stops' ride_id)
            'id',              // Local key on the addresses table
            'ride_id'          // Local key on the stops table linking to rides
        );
    }
}
