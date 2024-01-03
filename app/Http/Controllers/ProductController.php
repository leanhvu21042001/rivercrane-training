<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        if ($request->ajax()) {
            $perPage = $request->get('perPage') ?? 10;
            $name = $request->get('name') ?? '';
            $status = $request->get('status') ?? '';
            $price_from = $request->get('price_from') ?? '';
            $price_to = $request->get('price_to') ?? '';

            $products = Product::where('is_delete', 0)
                ->orderByDesc('created_at');

            // Handle Filter, Search
            if (!empty($name)) {
                $products->where('name', 'LIKE', "%$name%");
            }
            if (isset($status) && $status !== '') {
                $products->where('is_sales', '=', $status);
            }

            if (isset($price_from) && $price_from !== '' && isset($price_to) && $price_to !== '') {
                $min_price = 0;
                $max_price = 0;

                if ($price_from === $price_to) {
                    $min_price = 0;
                    $max_price = $price_to;
                } elseif ($price_from > $price_to) {
                    $min_price = $price_to;
                    $max_price = $price_from;
                } elseif ($price_from < $price_to) {
                    $min_price = $price_from;
                    $max_price = $price_to;
                }

                if ($min_price !== 0 && $max_price !== 0) {
                    $products->whereBetween('price', [$min_price, $max_price]);
                }
            }

            $paginate = $products->paginate($perPage);

            $paginate->getCollection()->transform(function ($product) {

                // 0: Ngừng bán, 1: Đang bán, 2: Hết hàng
                $product->status_sale_text = [
                    "Ngừng bán",
                    "Đang bán",
                    "Hết hàng",
                ][$product->is_sales];

                return $product;
            });

            return response()->json([
                'paginate' => $paginate
            ]);
        }

        return view('admin.pages.products.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.pages.products.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreProductRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreProductRequest $request)
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
            'message' => 'Created product',
            'product' => $created
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateProductRequest  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateProductRequest $request, Product $product)
    {
        //
    }

    /**
     * Set is_delete = true from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        $deleted = Product::where('id', '=', $id)->update([
            'is_delete' => 1
        ]);

        return response()->json([
            'message' => "Deleted product",
            'product' => $deleted,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        //
    }
}
