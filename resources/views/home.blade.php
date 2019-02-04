@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">User profile</div>
                <div class="card-header"><a href="/shoppingcart">Shopping cart</a></div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                        {{--You are logged in!--}}
                        <div class="form-group">
                            <label>Name:</label>
                            <input class="form-control" name="name" placeholder="Name" required>
                        </div>
                        <div class="form-group">
                            <label>Email address:</label>
                            <input class="form-control" name="email" placeholder="Email" required>
                        </div>
                        <div class="form-group">
                            <label>Birthdate:</label>
                            <input class="form-control" name="birthdate" placeholder="Birthdate">
                        </div>
                        <div class="form-group">
                            <label>Address:</label>
                            <input class="form-control" name="address" placeholder="Address">
                        </div>
                        <div class="form-group">
                            <label>City:</label>
                            <input class="form-control" name="city" placeholder="City">
                        </div>
                        <div class="form-group">
                            <label>Postal code:</label>
                            <input class="form-control" name="postalCode" placeholder="Postal code">
                        </div>
                        <div class="form-group">
                            <label>Phone number:</label>
                            <input class="form-control" name="phoneNumber" placeholder="Phone number">
                        </div>
                        <button type="submit" class="btn btn-primary">Update profile</button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
