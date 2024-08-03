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
        Schema::create('wing_external_stability_lls', function (Blueprint $table) {
            $table->id();

            $table->foreignId('project_id')->constrained();
            $table->foreignId('design_id')->constrained()->onDelete('cascade');;

            // LS Moment Arm
            $table->double('yev');
            $table->double('yls_v');

            // Material Properties
            $table->double('bstem_batter');
            $table->double('b_i');
            $table->double('sigma_brg');
            $table->double('delta_s');
            $table->double('g_r_fill');
            $table->double('phi_r_fill');
            $table->double('phi_f_soil');

            // EQ Parameters
            $table->double('pga');
            $table->double('f_pga_eq');
            $table->double('k_v');

            // Design Height and Spacing
            $table->double('min_design_height');
            $table->double('max_design_height');
            $table->double('s_v');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wing_external_stability_lls');
    }
};
