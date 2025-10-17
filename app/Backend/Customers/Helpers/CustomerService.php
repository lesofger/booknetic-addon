<?php

namespace BookneticApp\Backend\Customers\Helpers;

use BookneticApp\Models\Appointment;
use BookneticApp\Models\Customer;
use BookneticApp\Providers\Core\Permission;
use BookneticApp\Providers\DB\DB;
use BookneticApp\Providers\Helpers\Helper;

class CustomerService
{
    public static function createCustomer(CustomerData $customerData): int
    {
        Customer::insert([
            'user_id'       => null,
            'first_name'    => $customerData->first_name,
            'last_name'     => $customerData->last_name,
            'phone_number'  => $customerData->phone,
            'email'         => $customerData->email,
            'created_at'    => date('Y-m-d'),
        ]);

        return DB::lastInsertedId();
    }

    public static function createCustomerIfDoesntExist(CustomerData $customerData)
    {
        $customerId = self::checkIfCustomerExists($customerData);

        if (empty($customerId)) {
            $customerId = self::createCustomer($customerData);
        }

        return $customerId;
    }

    public static function checkIfCustomerExists(CustomerData $customerData)
    {
        $customerIdentifier = Helper::getOption('customer_identifier', 'email');

        if ($customerIdentifier === 'phone' && ! empty($customerData->phone)) {
            $checkCustomerExists = Customer::where('phone_number', $customerData->phone)->fetch();
        } elseif ($customerIdentifier === 'email' && ! empty($customerData->email)) {
            $checkCustomerExists = Customer::where('email', $customerData->email)->fetch();
        }

        return $checkCustomerExists->id ?? null;
    }

    public static function getCustomersOfLoggedInUser()
    {
        return Customer::query()
            ->where('user_id', Permission::userId())
            ->noTenant()
            ->fetchAll();
    }

    public static function updateOnlyEmptyDataOfCustomer($customerId, CustomerData $customerData)
    {
        $customerInf = Customer::get($customerId);

        if (! $customerInf) {
            return;
        }

        $updateData = [];

        if (! empty($customerData->email) && empty($customerInf->email)) {
            $updateData['email'] = $customerData->email;
        }

        if (! empty($customerData->phone) && empty($customerInf->phone_number)) {
            $updateData['phone_number'] = $customerData->phone;
        }

        if (! empty($customerData->first_name) && empty($customerInf->first_name)) {
            $updateData['first_name'] = $customerData->first_name;
        }

        if (! empty($customerData->last_name) && empty($customerInf->last_name)) {
            $updateData['last_name'] = $customerData->last_name;
        }

        if (! empty($updateData)) {
            Customer::where('id', $customerId)->update($updateData);
        }
    }

    public static function findCustomerTimezone($customerId)
    {
        $appointment = Appointment::where('customer_id', $customerId)
            ->where('client_timezone', '<>', '-')
            ->select([ 'client_timezone' ])
            ->orderBy('id DESC')
            ->fetch();

        $timezone = $appointment->client_timezone ?? '-';

        return apply_filters('bkntc_customer_timezone', $timezone, $customerId);
    }

    public static function findCustomerLocale($customerId)
    {
        $appointment = Appointment::where('customer_id', $customerId)
            ->where('locale', '<>', '')
            ->select([ 'locale' ])
            ->orderBy('id DESC')
            ->fetch();

        $locale = $appointment->locale ?? '-';

        return apply_filters('bkntc_customer_locale', $locale, $customerId);
    }
}
