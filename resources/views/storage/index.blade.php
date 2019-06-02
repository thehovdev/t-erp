@extends('layouts.app')

@section('content')
<div class="row my-2">
    <div class="col-sm-4">
        <form action="{{ route('storage.store') }}" method="GET">
            <div class="input-group mb-3">
                <input type="text" class="form-control" name="name" placeholder="Storage - X">
                <div class="input-group-append">
                    <button class="btn btn-success" type="submit">Add storage</button> 
                </div>
            </div>
        </form>
    </div>
</div>

<div class="row">
    <div class="col-sm-12">
        <table class="table">
            <thead>
                <tr>
                <th>Name</th>
                <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($storages as $storage)
                    <tr>
                        <td>{{ $storage->name }}</td>
                        <td>
                            <form action="{{ route('storage.delete') }}" method="GET" class="d-inline-block">
                                <input type="hidden" name="id" value="{{ $storage->id }}">
                                <button class="btn btn-danger">Delete</button>
                            </form>

                            <a href="{{ route('storage.list', $storage) }}" class="btn btn-primary">View</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>


@endsection
