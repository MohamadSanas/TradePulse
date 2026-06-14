<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\TradeService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TradeController extends Controller
{
    public function __construct(private TradeService $tradeService)
    {
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

        $trade = $user->trades()->create($data);

        $this->tradeService->applyTradeToCurrentStatus($user, $trade);
        $this->tradeService->addProfiteToCurrentProfite(
            $user,
            $trade,
            $user->effective_buy_prices()->latest()->first()
        );

        return redirect()->route('trades.index')
            ->with('success', 'Trade created successfully');
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
        $user = $this->currentUser();
        $trade = $user->trades()->findOrFail($id);
        $oldTrade = $trade->replicate();

        $trade->update($data);
        $this->tradeService->applyEditTradeToCurrentStatus($user, $oldTrade, $trade);

        return redirect()->route('trades.index')
            ->with('success', 'Trade updated successfully');
    }

    public function destroy($id)
    {
        $user = $this->currentUser();
        $trade = $user->trades()->findOrFail($id);

        $this->tradeService->applyDeleteTradeToCurrentStatus($user, $trade);
        $trade->delete();

        return redirect()->route('trades.index')
            ->with('success', 'Trade deleted successfully');
    }

    public function updateAverageBuyPrice(Request $request)
    {
        $validated = $request->validate([
            'average_buy_price' => 'required|numeric',
            'remaining_usdt' => 'required|numeric',
            'remaining_lkr' => 'required|numeric',
            'break_even_price' => 'required|numeric',
        ]);

        $this->tradeService->saveCurrentStatus($this->currentUser(), $validated);

        return redirect()->route('dashboard')
            ->with('success', 'Current status updated successfully');
    }

    public function viewUpdateAverageBuyPrice()
    {
        $user = $this->currentUser();

        $current_status = $user
            ->effective_buy_prices()
            ->latest()
            ->get();

        $currentStatus = $current_status->first();
        $total_profit = $user->currentprofite()->latest()->value('profite') ?? 0;
        $capitalAmounts = $user->capital_amount()->latest()->get();
        $currentCapital = $capitalAmounts->first();
        $totalCapital = $capitalAmounts->sum('capital');
        $totalAssets = $totalCapital + $total_profit;

        return view('dashboard', compact(
            'current_status',
            'currentStatus',
            'total_profit',
            'currentCapital',
            'totalCapital',
            'totalAssets'
        ));

    }

    public function setCapitalAmount(Request $request)
    {
        $validated = $request->validate([
            'capital' => 'required|numeric|min:0',
            'description' => 'nullable|string|max:1000',
        ]);

        $this->tradeService->setCapitalAmount($this->currentUser(), [
            'capital' => $validated['capital'],
            'description' => $validated['description'] ?? null,
        ]);

        return redirect()->route('capital-amount.index')
            ->with('success', 'Capital amount updated successfully');
    }

    public function showCapitalAmount()
    {
        $capitalAmounts = $this->currentUser()
            ->capital_amount()
            ->latest()
            ->get();

        $currentCapital = $capitalAmounts->first();
        $totalCapital = $capitalAmounts->sum('capital');

        return view('CapitalAmount.show', compact('capitalAmounts', 'currentCapital', 'totalCapital'));
    }

    private function validateTrade(Request $request): array
    {
        return $request->validate([
            'type' => 'required|in:buy,sell',
            'amount_usdt' => 'required|numeric',
            'bank_fee' => 'nullable|numeric',
            'total_lkr' => 'required|numeric',
            'fee' => 'nullable|numeric',
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
}
