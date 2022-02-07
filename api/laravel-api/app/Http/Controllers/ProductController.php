<?php

namespace App\Http\Controllers;

use App\Models\Products;
use Illuminate\Http\Request;
use App\Exceptions\Handler;
use Carbon\Carbon;

class ProductController extends Controller
{
    public function getAllProducts()
    {
        try{
            $products = Products::paginate();
            if(count($products)>0){
                return response($products,200);
            }else{
                return response('Table products is empty',204);
            }
        }catch(Exception $e){
            return response ($e,500);
        }
       
    }

    public function getProductForId($id){
        try{
            $product = Products::where('product_id',$id)->first();
            if(empty($product)){
                return response('Product not found',204);
            }else{
                return response($product,200);
            }
        }catch(Exception $e){
            return response($e,500);
        }
    }

    public function searchProductForName(Request $request){
        try {
            $input = $request->all();
            if(empty($input)){
                return response('Not data entering',400);
            }else{
                $product = Products::where('name','LIKE','%'.$input['name'].'%')->first();
                if(empty($product)){
                    return response('Product not found',204);
                }else{
                    return response($product,200);
                }
            }

            
        } catch (Exception $e) {
            return response($e->getMessage(),500);
        }
    }

    public function insertProduct(Request $request){
        try{
            $input = $request->all();
            if(empty($input)){
                throw new Exception('No data entered');
            }

            $newProduct = new Products;
            $newProduct->name = $input['name'];
            $newProduct->description = $input['description'];
            $newProduct->image = $input['image'];
            $newProduct->brand = $input['brand'];
            $newProduct->price = $input['price'];
            $newProduct->price_sale = $input['price_sale'];
            $newProduct->category = $input['category'];
            $newProduct->stock = $input['stock'];
            $newProduct->creation_date = Carbon::now();

            $result = $newProduct->save();
            
            if($result){
                return response($newProduct,200);
            }else{
                return response('Error inserting record',500);
            }

        } catch(Exception $e){  
            return response($e,500);
        }
    }

    public function updateProduct(Request $request, int $id){
        try{
            $input = $request->all();
            if(empty($input) || empty($id)){
                return response('No data entered',400);
            }else{
                $product = Products::find($id);
                if(empty($product)){
                    return response('Not content',204);
                }else{
                    $product->name = $input['name'];
                    $product->description = $input['description'];
                    $product->image = $input['image'];
                    $product->brand = $input['brand'];
                    $product->price = $input['price'];
                    $product->price_sale = $input['price_sale'];
                    $product->category = $input['category'];
                    $product->stock = $input['stock'];
                    $product->updated_date = Carbon::now();
    
                    $result=$product->save();
    
                    if($result){
                        return response($product,200);
                    }else{
                        throw new Exception('Error inserting record');
                    }
                }
            }

        } catch(Exception $e){  
            return response($e,500);
        }
    }

    public function deleteProduct($id){
        try{
            if(empty($id)){
               return response('Not data entered',400);
            }else{
                $product = Products::find($id);
                if(empty($product)){
                    return response('Product not found',204);
                }else{
                    $result = $product->delete();
                    if($result){
                        return response('Deleted product',200);
                    }else{
                        return response('Error deleting product',500);
                    }
                }
            }
        } catch(Exception $e){
            return response($e,500);
        }
    }
}
