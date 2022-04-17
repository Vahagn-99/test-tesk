<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 1; $i < 10; $i++) {
            User::create([
                'name' => 'Vahagn-' . $i,
                'email' => 'vahagnExample_' . $i . '_@gmail.com',
                'password' => Hash::make('vahagn')
            ]);
        }

        $admin = User::create([
            'name' => 'admin',
            'email' => 'admin_admin@gmail.com',
            'password' => 'adminadmin'
        ]);
        $admin->assignRole('writer');
        $admin->givePermissionTo('edit articles');
    }
}
