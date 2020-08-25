@extends('layouts.app')

@section('content')
    <div class="row mt-5">
        <div class="col-8 offset-2 card">
            <div class="card-body">
                <h3 class="card-title">{{ $branch->name }} Branch Financial Overview</h3>
                <canvas id="branch_items_sold_chart"></canvas>
            </div>
        </div>
        <div class="col-8 offset-2 card mt-2">
            <div class="card-body">
                <canvas id="branch_revenue_and_expenses_chart"></canvas>
            </div>
        </div>
    </div>

    <script src="{{ asset('js/app.js') }}"></script>
    <script>
        // Branch overview charts
        let branch_items_sold_chart = document.getElementById('branch_items_sold_chart').getContext('2d');
        let branch_revenue_and_expenses_chart = document.getElementById('branch_revenue_and_expenses_chart').getContext('2d');

        let branch = @json($branch);
        let months = @json($months).map(el => `${el.month_record} ${el.year_record}`);
        let items = @json($items).map(el => `${el.items_sold}`);
        let revenues = @json($revenues).map(el => `${el.monthly_revenue}`);
        let expenses = @json($expenses).map(el => `${el.monthly_expense}`);

        let itemsSoldChart = new Chart(branch_items_sold_chart, {
            type: 'bar',
            data: {
            labels: months,
            datasets: [
                {
                    label: branch.name,
                    backgroundColor: '#00b5cc',
                    borderColor: '#777',
                    borderWidth: 1,
                    data: items
                },
            ]},
            options: {
                title: {
                    display: true,
                    text: `${branch.name} Branch Products Sold`
                }
            } 
        });

        let revenueAndExpensesChart =  new Chart(branch_revenue_and_expenses_chart, {
            type: 'line',
			data: {
				labels: months,
				datasets: [{
					label: 'Revenue',
					backgroundColor: '#59abe3',
					borderColor: '#59abe3',
					data: revenues,
					fill: false,
				}, {
					label: 'Expense',
					fill: false,
					backgroundColor: '#f03434',
					borderColor: '#f03434',
					data: expenses,
				}]
			},
			options: {
				responsive: true,
				title: {
					display: true,
					text: 'Monthly Revenue and Expenses'
				},
				tooltips: {
					mode: 'index',
					intersect: false,
				},
				hover: {
					mode: 'nearest',
					intersect: true
				},
				scales: {
					xAxes: [{
						display: true,
						scaleLabel: {
							display: true,
							labelString: 'Month'
						}
					}],
					yAxes: [{
						display: true,
						scaleLabel: {
							display: true,
							labelString: 'Amount in PHP'
						}
					}]
                }
            }
        });

    </script>
@endsection