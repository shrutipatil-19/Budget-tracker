<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Budget Tracker</title>
</head>
<body>
    <h1>Budget Tracker</h1>

    <form method="POST" action="{{ route('budgets.store') }}">
        @csrf
        <h2>Add Budget</h2>
        <input type="text" name="title" placeholder="Budget Title">
        <input type="number" step="0.01" name="amount" placeholder="Amount" required>
        <button type="submit">Add Budget</button>
    </form>

    @foreach ($budgets as $budget)
        <h2>{{ $budget->title ?? 'Untitled Budget' }}: ${{ $budget->amount }}</h2>
        <p>Total Expenses: ${{ $budget->expenses->sum('amount') }}</p>
        <p>Remaining: ${{ $budget->remainingAmount() }}</p>

        <form method="POST" action="{{ route('expenses.store', $budget->id) }}">
            @csrf
            <h3>Add Expense</h3>
            <input type="text" name="title" placeholder="Expense Title" required>
            <input type="number" step="0.01" name="amount" placeholder="Amount" required>
            <button type="submit">Add Expense</button>
        </form>

        <ul>
            @foreach ($budget->expenses as $expense)
                <li>
                    {{ $expense->title }}: ${{ $expense->amount }}
                    <form method="POST" action="{{ route('expenses.delete', $expense->id) }}" style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit">Remove</button>
                    </form>
                </li>
            @endforeach
        </ul>
    @endforeach
</body>
</html>
