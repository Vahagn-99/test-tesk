<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductCreateRequest;
use App\Jobs\ProductProcessJob;
use App\Models\Product;
use Illuminate\Http\Request;


class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('project_create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductCreateRequest $request)
    {
        $product = Product::create($request->validate());
        if (asset($product) && !empty($product)) {
            $message = 'added a new product';
            $send = config('products.email');
            ProductProcessJob::dispatch($send, $product, $message);
        }
        $response = [
            'data' => $product,
            'message' => 'success'
        ];
        return response($response, 201)->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(ProductCreateRequest $product)
    {
        return view('project_detail', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(ProductCreateRequest $product)
    {
        return view('project_edit', compact('product'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(ProductCreateRequest $request, Product $product)
    {
        $product->update($request->validate());
        $response = [
            'data' => $product,
            'message' => 'success'
        ];
        return response($response, 202)->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(ProductCreateRequest $product)
    {
        $product->delete();
        return response(204)->back()->with('success', 'Product deleted');
    }
}
