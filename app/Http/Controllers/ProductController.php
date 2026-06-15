<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return View
     */
    public function index(): View
    {
        $products = Product::visible()->latest()->paginate(10);

        return view('products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return View
     */
    public function create(): View
    {
        return view('products.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param ProductRequest $request
     * @return RedirectResponse
     */
    public function store(ProductRequest $request): RedirectResponse
    {
        DB::transaction(function () use ($request): void {
            $data = $request->validated();
            $quantity = $data['quantity'];
            unset($data['quantity']);

            if ($request->hasFile('image')) {
                $data['image'] = $request->file('image')->store('products', 'public');
            } else {
                unset($data['image']);
            }

            Product::createWithStock($data, $quantity);
        });

        return redirect()->route('products.index')
            ->with('status', __('Product created successfully.'));
    }

    /**
     * Display the specified resource.
     *
     * @param Product $product
     * @return View
     */
    public function show(Product $product): View
    {
        $stockMovements = $product->stockMovements()->oldest()->get();

        return view('products.show', compact('product', 'stockMovements'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Product $product
     * @return View
     */
    public function edit(Product $product): View
    {
        return view('products.edit', compact('product'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param ProductRequest $request
     * @param Product $product
     * @return RedirectResponse
     */
    public function update(ProductRequest $request, Product $product): RedirectResponse
    {
        DB::transaction(function () use ($request, $product): void {
            $data = $request->validated();
            $quantity = $data['quantity'];
            unset($data['quantity']);

            if ($request->hasFile('image')) {
                if ($product->image) {
                    Storage::disk('public')->delete($product->image);
                }
                $data['image'] = $request->file('image')->store('products', 'public');
            } else {
                unset($data['image']);
            }

            $product->update($data);
            $product->saveStockChange($quantity);
        });

        return redirect()->route('products.index')
            ->with('status', __('Product updated successfully.'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Product $product
     * @return RedirectResponse
     */
    public function destroy(Product $product): RedirectResponse
    {
        $product->update(['status' => Product::STATUS_DELETED]);

        return redirect()->route('products.index')
            ->with('status', __('Product deleted successfully.'));
    }
}
