@extends('layouts.app')

@section('content')
    <div class="container col-md-8">
            <table class="table table-striped">
                    <thead class="thead-dark">
                      <tr>
                        <th scope="col">Order Id</th>
                        <th scope="col">Item number</th>
                        <th scope="col">Price</th>
                        <th scope="col">Created at</th>
                      </tr>
                    </thead>
                    <tbody>
                        @foreach($orders as $order)
                            <tr>
                                <th scope="row">{{ $order->id }} </th>
                                <td>{{ $order->price }}</td>
                                <td>{{ $order->items }}</td>
                                <td>{{ $order->created_at }}</td>
                            </tr>
                        @endforeach
                    </tbody>
            </table>
    </div>

@endsection