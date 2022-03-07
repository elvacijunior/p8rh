<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::all();

        $response = [
            'success' => true,
            'message' => 'Produtos recuperados com sucesso.',
            'products' => $products,
        ];
        return response()->json($response, 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $product_json = file_get_contents($request->file('fileProduct'));
        $decoded_json = json_decode($product_json);
        
        $is_array = is_array($decoded_json);
        $items = [];

        if($is_array == true) {
            foreach($decoded_json as $item) {
                $product = Product::create([
                    'title' => $item->title,
                    'type' => $item->type,
                    'description' => $item->description,
                    'price' => $item->price,
                    'rating' => $item->rating,
                ]);
                array_push($items, $product);
            }
            $response = [
                'success' => true,
                'message' => 'Produtos criados com sucesso.',
                'products' => $items
            ];
        } else {
            $product = Product::create([
                'title' => $decoded_json->title,
                'type' => $decoded_json->type,
                'description' => $decoded_json->description,
                'price' => $decoded_json->price,
                'rating' => $decoded_json->rating,
            ]);

            $response = [
                'success' => true,
                'message' => 'Produto criado com sucesso.',
                'product' => $product
            ];
        }
        return response()->json($response, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product = Product::find($id);

        if (is_null($product)) {
            $response = [
                'success' => false,
                'message' => 'Produto não encontrado.',
            ];
            return response()->json($response, 404);
        }

        $response = [
            'success' => true,
            'message' => 'Produto recuperado com sucesso.',
        ];
        return response()->json($response, 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        Product::where('id', $id)->update($request->all());

        $response = [
            'success' => true,
            'message' => 'Produto atualizado com sucesso.',
        ];
        return response()->json($response, 200);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Product::where('id', $id)->delete();

        $response = [
            'success' => true,
            'message' => 'Produto deletado com sucesso.',
        ];
        return response()->json($response, 200);
    }
}
