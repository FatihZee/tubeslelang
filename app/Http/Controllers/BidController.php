<?php

namespace App\Http\Controllers;

use App\Models\Bid;
use App\Models\User;
use App\Models\Auction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BidController extends Controller
{
    public function index($auctionId)
    {
        $auction = Auction::with('product')->findOrFail($auctionId);
        $user = User::find(Auth::id());

        $bids = Bid::where('auction_id', $auctionId)
                    ->where('user_id', Auth::id())
                    ->orderBy('bid_price', 'desc')
                    ->get();

        $highestBid = Bid::where('auction_id', $auctionId)
                        ->max('bid_price');

        return view('bids.index', compact('auction', 'bids', 'highestBid'));
    }

    public function create($auctionId)
    {
        $auction = Auction::with('product')->findOrFail($auctionId);
        return view('bids.create', compact('auction'));
    }

    public function store(Request $request, $auctionId)
    {
        $auction = Auction::with('product')->findOrFail($auctionId);

        $highestBid = Bid::where('auction_id', $auctionId)->max('bid_price');
        $minimumBid = max($highestBid + 1, $auction->product->price + 1);

        $request->validate([
            'bid_price' => 'required|numeric|min:' . $minimumBid,
        ]);

        Bid::create([
            'auction_id' => $auctionId,
            'user_id' => Auth::id(),
            'bid_price' => $request->bid_price,
            'bid_time' => now(),
        ]);

        return redirect()->route('bids.index', $auctionId)->with('success', 'Bid placed successfully.');
    }

    public function show($auctionId, $bidId)
    {
        $auction = Auction::findOrFail($auctionId);
        $bid = Bid::where('id', $bidId)->where('auction_id', $auctionId)->firstOrFail();

        return view('bids.show', compact('bid', 'auction'));
    }

    public function edit($auctionId, $bidId)
    {
        $auction = Auction::findOrFail($auctionId);
        $bid = Bid::where('id', $bidId)
                    ->where('auction_id', $auctionId)
                    ->where('user_id', Auth::id())
                    ->firstOrFail();

        return view('bids.edit', compact('auction', 'bid'));
    }

    public function update(Request $request, $auctionId, $bidId)
    {
        $auction = Auction::findOrFail($auctionId);
        $bid = Bid::where('id', $bidId)
                    ->where('auction_id', $auctionId)
                    ->where('user_id', Auth::id())
                    ->firstOrFail();

        $highestBid = Bid::where('auction_id', $auctionId)->max('bid_price');
        $minimumBid = max($highestBid + 1, $auction->product->price + 1);

        $request->validate([
            'bid_price' => 'required|numeric|min:' . $minimumBid,
        ]);

        $bid->update(['bid_price' => $request->bid_price]);

        return redirect()->route('bids.index', $auctionId)->with('success', 'Bid updated successfully.');
    }

    public function destroy($auctionId, $bidId)
    {
        $bid = Bid::where('id', $bidId)
                    ->where('auction_id', $auctionId)
                    ->where('user_id', Auth::id())
                    ->firstOrFail();

        $bid->delete();

        return redirect()->route('bids.index', $auctionId)->with('success', 'Bid deleted successfully.');
    }

    
}