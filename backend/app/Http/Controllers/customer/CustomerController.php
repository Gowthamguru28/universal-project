<?php

namespace App\Http\Controllers\customer;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\SalesItems;
use Auth;
use App\customerTape;
use App\UserRto;
use App\customerForm;
use App\customerImage;


class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Auth::user()->isRto()) {
            $data = customerForm::where('rto_id', Auth::getUser()->id)->get();
        } else {
            $data = customerForm::where('user_id', Auth::getUser()->id)->get();
        }
        return view('customer.index')->with(compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $rto =  UserRto::where('user_id', Auth::getUser()->id)->with('rto')->first();
        $data =  SalesItems::with('product.unit')->where('user_id', Auth::getUser()->id)->groupBy('product_id')->get();
        foreach ($data as $va=>$key) {
            $sales = SalesItems::where('user_id', Auth::getUser()->id)->where('product_id', $key->product_id)->sum('qty');
            $key->avilable_qty =  $sales - customerTape::where('product_id', $key->product_id)->where('user_id', $key->user_id)->sum('qty');

        }
       //return $data;
        return view('customer.create')->with(compact('data', 'rto'));
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
                'date' => 'required',
                'vehicle_no' => 'required',
                'vehicle_year'  => 'required',
                'class_no' =>  'required',
                'engine_no' =>  'required',
                'vehicle_make' =>  'required',
                'vehicle_model' =>  'required',
                'owner_name' => 'required',
                'phone' => 'required',
                'address' => 'required',
                'rto_id' => 'required',
                'class_3' => 'required',
                'class_4' => 'required',
                'front_image' => 'required',
                'left_image' => 'required',
                'right_image' => 'required',
                'back_image' => 'required',
            ]
        ); 
        $data = $request->all();
       $customer = array();
       $customer['date'] = $data['date'];
       $customer['vehicle_no'] = $data['vehicle_no'];
       $customer['vehicle_year'] = $data['vehicle_year'];
       $customer['class_no'] = $data['class_no'];
       $customer['engine_no'] = $data['engine_no'];
       $customer['vehicle_make'] = $data['vehicle_make'];
       $customer['vehicle_model'] = $data['vehicle_model'];
       $customer['owner_name'] = $data['owner_name'];
       $customer['phone'] = $data['phone'];
       $customer['address'] = $data['address'];
       $customer['rto_id'] = $data['rto_id'];
       $customer['class_3'] = $data['class_3'];
       $customer['class_4'] = $data['class_4'];
       $customer['user_id'] = Auth::getUser()->id;
       $customer['created_at'] = date('Y-m-d H:i:s');
       $customer['updated_at'] = date('Y-m-d H:i:s');
       //return $customer;
       $insert = customerForm::insertGetId($customer);

      foreach($data['product'] as $va=>$key) {
        $tape = array();
        $tape['customer_id'] = $insert;
        $tape['product_id'] = $key;
        $tape['user_id'] = Auth::getUser()->id;
        $tape['qty'] = $data['quantity'][$va];
        $tape['created_at'] = date('Y-m-d H:i:s');
        $tape['updated_at'] = date('Y-m-d H:i:s');
        customerTape::insert($tape);
      }

      $image = [];
      $fileName = "FR".time().'.'.$request->front_image->extension();  
      $request->front_image->move(public_path('uploads/customer'), $fileName);
      $image['front_image'] =  $fileName;

      $fileName = "LR".time().'.'.$request->left_image->extension();  
      $request->left_image->move(public_path('uploads/customer'), $fileName);
      $image['left_image'] =  $fileName;

      $fileName = "RR".time().'.'.$request->right_image->extension();  
      $request->right_image->move(public_path('uploads/customer'), $fileName);
      $image['right_image'] =  $fileName;

      $fileName = "BR".time().'.'.$request->back_image->extension();  
      $request->back_image->move(public_path('uploads/customer'), $fileName);

      $image['back_image'] =  $fileName;
      $image['customer_id'] = $insert;
      $image['created_at'] = date('Y-m-d H:i:s');
      $image['updated_at'] = date('Y-m-d H:i:s');
      customerImage::insert($image);
      return redirect('customer');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
         $data =  customerForm::with('images', 'tapes.product.unit', 'rto')->where('id', $id)->first();
         return view('customer.view')->with(compact('data'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data =  customerForm::with('images', 'tapes', 'rto')->where('id', $id)->first();
        $product =  SalesItems::with('product.unit')->where('user_id', Auth::getUser()->id)->groupBy('product_id')->get();
        foreach ($product as $va=>$key) {
            $sales = SalesItems::where('user_id', Auth::getUser()->id)->where('product_id', $key->product_id)->sum('qty');
            $key->avilable_qty =  $sales - customerTape::where('product_id', $key->product_id)->where('user_id', $key->user_id)->sum('qty');

        }
        //return $product;
        return view('customer.edit')->with(compact('data','product'));
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
                    'date' => 'required',
                    'vehicle_no' => 'required',
                    'vehicle_year'  => 'required',
                    'class_no' =>  'required',
                    'engine_no' =>  'required',
                    'vehicle_make' =>  'required',
                    'vehicle_model' =>  'required',
                    'owner_name' => 'required',
                    'phone' => 'required',
                    'address' => 'required',
                    'rto_id' => 'required',
                    'class_3' => 'required',
                    'class_4' => 'required',
                    // 'front_image' => 'required',
                    // 'left_image' => 'required',
                    // 'right_image' => 'required',
                    // 'back_image' => 'required',
                 ]
             ); 
            $data = $request->all();

                $image = [];
            if(!isset($request->frontUploadedName )) {
                $validatedData = $request->validate([
                    'front_image' => 'required',
                ]); 
               // return $request;
                $fileName = "FR".time().'.'.$request->front_image->extension();  
                $request->front_image->move(public_path('uploads/customer'), $fileName);
                $image['front_image'] =  $fileName;
            } 
            if(!isset($request->backUploadedName )) {
                $validatedData = $request->validate([
                    'back_image' => 'required',
                ]); 
               // return $request;
                $fileName = "BR".time().'.'.$request->back_image->extension();  
                $request->back_image->move(public_path('uploads/customer'), $fileName);
                $image['back_image'] =  $fileName;
            } 
            if(!isset($request->leftUploadedName )) {
                $validatedData = $request->validate([
                    'left_image' => 'required',
                ]); 
               // return $request;
                $fileName = "LR".time().'.'.$request->left_image->extension();  
                $request->left_image->move(public_path('uploads/customer'), $fileName);
                $image['left_image'] =  $fileName;
            } 
            if(!isset($request->rightUploadedName )) {
                $validatedData = $request->validate([
                    'right_image' => 'required',
                ]); 
               // return $request;
                $fileName = "RR".time().'.'.$request->right_image->extension();  
                $request->right_image->move(public_path('uploads/customer'), $fileName);
                $image['right_image'] =  $fileName;
            } 
            if(count($image) >0 ) {
                customerImage::where('customer_id', $id)->update($image);
            }
            $customer = array();
            $customer['date'] = $data['date'];
            $customer['vehicle_no'] = $data['vehicle_no'];
            $customer['vehicle_year'] = $data['vehicle_year'];
            $customer['class_no'] = $data['class_no'];
            $customer['engine_no'] = $data['engine_no'];
            $customer['vehicle_make'] = $data['vehicle_make'];
            $customer['vehicle_model'] = $data['vehicle_model'];
            $customer['owner_name'] = $data['owner_name'];
            $customer['phone'] = $data['phone'];
            $customer['address'] = $data['address'];
            $customer['rto_id'] = $data['rto_id'];
            $customer['class_3'] = $data['class_3'];
            $customer['class_4'] = $data['class_4'];
            $customer['user_id'] = Auth::getUser()->id;
            $customer['created_at'] = date('Y-m-d H:i:s');
            $customer['updated_at'] = date('Y-m-d H:i:s');
            //return $customer;
            customerForm::where('id', $id)->update($customer);


            customerTape::where('customer_id', $id)->delete();
            foreach($data['product'] as $va=>$key) {
                $tape = array();
                $tape['customer_id'] = $id;
                $tape['product_id'] = $key;
                $tape['user_id'] = Auth::getUser()->id;
                $tape['qty'] = $data['quantity'][$va];
                $tape['created_at'] = date('Y-m-d H:i:s');
                $tape['updated_at'] = date('Y-m-d H:i:s');
                customerTape::insert($tape);
            }
            return redirect('customer');
            // $image = [];
            // $fileName = "FR".time().'.'.$request->front_image->extension();  
            // $request->front_image->move(public_path('uploads/customer'), $fileName);
            // $image['front_image'] =  $fileName;

            // $fileName = "LR".time().'.'.$request->left_image->extension();  
            // $request->left_image->move(public_path('uploads/customer'), $fileName);
            // $image['left_image'] =  $fileName;

            // $fileName = "RR".time().'.'.$request->right_image->extension();  
            // $request->right_image->move(public_path('uploads/customer'), $fileName);
            // $image['right_image'] =  $fileName;

            // $fileName = "BR".time().'.'.$request->back_image->extension();  
            // $request->back_image->move(public_path('uploads/customer'), $fileName);

            // $image['back_image'] =  $fileName;
            // $image['customer_id'] = $insert;
            // $image['created_at'] = date('Y-m-d H:i:s');
            // $image['updated_at'] = date('Y-m-d H:i:s');
            // customerImage::insert($image);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        customerForm::where('id', $id)->delete();
        return redirect('customer');
    }
    public function statusUpdate(Request $request)
    {
        customerForm::where('id', $request->customer_id)->update(['status'=>$request->status ]);
        return redirect('customer');
    }
}
