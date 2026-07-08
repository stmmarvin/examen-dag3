<?php

namespace App\Http\Controllers;

use App\Models\Behandeling;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BehandelingController extends Controller
{
    // Toont overzicht van alle behandelingen met filter optie.
    public function index(Request $request)
    {
        // Maak een query builder instance voor Behandeling model.
        $query = Behandeling::query();
        
        // Haal filter waarde uit request, standaard 'alle'.
        $filter = $request->input('filter', 'alle');

        // Pas filter toe als er een specifieke behandeling is geselecteerd.
        if ($filter != 'alle') {
            $query->where('naam', $filter);
        }

        // Pagineer de resultaten (3 per pagina) en behoud filter in URL.
        $behandelingen = $query->paginate(3)->appends(['filter' => $filter]);

        // Haal alle unieke behandeling namen op voor de dropdown.
        $behandelingNames = Behandeling::distinct()->pluck('naam');

        // Stuur data naar de view.
        return view('behandelingen.index', compact('behandelingen', 'behandelingNames', 'filter'));
    }

    // Toont alle producten die gebruikt worden bij een specifieke behandeling.
    public function producten($id)
    {
        // Haal behandeling op met eager loading van producten en hun voorraad.
        // Dit voorkomt N+1 query probleem.
        $behandeling = Behandeling::with(['producten.voorraad'])->findOrFail($id);
        
        // Haal de producten collectie op via de relatie.
        $producten = $behandeling->producten;

        // Stuur data naar de producten view.
        return view('behandelingen.producten', compact('behandeling', 'producten'));
    }

    // Toont details van een specifiek product binnen een behandeling.
    public function productDetail($behandelingId, $productId)
    {
        // Haal behandeling en product op, geef 404 als niet gevonden.
        $behandeling = Behandeling::findOrFail($behandelingId);
        $product = Product::findOrFail($productId);

        // Haal pivot data op (zoals aantal) uit de tussentabel.
        $pivotData = DB::table('behandeling_product')
            ->where('behandeling_id', $behandelingId)
            ->where('product_id', $productId)
            ->first();

        // Stuur data naar de detail view.
        return view('behandelingen.product-detail', compact('behandeling', 'product', 'pivotData'));
    }

    // Toont het formulier om productprijs te wijzigen.
    public function editProduct($behandelingId, $productId)
    {
        // Haal behandeling en product op voor het formulier.
        $behandeling = Behandeling::findOrFail($behandelingId);
        $product = Product::findOrFail($productId);

        // Stuur data naar de edit view.
        return view('behandelingen.product-edit', compact('behandeling', 'product'));
    }

    // Werkt de productprijs bij met validatie voor minimale marge.
    public function updateProduct(Request $request, $behandelingId, $productId)
    {
        // Haal het product op dat gewijzigd moet worden.
        $product = Product::findOrFail($productId);

        // Bereken minimale verkoopprijs (30% marge boven inkoopprijs).
        $minPrice = $product->inkoop_prijs * 1.30;
        
        // Stel maximale prijs in (EUR 130.00 is realistisch voor salonproducten).
        $maxPrice = 130.00;

        // Valideer de nieuwe verkoopprijs met custom closure voor marge check.
        $request->validate([
            'verkoopprijs' => [
                'required',
                'numeric',
                'min:0',
                'max:' . $maxPrice,
                // Custom validatie regel: check of prijs >= 30% boven inkoop.
                function ($attribute, $value, $fail) use ($minPrice) {
                    if ($value < $minPrice) {
                        $fail('Verkoopprijs moet minimaal 30 procent boven de inkoopprijs liggen. Minimale prijs: EUR ' . number_format($minPrice, 2));
                    }
                },
            ],
        ], [
            // Custom error messages voor betere gebruikerservaring.
            'verkoopprijs.required' => 'Verkoopprijs is verplicht.',
            'verkoopprijs.numeric' => 'Verkoopprijs moet een geldig bedrag zijn.',
            'verkoopprijs.min' => 'Verkoopprijs moet minimaal 0 zijn.',
            'verkoopprijs.max' => 'Verkoopprijs mag niet hoger zijn dan EUR ' . number_format($maxPrice, 2) . '. Dit is onrealistisch voor een salonproduct.',
        ]);

        // Update de verkoopprijs en wijzigingsdatum.
        $product->verkoop_prijs = $request->verkoopprijs;
        $product->datum_gewijzigd = now();
        $product->save();

        // Redirect terug naar detail pagina met success bericht.
        return redirect()->route('behandelingen.product.detail', [$behandelingId, $productId])
            ->with('success', 'Productprijs bijgewerkt');
    }
}
