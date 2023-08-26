<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class StatisticsController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $days = $request->query('days', 30); // Default to 30 days
        $user = $request->user();

        // Total amount of followers they have gained in the past 30 days
        $followers = $user->followers()
            ->where('created_at', '>=', Carbon::now()->subDays($days))
            ->count();

        // Total revenue they made in the past 30 days from Donations, Subscriptions & Merch sales
        $donationsRevenue = $user->donations()
            ->where('created_at', '>=', Carbon::now()->subDays($days))
            ->sum('amount');

        $subscriptionsRevenue = $user->subscribers()
            ->where('created_at', '>=', Carbon::now()->subDays($days))
            ->select(DB::raw('
                    SUM(CASE WHEN subscription_tier = "Tier1" THEN 5
                    WHEN subscription_tier = "Tier2" THEN 10
                    WHEN subscription_tier = "Tier3" THEN 15
                    ELSE 0 END) AS revenue
            '))
            ->value('revenue');

        $merchRevenue = $user->merchSales()
            ->where('created_at', '>=', Carbon::now()->subDays($days))
            ->sum('amount');

        $totalRevenue = $donationsRevenue + $subscriptionsRevenue + $merchRevenue;

        // Top 3 items that did the best sales wise in the past 30 days
        $topItems = $user->merchSales()
            ->selectRaw('item_name, SUM(quantity) as total_quantity')
            ->where('created_at', '>=', Carbon::now()->subDays($days))
            ->groupBy('item_name')
            ->orderByDesc('total_quantity')
            ->limit(3)
            ->get()
            ->pluck('item_name')
            ->toArray();

        return response()->json([
            'followers' => $followers,
            'total_revenue' => number_format($totalRevenue, 2) . ' USD',
            'top_items' => $topItems,
        ]);
    }
}
