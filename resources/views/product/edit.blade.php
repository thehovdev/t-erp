@extends('layouts.app')

@section('content')
<hr>
<div class="row">
    <div class="col-sm-8">
        <form action="{{ route('product.update', ['product' => $product, 'id' => $id]) }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="name">Name:</label>
                <input type="text" class="form-control" id="name" name="name" value="{{ $product->name }}">
            </div>

            <button type="submit" class="btn btn-success">Submit</button>
        </form>
    </div>
</div>


@endsection
