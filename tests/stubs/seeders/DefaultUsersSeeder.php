<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;

class DefaultUsersSeeder extends Seeder
{
    protected $data = [
        ['name' => 'Admin User', 'role' => 'super_admin', 'email' => 'demo-admin@javaabu.com', 'password' => 'RandomPassword12345'],
        ['name' => 'Guest User', 'role' => 'guest', 'email' => 'demo-guest@javaabu.com', 'password' => 'RandomPassword12345'],
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach ($this->data as $user_data) {
            $user = User::whereEmail($user_data['email'])->first();
            if ($user) {
                $user->update(Arr::except($user_data, 'role'));
            } else {
                $user = new User(Arr::except($user_data, 'role'));
            }

            $user->status = \Javaabu\Auth\Enums\UserStatuses::APPROVED;
            $user->email = $user_data['email'];
            $user->password = $user_data['password'];
            $user->resetLoginAttempts();

            // save and verify
            $user->markEmailAsVerified();

            if (! empty($user_data['role'])) {
                $user->syncRoles($user_data['role']);
            }
        }
    }
}
