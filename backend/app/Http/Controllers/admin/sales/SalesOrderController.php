<?php

namespace App\Http\Controllers\admin\sales;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Company;
use DB;
use App\User;
use App\Sales;
use App\SalesItems;
use Auth;
use App\Product;
use App\PurchaseItem;
use App\UserRto;

class SalesOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Sales::where('created_by', Auth::getUser()->id)->get();
        return view('admin.sales.index')->with(compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $company = Company::get();

        $autoIncrementVal = DB::select('SELECT AUTO_INCREMENT FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA="inventory" AND TABLE_NAME="sales"');
	
		if(count($autoIncrementVal)>0) {
            $number = $autoIncrementVal[0]->AUTO_INCREMENT;
        }
        else {
            $number =0;
        }
		$num = $number + 1;
		$salesId = 'SO'.sprintf("%04d", $num);
        return view('admin.sales.create')->with(compact('company','salesId'));
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
            'role.*' => 'required',
            'user_id.*' => 'required',
            'company_id.*'  => 'required',
            'product_id.*'  => 'required',
            'quantity.*'  => 'required',
            'order_date' =>  'required'
        ],
        [  'product_id.*' => 'Product field is required',
            'company_id.*' => 'Company field is required',
            'role.*'  => 'Role field is required',
            'user_id.*'  => 'User field is required',
            'quantity.*'  => 'Quantity field is required',
        ]); 

        $data =  $request->all();
        $sale = array();
        $sale['order_number'] = $data['order_number'];
        $sale['order_date'] = $data['order_date'];
        $sale['created_by'] = Auth::getUser()->id;
        $saleId = Sales::create($sale);

        foreach($data['product_id'] as $va=>$key) {
            $saleItem = array();
            $saleItem['product_id'] = $key;
            $saleItem['user_id'] = $data['user_id'][$va];
            $saleItem['qty'] = $data['quantity'][$va];
            $saleItem['sales_id'] = $saleId->id;
            $saleItem['assigned_by'] = Auth::getUser()->id;
            SalesItems::create($saleItem);

        }
        return redirect('sales');
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

         $sale = Sales::where('id', $id)->with('items.user','items.product.unit')->first();
         foreach($sale->items as $va=>$key) {
            $key->allusers = User::where('role', $key->user->role)->get();
            $key->allproducts = Product::where('company_id', $key->product->company_id)->get();
            if(Auth::user()->isAdmin()) {
                $totalQty =  PurchaseItem::where('product_id', $key->product_id)->sum('qty');
                $saleQty =  SalesItems::where('product_id', $key->product_id)->where('assigned_by', Auth::getUser()->id)->sum('qty');
                $availableQty = $totalQty - $saleQty;
                if( $availableQty < 0) {
                    $availableQty = 0;
                }
            }  else if(Auth::user()->isDistributor())  {
                $totalQty =  SalesItems::where('user_id', Auth::getUser()->id)->where('product_id',$key->product_id)->sum('qty');
                $saleQty =  SalesItems::where('product_id', $key->product_id)->where('assigned_by', Auth::getUser()->id)->sum('qty');
                $availableQty = $totalQty - $saleQty;
                if( $availableQty < 0) {
                    $availableQty = 0;
                }
            }
            if($key->product->unit->name != 'Metre') {
                 $key->qty = round($key->qty);
            }
            $key->avilablepro = $availableQty;
            $key->totalqty = $totalQty;
            $key->saleqty = SalesItems::where('sales_id', '!=', $id)->where('product_id', $key->product_id)->where('assigned_by', Auth::getUser()->id)->sum('qty');
         }
        //return $sale;
        return view('admin.sales.edit')->with(compact('company','sale'));
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
            'role.*' => 'required',
            'user_id.*' => 'required',
            'company_id.*'  => 'required',
            'product_id.*'  => 'required',
            'quantity.*'  => 'required',
            'order_date' =>  'required'
        ],
        [  'product_id.*' => 'Product field is required',
            'company_id.*' => 'Company field is required',
            'role.*'  => 'Role field is required',
            'user_id.*'  => 'User field is required',
            'quantity.*'  => 'Quantity field is required',
        ]); 

        SalesItems::where('sales_id', $id)->delete();
        $data =  $request->all();

        foreach($data['product_id'] as $va=>$key) {
            $saleItem = array();
            $saleItem['product_id'] = $key;
            $saleItem['user_id'] = $data['user_id'][$va];
            $saleItem['qty'] = $data['quantity'][$va];
            $saleItem['sales_id'] = $id;
            $saleItem['assigned_by'] = Auth::getUser()->id;
            SalesItems::create($saleItem);

        }
        return redirect('sales');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $purchase = Sales::where('id', $id)->delete();
        return redirect('sales');
    }

    public function getUsers(Request $request)
    {
        $data = $request->all();

        if(Auth::user()->isAdmin()) {
            $users = User::where('role', $data['role_id'])->get();
        }  else if(Auth::user()->isDistributor())  {
            $rtos = UserRto::where('user_id', Auth::user()->id)->pluck('rto_id');
             
             $getDealers =  UserRto::where('user_id', '!=', Auth::user()->id)->whereHas('user', function($query) use($data){
                            $query->where('role',$data['role_id']);
             })->whereIn('rto_id',$rtos)->get();

            $users = array_pluck($getDealers, 'user');
        }

        return response()->json($users);

    }
}
