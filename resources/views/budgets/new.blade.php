<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Laravel 11 Multi Auth</title>
    <link rel="stylesheet" href="https://unpkg.com/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <style>
        /* General Reset */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}


/* Container */
.container {
    background: #fff;
    border-radius: 10px;
    padding: 20px 30px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    /* width: 500px; */
    text-align: center;
}

/* Title */
.title {
    font-size: 24px;
    font-weight: bold;
    margin-bottom: 20px;
    color: #0066cc;
}

/* Main Sections */
.main {
    display: flex;
    justify-content: space-between;
    gap: 10px;
    margin-bottom: 20px;
}

.form-section {
    background: #f8f9fa;
    padding: 10px 15px;
    border-radius: 8px;
    width: 48%;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
}

.form-section h2 {
    font-size: 18px;
    margin-bottom: 10px;
    color: #444;
}

input {
    width: 100%;
    padding: 10px;
    margin-bottom: 10px;
    border: 1px solid #ddd;
    border-radius: 5px;
}

button {
    background: #0066cc;
    color: #fff;
    padding: 10px 15px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    width: 100%;
}

button:hover {
    background: #005bb5;
}

/* Summary Section */
.summary {
    display: flex;
    justify-content: space-between;
    padding: 10px;
    background: #f8f9fa;
    border-radius: 8px;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    margin-bottom: 20px;
    font-size: 16px;
    color: #444;
}

.summary div {
    flex: 1;
    text-align: center;
}

/* History Section */
.history {
    text-align: left;
}

.history h2 {
    font-size: 18px;
    margin-bottom: 10px;
    color: #444;
}

table {
    width: 100%;
    border-collapse: collapse;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    margin-bottom: 20px;
}

table thead {
    background: #0066cc;
    color: #fff;
}

table th, table td {
    padding: 10px;
    text-align: left;
    border-bottom: 1px solid #ddd;
}

table tbody tr:hover {
    background: #f1f1f1;
}

.remove-btn {
    background: #cc0000;
    color: #fff;
    border: none;
    padding: 5px 10px;
    border-radius: 5px;
    cursor: pointer;
}

.remove-btn:hover {
    background: #a50000;
}

    </style>
</head>

<body class="bg-light">
    <nav class="navbar navbar-expand-md bg-white shadow-lg bsb-navbar bsb-navbar-hover bsb-navbar-caret" style="padding: 10px 69px;
">
        <!-- <div class="container"> -->
            <a class="navbar-brand" href="#">
                <strong>Laravel 11 Multi Auth</strong>
            </a>
            <button class="navbar-toggler border-0" type="button" data-bs-toggle="offcanvas"
                data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-list"
                    viewBox="0 0 16 16">
                    <path fill-rule="evenodd"
                        d="M2.5 12a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5z" />
                </svg>
            </button>
            <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasNavbar"
                aria-labelledby="offcanvasNavbarLabel">
                <div class="offcanvas-header">
                    <h5 class="offcanvas-title" id="offcanvasNavbarLabel">Menu</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                </div>
                <div class="offcanvas-body">
                    <ul class="navbar-nav justify-content-end flex-grow-1">

                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#!" id="accountDropdown" role="button"
                                data-bs-toggle="dropdown" aria-expanded="false">Hello, {{Auth::user()->name}}</a>
                            <ul class="dropdown-menu border-0 shadow bsb-zoomIn" aria-labelledby="accountDropdown">
                                <li>
                                    <form id="logout-form" action="{{ route('account.logout') }}" method="POST"
                                        style="display: none;">
                                        @csrf
                                    </form>
                                    <a class="dropdown-item" href="#"
                                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        Logout
                                    </a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        <!-- </div> -->
    </nav>
    <!-- <div class="container">
        <div class="card border-0 shadow my-5">
            <div class="card-header bg-light">
                <h3 class="h5 pt-2">Dashboard</h3>
            </div>
            <div class="card-body">
                You are logged in !!
            </div>
        </div>
    </div> -->
    <div class="container">
        <h1 class="title">Budget Tracker System</h1>
        <div class="main">
            <!-- Add Budget Section -->
            <div class="form-section">
                <h2>Add Budget</h2>
                <form id="add-budget-form" href="{{route('budgets.store')}}" method="post">
                    @csrf
                    <input type="number" id="budget" placeholder="Budget Amount" required>
                    <button type="submit">Add Budget</button>
                </form>
            </div>

            <!-- Add Expense Section -->
            <div class="form-section">
                <h2>Add Expense</h2>
                <form id="add-expense-form" href="{{route('expenses.store')}}" method="post">
                    @csrf
                    <input type="text" id="expense-title" placeholder="Expense Title" required>
                    <input type="number" id="expense-amount" placeholder="Amount" required>
                    <button type="submit">Add Expense</button>
                </form>
            </div>
        </div>

        <!-- Budget Summary -->
        <div class="summary">
            <div>Total Budget: <span id="total-budget">0.00</span></div>
            <div>Total Expenses: <span id="total-expenses">0.00</span></div>
            <div>Budget Left: <span id="budget-left">0.00</span></div>
        </div>

        <!-- Expense History -->
        <div class="history">
            <h2>Expense History:</h2>
            <table>
                <thead>
                    <tr>
                        <th>Expense Name</th>
                        <th>Amount</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody id="expense-history">
                    <!-- Dynamically populated rows will appear here -->
                </tbody>
            </table>
        </div>
    </div>
<script>
    // Budget Tracker Logic
let totalBudget = 0;
let totalExpenses = 0;

const budgetField = document.getElementById("budget");
const budgetDisplay = document.getElementById("total-budget");
const expenseTitleField = document.getElementById("expense-title");
const expenseAmountField = document.getElementById("expense-amount");
const totalExpensesDisplay = document.getElementById("total-expenses");
const budgetLeftDisplay = document.getElementById("budget-left");
const expenseHistory = document.getElementById("expense-history");

// Add Budget
document.getElementById("add-budget-form").addEventListener("submit", function (e) {
    e.preventDefault();
    totalBudget = parseFloat(budgetField.value);
    updateSummary();
    budgetField.value = "";
});

// Add Expense
document.getElementById("add-expense-form").addEventListener("submit", function (e) {
    e.preventDefault();
    const expenseTitle = expenseTitleField.value;
    const expenseAmount = parseFloat(expenseAmountField.value);

    // Add expense to the table
    const row = document.createElement("tr");
    row.innerHTML = `
        <td>${expenseTitle}</td>
        <td>${expenseAmount.toFixed(2)}</td>
        <td><button class="remove-btn">Remove</button></td>
    `;
    expenseHistory.appendChild(row);

    // Update totals
    totalExpenses += expenseAmount;
    updateSummary();

    // Remove expense on button click
    row.querySelector(".remove-btn").addEventListener("click", function () {
        totalExpenses -= expenseAmount;
        row.remove();
        updateSummary();
    });

    // Clear input fields
    expenseTitleField.value = "";
    expenseAmountField.value = "";
});

// Update Summary
function updateSummary() {
    budgetDisplay.textContent = totalBudget.toFixed(2);
    totalExpensesDisplay.textContent = totalExpenses.toFixed(2);
    budgetLeftDisplay.textContent = (totalBudget - totalExpenses).toFixed(2);
}

</script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4"
        crossorigin="anonymous"></script>
</body>

</html>