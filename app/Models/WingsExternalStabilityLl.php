<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WingsExternalStabilityLl extends Model
{
    use HasFactory;

    protected $fillable = [
        // LS Moment Arm
        'yev',
        'yls_v',

        // Material Properties
        'fpc',
        'fy',
        'g_conc',
        'e_steel',
        'e_conc',
        'cpf_soil',
        'bstem_batter',
        'theta',
        'b_i',
        'sigma_brg',
        'delta_s',
        'g_r_fill',
        'phi_r_fill',
        'cpr_fill',
        'g_b_fill',
        'phi_b_fill',
        'cpb_fill',
        'g_f_soil',
        'phi_f_soil',

        // EQ Parameters
        'pga',
        's_s_eq',
        's_1_eq',
        'f_pga_eq',
        'f_a_eq',
        'f_v_eq',
        's_d1_eq',
        'a_s_eq',
        'k_v',

        // Design Height and Spacing
        'min_design_height',
        'max_design_height',
        's_v',
        's_h'
    ];

    public function design()
    {
        return $this->belongsTo(Design::class);
    }
}
