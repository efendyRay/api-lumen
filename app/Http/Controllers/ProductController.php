<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'search' => 'string|string|max:200|min:2|regex:/^[a-zA-Z0-9]+$/',
            'skip' => 'numeric|max:10',
            'take' => 'numeric|max:10',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $q                = $request->search;
        $take             = $request->take;
        $skip             = $request->skip;
        
        if ($q || ($take && $skip)){
            $products = Product::when($q, function($query, $q) {
                $query->where('name', 'like', '%'.$q.'%')
                ->orWhere('code', 'like', '%'.$q.'%')
                ->orWhere('price', 'like', '%'.$q.'%');
            })->when($take, function($query, $take) {
                $query->take($take);
            })->when($skip, function($query, $skip) {
                $query->skip($skip-1);
            })->orderBy('created_at', 'ASC')->get();

            return $this->return_success("Success Menampilkan Semua Product", $products, Response::HTTP_OK);
        } else {
            $products = Product::orderBy('created_at', 'ASC')->get();

            return $this->return_success("Success Menampilkan Semua Product", $products, Response::HTTP_OK);
        }

    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name'          => 'required|string|min:2',
            'price'         => 'required|numeric',
        ]);
        try {

            $product               = new Product;
            $product->name         = $request->name;
            $product->code         = $request->code;
            $product->price        = $request->price;
            $product->status       = 'Ready';
            $product->save();

        } catch (\Exception $e) {
            
            return $this->return_badrequest("Gagal Simpan Product", $e->getMessage(), Response::HTTP_OK);
        }
        return $this->return_success("Success Simpan Product", null, Response::HTTP_OK);
    }

    public function detail($id)
    {
        $product = Product::findOrFail($id);

        return $this->return_success("Success Detail Product", $product, Response::HTTP_OK);
    }

    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $this->validate($request, [
            'name'          => 'required|string|min:2',
            'price'         => 'required|numeric',
        ]);
        try {

            $product->name         = $request->name;
            $product->price        = $request->price;
            $product->code         = $request->code;
            $product->update();

        } catch (\Exception $e) {
            return $this->return_badrequest("Gagal Update Product", $e->getMessage(), Response::HTTP_OK);
        }

        return $this->return_success("Success Update Product", null, Response::HTTP_OK);
    }

    public function destroy(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        $product->delete();

        return $this->return_success("Success Delete Product", null, Response::HTTP_OK);
    }
}
