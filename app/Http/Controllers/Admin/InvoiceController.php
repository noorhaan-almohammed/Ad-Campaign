<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Invoice;

class InvoiceController extends Controller
{
    public function index()
    {
        $invoices = Invoice::latest()->paginate(15);
        return view('admin.invoices.index', compact('invoices'));
    }

    public function show(Invoice $invoice)
    {
        return view('admin.invoices.show', compact('invoice'));
    }

    public function markPaid(Invoice $invoice)
    {
        $invoice->update(['status' => 'paid']);
        return back()->with('success', 'Invoice marked as paid.');
    }
}
