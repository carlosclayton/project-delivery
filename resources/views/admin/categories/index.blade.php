@extends('app')

@section('content')
    <div class="container">
        <h3>Categorias</h3>

        <!-- Link usando nome de rota -->
        <a href="{{route('create')}}"  class="btn btn-primary">Nova categoria</a>
        <table class="table">
            <thead>
            <th>
            <td>ID</td>
            <td>Nome</td>
            <td>Ação</td>
            </th>
            </thead>
            <tbody>
            @foreach($categories as $category)
            <tr>
                <td>{{ $category->id }}</td>
                <td>{{ $category->name }}</td>
                <td></td>
            </tr>
            @endforeach
            </tbody>
        </table>
        {{ $categories->render() }}
    </div>
@endsection