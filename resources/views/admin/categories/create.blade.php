@extends('app')

@section('content')
    <div class="container">
        <h3>Nova Categoria</h3><hr />

        @include('errors._check')

        {!! Form::open(['route' => 'store', 'class' => 'form']) !!}

        @include('admin.categories._form')

        <div class="form-group">
            {!! Form::submit('Cadastrar',['class' => 'btn btn-primary']) !!}
        </div>

        {!! Form::close() !!}

    </div>
@endsection