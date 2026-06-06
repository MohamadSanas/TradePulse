<?php

namespace App\Services;

use App\Models\User;
use App\Http\Controllers\Controller;

use App\Http\Controllers\TradeController;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TradeService extends TradeController
{
    protected function currentUser() :User
    {
        $user = Auth::user();
        if (!$user) {
            abort(401, 'Unauthorized');
        }
        return $user;
    }

    protected function validateTrade(Request $request)
    {
        return $request->validate([
            'type' => 'required|in:buy,sell',
            'amount' => 'required|numeric|min:0.01',
            'price' => 'required|numeric|min:0.01',
            'status' => 'required|in:open,closed,cancelled',
        ]);
    }

    public function createTrade(Request $request)
    {
        $data = $this->validateTrade($request);
        

        $trade = $this->currentUser()
            ->trades()
            ->create($data);

        return response()->json([
            'success' => true,
            'data' => $trade,
        ]);
    }

    public function applyTradeToCurrentStatus(User $user, $trade): void
    {
        $currentStatus = $user->effective_buy_prices()->latest()->first();
        $feeChardeByApp = floor($trade->amount_usdt * (($trade->fee ?? 0) / 100)*100)/100;

        $remainingUsdt = $currentStatus?->remaining_usdt ?? 0;
        $remainingLkr = $currentStatus?->remaining_lkr ?? 0;
        $bankFee = $trade->bank_fee ?? 0;
        $fee = $trade->fee ?? 0;

        if ($trade->type === 'buy') {

            $remainingUsdt += ($trade->amount_usdt - $feeChardeByApp);
            $remainingLkr += ($trade->total_lkr + $bankFee);

            $NewaverageBuyPrice = $remainingUsdt > 0
            ? $remainingLkr / $remainingUsdt
            : 0;
        }

        if ($trade->type === 'sell') {
            $average_buy_price = $user->effective_buy_prices()->latest()->value('Average_Buy_Price') ?? 0;
            $remainingUsdt -= $trade->amount_usdt;
            $remainingLkr -= ($trade->amount_usdt * $average_buy_price);
            $NewaverageBuyPrice = $average_buy_price;

        }

        $MaxSekkingFee = floor($remainingUsdt * ($fee / 100)*100)/100;
        $breakEvenPrice = $this->calculateBreakEvenPrice($remainingLkr, $remainingUsdt, $MaxSekkingFee);

        $data = [
            'average_buy_price' => round($NewaverageBuyPrice, 2),
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

    public function ApplyDeleteTradeToCurrentStatus(User $user, $trade): void
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
            $add_usdt = ($trade->amount_usdt - floor($trade->amount_usdt * ($fee / 100)*100)/100);
            $add_money = ($trade->total_lkr + $bankFee);
            $remainingUsdt -= $add_usdt;
            $remainingLkr -= $add_money;
        }

        if ($trade->type === 'sell') {
            $remainingUsdt += $trade->amount_usdt;
            $remainingLkr += $trade->amount_usdt * $currentStatus->average_buy_price;
        }

        $averageBuyPrice = $remainingUsdt > 0
            ? $remainingLkr / $remainingUsdt
            : 0;
        $maxSellingFee = floor($remainingUsdt * ($fee / 100)*100)/100;
        $breakEvenPrice = $this->calculateBreakEvenPrice($remainingLkr, $remainingUsdt, $maxSellingFee);

        $data = [
            'average_buy_price' => round($averageBuyPrice, 2),
            'remaining_usdt' => round($remainingUsdt, 2),
            'remaining_lkr' => round($remainingLkr, 2),
            'break_even_price' => round($breakEvenPrice, 2),
        ];

        $currentStatus->update($data);
    }

    public function ApplyEditTradeToCurrentStatus(User $user, $oldTrade, $newTrade): void
    {
        $this->ApplyDeleteTradeToCurrentStatus($user, $oldTrade);
        $this->ApplyTradeToCurrentStatus($user, $newTrade);
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
        $user = $this->currentUser();

        $current_status = $user
            ->effective_buy_prices()
            ->latest()
            ->get();

        $currentStatus = $current_status->first();
        $today_profit = $user->currentprofite()->latest()->value('profite') ?? 0;
        $capitalAmounts = $user->capital_amount()->latest()->get();
        $currentCapital = $capitalAmounts->first();
        $totalCapital = $capitalAmounts->sum('capital');

        return view('dashboard', compact('current_status', 'currentStatus', 'today_profit', 'currentCapital', 'totalCapital'));
    }


     private function addProfiteToCurrentProfite(User $user, $trade, $effective_buy_prices): void
    {
        $currentProfite = $user->currentprofite()->latest()->first();

        $profite = 0;


        if ($trade->type === 'sell' && $effective_buy_prices) {
            $profite = $trade->total_lkr - ($trade->amount_usdt * $effective_buy_prices->average_buy_price);
        }

        $data = [
            'profite' => round(($currentProfite?->profite ?? 0) + $profite, 2),
        ];

        if ($currentProfite) {
            $currentProfite->update($data);
        } else {
            $user->currentprofite()->create($data);
        }
    }


     private function calculateBreakEvenPrice(float $remainingLkr, float $remainingUsdt, float $sellingFee): float
    {
        $sellableUsdt = $remainingUsdt - $sellingFee;

        if ($sellableUsdt <= 0) {
            return 0;
        }

        return $remainingLkr / $sellableUsdt;
    }



    public function setCapitalAmount(Request $request)
    {
        $user = $this->currentUser();

        $validated = $request->validate([
            'capital' => 'required|numeric|min:0',
            'description' => 'nullable|string|max:1000',
        ]);

        $data = [
            'capital' => $validated['capital'],
            'description' => $validated['description'] ?? null,
        ];

        $user->capital_amount()->create($data);

        return redirect()->route('capital-amount.show')
            ->with('success', 'Capital amount updated successfully');
    }



}