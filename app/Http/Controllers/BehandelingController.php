<?php

namespace App\Http\Controllers;

use App\Models\Behandeling;
use App\Models\Product;
use App\Models\Voorraad;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BehandelingController extends Controller
{
    /**
     * Toon overzicht van alle behandelingen
     * Filtert behandelingen op basis van geselecteerde categorie
     */
    public function index(Request $request)
    {
        $query = Behandeling::query();
        $filter = $request->input('filter', 'alle');

        // Filter toepassen als specifieke categorie geselecteerd
        if ($filter != 'alle') {
            $query->where('naam', $filter);
        }

        // Pagineer resultaten en behoud filter parameter
        $behandelingen = $query->paginate(5)->appends(['filter' => $filter]);

        // Haal unieke behandeling namen op voor dropdown
        $behandelingNames = Behandeling::distinct()->pluck('naam');

        return view('behandelingen.index', compact('behandelingen', 'behandelingNames', 'filter'));
    }

    /**
     * Toon producten voor een specifieke behandeling
     * Haalt alle producten op via pivot tabel
     */
    public function producten($id)
    {
        $behandeling = Behandeling::findOrFail($id);
        
        // Haal producten op met benodigd aantal uit pivot tabel
        $producten = DB::table('producten')
            ->join('behandeling_product', 'producten.id', '=', 'behandeling_product.product_id')
            ->where('behandeling_product.behandeling_id', $id)
            ->select('producten.*', 'behandeling_product.aantal as aantal_benodigd')
            ->get();

        return view('behandelingen.producten', compact('behandeling', 'producten'));
    }

    /**
     * Display product details
     */
    public function productDetail($behandelingId, $productId)
    {
        $behandeling = Behandeling::findOrFail($behandelingId);
        $product = Product::findOrFail($productId);

        // Get the required quantity from pivot table
        $pivotData = DB::table('behandeling_product')
            ->where('behandeling_id', $behandelingId)
            ->where('product_id', $productId)
            ->first();

        return view('behandelingen.product-detail', compact('behandeling', 'product', 'pivotData'));
    }

    /**
     * Show the form for editing a product
     */
    public function editProduct($behandelingId, $productId)
    {
        $behandeling = Behandeling::findOrFail($behandelingId);
        $product = Product::findOrFail($productId);

        return view('behandelingen.product-edit', compact('behandeling', 'product'));
    }

    /**
     * Werk de productprijs bij
     * Valideert minimaal 30% marge boven inkoopprijs
     */
    public function updateProduct(Request $request, $behandelingId, $productId)
    {
        $product = Product::findOrFail($productId);

        // Bereken minimale prijs (inkoopprijs is 50% van huidige verkoopprijs)
        $purchasePrice = $product->prijs * 0.5;
        $minPrice = $purchasePrice * 1.30;
        $maxPrice = 9999.99; // Database limiet voor DECIMAL(10,2)

        // Valideer dat nieuwe prijs minimale marge haalt
        $request->validate([
            'verkoopprijs' => [
                'required',
                'numeric',
                'min:0',
                'max:' . $maxPrice,
                function ($attribute, $value, $fail) use ($minPrice) {
                    if ($value < $minPrice) {
                        $fail('Verkoopprijs moet minimaal 30 procent boven de inkoopprijs liggen. Minimale prijs: EUR ' . number_format($minPrice, 2));
                    }
                },
            ],
        ], [
            'verkoopprijs.required' => 'Verkoopprijs is verplicht.',
            'verkoopprijs.numeric' => 'Verkoopprijs moet een geldig bedrag zijn.',
            'verkoopprijs.min' => 'Verkoopprijs moet minimaal 0 zijn.',
            'verkoopprijs.max' => 'Verkoopprijs mag niet hoger zijn dan EUR ' . number_format($maxPrice, 2) . '. Dit is onrealistisch voor een salonproduct.',
        ]);

        // Werk productprijs bij
        $product->prijs = $request->verkoopprijs;
        $product->save();

        return redirect()->route('behandelingen.product.detail', [$behandelingId, $productId])
            ->with('success', 'Productprijs bijgewerkt');
    }
}
