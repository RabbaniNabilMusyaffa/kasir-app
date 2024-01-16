@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-7">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <h4>{{ __('Master Transaction') }}</h4>

                </div>
                @if (Session::has('message'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <span class="alert-icon"><i class="ni ni-like-2"></i></span>
                    <span class="alert-text"><strong>{{Session::get('message')}}!</strong></span>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                @endif
                <!-- Begin Page Content -->
                <div class="card-body">

                    <div class="row">
                        <div class="card mb-5">
                            <div class="table-responsive">
                                <table class="table align-items-center mb-0">
                                    <thead>
                                        <tr>
                                            <th
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                No</th>
                                            <th
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                                Name Item</th>

                                            <th
                                                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Nama Category</th>
                                            <th
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                                Stock</th>
                                            <th
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                                Price</th>

                                            <th
                                                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($datas as $transaction)
                                        <tr>
                                            <td>{{$loop->iteration }}</td>
                                            <td>{{$transaction -> name }}</td>
                                            <td>{{$transaction -> category -> name }}</td>
                                            <td>{{$transaction -> stock }}</td>
                                            <td>Rp. {{number_format ($transaction -> price) }}</td>
                                            <td class="text-center align-middle">
                                                <a class="btn btn-warning" role="button"
                                                    href="{{ route ('tambahtransaction', $transaction->id) }}">
                                                    <i class="fas fa-edit"></i>
                                                    Add Cart
                                                </a>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="mb-4">
                                {{$datas->links('pagination::bootstrap-5')}}


                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-5">
            <div class="card">
                <div class="card-header">
                    Cart
                </div>
                <div class="card-body">
                    <table class="table table-striped">
                        <thead>
                            <th>#</th>
                            <th>Item</th>
                            <th>Qty</th>
                            <th>Harga</th>
                            <th>Action</th>
                        </thead>

                        @php $total = 0; @endphp
                        @if(session('cart'))
                        @foreach (session('cart') as $item)
                        @php $total += $item['subtotal']; @endphp
                        <tr>
                            <td>{{$loop->iteration }}</td>
                            <td>{{$item['name'] }}</td>
                            <form action="{{route('update-transaction')}}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="id" value="{{$item['id']}}">
                                <td>
                                    <input class="form-control" type="number" onchange="ubah{{ $loop->iteration }}()"
                                        name="qty" min="0" style="width: 60px;" value="{{$item['qty']}}">
                                </td>
                                <td>Rp. {{ number_format($item['subtotal']) }}</td>
                                <td>
                                    <a class="btn btn-sm btn-danger" id="delete{{ $loop->iteration }}"
                                        href="{{ route ('delete-transaction', $item['id']) }}">
                                        delete
                                    </a>
                                    <input id="update{{ $loop->iteration }}" type="submit" style="display: none"
                                        class="btn btn-sm btn-primary" value="update">
                                </td>
                                <script>
                                    function ubah{{ $loop->iteration }} (){
                                        $('#delete{{ $loop->iteration }}').hide();
                                        $('#update{{ $loop->iteration }}').show();

                                    }
                                </script>
                            </form>
                            @endforeach
                            @else
                        <tr>
                            <td colspan="5 " class="text-center">
                                no item in cart
                            </td>
                        </tr>
                        </tr>
                        @endif
                    </table>
                    <form action="{{route('transaction.store')}}" method="POST">
                        @csrf
                        <table class="table">
                            <tr>
                                <td class="text-end" colspan="3"><strong>Grand Total</strong></td>
                                <td>
                                    <input id="total" name="total" type="number" class="form-control" value="{{ $total }}" readonly>
                                </td>
                            </tr>
                            <tr>
                                <td class="text-end" colspan="3"><strong>Pay Total</strong></td>
                                <td>
                                    <input type="number" name="pay_total" onkeyup="hitung()" id="pay_total"  class="form-control" min="{{  $total  }}" >
                                </td>
                            </tr>
    
                            <script>
                                function hitung(){
                                    var bayar = $('#pay_total').val();
                                    var total = $('#total').val();
                                    var change = bayar - total;
                                    $('#change').val(change);
                                }
                            </script>
    
                            <tr>
                                <td class="text-end" colspan="3"><strong>Change</strong></td>
                                <td>
                                    <input type="number" class="form-control" name="change" id="change" readonly>
                                </td>
                            </tr>
                            <tr>
                                <td class="text-end" colspan="6">
                                
                                    <input type="submit" class="btn btn-success" value="Checkout">
                                    <input class="btn btn-danger" value="reset">
                                </td>
                            </tr>
                        </table>
                    </form>
                    


                </div>
            </div>
        </div>
    </div>

</div>
</div>
@endsection