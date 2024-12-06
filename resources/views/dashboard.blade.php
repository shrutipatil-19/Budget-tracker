<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Laravel 11 Multi Auth</title>
    <link rel="stylesheet" href="https://unpkg.com/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <style>
        /* Reset General Styles */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background-color: #f8f9fa;
            font-family: 'Arial', sans-serif;
        }

        /* Container */
        .container {
            background: #fff;
            border-radius: 12px;
            padding: 30px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            max-width: 1200px;
            margin-top: 40px;
            display: flex;
        }

        .container .left {
            width: 33%;
            margin: 0px 14px;
        }

        .container .right {
            width: 67%;
        }

        .container h1 {
            text-align: center;
            color: #0066cc;
            margin-bottom: 30px;
            font-size: 32px;
            font-weight: 600;
        }

        /* Form Section */
        .form-section {
            background: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            margin-bottom: 30px;
        }

        .form-section input,
        .form-section button,
        .budget-list input,
        .budget-list button {
            width: 100%;
            padding: 8px;
            margin: 8px 0;
            border-radius: 5px;
            border: 1px solid #ddd;
            font-size: 16px;
        }

        .form-section .add,
        .budget-list .add {
            background-color: #0066cc;
            color: white;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .form-section button:hover {
            background-color: #005bb5;
        }

        /* Budget Overview */
        .summary {
            display: flex;
            justify-content: space-between;
            gap: 20px;
            margin-bottom: 30px;
        }

        .summary div {
            flex: 1;
            padding: 15px;
            background: #f0f0f0;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
            text-align: center;
        }

        .summary div h3 {
            font-size: 20px;
            color: #444;
        }

        /* Budget List */
        .budget-list h3 {
            font-size: 24px;
            color: #0066cc;
            margin-bottom: 15px;
        }

        .budget-list .budget-item {
            background: #ffffff;
            padding: 15px;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }

        .budget-item h4 {
            font-size: 20px;
            color: #333;
            margin-bottom: 15px;
        }

        .budget-item ul {
            list-style-type: none;
            padding-left: 0;
        }

        .budget-item ul li {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 8px;
            border-bottom: 1px solid #ddd;
        }

        .remove-btn {
            background-color: #cc0000;
            color: white;
            border: none;
            padding: 5px 10px;
            border-radius: 5px;
            cursor: pointer;
        }

        .remove-btn:hover {
            background-color: #a50000;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .container {
                flex-direction: column;
                padding: 0px;
            }

            .container .left,
            .container .right {
                width: 100%;
            }

            .container .left {
                margin: 0px;
            }

            .budget-list,
            .right {
                padding: 20px;
            }

            .list {
                overflow: scroll;
            }

            .summary {
                flex-direction: column;
            }

            .summary div {
                margin-bottom: 20px;
            }

            .budget-list h3 {
                font-size: 22px;
            }

            .budget-item h4 {
                font-size: 18px;
            }
        }
    </style>
</head>

<body class="bg-light">
    <nav class="navbar navbar-expand-md bg-white shadow-lg bsb-navbar bsb-navbar-hover bsb-navbar-caret" style="padding: 10px 69px;
">
        <!-- <div class="container"> -->
        <a class="navbar-brand" href="#">
            <strong>Budget Tracker</strong>
        </a>
        <button class="navbar-toggler border-0" type="button" data-bs-toggle="offcanvas"
            data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-list"
                viewBox="0 0 16 16">
                <path fill-rule="evenodd"
                    d="M2.5 12a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5z" />
            </svg>
        </button>
        <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
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
    <div class="container">


        <!-- Add Budget Form -->
        <div class="left">
            <div class="form-section">
                <h2>Add Budget</h2>
                <form action="{{ route('budgets.store') }}" method="POST">
                    @csrf
                    <input type="text" name="name" placeholder="Budget Name" required>
                    <input type="number" name="amount" placeholder="Amount" required>
                    <button type="submit" class="add">Add Budget</button>
                </form>
            </div>
            <div class="budget-list">

                @foreach($budgets as $budget)
                    <h4>{{ $budget->name }} - {{ $budget->amount }}</h4>
                    <h5>Add Expense</h5>
                    <form action="{{ route('expenses.store', $budget->id) }}" method="POST">
                        @csrf
                        <input type="text" name="title" placeholder="Expense Title" required>
                        <input type="number" name="amount" placeholder="Amount" required>
                        <button type="submit" class="add">Add Expense</button>
                    </form>

                    <!-- Delete Budget Form -->
                    <form action="{{ route('budgets.destroy', $budget->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger" type="submit"
                            onclick="return confirm('Are you sure you want to delete this budget?')">Delete Budget</button>
                    </form>

                    <hr>
                @endforeach

            </div>
        </div>
        <!-- Budget Overview Section -->
        <div class="right">
            <div class="summary">
                <div>
                    <h3>Total Budget</h3>
                    <p>{{ $totalBudget }}</p>
                </div>
                <div>
                    <h3>Total Expenses</h3>
                    <p>{{ $totalExpenses }}</p>
                </div>
                <div>
                    <h3>Budget Left</h3>
                    <p>{{ $budgetLeft }}</p>
                </div>
            </div>

            <div class="list">
                <h3>Budgets</h3>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Budget Name</th>
                            <th>Budget Amount</th>
                            <th>Expense Title</th>
                            <th>Expense Amount</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($budgets as $budget)
                            <!-- Row for each budget -->
                            <tr>
                                <td rowspan="{{ $budget->expenses->count() + 1 }}">{{ $budget->name }}</td>
                                <td rowspan="{{ $budget->expenses->count() + 1 }}">{{ $budget->amount }}</td>
                            </tr>
                            <!-- Rows for each expense under the budget -->
                            @foreach($budget->expenses as $expense)
                                <tr>
                                    <td>{{ $expense->title }}</td>
                                    <td>{{ $expense->amount }}</td>
                                    <td>
                                        <form action="{{ route('expenses.delete', $expense->id) }}" method="POST"
                                            style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-danger btn-sm" type="submit">Remove</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        @endforeach
                    </tbody>
                </table>

            </div>
        </div>
        <!-- Budget List with Expenses -->

    </div>


    <script>


    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4"
        crossorigin="anonymous"></script>
</body>

</html>