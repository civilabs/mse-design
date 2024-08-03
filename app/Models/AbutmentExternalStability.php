<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AbutmentExternalStability extends Model
{
    use HasFactory;

    protected $fillable = [
        // LS Moment Arm
        'yev',
        'yls_v',

        // Material Properties
        'bstem_batter',
        'b_i',
        'sigma_brg',
        'delta_s',
        'g_r_fill',
        'phi_r_fill',
        'phi_f_soil',

        // EQ Parameters
        'pga',
        'f_pga_eq',
        'k_v',

        // Design Height and Spacing
        'min_design_height',
        'max_design_height',
        's_v',
    ];

    public function design()
    {
        return $this->belongsTo(Design::class);
    }
}
