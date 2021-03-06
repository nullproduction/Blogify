<?php namespace jorenvanhocht\Blogify\Seeds;

use Illuminate\Database\Seeder;
use jorenvanhocht\Blogify\Facades\Blogify;
use jorenvanhocht\Blogify\Models\Visibility;

class VisibilityTableSeeder extends Seeder {

    public function run()
    {
        Visibility::create([
            "hash"          => Blogify::makeUniqueHash('visibility', 'hash'),
            "name"          => "Public",
        ]);

        Visibility::create([
            "hash"          => Blogify::makeUniqueHash('visibility', 'hash'),
            "name"          => "Protected",
        ]);

        Visibility::create([
            "hash"          => Blogify::makeUniqueHash('visibility', 'hash'),
            "name"          => "Private",
        ]);
    }

}