<?php

use App\Http\Controllers\DataController;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class DataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create('id_ID');
        $districts = DB::table('districts')->pluck('id');

        for($i = 1; $i <= 40000; $i++){
            $gender = $faker->randomElement(['male', 'female']);
            $name = $faker->name($gender);
            $birth_date = $faker->date('Y-m-d', '-17 years');
            $district_id = $faker->randomElement($districts);
            $nik = DataController::generate_nik($district_id, $birth_date, $gender);

            DB::table('data')->insert([
              'nik'         => $nik,
              'name'        => $name,
              'gender'      => $gender,
              'birth_city'  => $faker->city(),
              'birth_date'  => $birth_date,
              'district_id' => $district_id,
              'address'     => $faker->streetAddress(),
              'photo'       => $faker->imageUrl(),
            ]);
        }
    }
}
