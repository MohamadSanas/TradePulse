<?php

namespace App\Http\Controllers;

use App\Models\Trade;
use Illuminate\Http\Request;

class TradeController extends Controller
{
    public function index()
    {
        $trades = Trade::latest()->get();
        return view('trades.index', compact('trades'));
    }

    public function create()
    {
        return view('trades.create');
    }

    public function store(Request $request)
    {
        $data = $this->validateTrade($request);
        Trade::create($data);

        return redirect()->route('trades.index')
            ->with('success', 'Trade created successfully');
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
        $data = $this->validateTrade($request);
        $trade = Trade::findOrFail($id);
        $trade->update($data);
        return redirect()->route('trades.index')
            ->with('success', 'Trade updated successfully');
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
            'bank_fee' => 'required|numeric',
            'total_lkr' => 'required|numeric',
            'fee' => 'nullable|numeric'
        ]);
    }
}