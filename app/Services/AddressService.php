<?php
namespace App\Services;

use App\RepositoryInterfaces\AddressRepositoryInterface;

class AddressService
{
    protected $addressRepository;

    public function __construct(AddressRepositoryInterface $addressRepository)
    {
        $this->addressRepository = $addressRepository;
    }

    public function getAddressByTitle($title){
        return $this->addressRepository->getAddressByTitle($title);
    }

    public function getAddresses($title){
        return $this->addressRepository->getAddresses($title);
    }
}