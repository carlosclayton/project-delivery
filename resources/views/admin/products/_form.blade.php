

        <div class="form-group">
            {!! Form::label('category', 'Categoria:') !!}
            {!! Form::select('category_id', $cats, null,  ['class' => 'form-control',  'placeholder'=> 'Digite um produto']) !!}
        </div>

        <div class="form-group">
            {!! Form::label('name', 'Produto:') !!}
            {!! Form::text('name', null , ['class' => 'form-control',  'placeholder'=> 'Digite um produto']) !!}
        </div>


        <div class="form-group">
            {!! Form::label('description', 'Descricao:') !!}
            {!! Form::textarea('description', null , ['class' => 'form-control',  'placeholder'=> 'Digite uma descricao']) !!}
        </div>

        <div class="form-group">
            {!! Form::label('price', 'Preco:') !!}
            {!! Form::text('price', null , ['class' => 'form-control',  'placeholder'=> 'Digite um produto']) !!}
        </div>
