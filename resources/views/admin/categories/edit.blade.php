@extends('app')

@section('content')
    <div class="container">
        <h3>Editar Categoria {{ $cat->name }}</h3><hr />

        @include('errors._check')


        {!! Form::model($cat, ['route' => ['update', $cat->id], 'class' => 'form']) !!}

        @include('admin.categories._form')


        <div class="form-group">
            {!! Form::submit('Salvar',['class' => 'btn btn-primary']) !!}
        </div>

        {!! Form::close() !!}

    </div>
@endsection