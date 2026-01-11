<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BapAbsent extends Model
{
    protected $fillable = ['bap_id', 'nim', 'nama'];

    public function bap()
    {
        return $this->belongsTo(Bap::class);
    }
}
