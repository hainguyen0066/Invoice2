<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Invoice;
use Illuminate\Contracts\Routing\ResponseFactory;

class InvoiceController extends Controller
{
    public function getAllInvoices()
    {
        $invoices = Invoice::with('customer')->orderBy('id', 'DESC')->get();

        return response()->json([
            'invoices' => $invoices
        ], 200);
    }

    public function searchInvoice(Request $request)
    {
        $serachParams = $request->get('s');

        if ($serachParams != null) {
            $invoices = Invoice::with('customer')->where('id', 'LIKE', "%$serachParams%")->get();

            return response()->json([
                'invoices' => $invoices
            ], 200);
        } else {
            return $this->getAllInvoices();
        }

    }
}
