<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Response;
use Inertia\Inertia;
use App\Models\Empties;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): Response
    {
        $products = Product::getProducts();

        return Inertia::render('Dashboard/products', ['products' => $products]);
    }

    /**
     * Show the form for creating a new resource.
     */

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $filepath = $request->image_url->store('products');
        //dd($filepath);
        Product::create([
            'name' => $request->name,
            'category' => $request->category,
            'image_url' => $filepath
        ]);

        return to_route('NewProduct');
    }

    /**
     * Display the specified resource.
     */
    public function newEmpties(): Response
    {
        return Inertia::render('Dashboard/newEmpty');
    }

    public function saveEmpties(Request $request): RedirectResponse
    {
        //dd($request->quantity);
        Empties::create([
            'brand' => $request->brand,
            'quantity' => $request->quantity
        ]);

        return to_route('newEmpties');
    }

    public function updateEmpties(Request $request, Empties $empties): RedirectResponse
    {

        $empties->update([
            'brand' => $request->brand,
            'quantity' => $request->quantity
        ]);

        return to_route('newEmpties');
    }

    public function empties(): Response
    {
        $empties = Empties::getCurrentEmpties();
               // dd($empties);
        return Inertia::render('Dashboard/stockEmpty', ['empties' => $empties]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product): Response
    {
        return Inertia::render('Dashboard/newProduct', ['edit' => true, 'product' => $product]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product): RedirectResponse
    {

        if ($request->hasFile('image_url')) {
            // unlink(public_path($product->image_url));
            $path = $request->image_url->store('products');
            $product->image_url = $path;

            //dd($path);
        }
        $product->name = $request->name;
        $product->category = $request->category;

        $res = $product->save();

        return to_route('products');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product): RedirectResponse
    {
        //
    }
}
