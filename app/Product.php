<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;
use Auth;

class Product extends Model
{
    public function get($name) {
        return $this
            ->where('name', $name)
            ->where('user_id', Auth::id())
            ->first();
    }

    public function add($request) {
        // get product from system
        $product = $this->get($request->name);

        // if product does not exists in system then its new product
        if (is_null($product)) {
            $product = $this;
            $product->count = 0;
        }

        $product->user_id = Auth::id();
        $product->storage_id = $request->storage_id;
        $product->name = $request->name;
        $product->price = $request->price;
        $product->count = $product->count + $request->count;
        $product->save();

        return $product;
    }


    public function addWithSerials($request, $snumbers) {
        // get product from system
        $product = $this->get($request->name);

        // if product does not exists in system then its new product
        if (is_null($product)) {
            $product = $this;
            $product->count = 0;
            $serial = $snumbers;
        } else {
            $serial = json_decode($product->serial, true);
            $serial = array_merge($serial, $snumbers);
            $serial = array_combine(range(1, count($serial)), $serial);
        }

        $product->user_id = Auth::id();
        $product->storage_id = $request->storage_id;
        $product->name = $request->name;
        $product->price = $request->price;
        $product->count = $product->count + count($snumbers);
        $product->serial = json_encode($serial);
        $product->save();

        return $product;
    }


    public function sendFromUser($request) {

        $product = $this->find($request->product_id);

        if(!is_null($request->count)) {
            if(!is_null($product->serial)) {
                $productSnumbers = json_decode($product->serial, true);
                $productSnumbersCount = count($productSnumbers);

                if($product->count - $productSnumbersCount != $request->count) {
                    return false;
                }
            }
            if($product->count > $request->count) {
                $product->count = $product->count - $request->count;
            }
            if($product->count == $request->count) {
                $product->count = 0;
            }
            $product->save();
            return $this->receiveFromUser($request);
            
        } else {
            if(!is_null($request->serial)) {
                // serial numbers what will send to another user
                $snumbers = $request->serial;
                // product current serial numbers
                $productSnumbers = json_decode($product->serial, true);
                $productSnumbers = array_diff($productSnumbers, array_intersect($productSnumbers, $snumbers));
                $productSnumbers = array_combine(range(1, count($productSnumbers)), $productSnumbers);

                // product count minus count of sender serial numbers
                $product->serial = json_encode($productSnumbers);
                $product->count = $product->count - count($snumbers);
                $product->save();

                return $this->receiveFromUserSerials($request);
            }
        }


        return false;
    }

    public function returnBack($request) {
        $product = $this->find($request->receiver_product_id);

        // get owner and receiver
        $owner_id = $request->user_id;
        $owner_storage_id = $request->storage_id;
        $receiver_id = $request->receiver_id;
        $receiver_storage_id = $request->receiver_storage_id;


        // reverce owner and receiver for return back
        $request->user_id = $receiver_id;
        $request->storage_id = $receiver_storage_id;
        $request->receiver_id = $owner_id;
        $request->receiver_storage_id = $owner_storage_id;

        if(!is_null($request->count)) {
            if($product->count > $request->count) {
                $product->count = $product->count - $request->count;
            }
            $product->save();
            $this->receiveFromUser($request);
            
        } else {
            if(!is_null($request->serial)) {
                // serial numbers what will send to another user
                $request->serial = (array)$request->serial;

                // product current serial numbers
                $productSnumbers = json_decode($product->serial, true);
                $productSnumbers = array_diff($productSnumbers, $request->serial);
                $productSnumbers = json_encode($productSnumbers);
    
                // product count minus count of sender serial numbers
                $product->serial = $productSnumbers;
                $product->count = $product->count - count($request->serial);
                $product->save();

                $this->receiveFromUserSerials($request);
            }
        }


        if($product->count == $request->count) {
            $product->delete();
        }

        return true;
    }




    public function receiveFromUser($request) {
        $user = new User;
        $user = $user->find($request->receiver_id);

        // get received product and data
        $product = $this->find($request->product_id);
        $productName = $product->name;
        $productPrice = $product->price;
        $productReceived = $request->count;
        $productStorageId = $request->receiver_storage_id;

        // check if product exists in received user storage
        $product = $this
            ->where('name', $productName)
            ->where('user_id', $request->receiver_id)
            ->first();

        // if product does not exists in received user then its new product
        if (is_null($product)) {
            $product = $this;
            $product->count = 0;
        }

        $product->user_id = $user->id;
        $product->storage_id = $productStorageId;
        $product->name = $productName;
        $product->price = $productPrice;
        $product->count = $product->count + $productReceived;
        $product->save();

        return $product;
    }


    public function receiveFromUserSerials($request) {
        $user = new User;
        $user = $user->find($request->receiver_id);

        // get received product and data
        $product = $this->find($request->product_id);
        $productName = $product->name;
        $productPrice = $product->price;
        $productReceived = $request->serial;
        $productStorageId = $request->receiver_storage_id;

        // check if product exists in received user storage
        $product = $this
            ->where('name', $productName)
            ->where('user_id', $request->receiver_id)
            ->first();

        // if product does not exists in received user then its new product
        if (is_null($product)) {
            $product = $this;
            $product->count = 0;
            $serial = $request->serial;
        } else {
            $serial = json_decode($product->serial, true);
            $serial = array_merge($serial, (array)$request->serial);
            $serial = array_combine(range(1, count($serial)), $serial);
        }

        $product->user_id = $user->id;
        $product->storage_id = $productStorageId;
        $product->name = $productName;
        $product->price = $productPrice;
        $product->count = $product->count + count($productReceived);
        $product->serial = json_encode($serial);
        $product->save();

        return $product;
    }

}
