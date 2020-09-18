<?php

namespace Database\Seeders;

use App\Models\Feature;
use App\Models\Type;
use Illuminate\Database\Seeder;

class FeatureTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = \Faker\Factory::create();
        $features = collect(['Bath', 'Lounge', 'Close to town', 'Transport access', 'Beach', 'Rivers', 'Islands']
                            + $faker->words(25,false));
        
        $features->map(function($feature){
            Feature::create(['name'=>$feature]);
        });

        $types = collect(['Land', 'Building', 'Apartment']);

        $types->map(function($type){
            Type::create(['name'=>$type]);
        });
        
        Type::all()->map(function($type){
            $count = rand(1,15);
            for($i=0; $i<=$count; $i++)
            {
                $feature = Feature::find(rand(1,25));
                $type->features()->attach($feature);

            }
        });
    }

}
