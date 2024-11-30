<?php
namespace App\Services;

use App\RepositoryInterfaces\StopRepositoryInterface;

class StopService
{
    protected $stopReposity;

    public function __construct(StopRepositoryInterface $stopReposity)
    {
        $this->stopReposity = $stopReposity;    
    }

    public function addStopToRide($ride_id, $address_id, $type){
        return $this->stopReposity->addStopToRide($ride_id, $address_id, $type);
    }

    public function getStopAddresses(){
        return $this->stopReposity->getStopAddresses();
    }

    public function deleteById($id){
        return $this->stopReposity->deleteById($id);
    }
}