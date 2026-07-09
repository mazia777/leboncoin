<?php

use App\Http\Controllers\ProfileController;
use App\Models\Annonce;
use App\Models\Category;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

Route::get('/', function (Request $request) {
    $search = trim((string) $request->query('q', ''));
    $categoryId = $request->query('category_id');

    $categories = Category::query()
        ->orderBy('name')
        ->get();

    $annonces = Annonce::query()
        ->with(['category', 'images', 'seller'])
        ->when($categoryId, fn (Builder $query): Builder => $query->where('category_id', $categoryId))
        ->when($search !== '', function (Builder $query) use ($search): Builder {
            return $query->where(function (Builder $query) use ($search): void {
                $query
                    ->where('name', 'like', "%{$search}%")
                    ->orWhereHas('category', fn (Builder $query): Builder => $query->where('name', 'like', "%{$search}%"));
            });
        })
        ->latest()
        ->take(25)
        ->get();

    return view('welcome', [
        'annonces' => $annonces,
        'categories' => $categories,
        'categoryId' => $categoryId,
        'search' => $search,
    ]);
});

Route::get('/annonces/create', function () {
    return view('annonces.create', [
        'annonce' => null,
        'categories' => Category::query()->orderBy('name')->get(),
    ]);
})->middleware('auth')->name('annonces.create');

Route::post('/annonces', function (Request $request) {
    $validated = $request->validate([
        'name' => ['required', 'string', 'max:255'],
        'category_id' => ['required', 'exists:categories,id'],
        'price' => ['required', 'numeric', 'min:0', 'max:99999999.99'],
        'description' => ['required', 'string', 'max:5000'],
        'images' => ['required', 'array', 'min:1', 'max:5'],
        'images.*' => ['image', 'max:1536'],
    ]);

    $annonce = Annonce::create([
        'seller_id' => $request->user()->id,
        'buyer_id' => null,
        'category_id' => $validated['category_id'],
        'name' => $validated['name'],
        'price' => $validated['price'],
        'description' => $validated['description'],
        'status' => Annonce::STATUS_AVAILABLE,
    ]);

    foreach ($request->file('images', []) as $image) {
        $path = $image->store('annonces', 'public');

        $annonce->images()->create([
            'url' => "/storage/{$path}",
        ]);
    }

    return redirect()->route('annonces.show', $annonce);
})->middleware('auth')->name('annonces.store');

Route::get('/annonces/{annonce}/edit', function (Annonce $annonce, Request $request) {
    abort_unless($annonce->seller_id === $request->user()->id, 403);

    $annonce->load(['images']);

    return view('annonces.create', [
        'annonce' => $annonce,
        'categories' => Category::query()->orderBy('name')->get(),
    ]);
})->middleware('auth')->name('annonces.edit');

Route::patch('/annonces/{annonce}', function (Annonce $annonce, Request $request) {
    abort_unless($annonce->seller_id === $request->user()->id, 403);

    $validated = $request->validate([
        'name' => ['required', 'string', 'max:255'],
        'category_id' => ['required', 'exists:categories,id'],
        'price' => ['required', 'numeric', 'min:0', 'max:99999999.99'],
        'description' => ['required', 'string', 'max:5000'],
        'images' => ['nullable', 'array', 'max:5'],
        'images.*' => ['image', 'max:1536'],
    ]);

    $annonce->update([
        'category_id' => $validated['category_id'],
        'name' => $validated['name'],
        'price' => $validated['price'],
        'description' => $validated['description'],
        'status' => $request->boolean('status'),
    ]);

    $availableImageSlots = max(0, 5 - $annonce->images()->count());

    foreach (array_slice($request->file('images', []), 0, $availableImageSlots) as $image) {
        $path = $image->store('annonces', 'public');

        $annonce->images()->create([
            'url' => "/storage/{$path}",
        ]);
    }

    return redirect()->route('annonces.show', $annonce);
})->middleware('auth')->name('annonces.update');

Route::delete('/annonces/{annonce}', function (Annonce $annonce, Request $request) {
    abort_unless($annonce->seller_id === $request->user()->id, 403);

    $annonce->load('images');

    foreach ($annonce->images as $image) {
        $url = $image->getRawOriginal('url');
        $path = is_string($url) ? parse_url($url, PHP_URL_PATH) : null;

        if (is_string($path) && str_starts_with($path, '/storage/')) {
            Storage::disk('public')->delete(substr($path, strlen('/storage/')));
        }
    }

    $annonce->delete();

    return redirect()->route('dashboard');
})->middleware('auth')->name('annonces.destroy');

Route::post('/annonces/{annonce}/buy', function (Annonce $annonce, Request $request) {
    abort_if($annonce->seller_id === $request->user()->id, 403);

    if ($annonce->status === Annonce::STATUS_SOLD) {
        return redirect()
            ->route('annonces.show', $annonce)
            ->with('error', 'Cette annonce est deja vendue.');
    }

    $annonce->update([
        'buyer_id' => $request->user()->id,
        'status' => Annonce::STATUS_SOLD,
    ]);

    return redirect()
        ->route('annonces.show', $annonce)
        ->with('success', "Achat confirme. L'annonce est maintenant marquee comme vendue.");
})->middleware('auth')->name('annonces.buy');

Route::get('/annonces/{annonce}', function (Annonce $annonce, Request $request) {
    $annonce->load(['category', 'images', 'seller']);

    return view('annonces.show', [
        'annonce' => $annonce,
        'categories' => Category::query()->orderBy('name')->get(),
        'categoryId' => $request->query('category_id'),
        'search' => trim((string) $request->query('q', '')),
    ]);
})->name('annonces.show');

Route::get('/dashboard', function (Request $request) {
    $user = $request->user();

    $annonces = $user->annoncesForSale()
        ->with(['category', 'images'])
        ->orderBy('status')
        ->latest()
        ->get();

    return view('dashboard', [
        'annonces' => $annonces,
        'soldCount' => $annonces->where('status', Annonce::STATUS_SOLD)->count(),
        'totalSales' => $annonces
            ->where('status', Annonce::STATUS_SOLD)
            ->sum(fn (Annonce $annonce): float => (float) $annonce->price),
        'user' => $user,
    ]);
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
