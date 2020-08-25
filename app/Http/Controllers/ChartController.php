<?php

namespace App\Http\Controllers;

use App\Branch;
use App\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ChartController extends Controller
{
    public function index() {
        $branches = Branch::all();
    
        $operating_months = DB::table('transactions')
                ->select(DB::raw('YEAR(transactions.created_at) as year_record, MONTHNAME(transactions.created_at) as month_record'))
                ->groupBy(DB::raw('MONTH(transactions.created_at)'))
                ->get();

        $monthly_income_manila = DB::table('transactions')
                ->select(DB::raw('YEAR(transactions.created_at) as year_record, MONTH(transactions.created_at) as month_record, branches.name, SUM(products.price * transactions.quantity) as monthly_income, COUNT(transactions.created_at) as total'))
                ->join('products', 'transactions.product_id', '=', 'products.id')
                ->join('branches', 'transactions.branch_id', '=', 'branches.id')
                ->where('transactions.branch_id', 1)
                ->groupBy(DB::raw('MONTH(transactions.created_at)'))
                ->get();
                
        $monthly_income_iloilo = DB::table('transactions')
                ->select(DB::raw('YEAR(transactions.created_at) as year_record, MONTH(transactions.created_at) as month_record, branches.name, SUM(products.price * transactions.quantity) as monthly_income, COUNT(transactions.created_at) as total'))
                ->join('products', 'transactions.product_id', '=', 'products.id')
                ->join('branches', 'transactions.branch_id', '=', 'branches.id')
                ->where('transactions.branch_id', 2)
                ->groupBy(DB::raw('MONTH(transactions.created_at)'))
                ->get();
                
        $monthly_income_baguio = DB::table('transactions')
                ->select(DB::raw('YEAR(transactions.created_at) as year_record, MONTH(transactions.created_at) as month_record, branches.name, SUM(products.price * transactions.quantity) as monthly_income, COUNT(transactions.created_at) as total'))
                ->join('products', 'transactions.product_id', '=', 'products.id')
                ->join('branches', 'transactions.branch_id', '=', 'branches.id')
                ->where('transactions.branch_id', 3)
                ->groupBy(DB::raw('MONTH(transactions.created_at)'))
                ->get();
        // SELECT YEAR(created_at) as year_record, MONTHNAME(created_at) as month_record, branches.name, SUM(price) as 'Monthly Income', COUNT(created_at) as total FROM transactions JOIN products ON transactions.product_id = products.id JOIN branches ON transactions.branch_id = branches.id GROUP BY YEAR(created_at), MONTH(created_at), branch_id
        
        // return $month_records;
        // return $monthly_income_manila;
        return view('index')->with('branches', $branches)
                            ->with('months', $operating_months)
                            ->with('income_mnl', $monthly_income_manila)
                            ->with('income_ilo', $monthly_income_iloilo)
                            ->with('income_bgo', $monthly_income_baguio);
    }

    public function viewBranch($branch_id) {
        $branch = Branch::find($branch_id);

        $operating_months = DB::table('transactions')
                ->select(DB::raw('YEAR(transactions.created_at) as year_record, MONTHNAME(transactions.created_at) as month_record'))
                ->groupBy(DB::raw('MONTH(transactions.created_at)'))
                ->get();

        $monthly_items_sold = DB::table('transactions')
                ->select(DB::raw('YEAR(transactions.created_at) as year_record, MONTHNAME(transactions.created_at) as month_record, SUM(transactions.quantity) as items_sold'))
                ->where('transactions.branch_id', $branch_id)
                ->groupBy(DB::raw('MONTH(transactions.created_at)'))
                ->get();

        // Revenue, expenses and net income
        $monthly_revenue = DB::table('transactions')
                ->select(DB::raw('YEAR(transactions.created_at) as year_record, MONTH(transactions.created_at) as month_record, branches.name, SUM(products.price * transactions.quantity) as monthly_revenue'))
                ->join('products', 'transactions.product_id', '=', 'products.id')
                ->join('branches', 'transactions.branch_id', '=', 'branches.id')
                ->where('transactions.branch_id', $branch_id)
                ->groupBy(DB::raw('MONTH(transactions.created_at)'))
                ->get();

        $monthly_expense = DB::table('expenses')
                ->select(DB::raw('YEAR(expenses.created_at) as year_record, MONTH(expenses.created_at) as month_record, branches.name, SUM(expense_types.price * expenses.quantity) as monthly_expense'))
                ->join('expense_types', 'expenses.expense_type_id', '=', 'expense_types.id')
                ->join('branches', 'expenses.branch_id', '=', 'branches.id')
                ->where('expenses.branch_id', $branch_id)
                ->groupBy(DB::raw('MONTH(expenses.created_at)'))
                ->get();        
        
        return view('view_branch')->with('branch', $branch)
                                  ->with('months', $operating_months)
                                  ->with('items', $monthly_items_sold)
                                  ->with('revenues', $monthly_revenue)
                                  ->with('expenses', $monthly_expense);
    }
}
