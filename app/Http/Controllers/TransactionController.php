<?php

namespace App\Http\Controllers;

use App\Http\Requests\TransactionRequest;
use App\Models\Transaction;
use App\Models\TransactionItem;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (request()->ajax()) {
            $query = Transaction::query();

            return DataTables::of($query)
                ->addColumn('action', function ($item) {
                    return '
                    <div class="inline-flex gap-2">
                        <a href="' . route('dashboard.transaction.show', $item->id) . '" class="px-3 py-1 font-semibold text-white transition duration-300 ease-out bg-purple-500 rounded-md hover:bg-purple-700">
                        Show
                        </a>
                        <a href="' . route('dashboard.transaction.edit', $item->id) . '" class="px-3 py-1 font-semibold text-white transition duration-300 ease-out bg-indigo-500 rounded-md hover:bg-indigo-700">
                        Edit
                        </a>
                    </div>
                    ';
                })
                ->editColumn('total_price', function ($item) {
                    return number_format($item->total_price);
                })
                ->editColumn('status', function ($item) {
                    return '
                        <div class="px-3 py-1 mx-auto font-semibold text-center text-white bg-pink-400 rounded-lg max-w-max">' . $item->status . '</div>
                    ';
                })
                ->rawColumns(['action', 'status', 'total_price'])
                ->make();
        }

        return view('pages.dashboard.transaction.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Transaction $transaction)
    {
        if (request()->ajax()) {
            $query = TransactionItem::with(['product'])->where('transactions_id', $transaction->id);

            return DataTables::of($query)
                ->editColumn('product.price', function ($item) {
                    return number_format($item->product->price);
                })
                // ->rawColumns(['action'])
                ->make();
        }

        return view('pages.dashboard.transaction.show', compact('transaction'));
        // dd(compact('transaction'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Transaction $transaction)
    {
        return view('pages.dashboard.transaction.edit', compact('transaction'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(TransactionRequest $request, Transaction $transaction)
    {
        $data = $request->all();

        $transaction->update($data);

        return redirect()->route('dashboard.transaction.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
