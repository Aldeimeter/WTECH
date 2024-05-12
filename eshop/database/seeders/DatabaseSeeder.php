<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Genre;
use App\Models\User;
use App\Models\Book;
use Illuminate\Support\Str;
class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
           'email' => 'admin@admin.com',
           'password' => bcrypt('secretpass'),
           'is_admin' => true,
                ]);
        $genres = [
            'Crime','Fantasy','Horror','Non-Fiction','Fiction'
        ];

        foreach ($genres as $genre) {
            Genre::create(['name'=> $genre, 'slug'=>Str::slug($genre,'-')]);
        }

        $fictionGenre = Genre::where('slug','fiction')->firstOrFail();

        Book::factory(5)->create()->each(function ($book) use ($fictionGenre){
            $book->genres()->attach($fictionGenre);
        });
    }
}
