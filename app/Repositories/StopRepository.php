<?php
namespace App\Repositories;

use App\Models\Address;
use App\Models\Ride;
use App\Models\Stop;
use App\RepositoryInterfaces\StopRepositoryInterface;
use Carbon\Carbon;

class StopRepository  implements StopRepositoryInterface
{
    public function getStopAddresses(){
        // Fetch address IDs directly by joining the rides and stops in a single query
        return Address::whereIn('id', function($query) {
            $query->select('address_id')
                  ->from('stops')
                  ->whereIn('ride_id', function($query) {
                      $query->select('id')
                            ->from('rides')
                            ->where('status', '!=', 'inactive')
                            ->where('end_date', '>=', Carbon::today()->toDateString());
                  });
        })->orderBy('title', 'ASC')->get();
    }    
    
    public function addStopToRide($ride_id, $address_id, $type){
        $stop = Stop::where('ride_id', $ride_id)->where('address_id',$address_id)->where('type', $type)->first();
    
        if (!$stop) {
             // Create a new stop if it doesn't exist
            Stop::create([
                'ride_id' => $ride_id,
                'address_id' => $address_id,
                'type' => $type
            ]);
        
            return true; // Return true since a new stop was created
        }
        else {
            return true; // Return true since a new stop was created
        }
    
    }
    
    public function deleteById($id){
        $stop = Stop::find($id);
        return $stop->delete();
    }
}
