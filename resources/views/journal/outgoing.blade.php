@extends('layouts.app')

@section('content')

    <div class="row">
        <div class="col-sm-12">

            <table class="table table-bordered">
                <thead>
                  <tr>
                    <th>Receiver</th>
                    {{-- <th>Receiver(Email)</th> --}}
                    <th>Receiver(Storage)</th>
                    <th>Product</th>
                    <th>Serial Numbers</th>
                    <th>Count</th>
                    <th>Action</th>

                  </tr>
                </thead>
                <tbody>
                    @foreach ($outgoing_actions as $inaction)
                        <tr>
                            <td>{{ $inaction->receive('user')->name }}</td>
                            {{-- <td>{{ $inaction->receive('user')->email }}</td> --}}
                            <td>{{ $inaction->receive('storage')->name }}</td>
                            <td>{{ @$inaction->receive('product')->name }}</td>
                            <td>{{ $inaction->receive('serials') }}</td>
                            <td>{{ $inaction->receive('count') }}</td>
                            <td>
                                @if($inaction->receiverProductExists())
                                    <a class="btn btn-warning" href="{{ route('product.returnback', $inaction) }}">Return Back</a>
                                @endif
                            </td>

                        </tr>
                    @endforeach
                </tbody>
              </table>


        </div>

   
    </div>

@endsection
