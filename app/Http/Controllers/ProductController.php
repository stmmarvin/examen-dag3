<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Categorie;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with(['categorie']);
        
        // Filter op categorie indien geselecteerd
        if ($request->filled('categorie')) {
            $query->where('categorie_id', $request->categorie);
        }
        
        $producten = $query->orderBy('naam')->paginate(15);
        
        return view('producten.index', compact('producten'));
    }

    public function create()
    {
        $categorieen = Categorie::orderBy('naam')->get();
        return view('producten.create', compact('categorieen'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'categorie_id' => 'nullable|exists:categorieen,id',
            'naam' => 'required|string|max:255',
            'omschrijving' => 'nullable|string',
            'merk' => 'nullable|string|max:255',
            'ean_code' => 'nullable|string|max:50',
            'houdbaarheidsdatum' => 'nullable|date',
            'inkoop_prijs' => 'nullable|numeric|min:0',
            'verkoop_prijs' => 'nullable|numeric|min:0',
        ]);

        Product::create($validated);

        return redirect()->route('producten.index')->with('success', 'Product succesvol aangemaakt!');
    }

    public function show(Product $product)
    {
        $product->load(['categorie']);
        return view('producten.show', compact('product'));
    }

    public function edit(Product $product)
    {
        $categorieen = Categorie::orderBy('naam')->get();
        return view('producten.edit', compact('product', 'categorieen'));
    }

    public function update(Request $request, Product $product)
    {
        // Validate the input - only nieuwe_houdbaarheidsdatum
        $validated = $request->validate([
            'nieuwe_houdbaarheidsdatum' => 'required|date',
        ]);

        // Validate that nieuwe_houdbaarheidsdatum is max 7 days later than current houdbaarheidsdatum
        if ($product->houdbaarheidsdatum) {
            $currentDate = $product->houdbaarheidsdatum;
            $newDate = \Carbon\Carbon::parse($request->nieuwe_houdbaarheidsdatum);
            $maxAllowedDate = $currentDate->copy()->addDays(7);

            if ($newDate->greaterThan($maxAllowedDate)) {
                return back()->withErrors([
                    'nieuwe_houdbaarheidsdatum' => 'De houdbaarheidsdatum is met meer dan 7 dagen verlengd.',
                    'general' => 'Gegevens niet bijgewerkt'
                ])->withInput();
            }
        }

        // Update only houdbaarheidsdatum
        $product->update([
            'houdbaarheidsdatum' => $request->nieuwe_houdbaarheidsdatum,
        ]);

        return redirect()->route('producten.show', $product->id)->with('success', 'Houdbaarheidsdatum bijgewerkt');
    }

    public function destroy(Product $product)
    {
        $product->delete();

        return redirect()->route('producten.index')->with('success', 'Product succesvol verwijderd!');
    }
}
