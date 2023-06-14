<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Supplier;
use App\Product;
use App\SupplierInvoice;
use App\Settings;
use Auth;
use DB;

class SupplierInvoiceController extends Controller
{

	public function index(){
        
		$suppliers = Supplier::where('status', 1)->get();
        
		return view('admin.supplierInvoice.getSupplierForInvoice',['suppliers' => $suppliers]);
	}

	public function invoice(Request $request){

		$validatedData = $request->validate([
            'supplier' => 'required',
        ]); 

         return redirect('/supplier/invoiceadd/'.$request->supplier);

    }

	public function getSupplier(){

		$suppliers = Supplier::where('status', 1)->get();

		return view('admin.supplierInvoice.supplierInvoiceAdd',['suppliers' => $suppliers, 'invoice_number' => $invoice_number, 'supplierId' => $id, 'medicines' => $medicines]);

	}
      
    public function invoiceadd($id){

        $supplier = Supplier::where('id', $id)->first();

        $medicines = Product::where('status', 1)->where('supplier_id','=',$id)->get();

        $digits = 6;

        $invoice_number = 'INV'.rand(pow(10, $digits-1), pow(10, $digits)-1);

        $today = date("d/m/Y");

        $settings = Settings::first();

        return view('admin.supplierInvoice.templateSupplierInvoice',['supplier' => $supplier, 'invoice_number' => $invoice_number, 'supplierId' => $id, 'medicines' => $medicines, 'invoiceDate' => $today, 'settings' => $settings]);

    }
    public function invoiceCreate(Request $request){
        

    	$invoice_number = $request->invoice_number;

    	$product = $request->product;

    	$qty = $request->qty;

    	$price = $request->price;

    	$discount = $request->discount;

    	$total = $request->total;

    	$sub_total = $request->sub_total;

    	$discount_amount = $request->discount_amount;

    	$tax_amount = $request->tax_amount;

        $total_amount = $request->total_amount;

    	$discountType = $request->discountType;

    	$datas = [];

    	$today = date("d/m/Y");
        
        $invoice = new SupplierInvoice();

        $invoice->invoice_no =  $invoice_number;

        $invoice->company_id =  $request->supplier;

		$invoice->sum_subtotal = $sub_total;

		$invoice->sum_grandtotal = $total_amount;

		$invoice->sum_discount = $discount_amount;

		$invoice->tax_amount = $tax_amount;

		$invoice->tax_percent = $request->taxPercent;

        $invoice->created_by = Auth::user()->id;

        $invoice->created_at  = date("Y-m-d");

        
        $invoice->save();

        $lastInvId = $invoice->id;

        foreach($request->product as $key=>$value) {

            $discountMat = 0;

            $discountAmt = 0;

            if($discountType[$key] == "fixed"){

                $discountMat = $discount[$key];

                $discountAmt = $total[$key] - $discount[$key];
            }else{

                $discountMat = ($qty[$key] * $price[$key]) + (($discount[$key] / 100) * ($qty[$key] * $price[$key]));

                $discountAmt = ($qty[$key] * $price[$key]) - (($discount[$key] / 100) * ($qty[$key] * $price[$key]));

            }

            $datas['product'][] = array(
                'invoice_id' => $lastInvId,
                'invoice_no' => $invoice_number,
                'product_id' => $value,
                'qty_product' => $qty[$key],
                'unit_price' => $price[$key],
                'subtotal_product' => $total[$key],
                'discount_type' => $discountType[$key],
                'discount_product' => $discount[$key] ?? 0,
                'grandtotal_product' => $discountAmt,
                
            );
        }

		DB::table('supplier_invoice_productinfo')->insert($datas['product']);

        return redirect('/supplier/details/'.$invoice_number.'/'.$request->supplier);

    }

    public function print($invoice, $id)
    {
    	$supplier = Supplier::where('id', $id)->first();

    	$invoices = DB::table('supplier_invoices')->where('invoice_no', $invoice)->first();

        $products = DB::table('supplier_invoice_productinfo')->where('invoice_no', $invoice)->get();

        $settings = Settings::first();

    	return view('admin.supplierInvoice.printSupplierInvoice',['supplier' => $supplier, 'invoice' => $invoices, 'products' => $products, 'settings' => $settings]);

    }
    public function invoicelist()
    {
		$listData = DB::table('supplier_invoices')->paginate(5);

		return view('admin.supplierInvoice.supplierInvoiceList',['listData' => $listData]);

    }

    public function details($invoice, $id)
    {
    	$supplier = Supplier::where('id', $id)->first();

    	$invoices = DB::table('supplier_invoices')->where('invoice_no', $invoice)->first();

        $products = DB::table('supplier_invoice_productinfo')->where('invoice_no', $invoice)->get();

        $settings = Settings::first();

    	return view('admin.supplierInvoice.detailsSupplierInvoice',['supplier' => $supplier, 'invoice' => $invoices, 'products' => $products, 'settings' => $settings]);
    }

    public function delete($id){

        $invoices = DB::table('supplier_invoices')->where('id', $id)->delete();

        $products = DB::table('supplier_invoice_productinfo')->where('invoice_id', $id)->delete();

        return redirect('/supplier/invoicelist')->with('message','Deleted Successfully.');
    }

}
