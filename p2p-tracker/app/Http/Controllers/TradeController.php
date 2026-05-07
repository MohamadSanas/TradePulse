<?php

namespace App\Http\Controllers;

use App\Models\Trade;
use Illuminate\Http\Request;

class TradeController extends Controller
{
    public function apiIndex()
    {
        return response()->json([
            'success' => true,
            'data' => Trade::latest()->get()
        ]);
    }


    public function apiStore(Request $request)
    {
        $data = $this->validateTrade($request);

        $trade = Trade::create($data);

        return response()->json([
            'success' => true,
            'message' => 'Trade created successfully',
            'data' => $trade
            ], 201);
    }

    public function apiShow($id)
    {
        $trade = Trade::findOrFail($id);

        return response()->json([
            'success' => true,
            'data' => $trade
        ]);
    }



    public function apiUpdate(Request $request, $id)
    {
        $data = $this->validateTrade($request);

        $trade = Trade::findOrFail($id);
        $trade->update($data);

        return response()->json([
            'success' => true,
            'message' => 'Trade updated successfully',
            'data' => $trade
        ]);
    }

    public function apiDestroy($id)
    {
        $trade = Trade::findOrFail($id);
        $trade->delete();

        return response()->json([
            'success' => true,
            'message' => 'Trade deleted successfully'
        ]);
    }

    public function index()
    {
        $buyTrades = Trade::where('type', 'buy')->latest()->get();
        $sellTrades = Trade::where('type', 'sell')->latest()->get();

        return view('trades.index', compact('buyTrades', 'sellTrades'));
    }

    public function create()
    {
        return view('trades.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'type' => 'required|in:buy,sell',
            'amount_usdt' => 'required|numeric',
            'bank_fee' => 'nullable|numeric',
            'total_lkr' => 'required|numeric',
            'fee' => 'nullable|numeric'
        ]);

        Trade::create([
            'type' => $request->type,
            'amount_usdt' => $request->amount_usdt,
            'bank_fee' => $request->bank_fee,
            'total_lkr' => $request->total_lkr,
            'fee' => $request->fee
        ]);

        return redirect('/trades');
    }

    public function show($id)
    {
        $trade = Trade::findOrFail($id);
        return view('trades.show', compact('trade'));
    }

    public function edit($id)
    {
        $trade = Trade::findOrFail($id);
        return view('trades.edit', compact('trade'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'type' => 'required|in:buy,sell',
            'amount_usdt' => 'required|numeric',
            'bank_fee' => 'nullable|numeric',
            'total_lkr' => 'required|numeric',
            'fee' => 'nullable|numeric'
        ]);

        $trade = Trade::findOrFail($id);

        $trade->update([
            'type' => $request->type,
            'amount_usdt' => $request->amount_usdt,
            'bank_fee' => $request->bank_fee,
            'total_lkr' => $request->total_lkr,
            'fee' => $request->fee
        ]);

        return redirect('/trades');
    }

    public function destroy($id)
    {
        $trade = Trade::findOrFail($id);
        $trade->delete();

        return redirect()->route('trades.index')
            ->with('success', 'Trade deleted successfully');
    }

    private function validateTrade(Request $request)
    {
        return $request->validate([
            'type' => 'required|in:buy,sell',
            'amount_usdt' => 'required|numeric',
            'bank_fee' => 'nullable|numeric',
            'total_lkr' => 'required|numeric',
            'fee' => 'nullable|numeric'
        ]);
    }

    private function averagePrice($amount_usdt, $total_lkr)
    {
        return $amount_usdt > 0 ? $total_lkr / $amount_usdt : 0;
    }

    //get sum of all buy trades in data base 
    private function totalBuys()
    {
        return Trade::where('type', 'buy')->sum('amount_usdt');
    }

    //get total sells in data base 
    private function totalSells()
    {
        return Trade::where('type', 'sell')->sum('amount_usdt');
    }

    //get total 

    //get average price of sell trades
    private function averageSellPrice()
    {
        $totalSells = $this->totalSells();
        $totalSellValue = Trade::where('type', 'sell')->sum('total_lkr');
        return $this->averagePrice($totalSells, $totalSellValue);
    }


}