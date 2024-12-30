<?php

namespace App\Http\Controllers;

use App\Models\Bid;
use App\Models\User;
use App\Models\Auction;
use Barryvdh\DomPDF\PDF;
use App\Models\Transaction;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function index(Request $request)
    {
        $query = Transaction::with(['user', 'bid']);

        if ($request->has('search')) {
            $search = $request->input('search');
            $query->whereHas('user', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%");
            })->orWhereHas('bid', function ($q) use ($search) {
                $q->where('id', 'like', "%{$search}%");
            })->orWhere('id', 'like', "%{$search}%")
              ->orWhere('nominal', 'like', "%{$search}%")
              ->orWhere('status', 'like', "%{$search}%");
        }

        if ($request->has('perPage')) {
            $perPage = $request->input('perPage');
        } else {
            $perPage = 10;
        }

        $transactions = $query->paginate($perPage);

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

    //exportPdf
    public function exportPdf()
    {
        $transactions = Transaction::with(['user', 'bid'])->get();
        $pdf = app(PDF::class);
        $pdf->loadView('transactions.export-pdf', compact('transactions'));
        return $pdf->download('transactions.pdf');
    }

    public function exportCsv()
    {
        $transactions = Transaction::with(['user', 'bid'])->get();

        $headers = [
            "Content-type" => "text/csv",
            "Content-Disposition" => "attachment; filename=transactions.csv",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        ];

        $callback = function() use ($transactions) {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, ['ID', 'User Name', 'Bid ID', 'Nominal', 'Status', 'Created At']);

            foreach ($transactions as $transaction) {
                fputcsv($handle, [
                    $transaction->id,
                    $transaction->user->name,
                    $transaction->bid->id,
                    $transaction->nominal,
                    $transaction->status,
                    $transaction->created_at->format('Y-m-d H:i:s')
                ]);
            }

            fclose($handle);
        };

        return response()->stream($callback, 200, $headers);
    }
}