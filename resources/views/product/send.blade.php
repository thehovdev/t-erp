@extends('layouts.app')

@section('content')
<hr>
<div class="row">
    <div class="col-sm-8">
        <form action="{{ route('product.sendtoreceiver') }}" method="POST">
            @csrf
            @method('POST')
            <input type="hidden" name="storage_id" value="{{ $id }}">
            <div class="form-group">
                <label for="sel1">Select product:</label>
                <select class="form-control" name="product_id">
                    @foreach ($products as $product)
                        <option value="{{ $product->id }}">{{ $product->name }} (Count : {{ $product->count }} )</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="sel1">Select seller:</label>
                <select class="form-control" id="sel1" name="receiver_id">
                    @foreach ($receivers as $receiver)
                        <option value="{{ $receiver->id }}">{{ $receiver->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                    <label for="sel1">Select storage:</label>
                    <select class="form-control" id="sel1" name="receiver_storage_id">
                        @foreach ($receivers as $receiver)
                            <option disabled> {{ $receiver->name }} </option>
                            <hr>
                            @foreach ($receiver->storages as $storage)
                                <option value="{{ $storage->id }}">{{ $storage->name }}</option>
                            @endforeach
                        @endforeach
                    </select>
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
