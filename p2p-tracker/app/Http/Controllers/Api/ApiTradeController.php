<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Http\Controllers\Controller;
use App\Services\TradeService;

use App\Http\Controllers\TradeController;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ApiTradeController extends TradeService
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

    public function create()
    {
        return response()->json([
            'success' => true,
            'message' => 'Provide trade details to create a new trade',
        ]);
    }

    public function store(Request $request)
    {
        $data = $this->validateTrade($request);
        

        $trade = $this->currentUser()
            ->trades()
            ->create($data);

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

    public function edit($id)
    {
        $trade = $this->currentUser()
            ->trades()
            ->findOrFail($id);

        return response()->json([
            'success' => true,
            'message' => 'Provide updated trade details',
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

    public function ApiApplyTradeToCurrentStatus(Request $request, $id)
    {
        $trade = $this->currentUser()
            ->trades()
            ->findOrFail($id);

        $this->ApplyTradeToCurrentStatus($this->currentUser(), $trade);

        return response()->json([
            'success' => true,
            'message' => 'Trade status updated successfully',
        
        ]);
    }

    public function ApiApplyDeleteToCurrentStatus(Request $request, $id)
    {
        $trade = $this->currentUser()
            ->trades()
            ->findOrFail($id);

        $this->ApplyDeleteTradeToCurrentStatus($this->currentUser(), $trade);

        return response()->json([
            'success' => true,
            'message' => 'Trade status updated successfully',
        
        ]);
    }

    public function ApiApplyEditTradeToCurrentStatus(Request $request, $oldTradeId, $newTradeId)
    {
        $oldTrade = $this->currentUser()
            ->trades()
            ->findOrFail($oldTradeId);

        $newTrade = $this->currentUser()
            ->trades()
            ->findOrFail($newTradeId);

        $this->ApplyEditTradeToCurrentStatus($this->currentUser(), $oldTrade, $newTrade);

        return response()->json([
            'success' => true,
            'message' => 'Trade status updated successfully',
        
        ]);
    }
    


}
