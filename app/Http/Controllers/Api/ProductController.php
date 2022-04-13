<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\ProductCreateRequest;
use App\Jobs\ProductProcessJob;
use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = ProductResource::collection(Product::get());
        $response = [
            'data' => $products,
            'message' => 'success 1',
        ];
        return response()->json($response, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductCreateRequest $request)
    {
        if ($request->ajax()) {
            $product = Product::create($request->validate());
            if (asset($product) && !empty($product)) {
                $send = config('products.email');
                $message = 'added a new product';
                ProductProcessJob::dispatch($send, $product, $message);
                $response = [
                    'data' => new ProductResource($product),
                    'message' => 'success 1'
                ];
                return response()->json($response, 201);
            }
        }
        return false;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        $response = [
            'data' => new ProductResource($product),
            'message' => 'success 1'
        ];
        return response()->json($response, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ProductCreateRequest $request, Product $product)
    {
        $product->update($request->validate());
        if (Auth::user()->hasRole('admin')) {
            $product->article = $request->article;
        }
        $response = [
            'data' => new ProductResource($product),
            'message' => 'success 1'
        ];
        return response()->json($response, 202);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(ProductCreateRequest $product)
    {
        $product->delete();
        return response(MYSQLI_NO_DATA, 204);
    }
}
