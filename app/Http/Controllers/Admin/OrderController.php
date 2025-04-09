<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Traits\Notifications;
use DB;
use Auth;
use Inertia\Inertia;

class OrderController extends Controller
{
    use Notifications;

    public function __construct()
    {
        $this->middleware('permission:order');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $segments = request()->segments();
        $buttons = [
            [
                'name' => '<i class="bx bx-file"></i>&nbsp&nbsp' . __('Invoice Settings'),
                'url' => '#',
                'target' => '#invoiceSettingDrawer',
            ],
            [
                'name' => '<i class="bx bx-dollar"></i>&nbsp&nbsp' . __('Currency Settings'),
                'url' => '#',
                'target' => '#currencySettingDrawer',
            ],
            [
                'name' => '<i class="bx bx-cog"></i>&nbsp&nbsp' . __('Tax Settings'),
                'url' => '#',
                'target' => '#taxSettingDrawer',
            ]
        ];

        $orders = Order::query();

        if (!empty($request->search)) {
            if ($request->type == 'email') {
                $orders = $orders->whereHas('user', function ($q) use ($request) {
                    return $q->where('email', $request->search);
                });
            } else {
                $orders = $orders->where($request->type, 'LIKE', '%' . $request->search . '%');
            }
        }

        $orders = $orders->with('user', 'plan', 'gateway')->latest()->paginate(20);

        $totalOrders = Order::count();
        $totalPendingOrders = Order::where('status', 2)->count();
        $totalCompleteOrders = Order::where('status', 1)->count();
        $totalDeclinedOrders = Order::where('status', 0)->count();
        $type = $request->type ?? 'email';

        $invoice = get_option('invoice_data', true);
        $currency = get_option('base_currency', true);
        $tax = get_option('tax');

        return Inertia::render('Admin/Order/Index', [
            'segments' => $segments,
            'buttons' => $buttons,
            'orders' => $orders,
            'request' => $request,
            'totalOrders' => $totalOrders,
            'totalPendingOrders' => $totalPendingOrders,
            'totalCompleteOrders' => $totalCompleteOrders,
            'totalDeclinedOrders' => $totalDeclinedOrders,
            'type' => $type,
            'invoice' => $invoice,
            'currency' => $currency,
            'tax' => $tax
        ]);
    }



    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        $segments = request()->segments();
        $buttons = [
            [
                'name' => __('Orders'),
                'url' => '/admin/order'
            ],

        ];
        $order  = Order::with('user', 'plan', 'gateway')->findOrFail($id);
        $invoice_data = get_option('invoice_data', true);
        $meta = json_decode($order->meta ?? '');

        return Inertia::render('Admin/Order/Show', compact('order', 'invoice_data', 'segments', 'buttons', 'meta'));
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

        if(env('DEMO_MODE')){
            return back()->with('danger', __('Permission disabled for demo mode..!'));
       }
       
        $status = $request->status == 2 ? 'pending' : ($request->status == 1 ? 'approved' : 'rejected');
        $order  = Order::with('user', 'plan')->findorFail($id);
        $order->status = $status;
        $order->save();

        if ($request->assign_order == 'yes') {
            $order->user()->update([
                'plan_id'     => $order->plan_id,
                'will_expire' => $order->will_expire,
                'plan_data'        => json_encode($order->plan->data ?? ''),
            ]);
        }

        $title = '(' . $order->invoice_no . ') Subscription order is ' . $status;

        $notification['user_id'] = $order->user_id;
        $notification['title']   = $title;
        $notification['url'] = '/user/subscription-history';

        $this->createNotification($notification);

        return back();
    }
}