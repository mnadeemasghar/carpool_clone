<?php
namespace App\Repositories;

use App\Models\Address;
use App\RepositoryInterfaces\AddressRepositoryInterface;

class AddressRepository  implements AddressRepositoryInterface
{
    public function getAddressByTitle($title,$data = ['lat' => null, 'lng' => null]){
        $location_data = Address::where('title',$title)->first();
        if(!$location_data){
            $location_data = Address::create(array_merge($data,['title' => $title]));
        }

        return $location_data;
    }

    public function getAddresses($title){
        return Address::where('title', 'LIKE', "%{$title}%")->get(['id','title','lat','lng']);
    }
}