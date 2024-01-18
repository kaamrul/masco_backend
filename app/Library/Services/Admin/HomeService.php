<?php

namespace App\Library\Services\Admin;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Order;
use App\Library\Helper;
use Illuminate\Support\Facades\DB;

class HomeService extends BaseService
{
    public function index($request)
    {
        $user = auth()->user();

        if (isset($request->today)) {
            $from = Carbon::now()->toDateString();
            $to = Carbon::parse()->addDays(1)->format("Y-m-d");
        } elseif (isset($request->this_month)) {
            $from = Carbon::now()->startOfMonth()->toDateString();
            $to = Carbon::now()->toDateString();
        } elseif (isset($request->last_month)) {
            $from = Carbon::now()->startOfMonth()->subMonthsNoOverflow()->toDateString();
            $to = Carbon::now()->subMonthsNoOverflow()->endOfMonth()->toDateString();
        } elseif ($request->from && $request->to) {
            $from = $request->from;
            $to = $request->to;
        } else {
            $from = Carbon::now()->startOfMonth()->subMonthsNoOverflow()->toDateString();
            $to = Carbon::parse()->addDays(1)->format("Y-m-d");
        }

        $filterDateActive = [
            'today'       => $request->today ?? 0,
            'this_month' => $request->this_month ?? 0,
            'last_month'  => $request->last_month ?? 0,
        ];

        $data = [
            'filterDate'      => $filterDateActive,
            'totalSales'      => getFormattedAmount(263.78),
            'totalDue'        => getFormattedAmount(589.51),
            'totalCollection' => getFormattedAmount(550.25),
            'totalExpense'    => getFormattedAmount(421.35),
            'totalCustomer'   => User::getTotalActiveCustomer($from, $to),
            'date_range'      => $request->from && $request->to ? Helper::dateRange($request->from, $request->to) : null,
            'monthsArray'     => [1 => 'Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
            'orderCharts'     => [],
        ];

        return $data;
    }
}
