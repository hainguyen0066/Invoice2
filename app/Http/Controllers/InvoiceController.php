<?php

namespace App\Http\Controllers;

use App\Models\Counter;
use Illuminate\Http\Request;
use App\Models\Invoice;
use App\Models\InvoiceItem;

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

    public function createInvoice(Request $request)
    {
        $counter = Counter::where('key', 'invoice')->first();
        $ramdom = Counter::where('key', 'invoice')->first();

        $invoice = Invoice::orderBy('id', 'DESC')->first();

        if ($invoice) {
            $invoice = $invoice->id + 1;
            $counters = $counter->value + $invoice;
        } else {
            $counters = $counter->value;
        }

        $formData = [
            'number' => $counter->prefix.$counters,
            'customer_id' => null,
            'customer' => null,
            'date' => date('Y-m-d'),
            'due_date' => null,
            'reference' => null,
            'discount' => 0,
            'term_and_conditons' => 'Default Terms and Conditions',
            'items' => [
                [
                    'product_id' => null,
                    'product' => null,
                    'unit_price'> 0,
                    'quantity' => 1,
                ]
            ]
        ];

        return response()->json($formData, 200);
    }

    public function addInvoice(Request $request)
    {
        $invoiceItem = $request->input('invoice_item');
        $invoiceData['sub_total'] = $request->input('sub_total');
        $invoiceData['total'] = $request->input('total');
        $invoiceData['customer_id'] = $request->input('customer_id');
        $invoiceData['number'] = $request->input('number');
        $invoiceData['date'] = $request->input('date');
        $invoiceData['due_date'] = $request->input('due_date');
        $invoiceData['discount'] = $request->input('discount');
        $invoiceData['reference'] = $request->input('reference');
        $invoiceData['terms_and_conditions'] = $request->input('terms_and_conditions');

        $invoice = Invoice::create($invoiceData);

        foreach (json_decode($invoiceItem) as $key => $item) {
            $itemData['product_id'] = $item->id;
            $itemData['invoice_id'] = $invoice->id;
            $itemData['quantity'] = $item->quantity;
            $itemData['unit_price'] = $item->unit_price;

            InvoiceItem::create($itemData);
        }
    }
}
