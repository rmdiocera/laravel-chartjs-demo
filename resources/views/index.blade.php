@extends('layouts.app')

@section('content')
    <div class="row mt-5">
        <div class="col-8 offset-2 card">
            <div class="card-body">
                <h3 class="card-title">Company Overview</h3>
                <canvas id="branch_income_chart"></canvas>
                <div class="form-inline mt-2">
                    @foreach ($branches as $branch)
                        <a href="/branch/{{ $branch->id}}" class="btn btn-sm btn-primary mr-2">{{ $branch->name }} Branch Overview</a>                        
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('js/app.js') }}"></script>
    <script>
        let branch_income_chart = document.getElementById('branch_income_chart').getContext('2d');
        
        // Homepage chart
        let months = @json($months).map(el => `${el.month_record} ${el.year_record}`);
        let income_mnl = @json($income_mnl).map(el => `${el.monthly_income}`);
        let income_ilo = @json($income_ilo).map(el => `${el.monthly_income}`);
        let income_bgo = @json($income_bgo).map(el => `${el.monthly_income}`);

        
        let incomeChart = new Chart(branch_income_chart, {
            type: 'bar',
            data: {
            labels: months,
            datasets: [
                {
                    label: 'Manila',
                    backgroundColor: '#00b5cc',
                    borderColor: '#777',
                    borderWidth: 1,
                    data: income_mnl
                },
                {
                    label: 'Iloilo',
                    backgroundColor: '#f5e51b',
                    borderColor: '#777',
                    borderWidth: 1,
                    data: income_ilo
                },
                {
                    label: 'Baguio',
                    backgroundColor: '#26c281',
                    borderColor: '#777',
                    borderWidth: 1,
                    data: income_bgo
                }
            ]},
            options: {
                title: {
                    display: true,
                    text: 'Branch Monthly Revenue'
                }
            }
        });

    </script>
@endsection