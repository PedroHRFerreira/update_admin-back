<?php

namespace App\Http\Controllers;

use App\Models\Goals;
use App\Models\Sales;
use App\Models\Products;
use App\Models\Expenses;
use Illuminate\Http\JsonResponse;

class GoalsController extends Controller
{
    public function index(): JsonResponse
    {
        $monthOrder = [
            'January','February','March','April','May','June',
            'July','August','September','October','November','December'
        ];

        $salesByMonth = Sales::all()->groupBy('month')->map->sum('value');
        $orderedSalesMonths = array_values(array_filter($monthOrder, fn($m) => isset($salesByMonth[$m])));
        [$currentSalesMonth, $prevSalesMonth] = $this->getCurrentAndPrevious($orderedSalesMonths);
        $currentSales = $salesByMonth[$currentSalesMonth] ?? 0;
        $prevSales    = $salesByMonth[$prevSalesMonth]    ?? 0;
        $avgLast3     = $this->averageLastN($salesByMonth, $orderedSalesMonths, 3);
        $avgLast5     = $this->averageLastN($salesByMonth, $orderedSalesMonths, 5);

        // PRODUCTS
        $prodByMonth = Products::all()
            ->groupBy(fn($p) => $p->created_at->format('Y-m'))
            ->map->count();
        $prodMonths = array_keys($prodByMonth->toArray());
        sort($prodMonths);
        [$curProdMon, $prevProdMon] = $this->getCurrentAndPrevious($prodMonths);
        $curProdCnt = $prodByMonth[$curProdMon] ?? 0;
        $prevProdCnt= $prodByMonth[$prevProdMon] ?? 0;
        $avgCostCur = $this->getAvgCost($curProdMon);
        $avgCostPrev= $this->getAvgCost($prevProdMon);

        $expByMonth = Expenses::all()
            ->groupBy('month')
            ->map(fn($grp) => $grp->first()->expenses_current);
        $orderedExpMonths = array_values(array_filter($monthOrder, fn($m) => isset($expByMonth[$m])));
        [$curExpMon, $prevExpMon] = $this->getCurrentAndPrevious($orderedExpMonths);
        $curExp  = $expByMonth[$curExpMon]  ?? 0;
        $prevExp = $expByMonth[$prevExpMon] ?? 0;
        $minLast3 = $this->minLastN($expByMonth, $orderedExpMonths, 3);
        $minLast5 = $this->minLastN($expByMonth, $orderedExpMonths, 5);

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

        $goals = Goals::all()->map(function ($goal) use ($results) {
            $goal->setAttribute('completed', $results[$goal->id] ?? 0);
            return $goal;
        });        

        return response()->json([
            'goals'   => $goals,
            'status'  => 'success',
            'message' => 'Metas carregadas com sucesso',
            'code'    => 200,
        ]);
    }

    private function getCurrentAndPrevious(array $items): array
    {
        $count = count($items);
        return [
            $count > 0 ? $items[$count - 1] : null,
            $count > 1 ? $items[$count - 2] : null,
        ];
    }

    private function averageLastN($data, $orderedKeys, int $n): float
    {
        $lastN = array_slice($orderedKeys, -($n + 1), $n);
        $values = array_map(fn($key) => $data[$key] ?? 0, $lastN);
        return count($values) ? array_sum($values) / count($values) : 0;
    }

    private function minLastN($data, $orderedKeys, int $n): float
    {
        $lastN = array_slice($orderedKeys, -($n + 1), $n);
        $values = array_map(fn($key) => $data[$key] ?? INF, $lastN);
        return count($values) ? min($values) : 0;
    }

    private function getAvgCost(?string $month): float
    {
        if (!$month) return 0;
        return Products::whereYear('created_at', substr($month, 0, 4))
            ->whereMonth('created_at', substr($month, 5, 2))
            ->avg('price') ?: 0;
    }
}
