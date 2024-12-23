<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Auction;
use App\Models\Product;
use Illuminate\Http\Request;

class AuctionController extends Controller
{
    public function index()
    {
        $auctions = Auction::with('product', 'admin', 'winner')->get();
        return view('auctions.index', compact('auctions'));
    }

    public function create()
    {
        $products = Product::all();
        $admins = User::where('role', 'admin')->get();
        return view('auctions.create', compact('products', 'admins'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'admin_id' => 'required|exists:users,id_user',
            'status' => 'required|in:open,closed',
        ]);

        Auction::create([
            'product_id' => $request->product_id,
            'admin_id' => $request->admin_id,
            'status' => $request->status,
        ]);

        return redirect()->route('auctions.index')->with('success', 'Auction created successfully!');
    }

    public function show(Auction $auction)
    {
        return view('auctions.show', compact('auction'));
    }

    public function edit(Auction $auction)
    {
        $products = Product::all();
        return view('auctions.edit', compact('auction', 'products'));
    }

    public function update(Request $request, Auction $auction)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'status' => 'required|in:open,closed',
        ]);

        $auction->update([
            'product_id' => $request->product_id,
            'status' => $request->status,
        ]);

        return redirect()->route('auctions.index')->with('success', 'Auction updated successfully!');
    }

    public function destroy(Auction $auction)
    {
        $auction->delete();
        return redirect()->route('auctions.index')->with('success', 'Auction deleted successfully!');
    }

    public function selectWinner($auctionId)
    {
        $auction = Auction::with('bids')->findOrFail($auctionId);

        if ($auction->status != 'closed') {
            return redirect()->route('auctions.index')->with('error', 'Auction must be closed to select a winner.');
        }

        $winningBid = $auction->bids->sortByDesc('bid_price')->first();

        if ($winningBid) {
            $auction->winner_id = $winningBid->user_id;
            $auction->save();

            $auction->status = 'completed';
            $auction->save();

            return redirect()->route('auctions.index')->with('success', 'Winner selected successfully!');
        }

        return redirect()->route('auctions.index')->with('error', 'No bids placed in this auction.');
    }
}