<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Model\OrderDetail;
use App\Model\SearchFunction;
use App\Model\WithdrawRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SystemController extends Controller
{
    public function dashboard()
    {
        $bestSellProduct = OrderDetail::with('product.reviews')
            ->select('product_id', DB::raw('COUNT(product_id) as count'))
            ->groupBy('product_id')
            ->orderBy("count", 'desc')
            ->take(6)
            ->distinct()
            ->get();
        $newSellingProduct = OrderDetail::select('product_id')->orderBy('id', 'desc')->groupBy('order_id')->take(6)->distinct()->get();
        $withdraw_req = WithdrawRequest::orderBy('id', 'desc')->latest()->paginate(10);
        return view('admin-views.system.dashboard', compact('bestSellProduct', 'newSellingProduct', 'withdraw_req'));
    }

    public function search_function(Request $request)
    {
        $request->validate([
            'key' => 'required',
        ], [
            'key.required' => 'Product name is required!',
        ]);

        $key = explode(' ', $request->key);

        $items = SearchFunction::where(function ($q) use ($key) {
            foreach ($key as $value) {
                $q->orWhere('key', 'like', "%{$value}%");
            }
        })->get();

        return response()->json([
            'result' => view('admin-views.partials._search-result', compact('items'))->render(),
        ]);
    }

}
