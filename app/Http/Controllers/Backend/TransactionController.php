<?php

namespace App\Http\Controllers\Backend;

use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Exports\TransactionExport;
use App\Http\Controllers\Controller;
use App\Http\Services\FileService;
use App\Mail\BookingMailConfirm;
use App\Models\Review;
use Illuminate\Support\Facades\Mail;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Session;

class TransactionController extends Controller
{
    public function __construct(private FileService $fileService) {}

    public function index()
    {
        session(['role' => auth()->user()->name]);
        $transactions = Transaction::latest()->paginate(10);

        return view('backend.transaction.index', [
            'transactions' => $transactions]);


    }

    public function show(string $uuid)
    {
        $transaction = Transaction::where('uuid', $uuid)->firstOrFail();
        $review = Review::where('transaction_id', $transaction->id)->first();


        return view('backend.transaction.show', [
            'transaction' => $transaction,
            'review' => $review
        ]);
    }

    public function update(Request $request, string $id)
    {
        $this->authorizeAction();

        $data = $request->validate(['status' => 'required|in:pending,success,failed']);
        try {
            $transaction = Transaction::where('uuid', $id)->firstOrFail();
            $transaction->status = $data['status'];
            $transaction->save();

            Mail::to($transaction->email)
                ->cc('operator@gmail.com')
                ->send(new BookingMailConfirm($transaction));

            return redirect()->back()->with('success', 'Transaction status updated successfully');
        } catch (\Exception $error) {
            return redirect()->back()->with('error', $error->getMessage());
        }
    }

    public function destroy(string $id)
    {
        $this->authorizeAction();

        $transaction = Transaction::where('uuid', $id)->firstOrFail();
        $this->fileService->delete($transaction->file);
        $transaction->delete();

        return response()->json(['message' => 'Transaction has been deleted']);
    }

    public function download(Request $request)
    {

        $data = $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date'
        ]);

        try {
            return Excel::download(new TransactionExport($data['start_date'], $data['end_date']), 'transactions.xlsx');
        } catch (\Exception $error) {
            return redirect()->back()->with('error', $error->getMessage());
        }
    }

    private function authorizeAction()
    {
        // dd(session('role'));
        if (session('role') !== "Operator") {
            abort(403, 'Unauthorized action.');
        }
    }
}
