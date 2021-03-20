<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Deposit extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'deposits';

    /**
     * Get the owner of a given deposit.
     */
    public function customer(){
        return $this->belongsTo(Customer::class);
    }
}
