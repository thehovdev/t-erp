<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Storage;
use App\User;
use App\Product;
use Auth;

class StorageController extends Controller
{
    // home page with list of all storages
    public function index() {
        $storage = new Storage;
        // get current user
        $user = Auth::user();

        // using relation for get user storages
        $storages = $user->storages;

        return view('storage.index')
            ->with('storages', $storages);
    }
    // list all products in this storage
    public function list($id) {
        // get current user
        $user = Auth::user();
        // using relation for get user products by current storage
        $products = $user->products($id);

        return view('storage.list')
            ->with('products', $products)
            ->with('id', $id);
    }
    // insert new storage
    public function store(Request $request) {
        $request->validate([
            'name' => 'required'
        ]);

        $storage = new Storage;
        $storage->name = $request->name;
        $storage->user_id = Auth::id();
        $storage->save();

        return redirect()->back();
    }
    // delete storage and all his products
    public function delete(Request $request) {
        $request->validate([
            'id' => 'required'
        ]);

        $product = new Product;
        $storage = new Storage;
        $storage = $storage->find($request->id);
        $products = $product->where('storage_id', $storage->id)->delete();
        $storage->delete();

        return redirect()->back();
    }
}
