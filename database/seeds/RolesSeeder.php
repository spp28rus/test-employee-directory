<?php

use App\Models\Role;
use Illuminate\Database\Seeder;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = [
            Role::ADMIN_SLUG,
            Role::USER_SLUG,
        ];

        foreach ($roles as $slug) {
            Role::updateOrCreate([
                'slug' => $slug,
            ]);
        }
    }
}
