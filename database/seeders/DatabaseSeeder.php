<?php

namespace Database\Seeders;

use App\Models\Annonce;
use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $categories = collect([
            'Immobilier',
            'Vehicules',
            'Mode',
            'Maison',
            'Multimedia',
            'Loisirs',
            'Materiel professionnel',
            'Emploi',
            'Services',
            'Vacances',
            'Jardinage',
            'Bricolage',
            'Electromenager',
            'Informatique',
            'Telephonie',
            'Sports',
            'Jeux et jouets',
            'Livres',
            'Musique',
            'Animaux',
        ])->map(fn (string $name): Category => Category::firstOrCreate([
            'name' => $name,
        ]));

        $users = User::factory(50)->create();

        $users->each(function (User $seller) use ($users, $categories): void {
            $annoncesCount = fake()->numberBetween(1, 5);
            $soldAnnoncesIndexes = collect(range(0, $annoncesCount - 1))
                ->shuffle()
                ->take(fake()->numberBetween(0, min(3, $annoncesCount)));

            for ($index = 0; $index < $annoncesCount; $index++) {
                $isSold = $soldAnnoncesIndexes->contains($index);

                $annonce = Annonce::create([
                    'seller_id' => $seller->id,
                    'buyer_id' => $isSold ? $users->where('id', '!=', $seller->id)->random()->id : null,
                    'category_id' => $categories->random()->id,
                    'name' => fake()->sentence(3),
                    'price' => fake()->randomFloat(2, 5, 5000),
                    'description' => fake()->paragraphs(3, true),
                    'status' => $isSold,
                ]);

                foreach (range(1, fake()->numberBetween(1, 5)) as $imageIndex) {
                    $annonce->images()->create([
                        'url' => "https://picsum.photos/seed/annonce-{$annonce->id}-{$imageIndex}/800/600",
                    ]);
                }
            }
        });
    }
}
