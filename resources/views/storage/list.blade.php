@extends('layouts.app')

@section('content')
<div class="row my-2">
    <div class="col-sm-4">
        <a href="{{ route('product.create', $id) }}" class="btn btn-success" type="submit">Add product</a> 
        @if(Auth::user()->role_id !== 1)
            <a href="{{ route('product.send', $id) }}" class="btn btn-primary" type="submit">Send product</a> 
        @endif
    </div>
</div>

<div class="row">
    <div class="col-sm-12">
        <table class="table">
            <thead>
                <tr>
                <th>Name</th>
                <th>Price (AZN)</th>
                <th>Total (AZN)</th>
                <th>Count</th>
                <th>Serial</th>
                <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($products as $product)
                    <tr>
                        <td>{{ $product->name }}</td>
                        <td>{{ $product->price }}</td>
                        <td>{{ $product->price * $product->count }}</td>
                        <td>{{ $product->count }}</td>
                        <td>{{ $product->serial }}</td>
                        <td>
                            <form action="{{ route('product.destroy', $product) }}" class="d-inline-block">
                                <button class="btn btn-danger">Delete</button>
                            </form>

                            <a href="{{ route('product.edit', ['product' => $product, 'id' => $id]) }}" class="btn btn-primary">View</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>


@endsection
