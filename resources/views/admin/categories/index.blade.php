@extends('app')

@section('content')
    <div class="container">
        <h3>Categorias</h3>

        <!-- Link usando nome de rota -->
        <a href="{{route('create')}}"  class="btn btn-primary">Nova categoria</a>
        <table class="table">
            <thead>
            <tr>
            <th>ID</th>
            <th>Nome</th>
            <th>Action</th>
            </tr>
            </thead>
            <tbody>
            @foreach($categories as $category)
            <tr>
                <td>{{ $category->id }}</td>
                <td>{{ $category->name }}</td>
                <td><a href="{{route('edit', ['id' => $category->id ])}}"  class="btn btn-primary">Editar</a></td>
            </tr>
            @endforeach
            </tbody>
        </table>
        {{ $categories->render() }}
    </div>
@endsection