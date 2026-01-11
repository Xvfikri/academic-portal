<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BapSeat extends Model
{
    protected $fillable = ['bap_id', 'seat_number', 'nim'];

    public function bap()
    {
        return $this->belongsTo(Bap::class);
    }
}
