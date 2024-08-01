<?php

namespace Database\Seeders;

use App\Models\MemberRole;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MemberRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $items = [
            'Designer',
            'Supervisor',
            'Manager',
            'Other'
        ];

        foreach ($items as $item) {
            $type = new MemberRole();
            $type->name = $item;
            $type->save();
        }
    }
}
