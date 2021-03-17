<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'customers';

     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'phone'];

    /**
     * retrieve all deposits of a given user.
     */
    public function deposits() {
        return $this->hasMany(Deposit::class);
    }

    /**
     * retrieve all transferts of a given user.
     */
    public function transferts() {
        return $this->hasMany(Transfert::class);
    }

     /**
     * retrieve all history of deposits for a given user.
     */
    public function depositsHistory() {
        return $this->hasMany(DepositHistory::class);
    }



}
