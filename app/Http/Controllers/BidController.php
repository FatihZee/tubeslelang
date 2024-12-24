<?php

namespace App\Http\Controllers;

use App\Models\Bid;
use App\Models\User;
use App\Models\Auction;
use Barryvdh\DomPDF\PDF;
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

    public function exportPdf($auctionId)
    {
        $user = Auth::user();
        $auction = Auction::with(['product', 'admin', 'winner'])->findOrFail($auctionId);

        // Ambil bids yang terkait dengan auction ini
        if ($user->role === 'admin') {
            // Admin bisa melihat semua bid untuk auction ini
            $bids = Bid::where('auction_id', $auctionId)
                    ->with('user') // Memastikan bid memiliki relasi dengan User
                    ->orderBy('bid_price', 'desc')
                    ->get();
        } else {
            // Member hanya bisa melihat bid yang mereka buat
            $bids = Bid::where('auction_id', $auctionId)
                    ->where('user_id', auth()->user()->id_user) // Hanya mengambil bid milik user yang login
                    ->with('user') // Memastikan bid memiliki relasi dengan User
                    ->orderBy('bid_price', 'desc')
                    ->get();
        }

        // Generate PDF
        $pdf = app(PDF::class);
        $pdf->loadView('bids.export-pdf', compact('auction', 'bids'));
        return $pdf->download('auction-report.pdf');
    }

}