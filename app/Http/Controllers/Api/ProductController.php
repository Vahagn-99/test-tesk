<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\ProductCreateRequest;
use App\Jobs\ProductProcessJob;
use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use App\Models\User;
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
        $products = ProductResource::collection(Product::orderBy('id', 'desc')->paginate(10));
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

            $product = Product::create([
                'article' => $request->article,
                'name' => $request->name,
                'status' => $request->status,
                'data' =>  json_encode($request->data),
            ]);
            if (asset($product) && !empty($product)) {
                $send = config('products.email');
                $message = 'added a new product';
                ProductProcessJob::dispatch($send, $product, $message)->onQueue('product');
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
        $response = array();
        $product->update([
            'name' => $request->name,
            'status' => $request->status,
            'data' =>  json_encode($request->data),
        ]);
        $admin = User::admin()->get();
        if ($admin) {
            $product->article = $request->article;
        } else {
            $response = [
                'data' => null,
                'message' => 'no permision'
            ];
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
    public function destroy(Product $product)
    {
        $product->delete();
        return response('deleted', 204);
    }
}
