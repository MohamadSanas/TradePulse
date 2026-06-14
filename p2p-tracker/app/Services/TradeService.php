<?php

namespace App\Services;

use App\Models\User;
use Nette\Utils\Type;

use App\Models\WithdrawHistory;

class TradeService
{
    public function applyTradeToCurrentStatus(User $user, $trade): void
    {
        $currentStatus = $user->effective_buy_prices()->latest()->first();
        $feeChargedByApp = floor($trade->amount_usdt * (($trade->fee ?? 0) / 100) * 100) / 100;

        $remainingUsdt = $currentStatus?->remaining_usdt ?? 0;
        $remainingLkr = $currentStatus?->remaining_lkr ?? 0;
        $bankFee = $trade->bank_fee ?? 0;
        $fee = $trade->fee ?? 0;
        $newAverageBuyPrice = $currentStatus?->average_buy_price ?? 0;

        if ($trade->type === 'buy') {
            $remainingUsdt += ($trade->amount_usdt - $feeChargedByApp);
            $remainingLkr += ($trade->total_lkr + $bankFee);

            $newAverageBuyPrice = $remainingUsdt > 0
                ? $remainingLkr / $remainingUsdt
                : 0;
        }

        if ($trade->type === 'sell') {
            $averageBuyPrice = $currentStatus?->average_buy_price ?? 0;
            $remainingUsdt -= $trade->amount_usdt;
            $remainingLkr -= ($trade->amount_usdt * $averageBuyPrice);
            $newAverageBuyPrice = $averageBuyPrice;
        }

        $maxSellingFee = floor($remainingUsdt * ($fee / 100) * 100) / 100;
        $breakEvenPrice = $this->calculateBreakEvenPrice($remainingLkr, $remainingUsdt, $maxSellingFee);

        $this->saveCurrentStatus($user, [
            'average_buy_price' => round($newAverageBuyPrice, 2),
            'remaining_usdt' => round($remainingUsdt, 2),
            'remaining_lkr' => round($remainingLkr, 2),
            'break_even_price' => round($breakEvenPrice, 2),
        ]);
    }

    public function applyDeleteTradeToCurrentStatus(User $user, $trade): void
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
            $addedUsdt = $trade->amount_usdt - floor($trade->amount_usdt * ($fee / 100) * 100) / 100;
            $addedMoney = $trade->total_lkr + $bankFee;
            $remainingUsdt -= $addedUsdt;
            $remainingLkr -= $addedMoney;
        }

        if ($trade->type === 'sell') {
            $remainingUsdt += $trade->amount_usdt;
            $remainingLkr += $trade->amount_usdt * $currentStatus->average_buy_price;
        }

        $averageBuyPrice = $remainingUsdt > 0
            ? $remainingLkr / $remainingUsdt
            : 0;
        $maxSellingFee = floor($remainingUsdt * ($fee / 100) * 100) / 100;
        $breakEvenPrice = $this->calculateBreakEvenPrice($remainingLkr, $remainingUsdt, $maxSellingFee);

        $currentStatus->update([
            'average_buy_price' => round($averageBuyPrice, 2),
            'remaining_usdt' => round($remainingUsdt, 2),
            'remaining_lkr' => round($remainingLkr, 2),
            'break_even_price' => round($breakEvenPrice, 2),
        ]);
    }

    public function applyEditTradeToCurrentStatus(User $user, $oldTrade, $newTrade): void
    {
        $this->applyDeleteTradeToCurrentStatus($user, $oldTrade);
        $this->applyTradeToCurrentStatus($user, $newTrade);
    }

    public function saveCurrentStatus(User $user, array $data): void
    {
        $currentStatus = $user->effective_buy_prices()->latest()->first();

        if ($currentStatus) {
            $currentStatus->update($data);
            return;
        }

        $user->effective_buy_prices()->create($data);
    }

    public function addProfiteToCurrentProfite(User $user, $trade, $effectiveBuyPrices = null): void
    {
        $currentProfite = $user->currentprofite()->latest()->first();
        $profite = 0;

        if ($trade->type === 'sell' && $effectiveBuyPrices) {
            $profite = $trade->total_lkr - ($trade->amount_usdt * $effectiveBuyPrices->average_buy_price);
        }

        $data = [
            'profite' => round(($currentProfite?->profite ?? 0) + $profite, 2),
        ];

        if ($currentProfite) {
            $currentProfite->update($data);
            return;
        }

        $user->currentprofite()->create($data);
    }

    public function calculateBreakEvenPrice(float $remainingLkr, float $remainingUsdt, float $sellingFee): float
    {
        $sellableUsdt = $remainingUsdt - $sellingFee;

        if ($sellableUsdt <= 0) {
            return 0;
        }

        return $remainingLkr / $sellableUsdt;
    }

    public function setCapitalAmount(User $user, array $data): void
    {
        $user->capital_amount()->create($data);
    }

    public function Withdraw(User $user , float $amount): void{
        $currentCapital = $user->capital_amount()->latest()->first();

        if (! $currentCapital) {
            return;
        }

        $newCapitalAmount = max(0, $currentCapital->amount - $amount);

        $currentCapital->update([
            'amount' => round($newCapitalAmount, 2),
        ]);

    }

    public function totalAsset(User $user): float
    {
        $currentCapital = $user->totalcapital()->latest()->first();
        $currentProfite = $user->currentprofite()->latest()->first();

        return round(($currentCapital?->capital ?? 0) + ($currentProfite?->profite ?? 0), 2);
    }

    public function removeCapitalAmount(User $user, int $capitalAmountId): void
    {
        $capitalAmount = $user->capital_amount()->find($capitalAmountId);

        if ($capitalAmount) {
            $capitalAmount->delete();
        }
    }

    public function updateCapitalAmount(User $user, int $capitalAmountId, float $newCapital, ?string $description = null): void
    {
        $capitalAmount = $user->capital_amount()->find($capitalAmountId);

        if ($capitalAmount) {
            $capitalAmount->update([
                'capital' => round($newCapital, 2),
                'description' => $description,
            ]);
        }
    }

    public function withdrawProfit(User $user, float $amount, ?string $description = null): void 
    {

        $currentProfite = $user->currentprofite()->latest()->first();

        if (! $currentProfite) {
            return;
        }

        if ($amount > $currentProfite->profite) {
            throw new \Exception('Withdrawal amount exceeds available profit.');
        }

        $currentProfite->update([
            'profite' => round(
                $currentProfite->profite - $amount,
                2
            ),
        ]);

        $user->withdrawHistories()->create([
            'amount' => $amount,
            'description' => $description,
        ]);
    }

}
