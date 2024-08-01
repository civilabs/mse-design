<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('abutment_external_stabilities', function (Blueprint $table) {
            $table->id();

            $table->foreignId('project_id')->constrained();
            $table->foreignId('design_id')->constrained()->onDelete('cascade');;

            // LS Moment Arm
            $table->double('yev');
            $table->double('yls_v');

            // Material Properties
            // $table->double('fpc');
            // $table->double('fy');
            // $table->double('g_conc');
            // $table->double('e_steel');
            // $table->double('e_conc');
            // $table->double('cpf_soil');
            $table->double('bstem_batter');
            // $table->double('theta');
            $table->double('b_i');
            $table->double('sigma_brg');
            $table->double('delta_s');
            $table->double('g_r_fill');
            $table->double('phi_r_fill');
            // $table->double('cpr_fill');
            // $table->double('g_b_fill');
            // $table->double('phi_b_fill');
            // $table->double('cpb_fill');
            // $table->double('g_f_soil');
            $table->double('phi_f_soil');

            // EQ Parameters
            $table->double('pga');
            // $table->double('s_s_eq');
            // $table->double('s_1_eq');
            $table->double('f_pga_eq');
            // $table->double('f_a_eq');
            // $table->double('f_v_eq');
            // $table->double('s_d1_eq');
            // $table->double('a_s_eq');
            $table->double('k_v');

            // Design Height and Spacing
            $table->double('min_design_height');
            $table->double('max_design_height');
            $table->double('s_v');
            // $table->double('s_h');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('abutment_external_stabilities');
    }
};
