<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transfert extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'transferts';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['amount', 'currency', 'customer_id', 'price'];

    /**
     * Get the customer behind a given transfert.
     */
    public function customer() {
        return $this->belongsTo(Customer::class);
    }

    /**
     * Get the sendor of the transfert.
     */
    public function sender() {
        return $this->hasOne(User::class, 'id', 'from');
    }

    /**
     * Get the receiver of the transfert.
     */
    public function receiver() {
        return $this->hasOne(User::class, 'id', 'to');
    }


    /**
     * Get the currecy of a given transfert.
     */
    public function money() {
        return $this->hasOne(Currency::class, 'id', 'currency');
    }

}
