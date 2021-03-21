<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTransaction;
use App\Models\Product;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Auth::user()->user_type == 'admin') {
            return view('dashboard', ['transactions' => Transaction::all()]);
        } else {
            return view('dashboard', ['transactions' => Transaction::where('user_id', Auth::user()->id)->get()]);
        }
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTransaction $request)
    {
        // store validated transaction
        $validated = $request->validated();
        $transaction = new Transaction([
            'product_id' => $validated['product_id'],
            'user_id' => Auth::user()->id,
            'quantity' => $validated['quantity'],
        ]);
        $transaction->save();

        // update product with new quantity/status
        $product = Product::find($request->product_id);
        $new_quantity = $product->quantity - $transaction->quantity;
        $product->update([
            'quantity' => $new_quantity,
            'status' => $new_quantity > 0 ? 'available' : 'out of stock',
        ]);
        $product->save();

        // return response
        if ($transaction) {
            return response()->json([
                "msg" => "You purchased $request->quantity of $product->name",
                "new_quantity" => $product->quantity,
                "new_status" => $product->status,
            ]);
        } else {
            return response()->json("Failed to make the purchase");
        }
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Transaction $transaction
     * @return \Illuminate\Http\Response
     */
    public function show(Transaction $transaction)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Transaction $transaction
     * @return \Illuminate\Http\Response
     */
    public function edit(Transaction $transaction)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Transaction $transaction
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Transaction $transaction)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Transaction $transaction
     * @return \Illuminate\Http\Response
     */
    public function destroy(Transaction $transaction)
    {
        //
    }
}
