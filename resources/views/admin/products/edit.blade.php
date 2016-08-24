@extends('app')

@section('content')
    <div class="container">
        <h3>Editar produto {{ $prod->name }}</h3><hr />

        @include('errors._check')


        {!! Form::model($prod, ['route' => ['update', $prod->id], 'class' => 'form']) !!}

        @include('admin.products._form')


        <div class="form-group">
            {!! Form::submit('Salvar',['class' => 'btn btn-primary']) !!}
        </div>

        {!! Form::close() !!}

    </div>
@endsection