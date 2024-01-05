<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Transaction;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function index(Request $request)
    {
        $pagination = 5;

        $datas = Item::where(function ($q) use ($request) {
            $q->where('name', 'LIKE', '%' . $request->search . '%');
        })->orderBy('id', 'asc')->paginate($pagination);
        return view('transaction', compact('datas'));
    }

    public function Tambah($id)
    {
        $item = Item::findorfail($id);
        $cart = session()->get('cart');
        if (isset($cart[$id])) {

            $cart[$id]['qty'] += 1;
            $cart[$id]['subtotal'] = $item->price * $cart[$id]['qty'];
        } else {
            $cart[$id] = [
                "id" => $item->id,
                "name" => $item->name,
                "qty" => 1,
                "subtotal" => $item->price,
            ];
        }
        session()->put('cart', $cart);
        return redirect()->route('transaction')->with('message', 'Berhasil Menambahkan Data');
    }

    public function Update(Request $request)
    {
        $item = Item::findorfail($request->id);
        $cart = session('cart');

        if ($request->qty < 1) {
            $this->Delete($request->id);
        } else {
            $cart[$request->id]['qty'] = $request->qty;
            $cart[$request->id]['subtotal'] = $item->price *= $request->qty;
            session()->put('cart', $cart);
        };

        return redirect()->route('transaction')->with('message', 'Berhasil Mengupdate Data');
    }
    public function Delete($id)
    {

        $cart = session('cart');

        if (isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart);
        }
        return redirect()->route('transaction')->with('message', 'Berhasil Menghapus Data');
    }
}
