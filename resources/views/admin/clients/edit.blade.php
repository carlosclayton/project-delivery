@extends('app')

@section('content')
    <div class="container">
        <h3>Editar cliente {{ $client->name }}</h3><hr />

        @include('errors._check')


        {!! Form::model($client, ['route' => ['update', $client->id], 'class' => 'form']) !!}

        @include('admin.clients._form')


        <div class="form-group">
            {!! Form::submit('Salvar',['class' => 'btn btn-primary']) !!}
        </div>

        {!! Form::close() !!}

    </div>
@endsection