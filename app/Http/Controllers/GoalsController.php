<?php

namespace App\Http\Controllers;

use App\Models\Goals;
use App\Models\Sales;
use App\Models\Products;
use App\Models\Expenses;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Collection;

class GoalsController extends Controller
{
    public function index(): JsonResponse
    {
        $goals = Goals::all();

        $monthOrder = [
            'January','February','March','April','May','June',
            'July','August','September','October','November','December'
        ];
        $salesByMonth = Sales::all()
            ->groupBy('month')
            ->map(fn($grp) => $grp->sum('value'));
        $orderedSalesMonths = array_values(array_filter(
            $monthOrder,
            fn($m) => isset($salesByMonth[$m])
        ));
        $currentSalesMonth = end($orderedSalesMonths);
        $prevSalesMonth = $orderedSalesMonths[count($orderedSalesMonths) - 2] ?? null;
        $currentSales = $salesByMonth[$currentSalesMonth] ?? 0;
        $prevSales    = $salesByMonth[$prevSalesMonth]    ?? 0;
        $last3        = array_slice($orderedSalesMonths, -4, 3);
        $avgLast3     = array_sum(array_map(fn($m) => $salesByMonth[$m], $last3)) / max(1, count($last3));
        $last5        = array_slice($orderedSalesMonths, -6, 5);
        $avgLast5     = array_sum(array_map(fn($m) => $salesByMonth[$m], $last5)) / max(1, count($last5));

        $prodByMonth = Products::all()
            ->groupBy(fn($p) => $p->created_at->format('Y-m'))
            ->map->count();
        $prodMonths  = array_keys($prodByMonth->toArray());
        sort($prodMonths);
        $curProdMon = end($prodMonths);
        $prevProdMon= $prodMonths[count($prodMonths) - 2] ?? null;
        $curProdCnt = $prodByMonth[$curProdMon] ?? 0;
        $prevProdCnt= $prodByMonth[$prevProdMon] ?? 0;
        $avgCostCur = Products::whereYear('created_at', substr($curProdMon, 0,4))
                              ->whereMonth('created_at', substr($curProdMon, 5,2))
                              ->avg('price') ?: 0;
        $avgCostPrev= Products::whereYear('created_at', substr($prevProdMon,0,4))
                              ->whereMonth('created_at', substr($prevProdMon,5,2))
                              ->avg('price') ?: 0;

        $expByMonth = Expenses::all()
            ->groupBy('month')
            ->map(fn($grp) => $grp->first()->expenses_current);
        $orderedExpMonths = array_values(array_filter(
            $monthOrder,
            fn($m) => isset($expByMonth[$m])
        ));
        $curExpMon  = end($orderedExpMonths);
        $prevExpMon = $orderedExpMonths[count($orderedExpMonths) - 2] ?? null;
        $curExp     = $expByMonth[$curExpMon]  ?? 0;
        $prevExp    = $expByMonth[$prevExpMon] ?? 0;
        $expLast3   = array_slice($orderedExpMonths, -4, 3);
        $minLast3   = min(array_map(fn($m) => $expByMonth[$m], $expLast3));
        $expLast5   = array_slice($orderedExpMonths, -6, 5);
        $minLast5   = min(array_map(fn($m) => $expByMonth[$m], $expLast5));

        $results = [
            1  => $currentSales > $prevSales,
            2  => $currentSales > $avgLast3,
            3  => $currentSales > $avgLast5,
            4  => $currentSales > 100,
            5  => ($curProdCnt - $prevProdCnt) >= 5,
            6  => ($curProdCnt - $prevProdCnt) >= 10,
            7  => ($curProdCnt - $prevProdCnt) >= 20,
            8  => $avgCostCur < $avgCostPrev,
            9  => $curExp < $prevExp,
            10 => $curExp < $minLast3,
            11 => $curExp < $minLast5,
            12 => $currentSales >= $curExp,
        ];

        $goals->transform(function($goal) use ($results) {
            $goal->completed = $results[$goal->id] ? 1 : 0;
            return $goal;
        });

        return response()->json([
            'goals'   => $goals,
            'status'  => 'success',
            'message' => 'Metas carregadas com sucesso',
            'code'    => 200,
        ], 200);
    }
}
