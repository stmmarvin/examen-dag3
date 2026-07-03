<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Categorie;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::query();
        
        // Filter op categorie indien geselecteerd
        if ($request->filled('CategorieId')) {
            $query->where('CategorieId', $request->CategorieId);
        }
        
        $producten = $query->orderBy('Naam')->paginate(15);
        $categorieen = Categorie::orderBy('Naam')->get();
        
        return view('producten.index', compact('producten', 'categorieen'));
    }

    public function create()
    {
        $categorieen = Categorie::orderBy('Naam')->get();
        return view('producten.create', compact('categorieen'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'CategorieId' => 'nullable|exists:Categorie,Id',
            'Naam' => 'required|string|max:255',
            'Omschrijving' => 'nullable|string',
            'Merk' => 'nullable|string|max:255',
            'EANcode' => 'nullable|string|max:50',
            'Houdbaarheidsdatum' => 'nullable|date',
            'InkoopPrijs' => 'nullable|numeric|min:0',
            'VerkoopPrijs' => 'nullable|numeric|min:0',
        ]);

        Product::create($validated);

        return redirect()->route('producten.index')->with('success', 'Product succesvol aangemaakt!');
    }

    public function show(Product $product)
    {
        return view('producten.show', compact('product'));
    }

    public function edit(Product $product)
    {
        $categorieen = Categorie::orderBy('Naam')->get();
        return view('producten.edit', compact('product', 'categorieen'));
    }

    public function update(Request $request, Product $product)
    {
        // Validate the input - only nieuwe_houdbaarheidsdatum
        $validated = $request->validate([
            'nieuwe_houdbaarheidsdatum' => 'required|date',
        ]);

        // Validate that nieuwe_houdbaarheidsdatum is max 7 days later than current houdbaarheidsdatum
        if ($product->Houdbaarheidsdatum) {
            $currentDate = $product->Houdbaarheidsdatum;
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
        $product->Houdbaarheidsdatum = $request->nieuwe_houdbaarheidsdatum;
        $product->DatumGewijzigd = now();
        $product->save();

        return redirect()->route('producten.show', $product->Id)->with('success', 'Houdbaarheidsdatum bijgewerkt');
    }

    public function destroy(Product $product)
    {
        $product->delete();

        return redirect()->route('producten.index')->with('success', 'Product succesvol verwijderd!');
    }
}
