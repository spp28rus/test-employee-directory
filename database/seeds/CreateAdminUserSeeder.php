<?php

use App\Models\Role;
use App\User;
use Illuminate\Auth\Events\Registered;
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
        $adminEmail = 'admin@admin.com';

        if (User::where('email', $adminEmail)->first()) {
            dump(__('validation.email', [
                'attribute' => $adminEmail,
            ]));
            return;
        }

        DB::beginTransaction();

        $user = new User();
        $user->name = 'admin';
        $user->password = bcrypt('password');
        $user->email = $adminEmail;
        $user->phone_number = '+777777777';
        $user->api_token = User::generateApiToken();
        $user->save();

        event(new Registered($user));

        $user->userRoles()->create([
            'role_id' => Role::getBySlug(Role::ADMIN_SLUG)->id,
        ]);

        DB::commit();
    }
}
