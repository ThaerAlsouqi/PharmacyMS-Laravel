<?php

namespace App\Http\Controllers\Admin;

use App\Models\Category;
use App\Models\Purchase;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use QCod\AppSettings\Setting\AppSettings;

class PurchaseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $title = 'purchases';
        if($request->ajax()){
            $purchases = Purchase::get();
            return DataTables::of($purchases)
                ->addColumn('product',function($purchase){
                    $image = '';
                    if(!empty($purchase->image)){
                        $image = '<span class="avatar avatar-sm mr-2">
						<img class="avatar-img" src="'.asset("storage/purchases/".$purchase->image).'" alt="product">
					    </span>';
                    }                 
                    return $purchase->product.' ' . $image;
                })
                ->addColumn('category',function($purchase){
                    if(!empty($purchase->category)){
                        return $purchase->category->name;
                    }
                })
                ->addColumn('cost_price',function($purchase){
                    return settings('app_currency','$'). ' '. $purchase->cost_price;
                })
                ->addColumn('supplier',function($purchase){
                    return $purchase->supplier->name;
                })
                ->addColumn('expiry_date',function($purchase){
                    return date_format(date_create($purchase->expiry_date),'d M, Y');
                })
                ->addColumn('action', function ($row) {
                    $editbtn = '<a href="'.route("purchases.edit", $row->id).'" class="editbtn"><button class="btn btn-info"><i class="fas fa-edit"></i></button></a>';
                    $deletebtn = '<a data-id="'.$row->id.'" data-route="'.route('purchases.destroy', $row->id).'" href="javascript:void(0)" id="deletebtn"><button class="btn btn-danger"><i class="fas fa-trash"></i></button></a>';
                    // if u want to restrict access to edit and delete buttons based on permissions but first add the permissions ,'edit-purchase', to the tables then to the roles 
                    // if (!auth()->user()->hasPermissionTo('edit-purchase')) {
                    //     $editbtn = '';
                    // }
                    // if (!auth()->user()->hasPermissionTo('destroy-purchase')) {
                    //     $deletebtn = '';
                    // }
                    $btn = $editbtn.' '.$deletebtn;
                    return $btn;
                })
                ->rawColumns(['product','action'])
                ->make(true);
        }
        return view('admin.purchases.index',compact(
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
        $title = 'create purchase';
        $categories = Category::get();
        $suppliers = Supplier::get();
        return view('admin.purchases.create',compact(
            'title','categories','suppliers'
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
        'product'=>'required|max:200',
        'category'=>'required',
        'cost_price'=>'required|min:1',
        'quantity'=>'required|min:1',
        'expiry_date'=>'required',
        'supplier'=>'required',
        'image'=>'file|image|mimes:jpg,jpeg,png,gif',
        'barcode'=>'nullable|string|max:50|unique:purchases,barcode',
        'minimum_stock'=>'nullable|integer|min:1'
    ]);

    $imageName = null;
    if($request->hasFile('image')){
        $imageName = time().'.'.$request->image->extension();
        $request->image->move(public_path('storage/purchases'), $imageName);
    }

    // Handle barcode - if empty, auto-generate
    $barcode = $request->barcode;
    if (empty($barcode)) {
        do {
            $barcode = 'PHM' . str_pad(mt_rand(10000000, 99999999), 8, '0', STR_PAD_LEFT);
        } while (Purchase::where('barcode', $barcode)->exists());
    }

    Purchase::create([
        'product'=>$request->product,
        'category_id'=>$request->category,
        'supplier_id'=>$request->supplier,
        'cost_price'=>$request->cost_price,
        'quantity'=>$request->quantity,
        'minimum_stock'=>$request->minimum_stock ?? 5,
        'expiry_date'=>$request->expiry_date,
        'image'=>$imageName,
        'barcode'=>$barcode,
    ]);

    $notifications = notify("Purchase has been added with barcode: " . $barcode);
    return redirect()->route('purchases.index')->with($notifications);
}

public function validateBarcode(Request $request)
{
    $barcode = $request->input('barcode');
    
    $validation = ['valid' => false, 'message' => ''];

    if (strlen($barcode) < 4) {
        $validation['message'] = 'Barcode too short (minimum 4 characters)';
        return response()->json($validation);
    }

    if (Purchase::where('barcode', $barcode)->exists()) {
        $validation['message'] = 'Barcode already exists in system';
        return response()->json($validation);
    }

    $validation['valid'] = true;
    $validation['message'] = 'Barcode is valid and available';
    
    return response()->json($validation);
}

    

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \app\Models\Purchase $purchase
     * @return \Illuminate\Http\Response
     */
    public function edit(Purchase $purchase)
    {
        $title = 'edit purchase';
        $categories = Category::get();
        $suppliers = Supplier::get();
        return view('admin.purchases.edit',compact(
            'title','purchase','categories','suppliers'
        ));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \app\Models\Purchase $purchase
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Purchase $purchase)
{
    $this->validate($request,[
        'product'=>'required|max:200',
        'category'=>'required',
        'cost_price'=>'required|min:1',
        'quantity'=>'required|min:1',
        'expiry_date'=>'required',
        'supplier'=>'required',
        'image'=>'file|image|mimes:jpg,jpeg,png,gif',
        'barcode'=>'nullable|string|max:50|unique:purchases,barcode,'.$purchase->id,
        'minimum_stock'=>'nullable|integer|min:1'
    ]);

    $imageName = $purchase->image;
    if($request->hasFile('image')){
        $imageName = time().'.'.$request->image->extension();
        $request->image->move(public_path('storage/purchases'), $imageName);
    }

    // Handle barcode - if empty, auto-generate
    $barcode = $request->barcode;
    if (empty($barcode) && empty($purchase->barcode)) {
        do {
            $barcode = 'PHM' . str_pad(mt_rand(10000000, 99999999), 8, '0', STR_PAD_LEFT);
        } while (Purchase::where('barcode', $barcode)->exists());
    } else {
        $barcode = $barcode ?: $purchase->barcode;
    }

    $purchase->update([
        'product'=>$request->product,
        'category_id'=>$request->category,
        'supplier_id'=>$request->supplier,
        'cost_price'=>$request->cost_price,
        'quantity'=>$request->quantity,
        'minimum_stock'=>$request->minimum_stock ?? $purchase->minimum_stock ?? 5,
        'expiry_date'=>$request->expiry_date,
        'image'=>$imageName,
        'barcode'=>$barcode,
    ]);

    $notifications = notify("Purchase has been updated");
    return redirect()->route('purchases.index')->with($notifications);
}

    public function reports(){
        $title ='purchase reports';
        return view('admin.purchases.reports',compact('title'));
    }

    public function generateReport(Request $request){
        $this->validate($request,[
            'from_date' => 'required',
            'to_date' => 'required'
        ]);
        $title = 'purchases reports';
        $purchases = Purchase::whereBetween(DB::raw('DATE(created_at)'), array($request->from_date, $request->to_date))->get();
        return view('admin.purchases.reports',compact(
            'purchases','title'
        ));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        return Purchase::findOrFail($request->id)->delete();
    }

    public function sell(Request $request, Purchase $purchase)
    {
        if ($purchase->is_expired) {
            return redirect()->back()->withErrors(['error' => 'This medicine is expired and cannot be sold.']);
        }

        // ...existing sale logic...
        
    }
}
