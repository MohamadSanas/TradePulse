<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\TradeService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ApiTradeController extends Controller
{
    public function __construct(private TradeService $tradeService)
    {
    }

    public function index()
    {
        return response()->json([
            'success' => true,
            'data' => $this->currentUser()
                ->trades()
                ->latest()
                ->get(),
        ]);
    }

    public function store(Request $request)
    {
        $user = $this->currentUser();
        $trade = $user->trades()->create($this->validateTrade($request));

        $this->tradeService->applyTradeToCurrentStatus($user, $trade);
        $this->tradeService->addProfiteToCurrentProfite(
            $user,
            $trade,
            $user->effective_buy_prices()->latest()->first()
        );

        return response()->json([
            'success' => true,
            'message' => 'Trade created successfully',
            'data' => $trade,
        ], 201);
    }

    public function show($id)
    {
        $trade = $this->currentUser()
            ->trades()
            ->findOrFail($id);

        return response()->json([
            'success' => true,
            'data' => $trade,
        ]);
    }

    public function update(Request $request, $id)
    {
        $user = $this->currentUser();
        $trade = $user->trades()->findOrFail($id);
        $oldTrade = $trade->replicate();

        $trade->update($this->validateTrade($request));
        $this->tradeService->applyEditTradeToCurrentStatus($user, $oldTrade, $trade);

        return response()->json([
            'success' => true,
            'message' => 'Trade updated successfully',
            'data' => $trade,
        ]);
    }

    public function destroy($id)
    {
        $user = $this->currentUser();
        $trade = $user->trades()->findOrFail($id);

        $this->tradeService->applyDeleteTradeToCurrentStatus($user, $trade);
        $trade->delete();

        return response()->json([
            'success' => true,
            'message' => 'Trade deleted successfully',
        ]);
    }

    public function apiApplyTradeToCurrentStatus(Request $request, $id)
    {
        $trade = $this->currentUser()
            ->trades()
            ->findOrFail($id);

        $this->tradeService->applyTradeToCurrentStatus($this->currentUser(), $trade);

        return response()->json([
            'success' => true,
            'message' => 'Trade status updated successfully',
        ]);
    }

    public function apiViewUpdateAverageBuyPrice()
    {
        return response()->json([
            'success' => true,
            'data' => $this->currentUser()
                ->effective_buy_prices()
                ->latest()
                ->get(),
        ]);
    }

    public function apiUpdateAverageBuyPrice(Request $request)
    {
        $validated = $request->validate([
            'average_buy_price' => 'required|numeric',
            'remaining_usdt' => 'required|numeric',
            'remaining_lkr' => 'required|numeric',
            'break_even_price' => 'required|numeric',
        ]);

        $this->tradeService->saveCurrentStatus($this->currentUser(), $validated);

        return response()->json([
            'success' => true,
            'message' => 'Current status updated successfully',
        ]);
    }

    public function apiDestroyEffectiveBuyPrice($id)
    {
        $effectiveBuyPrice = $this->currentUser()
            ->effective_buy_prices()
            ->findOrFail($id);

        $effectiveBuyPrice->delete();

        return response()->json([
            'success' => true,
            'message' => 'Effective Buy Price deleted successfully',
        ]);
    }

    public function apiAddProfiteToCurrentProfite(Request $request, $tradeId)
    {
        $trade = $this->currentUser()
            ->trades()
            ->findOrFail($tradeId);

        $effectiveBuyPrices = $this->currentUser()
            ->effective_buy_prices()
            ->latest()
            ->first();

        $this->tradeService->addProfiteToCurrentProfite($this->currentUser(), $trade, $effectiveBuyPrices);

        return response()->json([
            'success' => true,
            'message' => 'Profit added to current profit successfully',
        ]);
    }

    public function apiCalculateBreakEvenPrice(Request $request)
    {
        $validated = $request->validate([
            'remaining_lkr' => 'required|numeric',
            'remaining_usdt' => 'required|numeric',
            'selling_fee' => 'required|numeric',
        ]);

        $breakEvenPrice = $this->tradeService->calculateBreakEvenPrice(
            $validated['remaining_lkr'],
            $validated['remaining_usdt'],
            $validated['selling_fee']
        );

        return response()->json([
            'success' => true,
            'break_even_price' => round($breakEvenPrice, 2),
        ]);
    }

    public function apiSetCapitalAmount(Request $request)
    {
        $validated = $request->validate([
            'capital' => 'required|numeric|min:0',
            'description' => 'nullable|string|max:1000',
        ]);

        $this->tradeService->setCapitalAmount($this->currentUser(), [
            'capital' => $validated['capital'],
            'description' => $validated['description'] ?? null,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Capital amount updated successfully',
        ]);
    }

    public function apiShowCapitalAmount()
    {
        $capitalAmounts = $this->currentUser()
            ->capital_amount()
            ->latest()
            ->get();

        return response()->json([
            'success' => true,
            'data' => $capitalAmounts,
        ]);
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
            abort(401, 'Unauthorized');
        }

        return $user;
    }
}
