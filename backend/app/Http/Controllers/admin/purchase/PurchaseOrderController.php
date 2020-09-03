<?php

namespace App\Http\Controllers\admin\purchase;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Company;
use App\Product;
use DB;
use App\Purchase;
use App\PurchaseItem;

class PurchaseOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Purchase::get();
        return view('admin.purchase.index')->with(compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $company = Company::get();

        $autoIncrementVal = DB::select('SELECT AUTO_INCREMENT FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA="inventory" AND TABLE_NAME="purchases"');
	
		if(count($autoIncrementVal)>0) {
            $number = $autoIncrementVal[0]->AUTO_INCREMENT;
        }
        else {
            $number =0;
        }
		$num = $number + 1;
		$purchaseId = 'PO'.sprintf("%04d", $num);
        return view('admin.purchase.create')->with(compact('company','purchaseId'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'product_id.*' => 'required',
            'company_id.*' => 'required',
            'quantity.*'  => 'required',
            'order_date' =>  'required'
        ],
        [  'product_id.*' => 'Product field is required',
            'company_id.*' => 'Company field is required',
            'quantity.*'  => 'Quantity field is required',
        ]); 
                                             
        $data =  $request->all();

        $purchase = array();
        $purchase['order_number'] = $data['order_number'];
        $purchase['order_date'] = $data['order_date'];
        $purchaseId = Purchase::create($purchase);
        
        foreach ($data['company_id'] as $va=>$key) {
            $items = array();
            $items['purchase_id'] = $purchaseId->id;
            $items['company_id'] = $data['company_id'][$va];
            $items['product_id'] = $data['product_id'][$va];
            $items['qty'] = $data['quantity'][$va];
            PurchaseItem::create($items);
        }

        return redirect('admin/purchase');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $company = Company::get();

         $purchase = Purchase::where('id', $id)->with('items')->first();
         //return $purchase->items;
        return view('admin.purchase.edit')->with(compact('company','purchase'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'product_id.*' => 'required',
            'company_id.*' => 'required',
            'quantity.*'  => 'required',
            'order_date' =>  'required'
        ],
        [  'product_id.*' => 'Product field is required',
            'company_id.*' => 'Company field is required',
            'quantity.*'  => 'Quantity field is required',
        ]); 
                                             
        $data =  $request->all();
        
        PurchaseItem::where('purchase_id', $id)->delete();

        foreach ($data['company_id'] as $va=>$key) {
            $items = array();
            $items['purchase_id'] = $id;
            $items['company_id'] = $data['company_id'][$va];
            $items['product_id'] = $data['product_id'][$va];
            $items['qty'] = $data['quantity'][$va];
            PurchaseItem::create($items);
        }

        return redirect('admin/purchase');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $purchase = Purchase::where('id', $id)->delete();
        return redirect('admin/purchase');

    }

    public function getProduct(Request $request){

        $data = Product::where('company_id', $request->company_id)->get();
        return response()->json($data);

    }
}
