@extends('app')

@section('content')
    <div class="container">
        <h3>Pedidos</h3>

        <!-- Link usando nome de rota -->
        <a href="{{route('create')}}"  class="btn btn-primary">Novo pedido</a>
        <table class="table">
            <thead>
            <tr>
            <th>ID</th>
                <th>Total</th>
                <th>Status</th>
            <th>Action</th>
            </tr>
            </thead>
            <tbody>
            @foreach($orders as $order)
            <tr>
                <td>{{ $order->id }}</td>
                <td>{{ $order->total }}</td>
                <td>{{ $order->status }}</td>
                <td></td>
                <td><a href="{{route('edit', ['id' => $order->id ])}}"  class="btn btn-primary">Editar</a></td>
                <td><a href="{{route('destroy', ['id' => $order->id ])}}"  class="btn btn-danger">Deletar</a></td>
            </tr>
            @endforeach
            </tbody>
        </table>
        {{ $orders->render() }}
    </div>
@endsection