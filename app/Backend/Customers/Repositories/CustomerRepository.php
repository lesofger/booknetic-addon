<?php

namespace BookneticApp\Backend\Customers\Repositories;

use BookneticApp\Models\Customer;
use BookneticApp\Providers\DB\Collection;

class CustomerRepository
{
    /**
     * @param int $id
     * @return Collection|null
     */
    public function get(int $id): ?Collection
    {
        return Customer::get($id);
    }

    /**
     * @param array $data
     * @return int
     */
    public function create(array $data): int
    {
        Customer::insert($data);

        return Customer::lastId();
    }

    /**
     * @param int $id
     * @param array $data
     * @return void
     */
    public function update(int $id, array $data): void
    {
        Customer::where('id', $id)->update($data);
    }

    /**
     * @param string $email
     * @return int
     */
    public function getCustomerCountByEmail(string $email): int
    {
        return  Customer::noTenant()->where('email', $email)->count();
    }

    /**
     * @param int $id
     * @return void
     */
    public function delete(int $id): void
    {
        Customer::where('id', $id)->delete();
    }

    /**
     * @param int $id
     * @return int
     */
    public function getCustomerCountByWpUserId(int $id): int
    {
        return Customer::noTenant()->where('user_id', $id)->count();
    }
}
