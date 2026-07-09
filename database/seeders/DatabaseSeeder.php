<?php

namespace Database\Seeders;

use App\Models\Annonce;
use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

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

        $annonceNames = collect([
            'Canape confortable',
            'Velo urbain',
            'Table basse',
            'Ordinateur portable',
            'Chaise design',
            'Console de jeux',
            'Lampe vintage',
            'Bureau compact',
            'Sac de voyage',
            'Appareil photo',
        ]);

        $users = collect(range(1, 50))->map(fn (int $index): User => User::firstOrCreate(
            ['email' => "user{$index}@example.com"],
            [
                'name' => "Utilisateur {$index}",
                'password' => Hash::make('password'),
            ],
        ));

        $users->each(function (User $seller, int $sellerIndex) use ($users, $categories, $annonceNames): void {
            $annoncesCount = ($sellerIndex % 5) + 1;
            $soldAnnoncesIndexes = collect(range(0, $annoncesCount - 1))
                ->take(min($sellerIndex % 4, $annoncesCount));

            for ($index = 0; $index < $annoncesCount; $index++) {
                $isSold = $soldAnnoncesIndexes->contains($index);
                $buyer = $isSold
                    ? $users->where('id', '!=', $seller->id)->values()->get(($sellerIndex + $index) % 49)
                    : null;

                $annonce = Annonce::create([
                    'seller_id' => $seller->id,
                    'buyer_id' => $buyer?->id,
                    'category_id' => $categories->get(($sellerIndex + $index) % $categories->count())->id,
                    'name' => $annonceNames->get(($sellerIndex + $index) % $annonceNames->count()).' #'.($sellerIndex + 1).'-'.($index + 1),
                    'price' => 10 + (($sellerIndex + 1) * ($index + 2) * 3),
                    'description' => 'Annonce de demonstration generee automatiquement pour presenter les fonctionnalites de la marketplace.',
                    'status' => $isSold,
                ]);

                foreach (range(1, (($sellerIndex + $index) % 5) + 1) as $imageIndex) {
                    $annonce->images()->create([
                        'url' => "https://picsum.photos/seed/annonce-{$annonce->id}-{$imageIndex}/800/600",
                    ]);
                }
            }
        });
    }
}
