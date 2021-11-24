<?php
   
namespace App\Http\Controllers\API;
   
use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use Validator;
use App\Models\Order;
use App\Models\Product;

class OrderController extends BaseController
{
    public function store(Request $request)
    {
        $input = $request->only('product_id', 'quantity');
        $validator = Validator::make($input, [
            'product_id' => 'required|numeric',
            'quantity' => 'required|numeric',
        ]);

        if($validator->fails()){
            return $this->sendError($validator->errors());       
        }

        $product = Product::find($request->product_id);

        if ($product) {
            if($product->stock < $request->quantity) {
                return $this->sendError('Failed to order this product due to unavailabitility of the stock.', [], 400);
            }

            $product->decrement('stock', $request->quantity);
    
            $user = auth()->user();
            $input['order_by'] = $user->id;
            $order = Order::create($input);

            if($order) {
                return $this->sendResponse('You have successfully ordered this product.', [], 201);
            }
        }
        
        return $this->sendError('Failed to find product.', [], 404);

    }

}