<?php

namespace BookneticApp\Backend\Customers\Mappers;

use BookneticApp\Backend\Customers\DTOs\Response\CustomerResponse;
use BookneticApp\Providers\DB\Collection;

class CustomerMapper
{
    /**
     * @param Collection $customer
     * @return CustomerResponse
     */
    public static function toResponse(Collection $customer): CustomerResponse
    {
        $dto = new CustomerResponse();

        $dto->setId($customer->id)
            ->setFirstName($customer->first_name)
            ->setLastName($customer->last_name)
            ->setPhoneNumber($customer->phone_number)
            ->setEmail($customer->email)
            ->setBirthdate($customer->birthdate)
            ->setNotes($customer->notes ?? '')
            ->setProfileImage($customer->profile_image)
            ->setUserId($customer->user_id ?? 0)
            ->setGender($customer->gender);

        return $dto;
    }
}
