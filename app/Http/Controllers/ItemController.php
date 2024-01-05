<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Item;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    public function index(Request $request)
    {
        $pagination = 5;
        $category = Category::all();
        $data = Item::where(function ($q) use ($request) {
            $q->where('name', 'LIKE', '%' . $request->search . '%');
        })->orderBy('id', 'asc')->paginate($pagination);
        return view('item', compact('data', 'category'));
    }

    public function Tambah()
    {
        return view('item.Add');
    }
    public function Edit($id)
    {
        $item = Item::find($id);
        return $item;
    }
    public function Update(Request $request, $id)
    {
        $item = Item::find($id);
        $request->validate([
            'name' => 'required|string|min:5|unique:App\Models\Item',
            'category_id' => 'required|integer',
            'price' => 'required|integer',
            'stock' => 'required|integer',
        ]);
        $item->update([
            'name' => $request->name,
            'category_id' => $request->category_id,
            'price' => $request->price,
            'stock' => $request->stock,
        ]);
        return redirect()->route('item')->with('message', 'Berhasil Memperbarui Data');
    }
    public function Delete($id)
    {
        Item::destroy($id);
        return redirect()->route('item')->with('message', 'Berhasil Menghapus Data');
    }
    public function Send(Request $request)
    {
        $request->validate([
            'name' => 'required|string|min:5|unique:App\Models\Item',
            'category_id' => 'required|integer',
            'price' => 'required|integer',
            'stock' => 'required|integer',
        ]);


        $data = Category::where('id', $request['category_id'])->first();

        Item::create([
            'name' => $request->name,
            'category_id' => $request->category_id,
            'price' => $request->price,
            'stock' => $request->stock,
        ]);
        return redirect()->route('item')->with('message', 'Berhasil Menambahkan Data');
    }
}
