<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Journal;
use App\Storage;
use App\Product;
use App\User;
use Auth;

class ProductController extends Controller
{

    public function index()
    {
        // return view('product.index');
    }

    public function create($id)
    {
        return view('product.create')->with('id', $id);
    }

    public function edit($product_id, $id) 
    {
        $product = new Product;
        $user = new User;
        if ($user->storage($id)) {
            $product = $product->find($product_id);
        }

        return view('product.edit')
            ->with('product', $product)
            ->with('id', $id);
    }

    public function send($id) 
    {
        $user = Auth::user();
        $receivers = $user->getReceivers();
        $products = $user->products($id);


        return view('product.send')
            ->with('id', $id)
            ->with('products', $products)
            ->with('receivers', $receivers);
    }

    // dependency injection for find journal id
    public function returnback(Journal $inaction) {
        $action = json_decode($inaction->action);

        $product = new Product;
        $product = $product->returnBack($action);

        $inaction->delete();

        return redirect()->back();
    }


    public function sendtoreceiver(Request $request) {
        $request->validate([
            'product_id' => 'required',
            'storage_id' => 'required',
            'receiver_id' => 'required',
            'receiver_storage_id' => 'required',
            'serial' => 'required_without:count',
            'count' => 'required_without:serial',
        ]);

        $user = new User;
        $journal = new Journal;
        $storage = new Storage;
        $product = new Product;
        
        if ($user->storage($request->storage_id)) {
            $product = $product->sendFromUser($request);
            if($product) {
                $request->request->add(['user_id' => Auth::id()]); //add request
                $request->request->add(['name' => $product->name]); //add request
                $request->request->add(['receiver_product_id' => $product->id]); //add request
                $journal = $journal->insert($request);
            } else {
                return redirect()->back();
            }
        }
        return redirect()->route('storage.list', $request->storage_id);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'price' => 'required',
            'serial' => 'required_without:count',
            'count' => 'required_without:serial',
        ]);

        $user = new User;
        $count = $request->count;
        $snumbers = $request->serial;

        if ($user->storage($request->storage_id)) {

            if(!is_null($count)) {
                $product = new Product;
                $product->add($request);
            }

            if(!is_null($snumbers)) {
                $product = new Product;
                $product->addWithSerials($request, $snumbers);
            }
            return redirect()->route('storage.list', $request->storage_id);
        }   

        // else redirect back to index
        return redirect()->route('storage.index');
    }

    public function update($product_id, $id, Request $request) {
        $request->validate([
            'name' => 'required',
        ]);

        $user = new User;
        $product = new Product;
        if ($user->storage($id)) {
            $product = $product->find($product_id);
            $product->name = $request->name;
            $product->save();
        }

        return redirect()->route('storage.list', $id);

    }


    public function destroy($id)
    {

        if(!is_null($id)) {
            $user = Auth::user();
            $product = $user->product($id)->delete();
        }

        return redirect()->back();
    }
}
