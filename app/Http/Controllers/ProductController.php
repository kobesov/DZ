<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function add_product(Request $new_prod){
        $validate = Validator::make($new_prod->all(),
            [
                "prod_name" => 'required',
                "quantity" => 'required',
                "price" => 'required',
            ]);
                if($validate->fails())
        {
            return response()->json(
                [
                    "message"=>$validate->errors(),
                ]
            );
        }
        Product::create($new_prod->all());
        return response()->json("product add");
    }

    public function renewal_prod(Request$renewal){
        $validator=Validator::make($renewal->all(),[
            "prod_name"=>"required",
        ]);

        $product=Product::where("prod_name",$renewal->prod_name)->first();

        if($product){
            $new_quantity=Validator::make($renewal->all(),[
                "quantity"=>"required",
            ]);
            $product->quantity=$new_quantity->quantity;
            $product->save();
            return response()->json(
            [
            "quantity" => $product->quantity,
            ]
            );
        }
        return response()->json("Товара не существует");
    }

     public function delete_prod(Request$delete){
        $validator=Validator::make($delete->all(),[
            "prod_name"=>"required",
        ]);

        $product=Product::where("prod_name",$delete->prod_name)->first();

		if($product){
			$product -> delete();
			$product -> save();
		}
		return response()->json("Товара не существует");
	}
}