<?php

namespace App\Http\Controllers;
use App\Models\Budget;
use App\Models\Expense;
use Illuminate\Http\Request;
use PDF; // Import the PDF facade

class dashboardController extends Controller
{
    // this method will show dashboard page for user
    public function index()
    {
        $budgets = Budget::with('expenses')->where('user_id', auth()->id())->get();
        // Calculate total budget
        $totalBudget = $budgets->sum('amount');

        // Calculate total expenses across all budgets
        $totalExpenses = $budgets->reduce(function ($carry, $budget) {
            return $carry + $budget->expenses->sum('amount');
        }, 0);

        // Calculate the remaining budget
        $budgetLeft = $totalBudget - $totalExpenses;
        return view('dashboard', compact('budgets', 'totalBudget', 'totalExpenses', 'budgetLeft'));
    }
    public function storeBudget(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0',
        ]);

        Budget::create([
            'user_id' => auth()->id(),
            'name' => $request->name,
            'amount' => $request->amount,
        ]);

        return redirect()->route('dashboard')->with('success', 'Budget added successfully.');
    }

    public function storeExpense(Request $request, $budgetId)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0',
        ]);

        Expense::create([
            'budget_id' => $budgetId,
            'title' => $request->title,
            'amount' => $request->amount,
        ]);

        return redirect()->route('dashboard')->with('success', 'Expense added successfully.');
    }

    public function deleteExpense($expenseId)
    {
        $expense = Expense::findOrFail($expenseId);
        $expense->delete();

        return redirect()->route('dashboard')->with('success', 'Expense removed successfully.');
    }
    public function destroy($id)
    {
        $budget = Budget::findOrFail($id);

        // Delete related expenses first to avoid foreign key constraint issues
        $budget->expenses()->delete();

        // Delete the budget
        $budget->delete();

        return redirect()->route('dashboard')->with('success', 'Budget deleted successfully.');
    }
    

}


