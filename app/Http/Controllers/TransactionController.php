<?php

namespace App\Http\Controllers;

use App\Models\Bid;
use App\Models\User;
use App\Models\Auction;
use App\Models\Transaction;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function index()
    {
        $transactions = Transaction::with(['user', 'bid'])->get();
        return view('transactions.index', compact('transactions'));
    }

    public function create()
    {
        $userId = auth()->user()->id_user;

        $bids = Bid::whereHas('auction', function ($query) {
                    $query->where('status', 'completed');
                })
                ->where('user_id', $userId)
                ->whereDoesntHave('transaction', function ($query) {
                    $query->where('status', '!=', 'pending');
                })
                ->with(['auction.product'])
                ->orderBy('bid_price', 'desc')
                ->get();

        return view('transactions.create', compact('bids'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id_user',
            'bid_id' => 'required|exists:bids,id',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status' => 'required|in:pending,confirmed,rejected',
        ]);

        $bid = Bid::findOrFail($request->bid_id);

        $imagePath = $request->file('image')->store('payments', 'public');

        Transaction::create([
            'user_id' => $validated['user_id'],
            'bid_id' => $validated['bid_id'],
            'nominal' => $bid->bid_price,
            'image' => $imagePath,
            'status' => $validated['status'],
        ]);

        return redirect()->route('auctions.index')->with('success', 'Transaction created successfully.');
    }

    public function show($id)
    {
        $transaction = Transaction::with(['user', 'bid'])->findOrFail($id);
        return view('transactions.show', compact('transaction'));
    }

    public function edit($id)
    {
        $transaction = Transaction::findOrFail($id);
        $users = User::all();
        $bids = Bid::all();
        return view('transactions.edit', compact('transaction', 'users', 'bids'));
    }

    public function update(Request $request, $id)
    {
        $transaction = Transaction::findOrFail($id);

        $validated = $request->validate([
            'user_id' => 'nullable|exists:users,id_user',
            'bid_id' => 'nullable|exists:bids,id',
            'nominal' => 'nullable|numeric|min:0',
            'image' => 'nullable|string',
            'status' => 'nullable|in:pending,confirmed,rejected',
        ]);

        $transaction->update($validated);

        return redirect()->route('transactions.index')->with('success', 'Transaction updated successfully.');
    }

    public function destroy($id)
    {
        $transaction = Transaction::findOrFail($id);
        $transaction->delete();

        return redirect()->route('transactions.index')->with('success', 'Transaction deleted successfully.');
    }
}