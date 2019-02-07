@extends('layouts.app')

@section('content')
    <div class="container col-md-8 mt-4 mb-4">
        <table class="table table-striped">
            <thead class="thead-dark">
              <tr>
                <th scope="col">Order Id</th>
                <th scope="col">Item number</th>
                <th scope="col">Price</th>
                <th scope="col">Transaction made on</th>
                <th></th>
              </tr>
            </thead>
            <tbody>
                @foreach($orders as $order)
                    <tr>
                        <th scope="row">{{ $order->id }} </th>
                        <td>{{ $order->items }}</td>
                        <td>${{ $order->price }}</td>
                        <td>{{ $order->created_at }}</td>
                        <td>
                            <button type="button" class="btn btn-dark btn-sm" data-toggle="modal" data-target="#exampleModal{{$order->id}}">
                                <i class="fas fa-eye"></i>
                            </button>
                        </td>
                    </tr>


                @endforeach
            </tbody>
        </table>
    </div>

    @foreach($orders as $order)
        <div class="modal fade" id="exampleModal{{$order->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Order number: {{$order->id}}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <h3>Check</h3>

                        <table class="table">
                            <tr>
                                <th>Registred user:</th>
                                <td>{{auth()->user()->name}}</td>
                            </tr>
                            <tr>
                                <th>User id:</th>
                                <td>{{$order->user_id}}</td>
                            </tr>
                            <tr>
                                <th>Products:</th>
                                <td>
                                    <ul>
                                        @foreach($order->products as $product => $number)
                                            <li>{{$number}}x <a href="/products/{{$product}}">{{$product}}</a></li>
                                        @endforeach
                                    </ul>
                                </td>
                            </tr>
                            <tr>
                                <th>Bought on:</th>
                                <td>{{$order->created_at}}</td>
                            </tr>
                            <tr>
                                <th>Total price:</th>
                                <td>${{$order->price}}</td>
                            </tr>
                        </table>
                    </div>
                    <div class="modal-footer">
                        <small>Approved by Mongo-Shop team</small>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    @endforeach

@endsection