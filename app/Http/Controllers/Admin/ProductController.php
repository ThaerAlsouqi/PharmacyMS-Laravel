<?php

namespace App\Http\Controllers\Admin;

use App\Models\Product;
use App\Models\Purchase;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Yajra\DataTables\DataTables;
use App\Http\Controllers\Controller;
use QCod\AppSettings\Setting\AppSettings;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $title = 'products';
        if ($request->ajax()) {
            $products = Product::latest();
            return DataTables::of($products)
                ->addColumn('product',function($product){
                    $image = '';
                    if(!empty($product->purchase)){
                        $image = null;
                        if(!empty($product->purchase->image)){
                            $image = '<span class="avatar avatar-sm mr-2">
                            <img class="avatar-img" src="'.asset("storage/purchases/".$product->purchase->image).'" alt="image">
                            </span>';
                        }
                        return $product->purchase->product. ' ' . $image;
                    }                 
                })
                
                ->addColumn('category',function($product){
                    $category = null;
                    if(!empty($product->purchase->category)){
                        $category = $product->purchase->category->name;
                    }
                    return $category;
                })
                ->addColumn('price',function($product){                   
                    return settings('app_currency','$').' '. $product->price;
                })
                ->addColumn('quantity',function($product){
                    if(!empty($product->purchase)){
                        return $product->purchase->quantity;
                    }
                })
                ->addColumn('expiry_date',function($product){
                    if(!empty($product->purchase)){
                        return date_format(date_create($product->purchase->expiry_date),'d M, Y');
                    }
                })
                ->addColumn('action', function ($row) {
                    $editbtn = '<a href="'.route("products.edit", $row->id).'" class="editbtn"><button class="btn btn-info"><i class="fas fa-edit"></i></button></a>';
                    $deletebtn = '<a data-id="'.$row->id.'" data-route="'.route('products.destroy', $row->id).'" href="javascript:void(0)" id="deletebtn"><button class="btn btn-danger"><i class="fas fa-trash"></i></button></a>';
                    
                    // Check permissions with fallback
                    // if (!auth()->check() || !auth()->user()->hasPermissionTo('edit-product')) {
                    //     $editbtn = '';
                    // }
                    // if (!auth()->check() || !auth()->user()->hasPermissionTo('destroy-purchase')) {
                    //     $deletebtn = '';
                    // }
                    
                    $btn = $editbtn.' '.$deletebtn;
                    return $btn;
                })
                ->rawColumns(['product','action'])
                ->make(true);
        }
        return view('admin.products.index',compact(
            'title'
        ));
    }
    

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
   public function create()
{
    $title = 'Add Product';
    $purchases = Purchase::get();
    return view('admin.products.create', compact('title', 'purchases'));
}

public function store(Request $request)
{
    $this->validate($request, [
           'product' => 'required|exists:purchases,id',
            'margin' => 'required|numeric|min:0|max:1000',
            'minimum_stock' => 'required|integer|min:1',
            'description' => 'nullable|max:255'
    ]);

    $purchase = Purchase::findOrFail($request->product);
    $cost_price = $purchase->cost_price;
    $margin = $request->margin ?? 0;
    $price = $cost_price + ($cost_price * ($margin / 100));

    Product::create([
        'purchase_id' => $purchase->id,
        'price' => $price,
        'margin' => $margin,
        'description' => $request->description,
    ]);

     $purchase->update(['minimum_stock' => $request->minimum_stock]);


    $notification = notify("Product has been added");
    return redirect()->route('products.index')->with($notification);
}


    
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \app\Models\Product $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        $title = 'edit product';
        $purchases = Purchase::get();
        return view('admin.products.edit',compact(
            'title','product','purchases'
        ));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \app\Models\Product $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        $this->validate($request,[
            'product' => 'required|max:200',
            'margin' => 'nullable|numeric', 
            'description' => 'nullable|max:255',
        ]);
    
        $cost_price = Purchase::findOrFail($request->product)->cost_price;
        $price = $request->price;
        $margin = 0;
        
        if ($request->margin > 0) {
            $margin = $cost_price + ($cost_price * ($request->margin / 100));
        }
        $price = $price + $margin;
        
        $product->update([
            'purchase_id' => $request->product,
            'price' => $price,
            'margin' => $request->margin, 
            'description' => $request->description,
        ]);
    
        $notification = notify('Product has been updated');
        return redirect()->route('products.index')->with($notification);
    }
    

     /**
     * Display a listing of expired resources.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function expired(Request $request){
        $title = "expired Products";
        if ($request->ajax()) {
            $products = Product::whereHas('purchase', function ($query) {
                $query->whereDate('expiry_date', '<=', Carbon::now());
            })->get();

            return DataTables::of($products)
                ->addColumn('product', function ($product) {
                    $image = '';
                    if (!empty($product->purchase) && !empty($product->purchase->image)) {
                        $image = '<span class="avatar avatar-sm mr-2">
                        <img class="avatar-img" src="' . asset("storage/purchases/" . $product->purchase->image) . '" alt="image">
                        </span>';
                    }
                    return $product->purchase->product ?? 'N/A' . ' ' . $image;
                })
                ->addColumn('category', function ($product) {
                    return $product->purchase->category->name ?? 'N/A';
                })
                ->addColumn('price', function ($product) {
                    return settings('app_currency', '$') . ' ' . $product->price;
                })
                ->addColumn('quantity', function ($product) {
                    return $product->purchase->quantity ?? 'N/A';
                })
                ->addColumn('margin', function ($product) {
                    return $product->margin ?? 'N/A';
                })
                ->addColumn('expiry_date', function ($product) {
                    return !empty($product->purchase->expiry_date) 
                        ? date_format(date_create($product->purchase->expiry_date), 'd M, Y') 
                        : 'N/A';
                })
                ->addColumn('action', function ($row) {
                    $editbtn = '<a href="' . route("products.edit", $row->id) . '" class="editbtn"><button class="btn btn-info"><i class="fas fa-edit"></i></button></a>';
                    $deletebtn = '<a data-id="' . $row->id . '" data-route="' . route('products.destroy', $row->id) . '" href="javascript:void(0)" id="deletebtn"><button class="btn btn-danger"><i class="fas fa-trash"></i></button></a>';
                   // if u want to restrict access to edit and delete buttons based on permissions but first add the permissions ,'edit-purchase', to the tables then to the roles 
                    // if (!auth()->check() || !auth()->user()->hasPermissionTo('edit-product')) {
                    //     $editbtn = '';
                    // }
                    // if (!auth()->check() || !auth()->user()->hasPermissionTo('destroy-purchase')) {
                    //     $deletebtn = '';
                    // }
                    return $editbtn . ' ' . $deletebtn;
                })
                ->rawColumns(['product', 'action'])
                ->make(true);
        }
        return view('admin.products.expired', compact('title'));
    }

    /**
     * Display a listing of out of stock resources.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function outstock(Request $request){
        $title = "outstocked Products";
        if ($request->ajax()) {
            $products = Product::whereHas('purchase', function ($query) {
                $query->where('quantity', '<=', 0);
            })->get();

            return DataTables::of($products)
                ->addColumn('product', function ($product) {
                    $image = '';
                    if (!empty($product->purchase) && !empty($product->purchase->image)) {
                        $image = '<span class="avatar avatar-sm mr-2">
                        <img class="avatar-img" src="' . asset("storage/purchases/" . $product->purchase->image) . '" alt="image">
                        </span>';
                    }
                    return $product->purchase->product . ' ' . $image;
                })
                ->addColumn('category', function ($product) {
                    return !empty($product->purchase->category) ? $product->purchase->category->name : 'N/A';
                })
                ->addColumn('price', function ($product) {
                    return settings('app_currency', '$') . ' ' . $product->price;
                })
                ->addColumn('quantity', function ($product) {
                    return !empty($product->purchase) ? $product->purchase->quantity : 'N/A';
                })
                ->addColumn('expiry_date', function ($product) {
                    return !empty($product->purchase) ? date_format(date_create($product->purchase->expiry_date), 'd M, Y') : 'N/A';
                })
                ->addColumn('action', function ($row) {
                    $editbtn = '<a href="' . route("products.edit", $row->id) . '" class="editbtn"><button class="btn btn-info"><i class="fas fa-edit"></i></button></a>';
                    $deletebtn = '<a data-id="' . $row->id . '" data-route="' . route('products.destroy', $row->id) . '" href="javascript:void(0)" id="deletebtn"><button class="btn btn-danger"><i class="fas fa-trash"></i></button></a>';
                    // if (!auth()->user()->hasPermissionTo('edit-product')) {
                    //     $editbtn = '';
                    // }
                    // if (!auth()->user()->hasPermissionTo('destroy-purchase')) {
                    //     $deletebtn = '';
                    // }
                    return $editbtn . ' ' . $deletebtn;
                })
                ->rawColumns(['product', 'action'])
                ->make(true);
        }
        return view('admin.products.outstock', compact('title'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        return Product::findOrFail($request->id)->delete();
    }
}
