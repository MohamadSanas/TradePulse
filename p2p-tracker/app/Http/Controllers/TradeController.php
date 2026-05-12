<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TradeController extends Controller
{

    public function apiIndex()
    {
        return response()->json([
            'success' => true,
            'data' => $this->currentUser()
                ->trades()
                ->latest()
                ->get()
        ]);
    }

    public function apiStore(Request $request)
    {
        $data = $this->validateTrade($request);

        $trade = $this->currentUser()
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
        $trade = $this->currentUser()
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

        $trade = $this->currentUser()
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
        $trade = $this->currentUser()
            ->trades()
            ->findOrFail($id);

        $trade->delete();

        return response()->json([
            'success' => true,
            'message' => 'Trade deleted successfully'
        ]);
    }


    public function index()
    {
        $buyTrades = $this->currentUser()
            ->trades()
            ->where('type', 'buy')
            ->latest()
            ->get();

        $sellTrades = $this->currentUser()
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
        $user = $this->currentUser();

        $trade = $user
            ->trades()
            ->create($data);

        $this->applyTradeToCurrentStatus($user, $trade);

        return redirect('/trades');
    }

    public function show($id)
    {
        $trade = $this->currentUser()
            ->trades()
            ->findOrFail($id);

        return view('trades.show', compact('trade'));
    }

    public function edit($id)
    {
        $trade = $this->currentUser()
            ->trades()
            ->findOrFail($id);

        return view('trades.edit', compact('trade'));
    }

    public function update(Request $request, $id)
    {
        $data = $this->validateTrade($request);
        $trade = $this->currentUser()
            ->trades()
            ->findOrFail($id);

        $trade->update($data);

        return redirect('/trades');
    }

    public function destroy($id)
    {
        $trade = $this->currentUser()
            ->trades()
            ->findOrFail($id);

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

    private function currentUser(): User
    {
        $user = Auth::user();

        if (! $user instanceof User) {
            abort(401);
        }
        return $user;
    }

    private function applyTradeToCurrentStatus(User $user, $trade): void
    {
        $currentStatus = $user->effective_buy_prices()->latest()->first();
        $feeChardeByApp= $trade-> flooor($trade->amount_usdt * ($trade->fee ?? 0) / 100);

        $remainingUsdt = $currentStatus?->remaining_usdt ?? 0;
        $remainingLkr = $currentStatus?->remaining_lkr ?? 0;
        $bankFee = $trade->bank_fee ?? 0;
        $fee = $trade->fee ?? 0;

        if ($trade->type === 'buy') {

            $remainingUsdt += $trade->amount_usdt-$feeChardeByApp;
            $remainingLkr += $trade->total_lkr + $bankFee;
        }

        if ($trade->type === 'sell') {
            $remainingUsdt -= $trade->amount_usdt;
            $remainingLkr -= $trade->total_lkr;
        }

        $averageBuyPrice = $remainingUsdt > 0
            ? $remainingLkr / $remainingUsdt
            : 0;
        $MaxSekkingFee = floor($remainingUsdt * ($fee / 100));
        $breakEvenPrice = $remainingLkr/($remainingUsdt-$MaxSekkingFee);

        $data = [
            'average_buy_price' => round($averageBuyPrice, 2),
            'remaining_usdt' => round($remainingUsdt, 2),
            'remaining_lkr' => round($remainingLkr, 2),
            'break_even_price' => round($breakEvenPrice, 2),
        ];

        if ($currentStatus) {
            $currentStatus->update($data);
        } else {
            $user->effective_buy_prices()->create($data);
        }
    }

    private function appleDeleteTradeToCurrentStatus(User $user, $trade): void
    {
        $currentStatus = $user->effective_buy_prices()->latest()->first();

        if (! $currentStatus) {
            return;
        }

        $remainingUsdt = $currentStatus->remaining_usdt;
        $remainingLkr = $currentStatus->remaining_lkr;
        $bankFee = $trade->bank_fee ?? 0;
        $fee = $trade->fee ?? 0;

        if ($trade->type === 'buy') {
            $remainingUsdt -= $trade->amount_usdt - floor($trade->amount_usdt * ($fee / 100));
            $remainingLkr -= $trade->total_lkr + $bankFee;
        }

        if ($trade->type === 'sell') {
            $remainingUsdt += $trade->amount_usdt;
            $remainingLkr += $trade->total_lkr;
        }

        $averageBuyPrice = $remainingUsdt > 0
            ? $remainingLkr / $remainingUsdt
            : 0;

        $data = [
            'average_buy_price' => round($averageBuyPrice, 2),
            'remaining_usdt' => round($remainingUsdt, 2),
            'remaining_lkr' => round($remainingLkr, 2),
        ];

        $currentStatus->update($data);
    }

    private function applyediteTradeToCurrentStatus(User $user, $oldTrade, $newTrade): void
    {
        $this->appleDeleteTradeToCurrentStatus($user, $oldTrade);
        $this->applyTradeToCurrentStatus($user, $newTrade);
    }

    public function updateAverageBuyPrice(Request $request)
    {
        $user = $this->currentUser();

        $validated = $request->validate([
            'average_buy_price' => 'required|numeric',
            'remaining_usdt' => 'required|numeric',
            'remaining_lkr' => 'required|numeric',
            'break_even_price' => 'required|numeric',
        ]);

        $data = [
            'average_buy_price' => $validated['average_buy_price'],
            'remaining_usdt' => $validated['remaining_usdt'],
            'remaining_lkr' => $validated['remaining_lkr'],
            'break_even_price' => $validated['break_even_price'],
        ];

        $currentStatus = $user->effective_buy_prices()->latest()->first();
        if ($currentStatus) {
            $currentStatus->update($data);
        } else {
            $user->effective_buy_prices()->create($data);
        }

        return redirect()->route('dashboard')
            ->with('success', 'Current status updated successfully');

    }

    public function viewUpdateAverageBuyPrice()
    {
        $current_status = $this->currentUser()
            ->effective_buy_prices()
            ->latest()
            ->get();

        $currentStatus = $current_status->first();

        return view('dashboard', compact('current_status', 'currentStatus'));
    }

    public function apiViewUpdateAverageBuyPrice()
    {
        return response()->json([
            'success' => true,
            'data' => $this->currentUser()
                ->effective_buy_prices()
                ->latest()
                ->get()
        ]);
    }


    public function apiUpdateAverageBuyPrice(Request $request, $id)
    {
        $data = $this->validateTrade($request);
        $trade = $this->currentUser()
            ->effective_buy_prices()
            ->findOrFail($id);

        $trade->update($data);

        return response()->json([
            'success' => true,
            'message' => 'Effective Buy Price updated successfully',
            'data' => $trade
        ]);
    }

    public function apiDestroyEffectiveBuyPrice($id)
    {
        $trade = $this->currentUser()
            ->effective_buy_prices()
            ->findOrFail($id);

        $trade->delete();

        return response()->json([
            'success' => true,
            'message' => 'Effective Buy Price deleted successfully'
        ]);
    }





}
