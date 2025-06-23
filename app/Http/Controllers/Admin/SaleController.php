<?php

namespace App\Http\Controllers\Admin;

use App\Models\Sale;
use App\Models\Product;
use App\Models\Purchase;
use Illuminate\Http\Request;
use App\Events\PurchaseOutStock;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class SaleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $title = 'sales';
        if($request->ajax()){
            $sales = Sale::latest();
            return DataTables::of($sales)
                    ->addIndexColumn()
                    ->addColumn('product',function($sale){
                        $image = '';
                        if(!empty($sale->product)){
                            $image = null;
                            if(!empty($sale->product->purchase->image)){
                                $image = '<span class="avatar avatar-sm mr-2">
                                <img class="avatar-img" src="'.asset("storage/purchases/".$sale->product->purchase->image).'" alt="image">
                                </span>';
                            }
                            return $sale->product->purchase->product. ' ' . $image;
                        }                 
                    })
                    ->addColumn('total_price',function($sale){                   
                        return settings('app_currency','$').' '. $sale->total_price;
                    })
                    ->addColumn('date',function($row){
                        return date_format(date_create($row->created_at),'d M, Y');
                    })
                    ->addColumn('action', function ($row) {
                        $editbtn = '<a href="'.route("sales.edit", $row->id).'" class="editbtn"><button class="btn btn-info"><i class="fas fa-edit"></i></button></a>';
                        $deletebtn = '<a data-id="'.$row->id.'" data-route="'.route('sales.destroy', $row->id).'" href="javascript:void(0)" id="deletebtn"><button class="btn btn-danger"><i class="fas fa-trash"></i></button></a>';
                        $btn = $editbtn.' '.$deletebtn;
                        return $btn;
                    })
                    ->rawColumns(['product','action'])
                    ->make(true);

        }
        $products = Product::get();
        return view('admin.sales.index',compact(
            'title','products',
        ));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
public function create()
{
    $title = 'create sales';
    $products = Product::with('purchase')->get(); // ✅ Load purchase relationship
    return view('admin.sales.create',compact(
        'title','products'
    ));
}

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
public function store(Request $request)
{
    $this->validate($request,[
        'product'=>'required',
        'quantity'=>'required|integer|min:1'
    ]);
    
    $sold_product = Product::find($request->product);
    
    // Update quantity in BOTH purchases AND products tables
    $purchased_item = Purchase::find($sold_product->purchase->id);
    $new_purchase_quantity = ($purchased_item->quantity) - ($request->quantity);
    $new_product_quantity = ($sold_product->quantity) - ($request->quantity);
    
    $notification = '';
    
    if (!($new_purchase_quantity < 0) && !($new_product_quantity < 0)){

        // Update Purchase quantity
        $purchased_item->update([
            'quantity'=>$new_purchase_quantity,
        ]);
        
        // Update Product quantity (THIS WAS MISSING!)
        $sold_product->update([
            'quantity'=>$new_product_quantity,
        ]);

        // Calculate item's total price
        $total_price = ($request->quantity) * ($sold_product->price);
        
        Sale::create([
            'product_id'=>$request->product,
            'quantity'=>$request->quantity,
            'total_price'=>$total_price,
        ]);

        $notification = notify("Product has been sold");
    } else {
        $notification = notify("Insufficient stock available!", 'error');
        return redirect()->route('sales.index')->with($notification);
    }
    
    // Check for low stock alert
    if($new_product_quantity <= ($sold_product->minimum_stock ?? 5)){
        $notification = notify("Product is running low on stock!", 'warning');
    }

    return redirect()->route('sales.index')->with($notification);
}

    

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \app\Models\Sale $sale
     * @return \Illuminate\Http\Response
     */
    public function edit(Sale $sale)
    {
        $title = 'edit sale';
        $products = Product::get();
        return view('admin.sales.edit',compact(
            'title','sale','products'
        ));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \app\Models\Sale $sale
     * @return \Illuminate\Http\Response
     */
public function update(Request $request, Sale $sale)
{
    $this->validate($request,[
        'product'=>'required',
        'quantity'=>'required|integer|min:1'
    ]);
    
    $sold_product = Product::find($request->product);
    $purchased_item = Purchase::find($sold_product->purchase->id);
    
    // Calculate the difference in quantity
    $quantity_difference = $request->quantity - $sale->quantity;
    
    $new_purchase_quantity = $purchased_item->quantity - $quantity_difference;
    $new_product_quantity = $sold_product->quantity - $quantity_difference;
    
    $notification = '';
    
    if (!($new_purchase_quantity < 0) && !($new_product_quantity < 0)){
        
        // Update Purchase quantity
        $purchased_item->update([
            'quantity'=>$new_purchase_quantity,
        ]);
        
        // Update Product quantity
        $sold_product->update([
            'quantity'=>$new_product_quantity,
        ]);

        // Calculate new total price
        $total_price = ($request->quantity) * ($sold_product->price);
        
        $sale->update([
            'product_id'=>$request->product,
            'quantity'=>$request->quantity,
            'total_price'=>$total_price,
        ]);

        $notification = notify("Sale has been updated");
    } else {
        $notification = notify("Insufficient stock for this update!", 'error');
        return redirect()->route('sales.index')->with($notification);
    }
    
    return redirect()->route('sales.index')->with($notification);
}

    /**
     * Generate sales reports index
     *
     * @return \Illuminate\Http\Response
     */
    public function reports(Request $request){
        $title = 'sales reports';
        return view('admin.sales.reports',compact(
            'title'
        ));
    }

    /**
     * Generate sales report form post
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function generateReport(Request $request){
        $this->validate($request,[
            'from_date' => 'required',
            'to_date' => 'required',
        ]);
        $title = 'sales reports';
        $sales = Sale::whereBetween(DB::raw('DATE(created_at)'), array($request->from_date, $request->to_date))->get();
        return view('admin.sales.reports',compact(
            'sales','title'
        ));
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        return Sale::findOrFail($request->id)->delete();
    }
}
