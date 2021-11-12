<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $company = new Company();
        $company->name = 'Spot On Solutions';
        $company->logo = 'https://spotonsolutions.com/wp-content/uploads/2021/03/logo.png';
        $company->save();

        $company = new Company();
        $company->name = 'Get Found First';
        $company->logo = 'https://getfoundfirst.com/wp-content/uploads/2021/06/logo-1.png';
        $company->save();

        $company = new Company();
        $company->name = 'Perfect Point Marketing';
        $company->logo = 'https://perfectpointmarketing.com/wp-content/themes/ppm-n/img/logo.png';
        $company->save();

        $user = new User();
        $user->name = 'Get Found First';
        $user->email = 'wp@perfectpointmarketing.com';
        $user->email_verified_at = now();
        $user->password = Hash::make('QgYhfu&$dD00qfVCDte@');
        $user->remember_token = Str::random(10);
        $user->save();


        $this->call([
            UserSeeder::class
        ]);
    }
}
