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
            <th>Produto</th>
                <th>Categoria</th>
                <th>Valor</th>
            <th>Action</th>
            </tr>
            </thead>
            <tbody>
            @foreach($prods as $prod)
            <tr>
                <td>{{ $prod->id }}</td>
                <td>{{ $prod->name }}</td>
                <td>{{ $prod->category->name }}</td>
                <td>{{ $prod->price }}</td>
                <td><a href="{{route('edit', ['id' => $prod->id ])}}"  class="btn btn-primary">Editar</a></td>
                <td><a href="{{route('destroy', ['id' => $prod->id ])}}"  class="btn btn-danger">Deletar</a></td>
            </tr>
            @endforeach
            </tbody>
        </table>
        {{ $prods->render() }}
    </div>
@endsection