@extends('app')

@section('content')
    <div class="container">
        <h3>Nova Categoria</h3><hr />

        @if (count($errors) > 0)
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {!! Form::open(['route' => 'store', 'class' => 'form']) !!}
        <div class="form-group">
            {!! Form::label('name', 'Categoria:') !!}
            {!! Form::text('name', null, ['class' => 'form-control',  'placeholder'=> 'Digite uma categoria']) !!}
        </div>

        <div class="form-group">
            {!! Form::submit('Cadastrar',['class' => 'btn btn-primary']) !!}
        </div>

        {!! Form::close() !!}

    </div>
@endsection