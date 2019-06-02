@extends('layouts.app')

@section('content')
<hr>
<div class="row">
    <div class="col-sm-8">
        <form action="{{ route('product.store') }}" method="POST">
            @csrf
            @method('POST')
            <input type="hidden" name="storage_id" value="{{ $id }}">
            <div class="form-group">
                <label for="name">Name:</label>
                <input type="text" class="form-control" id="name" name="name" value="HP - Laptop">
            </div>

            <div class="form-group">
                <label for="price">Price (AZN):</label>
                <input type="number" class="form-control" id="price" name="price" value="1000">
            </div>

            <div class="form-group">
                <label for="count">Count:</label>
                <input type="number" class="form-control" id="count" name="count">
            </div>

            <div class="form-group">
                <label for="serial">Serial:</label>
                <textarea type="text" class="form-control" id="serial" name="serial" placeholder="Yeni seriya yeni sətrdə yazılır"></textarea>
            </div>

            <button type="submit" class="btn btn-success">Submit</button>
        </form>
    </div>
</div>


@endsection
