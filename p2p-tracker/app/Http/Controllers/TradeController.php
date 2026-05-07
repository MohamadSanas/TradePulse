<?php

namespace App\Http\Controllers;

use App\Models\Trade;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TradeController extends Controller
{
    // =========================
    // API METHODS
    // =========================

    public function apiIndex()
    {
        return response()->json([
            'success' => true,
            'data' => Auth::user()
                ->trades()
                ->latest()
                ->get()
        ]);
    }

    public function apiStore(Request $request)
    {
        $data = $this->validateTrade($request);

        $trade = Auth::user()
            ->trades()
            ->create($data);

        return response()->json([
            'success' => true,
            'message' => 'Trade created successfully',
            'data' => $trade
        ], 201);
    }

    public function apiShow($id)
    {
        $trade = Auth::user()
            ->trades()
            ->findOrFail($id);

        return response()->json([
            'success' => true,
            'data' => $trade
        ]);
    }

    public function apiUpdate(Request $request, $id)
    {
        $data = $this->validateTrade($request);

        $trade = Auth::user()
            ->trades()
            ->findOrFail($id);

        $trade->update($data);

        return response()->json([
            'success' => true,
            'message' => 'Trade updated successfully',
            'data' => $trade
        ]);
    }

    public function apiDestroy($id)
    {
        $trade = Auth::user()
            ->trades()
            ->findOrFail($id);

        $trade->delete();

        return response()->json([
            'success' => true,
            'message' => 'Trade deleted successfully'
        ]);
    }

    // =========================
    // WEB CRUD METHODS
    // =========================

    public function index()
    {
        $buyTrades = Auth::user()
            ->trades()
            ->where('type', 'buy')
            ->latest()
            ->get();

        $sellTrades = Auth::user()
            ->trades()
            ->where('type', 'sell')
            ->latest()
            ->get();

        return view('trades.index', compact('buyTrades', 'sellTrades'));
    }

    public function create()
    {
        return view('trades.create');
    }

    public function store(Request $request)
    {
        $data = $this->validateTrade($request);

        Auth::user()
            ->trades()
            ->create($data);

        return redirect('/trades');
    }

    public function show($id)
    {
        $trade = Auth::user()
            ->trades()
            ->findOrFail($id);

        return view('trades.show', compact('trade'));
    }

    public function edit($id)
    {
        $trade = Auth::user()
            ->trades()
            ->findOrFail($id);

        return view('trades.edit', compact('trade'));
    }

    public function update(Request $request, $id)
    {
        $data = $this->validateTrade($request);

        $trade = Auth::user()
            ->trades()
            ->findOrFail($id);

        $trade->update($data);

        return redirect('/trades');
    }

    public function destroy($id)
    {
        $trade = Auth::user()
            ->trades()
            ->findOrFail($id);

        $trade->delete();

        return redirect()->route('trades.index')
            ->with('success', 'Trade deleted successfully');
    }

    // =========================
    // VALIDATION
    // =========================

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

    // =========================
    // CALCULATION METHODS
    // =========================

    private function averagePrice($amount_usdt, $total_lkr)
    {
        return $amount_usdt > 0
            ? $total_lkr / $amount_usdt
            : 0;
    }

    // Total Buy USDT
    private function totalBuys()
    {
        return Auth::user()
            ->trades()
            ->where('type', 'buy')
            ->sum('amount_usdt');
    }

    // Total Sell USDT
    private function totalSells()
    {
        return Auth::user()
            ->trades()
            ->where('type', 'sell')
            ->sum('amount_usdt');
    }

    // Average Sell Price
    private function averageSellPrice()
    {
        $totalSells = $this->totalSells();

        $totalSellValue = Auth::user()
            ->trades()
            ->where('type', 'sell')
            ->sum('total_lkr');

        return $this->averagePrice(
            $totalSells,
            $totalSellValue
        );
    }
}