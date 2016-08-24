@extends('app')

@section('content')
    <div class="container">
        <h3>Novo produto</h3><hr />

        @include('errors._check')

        {!! Form::open(['route' => 'store', 'class' => 'form']) !!}

        @include('admin.products._form')

        <div class="form-group">
            {!! Form::submit('Cadastrar',['class' => 'btn btn-primary']) !!}
        </div>

        {!! Form::close() !!}

    </div>
@endsection