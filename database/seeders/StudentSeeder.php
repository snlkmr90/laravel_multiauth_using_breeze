<?php

namespace Database\Seeders;

use App\Models\Students;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
class StudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $students = [];
        $faker = Faker::create();
        for ($i=0; $i <1000 ; $i++) {
            $genderArr = ['male','female'];
            $randGenderKey = array_rand($genderArr,1);
            $gender =  $genderArr[$randGenderKey];
            $students[] = [
                'name'=>$faker->name,
                'age'=>rand(20,70),
                'gender'=>$gender
            ];
        }
        
        Students::insert($students);
    }
}
