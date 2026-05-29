<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ApiTradeController extends Controller
{
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
        $trade = $this->currentUser()
            ->trades()
            ->create($this->validateTrade($request));

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
        $trade = $this->currentUser()
            ->trades()
            ->findOrFail($id);

        $trade->update($this->validateTrade($request));

        return response()->json([
            'success' => true,
            'message' => 'Trade updated successfully',
            'data' => $trade,
        ]);
    }

    public function destroy($id)
    {
        $trade = $this->currentUser()
            ->trades()
            ->findOrFail($id);

        $trade->delete();

        return response()->json([
            'success' => true,
            'message' => 'Trade deleted successfully',
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
            abort(401);
        }

        return $user;
    }
}
