@extends('app')

@section('content')
    <div class="container">
        <h3>Produtos</h3>

        <!-- Link usando nome de rota -->
        <a href="{{route('create')}}"  class="btn btn-primary">Nova categoria</a>
        <table class="table">
            <thead>
            <tr>
            <th>ID</th>
            <th>Nome</th>
                <th>Phone</th>
                <th>Adress</th>
            <th>Action</th>
            </tr>
            </thead>
            <tbody>
            @foreach($clients as $client)
            <tr>
                <td>{{ $client->id }}</td>
                <td>{{ $client->user->name }}</td>
                <td>{{ $client->phone }}</td>
                <td>{{ $client->address }}</td>
                <td></td>
                <td><a href="{{route('edit', ['id' => $client->id ])}}"  class="btn btn-primary">Editar</a></td>
                <td><a href="{{route('destroy', ['id' => $client->id ])}}"  class="btn btn-danger">Deletar</a></td>
            </tr>
            @endforeach
            </tbody>
        </table>
        {{ $clients->render() }}
    </div>
@endsection