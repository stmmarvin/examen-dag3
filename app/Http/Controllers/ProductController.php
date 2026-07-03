<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Categorie;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with(['categorie', 'voorraad']);
        
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
        $product->load(['categorie', 'voorraad']);
        return view('producten.show', compact('product'));
    }

    public function edit(Product $product)
    {
        $categorieen = Categorie::orderBy('naam')->get();
        return view('producten.edit', compact('product', 'categorieen'));
    }

    public function update(Request $request, Product $product)
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

        $product->update($validated);

        return redirect()->route('producten.index')->with('success', 'Product succesvol bijgewerkt!');
    }

    public function destroy(Product $product)
    {
        $product->delete();

        return redirect()->route('producten.index')->with('success', 'Product succesvol verwijderd!');
    }
}
