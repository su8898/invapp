<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Invoice;

class DashboardController extends Controller
{
    /**
     * Display this month's invoice amounts.
     */
    public function index()
    {
        // Get the current month
        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;

        // Query to get invoices for the current month
        $invoices = Invoice::whereYear('invoice_date', $currentYear)
                    ->whereMonth('invoice_date', $currentMonth)
                    ->get();

        // Calculate total amounts
        $totalGrossAmount = $invoices->sum('gross_amt');
        $totalVatAmount = $invoices->sum('vat_amt');
        $totalNetAmount = $invoices->sum('net_amt');

        // Pass data to view
        return view('dashboard', [
            'totalGrossAmount' => $totalGrossAmount,
            'totalVatAmount' => $totalVatAmount,
            'totalNetAmount' => $totalNetAmount
        ]);
    }
}
