<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\SaveProductRequest;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Create the controller instance.
     */
    public function __construct()
    {
        $this->authorizeResource(Product::class, 'product');
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $perPage = $request->get('per_page') ?? 10;
        $name = $request->get('name');
        $status = $request->get('status');
        $minPrice = $request->get('price_from');
        $maxPrice = $request->get('price_to');

        $products = Product::notDelete()
            ->orderByDesc('created_at')
            ->byName($name)
            ->byStatus($status)
            ->byMinPrice($minPrice)
            ->byMaxPrice($maxPrice);

        $productMaxPrice = Product::notDelete()->orderBy('price', 'DESC')->first();
        $productMinPrice = Product::notDelete()->orderBy('price', 'ASC')->first();

        $paginate = $products->paginate($perPage);

        return response()->json([
            'status' => true,
            'paginate' => $paginate,
            'minPrice' => $productMinPrice->price,
            'maxPrice' => $productMaxPrice->price,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreProductRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SaveProductRequest $request)
    {
        $fileUpload = $request->file('fileUpload');

        // store file to storage if $fileUpload exists
        if ($fileUpload) {
            $fileNameHashed = $fileUpload->hashName();
            $path = Storage::putFileAs('uploads/product', $fileUpload, $fileNameHashed);
            $request->merge(['image' =>  $path]);
        }

        $name = $request->input('name');
        $description = $request->input('description') ?? ''; // data should be an empty string instead of NULL
        $price = $request->input('price');
        $is_sales = $request->input('is_sales');
        $image = $request->input('image');

        $created = Product::create([
            'name' => $name,
            'description' => $description,
            'price' => $price,
            'is_sales' => $is_sales,
            'image' => $image,
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Created product',
            'product' => $created
        ], 201);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function getSingleData($id)
    {
        // $this->authorize('delete', Product::class);
        $product = Product::where('id', '=', $id)->first();

        return response()->json([
            'status' => true,
            'message' => 'Get product successfully',
            'product' => $product
        ], 201);
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateProductRequest  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(SaveProductRequest $request, Product $product)
    {
        $fileUpload = $request->file('fileUpload');

        // store file to storage if $fileUpload exists
        if ($fileUpload) {
            $fileNameHashed = $fileUpload->hashName();
            $path = Storage::putFileAs('uploads/product', $fileUpload, $fileNameHashed);
            $request->merge(['image' =>  $path]);
        }



        $name = $request->input('name') ?? $product->name;
        // description: data should be an empty string instead of NULL
        $description = $request->input('description') ?? $product->description;
        $price = $request->input('price') ?? $product->price;
        $is_sales = $request->input('is_sales') ?? $product->is_sales;
        $image = $request->input('image') ?? $product->image;

        if (!$request->input('imageName')) {
            $image = '';
        }

        $updated = Product::where('id', '=', $product->id)->update([
            'name' => $name,
            'description' => $description,
            'price' => $price,
            'is_sales' => $is_sales,
            'image' => $image,
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Updated product',
            'product' => $updated
        ], 200);
    }

    /**
     * Set is_delete = true from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        $this->authorize('delete', Product::class);

        $deleted = Product::where('id', '=', $id)->update([
            'is_delete' => 1
        ]);

        return response()->json([
            'status' => true,
            'message' => "Deleted product",
            'product' => $deleted,
        ]);
    }
}
