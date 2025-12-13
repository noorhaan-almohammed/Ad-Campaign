<?php
namespace App\Http\Controllers\Advertiser;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use Illuminate\Support\Facades\Auth;

class InvoiceController extends Controller
{
    public function index()
    {
        $invoices = Invoice::where('user_id', Auth::id())->latest()->paginate(10);

        return view('advertiser.invoices.index', compact('invoices'));
    }

    public function show(Invoice $invoice)
    {
        if ($invoice->user_id !== Auth::id()) {
            abort(403);
        }

        return view('advertiser.invoices.show', compact('invoice'));
    }
}
