<?php

use App\Models\Role;
use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CreateAdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::beginTransaction();

        $user = new User();
        $user->name = 'admin';
        $user->password = bcrypt('password');
        $user->email = 'admin@admin.com';
        $user->phone_number = '+777777777';
        $user->save();

        $user->userRoles()->create([
            'role_id' => Role::getBySlug(Role::ADMIN_SLUG)->id,
        ]);

        $user->employee()->create();

        DB::commit();
    }
}
