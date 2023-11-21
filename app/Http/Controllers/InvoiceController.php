<?php

namespace App\Http\Controllers;

use App\Models\Counter;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
	public function getAllInvoices()
	{
		$invoices = Invoice::with('customer')->orderBy('id', 'DESC')->get();
		return response()->json([
			'invoices' => $invoices,
		], 200);
	}
	public function searchInvoice(Request $request)
	{
		$search = $request->get('s');

		if ($search != null) {
			$invoices = Invoice::with('customer')
				->where('id', 'LIKE', "%$search%")
				->orWhere(function ($query) use ($search) {
					$query->where('id', 'LIKE', $search)
						->whereNot('id', $search);
				})
				->get();
			return response()->json([
				"invoices" => $invoices
			], 200);
		} else {
			return $this->getAllInvoices();
		}
	}
	public function createInvoice(Request $request)
	{
		$counter = Counter::where('key', 'invoice')->first();
		$random = Counter::where('key', 'invoice')->first();

		$invoice = Invoice::orderBy('id', 'DESC')->first();
		if($invoice)
		{
			$invoice = $invoice->id + 1;
			$counters = $counter->value + $invoice;
		}else {
			$counters = $counter->value;
		}

		$formData = [
			'number'=>$counter->prefix.$counters,
			'customer_id'=>null,
			'customer'=>null,
			'date'=>date('Y-m-d'),
			'due_date'=>null,
			'reference'=>null,
			'discount'=>0,
			'terms_and_conditions'=>'terms_and_conditions',
			'items'=>[
				[
					'product_id'=>null,
					'product'=>null,
					'unit_price'=>0,
					'quantity'=>1,

				]
			]
		];
		return response()->json($formData);
	}
	
	public function addInvoice(Request $request)
	{
		$invoiceItem = $request->input('invoice_item');
		
		$invoiceData['customer_id'] = $request->input('customerId');
		$invoiceData['date'] = $request->input('date');
		$invoiceData['due_date'] = $request->input('due_date');
		$invoiceData['number'] = $request->input('number');
		$invoiceData['reference'] = $request->input('reference');
		$invoiceData['discount'] = $request->input('discount');
		$invoiceData['sub_total'] = $request->input('subtotal');
		$invoiceData['total'] = $request->input('total');
		$invoiceData['terms_and_conditions'] = $request->input('terms_and_conditions');

		$invoice = Invoice::create($invoiceData);

		foreach(json_decode($invoiceItem) as $item)
		{
			$itemData['product_id'] = $item->id;
			$itemData['invoice_id'] = $invoice->id;
			$itemData['quantity'] = $item->quantity;
			$itemData['unit_price'] = $item->unit_price;

			InvoiceItem::create($itemData);
		}
	}

	public function getInvoice($id){

		$invoice = Invoice::with(['customer','invoice_items.product'])->find($id);

		return response()->json([
			'invoice' => $invoice
		], 200);
	}

	public function getEditInvoice($id)
	{
		$invoice = Invoice::with(['customer','invoice_items.product'])->find($id);

		return response()->json([
			'invoice' => $invoice
		], 200);
	}

	public function deleteInvoiceItems($id)
	{
		$invoiceItem=InvoiceItem::findOrFail($id);
		$invoiceItem->delete();
	}

	public function updateInvoice(Request $request, $id)
	{
		$invoice = Invoice::where('id',$id)->first();

		$invoice->sub_total = $request->subtotal;
		$invoice->customer_id = $request->customer_id;
		$invoice->date = $request->date;
		$invoice->due_date = $request->due_date;
		$invoice->number = $request->number;
		$invoice->reference = $request->reference;
		$invoice->discount = $request->discount;
		$invoice->terms_and_conditions = $request->terms_and_conditions;
		$invoice->update($request->all());

		$invoiceItem= $request->input("invoice_item");
		
		$invoice->invoice_items()->delete();

		foreach(json_decode($invoiceItem) as $item)
		{
			$itemData['product_id'] = $item->product_id;
			$itemData['invoice_id'] = $invoice->id;
			$itemData['quantity'] = $item->quantity;
			$itemData['unit_price'] = $item->unit_price;

			InvoiceItem::create($itemData);
		}
	}

	public function deleteInvoice($id)
	{
		$invoice = Invoice::findOrFail($id);
		$invoice->invoice_items()->delete();
		$invoice->delete();
	}
}
