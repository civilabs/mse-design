<?php

namespace Database\Seeders;

use App\Models\DesignType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DesignTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $items = [
            [
                'Abutment External Stability',
                'abutment_external_stability',
                'Check for external stability of an abutment.'
            ],
            [
                'Wing External Stability',
                'wing_external_stability',
                'Check for external stability of a wing (without LL).'
            ],
            [
                'Wing External Stability with LL',
                'wing_external_stability_ll',
                'Check for external stability of a wing (with LL).'
            ],
            [
                'Abutment Internal Stability',
                'abutment_internal_stability',
                'Check for internal stability of an abutment.'
            ],
            [
                'Wing Internal Stability',
                'wing_internal_stability',
                'Check for internal stability of a wing.'
            ]
        ];

        foreach ($items as $item) {
            $test = new DesignType();
            $test->name = $item[0];
            $test->key = $item[1];
            $test->description = $item[2];
            $test->save();
        }
    }
}
