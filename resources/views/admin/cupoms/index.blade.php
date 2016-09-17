@extends('app')

@section('content')
    <div class="container">
        <h3>Cupoms</h3>

        <!-- Link usando nome de rota -->
        <a href="{{route('cupoms.create')}}"  class="btn btn-primary">Novo cupom</a>
        <table class="table">
            <thead>
            <tr>
            <th>ID</th>
                <th>Code</th>
                <th>Data</th>
                <th>Valor</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>
            @foreach($cupoms as $cupom)
            <tr>
                <td>{{ $cupom->id }}</td>
                <td>{{ $cupom->code }}</td>
                <td>{{ $cupom->created_at }}</td>
                <td>{{ $cupom->value }}</td>
                <td></td>
                <td><a href="{{route('cupoms.edit', ['id' => $cupom->id ])}}"  class="btn btn-primary">Editar</a></td>
                <td><a href="{{route('cupoms.destroy', ['id' => $cupom->id ])}}"  class="btn btn-danger">Deletar</a></td>
            </tr>
            @endforeach
            </tbody>
        </table>
        {{ $cupoms->render() }}
    </div>
@endsection