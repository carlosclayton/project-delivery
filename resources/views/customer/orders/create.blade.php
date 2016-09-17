@extends('app')

@section('content')
    <div class="container">
        <h3>Novo produto</h3><hr />

        @include('errors._check')

        {!! Form::open(['class' => 'form']) !!}
        <div class="form-group">
            <label > Total: </label>
            <p id="total"></p>
            <a id="btnNewItem" href="#" class="btn btn-default">Novo item</a>
            <br />
            <br />

        <table class="table table-bordered">
            <thead>
            <tr>
                <td>Produto</td>
                <td>Quantidade</td>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td>
                    <select name="items[0][product_id]" id="" class="form-control">
                        @foreach($products as $prod)
                            <option value="{{$prod->id}}" data-price="{{$prod->price}}">{{$prod->name}} --- {{$prod->price}}</option>
                        @endforeach
                    </select>
                </td>
                <td>
                    {!! Form::text('items[0][qtd]', 1 , ['class' => 'form-control']) !!}
                </td>
            </tr>
            </tbody>
        </table>

        <div class="form-group">
            {!! Form::submit('Criar pedido',['class' => 'btn btn-primary']) !!}
        </div>

        {!! Form::close() !!}

    </div>
@endsection

@section('post-script')
            <script>
                $("#btnNewItem").click(function(){
                    var row = $('table tbody > tr:last'),
                            newRow  = row.clone(),
                            length = $('table tbody tr').length;

                    newRow.find('td').each(function(){
                        var td = $(this),
                                input = td.find('input,select'),
                                name = input.attr('name');
                        input.attr('name', name.replace((length -1) + "", length + ""));
                    });

                    newRow.find('input').val(1);
                    newRow.insertAfter(row);
                    calculateTotal();
                });

                $(document.body).on('click', 'select', function(){
                    calculateTotal();
                });

                $(document.body).on('blur', 'input', function(){
                        calculateTotal();
                });

                function calculateTotal(){
                    var total = 0,
                    trlen = $('table tbody tr').length,
                    tr = null, price, qtd;

                    for(var i = 0; i < trlen; i++){
                        tr = $('table tbody tr').eq(i);
                        price = tr.find(':selected').data('price');
                        qtd  = tr.find('input').val();
                        total += price * qtd;
                    }

                    $('#total').html(total);
                }
            </script>

@endsection