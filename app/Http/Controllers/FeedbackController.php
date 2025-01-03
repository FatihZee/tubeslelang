<?php

namespace App\Http\Controllers;

use App\Models\Feedback;
use Barryvdh\DomPDF\PDF;
use Illuminate\Support\Facades\Auth;
use App\Models\Transaction;
use Illuminate\Http\Request;

class FeedbackController extends Controller
{
    public function index()
    {
        if (Auth::user()->role === 'admin') {
            // Admin dapat melihat semua feedback
            $feedbacks = Feedback::with(['user', 'transaction'])->get();
        } else {
            // Member hanya dapat melihat feedback mereka sendiri
            $feedbacks = Feedback::with(['user', 'transaction'])
                ->where('user_id', Auth::id())
                ->get();
        }

        return view('feedbacks.index', compact('feedbacks'));
    }


    public function create(Request $request)
    {
        $transactionId = $request->query();
        $transactionId = array_key_first($transactionId);
        
        if (!$transactionId) {
            abort(404, 'Transaction ID is required.');
        }

        $transaction = Transaction::findOrFail($transactionId);
        return view('feedbacks.create', compact('transaction'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'transaction_id' => 'required|exists:transactions,id',
            'feedback' => 'required|string|max:5000',
        ]);

        Feedback::create([
            'user_id' => auth()->user()->id_user,
            'transaction_id' => $request->transaction_id,
            'feedback' => $request->feedback,
        ]);

        return redirect()->route('auctions.index')->with('success', 'Feedback submitted successfully.');
    }

    public function edit($id)
    {
        $feedback = Feedback::findOrFail($id);
        return view('feedbacks.edit', compact('feedback'));
    }

    public function update(Request $request, $id)
    {
        $feedback = Feedback::findOrFail($id);

        $request->validate([
            'feedback' => 'required|string|max:5000',
        ]);

        $feedback->update([
            'feedback' => $request->feedback,
        ]);

        return redirect()->route('feedbacks.index')->with('success', 'Feedback updated successfully.');
    }

    public function destroy($id)
    {
        $feedback = Feedback::findOrFail($id);
        $feedback->delete();

        return redirect()->route('feedbacks.index')->with('success', 'Feedback deleted successfully.');
    }

    public function show($id)
    {
        $feedback = Feedback::with(['user', 'transaction'])->findOrFail($id);
        return view('feedbacks.show', compact('feedback'));
    }

    public function exportPdf()
    {
        $feedbacks = Feedback::with(['user', 'transaction'])->get();
        $pdf = app(PDF::class);
        $pdf->loadView('feedbacks.export-pdf', compact('feedbacks'));
        return $pdf->download('feedbacks-list.pdf');
    }
}