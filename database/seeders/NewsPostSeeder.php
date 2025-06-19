<?php

namespace Database\Seeders;

use App\Models\NewsPost;
use Illuminate\Database\Seeder;

class NewsPostSeeder extends Seeder
{
    public function run()
    {
        $post = [
            'title' => 'Door de Corona crisis is De Gouden Draak op het moment slechts beperkt open.',
            'content' => 'Het restaurant-gedeelte is gesloten. U kan uw favoriete gerechten nog wel afhalen.',
            'created_at' => now(),
            'updated_at' => now(),
        ];
        NewsPost::insert($post);
    }
}
