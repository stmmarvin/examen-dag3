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
        if ($request->filled('categorie_id')) {
            $query->where('categorie_id', $request->categorie_id);
        }
        
        $producten = $query->orderBy('naam')->paginate(15)->withQueryString();
        $categorieen = Categorie::orderBy('naam')->get();
        
        return view('producten.index', compact('producten', 'categorieen'));
    }

    public function create()
    {
        $categorieen = Categorie::orderBy('naam')->get();
        return view('producten.create', compact('categorieen'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'categorie_id' => 'nullable|exists:categorie,id',
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

    public function show($id)
    {
        $product = Product::with(['categorie'])->findOrFail($id);
        return view('producten.show', compact('product'));
    }

    public function edit($id)
    {
        $product = Product::findOrFail($id);
        $categorieen = Categorie::orderBy('naam')->get();
        return view('producten.edit', compact('product', 'categorieen'));
    }

    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        
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
        $product->houdbaarheidsdatum = $request->nieuwe_houdbaarheidsdatum;
        $product->datum_gewijzigd = now();
        $product->save();

        return redirect()->route('producten.show', $product->id)->with('success', 'Houdbaarheidsdatum bijgewerkt');
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();

        return redirect()->route('producten.index')->with('success', 'Product succesvol verwijderd!');
    }
}
