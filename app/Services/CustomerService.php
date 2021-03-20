<?php
namespace App\Services;

use App\Models\Customer;

class CustomerService {


    static function isExistant($uid) {
        return (bool) Customer::find($uid);
    }
}
