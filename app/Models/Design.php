<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Design extends Model
{
    use HasFactory;

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function design_type()
    {
        return $this->belongsTo(DesignType::class);
    }

    public function abutment_external_stability()
    {
        return $this->hasOne(AbutmentExternalStability::class);
    }

    public function wings_external_stability_ll()
    {
        return $this->hasOne(WingsExternalStabilityLl::class);
    }
}
