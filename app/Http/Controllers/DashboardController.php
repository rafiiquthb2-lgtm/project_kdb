<?php

namespace App\Http\Controllers;

use App\Models\CustomerDetail;
use App\Models\TransactionDetail;
use App\Models\OrderDetail;
use App\Models\ProductDetail;
use App\Models\AuditLog;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        
        $stats = [];

        // Admin & Data Analyst see global stats
        if ($user->hasRole(['admin', 'data_analyst'])) {
            $stats['total_customers'] = CustomerDetail::count();
            $stats['total_transactions'] = TransactionDetail::count();
            $stats['total_orders'] = OrderDetail::count();
            $stats['total_revenue'] = TransactionDetail::sum('total_paid');
        }

        // Admin & Auditor see audit info
        if ($user->hasRole(['admin', 'auditor'])) {
            $stats['total_audit_logs'] = AuditLog::count();
            $stats['recent_activities'] = AuditLog::with('user')
                ->latest('created_at')
                ->take(5)
                ->get();
        }

        // Customer sees their own stats
        if ($user->isCustomer() && $user->customer_id) {
            $stats['my_transactions'] = TransactionDetail::where('customer_id', $user->customer_id)->count();
            $stats['my_total_spent'] = TransactionDetail::where('customer_id', $user->customer_id)->sum('total_paid');
            $stats['total_products'] = ProductDetail::count();
        }

        return view('dashboard', compact('user', 'stats'));
    }
}
