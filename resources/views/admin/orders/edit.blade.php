@extends('app')

@section('content')
    <div class="container">

        <h1 class="page-header" id="tables">
            <a class="anchorjs-link " href="#tables" aria-label="Anchor link for: tables" data-anchorjs-icon="?" style="font-family: anchorjs-icons; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: normal; line-height: inherit; position: absolute; margin-left: -1em; padding-right: 0.5em;"></a>Pedido #{{ $order->id }}</h1>


        <h2 id="tables-example">Dados do pedido</h2>
        <div class="bs-example" data-example-id="striped-table">
            <table class="table table-striped">
                <thead> <tr> <th>#</th> <th>Cliente</th> <th>Data</th> <th>Total</th> </tr> </thead>
                <tbody>
                <tr>
                    <th scope="row">{{ $order->id }}</th> <td>{{ $order->client->user->name }}</td> <td>{{ $order->created_at }}</td> <td>{{ $order->total }}</td>
                </tr>
                </tbody> </table>
        </div>

        <br />
        <br />

        <h2 id="tables-example">Dados da entrega</h2>
        <div class="bs-example" data-example-id="striped-table">
            <table class="table table-striped">
                <thead> <tr> <th>#</th> <th>Endereco</th> <th>Cidade</th> <th>Estado</th> </tr> </thead>
                <tbody>
                <tr>
                    <th scope="row">{{ $order->client->id }}</th> <td>{{ $order->client->address }}</td> <td>{{ $order->client->city }}</td> <td>{{ $order->client->state }}</td>
                </tr>
                </tbody> </table>
        </div>

        <br />
        <br />


        <h2 id="tables-example">Situacao do pedido</h2>
        <div class="bs-example" data-example-id="striped-table">
            @include('errors._check')


            {!! Form::model($order, ['route' => ['update', $order->id], 'class' => 'form']) !!}

            <div class="form-group">
                {!! Form::label('Status', 'Categoria:') !!}
                {!! Form::select('status', $list_status, null,  ['class' => 'form-control',  'placeholder'=> 'Selecione um status']) !!}
            </div>

            <div class="form-group">
                {!! Form::label('Entregador', 'Entregador:') !!}
                {!! Form::select('user_deliveryman_id', $deliveryman, null,  ['class' => 'form-control',  'placeholder'=> 'Selecione um entregador']) !!}
            </div>

            <div class="form-group">
                {!! Form::submit('Salvar',['class' => 'btn btn-primary']) !!}
            </div>

            {!! Form::close() !!}
        </div>

    </div>
@endsection