@extends('backend.template.main')

@section('title', 'Dashboard')

@section('content')
    <div class="py-4">
        <nav aria-label="breadcrumb" class="d-none d-md-inline-block">
            <ol class="breadcrumb breadcrumb-dark breadcrumb-transparent">
                <li class="breadcrumb-item">
                    <a href="#">
                        <svg class="icon icon-xxs" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6">
                            </path>
                        </svg>
                    </a>
                </li>
                <li class="breadcrumb-item"><a href="{{ route('panel.transaction.index') }}">Transaction</a></li>
            </ol>
        </nav>

        <div class="mb-3 mb-lg-0">
            <h1 class="h4">Dashboard</h1>
            <p class="mb-0">Data Transaction Yummy Restoran</p>
        </div>

         <!-- Grafik Statistik Transaksi -->
         <h3 class="text-left mb-3">Statistical Data Transaction</h3>
         <canvas id="transactionsChart" style="max-height: 300px; max-width: 1000px;"></canvas>

         <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

         <script>
             const ctx = document.getElementById('transactionsChart').getContext('2d');
             const transactionsChart = new Chart(ctx, {
                 type: 'bar',
                 data: {
                     labels: ['Total Transactions', 'Pending', 'Success', 'Failed'],
                     datasets: [{
                         label: 'Transaksi',
                         data: [{{ $totalTransactions }}, {{ $pendingTransactions }}, {{ $successTransactions }}, {{ $failedTransactions }}],
                         backgroundColor: [
                             'rgba(54, 162, 235, 0.6)',
                             'rgba(255, 206, 86, 0.6)',
                             'rgba(75, 192, 192, 0.6)',
                             'rgba(255, 99, 132, 0.6)'
                         ],
                         borderColor: [
                             'rgba(54, 162, 235, 1)',
                             'rgba(255, 206, 86, 1)',
                             'rgba(75, 192, 192, 1)',
                             'rgba(255, 99, 132, 1)'
                         ],
                         borderWidth: 1
                     }]
                 },
                 options: {
                     scales: {
                         y: {
                             beginAtZero: true
                         }
                     }
                 }
             });
         </script>

        <h3 class="text-left mb-3">Latest Transaction Table</h3>
        <table class="table table-striped table-bordered table-hover">
            <thead class="thead-dark">
                <tr>
                    <th>No</th>
                    <th>CODE</th>
                    <th>NAME</th>
                    <th>TYPE</th>
                    <th>Date/time</th>
                    <th>Status</th>
                    <th>AMOUNT</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($recentTransactions as $transaction)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $transaction->code }}</td>
                        <td>{{ $transaction->name }}</td>
                        <td>{{ $transaction->type }}</td>
                        <td>{{ $transaction->created_at->format('Y-m-d H:i') }}</td>
                        <td>
                            <span class="badge
                                @if ($transaction->status == 'pending') bg-warning
                                @elseif($transaction->status == 'failed') bg-danger
                                @else bg-success
                                @endif"
                                style="color: black;">
                                {{ ucfirst($transaction->status) }}
                            </span>
                        </td>
                        <td>Rp {{ number_format($transaction->amount, 0, ',', '.') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="d-flex justify-content-end mb-3">
            {{ $recentTransactions->links() }}
        </div>
    </div>

    @push('js')
        <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @endpush

@endsection
