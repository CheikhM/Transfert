<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WithDrawl extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'withdrawls';

    /**
     * Get the person behind a given withdrawl.
    */
    public function customer(){
        return $this->belongsTo(Customer::class);
    }
}
