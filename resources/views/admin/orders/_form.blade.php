


        <div class="form-group">
            {!! Form::label('name', 'Nome:') !!}
            {!! Form::text('user[name]', null , ['class' => 'form-control',  'placeholder'=> 'Digite um produto']) !!}
        </div>


        <div class="form-group">
            {!! Form::label('email', 'Email:') !!}
            {!! Form::text('user[email]', null , ['class' => 'form-control',  'placeholder'=> 'Digite um email']) !!}
        </div>

        <div class="form-group">
            {!! Form::label('address', 'Endereco:') !!}
            {!! Form::textarea('address', null , ['class' => 'form-control',  'placeholder'=> 'Digite um endereco']) !!}
        </div>

        <div class="form-group">
            {!! Form::label('phone', 'Telefone:') !!}
            {!! Form::text('phone', null , ['class' => 'form-control',  'placeholder'=> 'Digite um telefone']) !!}
        </div>

        <div class="form-group">
            {!! Form::label('city', 'Cidade:') !!}
            {!! Form::text('city', null , ['class' => 'form-control',  'placeholder'=> 'Digite uma cidade']) !!}
        </div>

        <div class="form-group">
            {!! Form::label('state', 'Estado:') !!}
            {!! Form::text('state', null , ['class' => 'form-control',  'placeholder'=> 'Digite um estado']) !!}
        </div>
