<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Storage;
use App\User;
use App\Product;
use Auth;

class StorageController extends Controller
{
    public function index() {
        $storage = new Storage;
        $user = Auth::user();

        $storages = $user->storages;

        return view('storage.index')
            ->with('storages', $storages);
    }

    public function list($id) {
        $user = Auth::user();
        $products = $user->products($id);

        return view('storage.list')
            ->with('products', $products)
            ->with('id', $id);
    }

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
