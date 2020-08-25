<?php

namespace App\Http\Controllers\admin\product;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Product;
use App\Company;
use App\Unit;
use Illuminate\Validation\Rule;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Product::with('company')->get();
        return view('admin.product.index')->with('data', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $company = Company::get();
        $unit = Unit::get();
        return view('admin.product.create')->with(compact('company', 'unit'));
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
            'name' => 'required',
            'company_id' => ['required', Rule::unique('products')->where(function ($query) use ($request) {
                return $query
                    ->where('name', $request->name)
                    ->where('company_id', $request->company_id);
                })],
                'unit_id' => 'required'
                ],  [
                'company_id.unique'=> 'This Company already mapped with this Product'
             ]); 
        $data = request()->except(['_token','_method']);
        Product::insert($data);
        return redirect('admin/product');
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
        $data =  Product::where('id',$id)->first();
        $company = Company::get();
        $unit = Unit::get();
        return view('admin.product.edit')->with(compact('data','company','unit'));
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
            'name' => 'required',
            'company_id' => ['required', Rule::unique('products')->where(function ($query) use ($request,$id) {
                return $query
                    ->where('id', '!=', $id)
                    ->where('name', $request->name)
                    ->where('company_id', $request->company_id);
            })],
            'unit_id' => 'required'
        ], 
        [
            'company_id.unique'=> 'This Company already mapped with this Product'
        ]);

        $data = request()->except(['_token','_method']);
        Product::where('id', $id)->update($data);
        return redirect('admin/product');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Product::where('id', $id)->delete();
        return redirect('admin/product');
    }
}
