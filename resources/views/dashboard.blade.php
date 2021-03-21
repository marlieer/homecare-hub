<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h2>Purchase History</h2>
                    <table class="table table-hover m-3">
                        <tr>
                            <th>Product Name</th>
                            <th>Quantity</th>
                            <th>Date Purchased</th>
                        </tr>
                        @foreach($transactions as $transaction)
                            <tr>
                                <td>{{ $transaction->product->name }}</td>
                                <td>{{ $transaction->quantity }}</td>
                                <td>{{ date('F j, Y', strtotime($transaction->created_at)) }}</td>
                            </tr>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
