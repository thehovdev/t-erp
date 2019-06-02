<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Auth;
use App\Product;
use App\User;

class Journal extends Model
{


    public function receiverProductExists() {
        $action = json_decode($this->action);
        $product = new Product;
        $product = $product->find($action->receiver_product_id);

        if(!is_null($product)) {

            if(!is_null($product->serial)) {
                $productSnumbers = json_decode($product->serial, true);
                $productSnumbersCount = count($productSnumbers);

                if($product->count - $productSnumbersCount != $action->count) {
                    return false;
                }
            }

            return true;
        }

        return false;
    }

    public function receive($arg) {
        $action = json_decode($this->action);

        switch ($arg) {
            case 'user':
                $receive = User::find($action->receiver_id, ['name', 'email']);
                break;
            case 'storage':
                $receive = Storage::find($action->receiver_storage_id);
                break;    
            case 'product':
                $receive = Product::find($action->product_id);
                if(is_null($receive)) {
                    $receive = $action;
                }
                break;    
            case 'serials':
                $receive = null;
                if(!is_null($action->serial)) {
                    $serial = array_combine(range(1, count((array)$action->serial)), (array)$action->serial);
                    $receive = json_encode($serial);
                }
                break;     
            case 'count':
                $receive = $action->count;
                if(is_null($receive)) {
                    $receive = count((array)$action->serial);
                } 
                break;
            default:
                # code...
                break;
        }

        return $receive;
    }

    public function insert($request) {
        $action = $request->except(['_token', '_method']);

        $this->user_id = Auth::id();
        $this->receiver_id = $request->receiver_id;
        $this->action = json_encode($action);
        $this->save();

        return true;
    }
}
