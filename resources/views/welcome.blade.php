<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Testes :upd8</title>
        <link rel="stylesheet" type="text/css" href="{{ asset('/css/dataTables.bootstrap5.min.css') }}" />
        <link rel="stylesheet" type="text/css" href="{{ asset('/css/bootstrap.min.css') }}" />
        <script src="{{ asset('/js/jquery.min.js') }}"></script>
        <script src="{{ asset('/js/bootstrap.min.js') }}"></script>
        <script src="{{ asset('/js/jquery.dataTables.min.js') }}"></script>
        <script src="{{ asset('/js/dataTables.bootstrap5.min.js') }}"></script>
        <script src="{{ asset('/js/jquery.mask.min.js') }}"></script>        
    </head>
    <body>
        <div class="container-lg border-info">
            <div class="card col-sm-12">
                @include('telapesquisa')
                <div class="card-body">
                    <div class="card col-sm-12">
                        <div class="card-header">
                            <h5 class="text-info">Resultado da Pesquisa</h5>
                        </div>
                        <div class="card-body">
                            <table id="resultadoPesquisa" class="table table-striped" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>&nbsp;</th>
                                        <th>&nbsp;</th>
                                        <th>Cliente</th>
                                        <th>CPF</th>
                                        <th>Data Nasc.</th>
                                        <th>Estado</th>
                                        <th>Cidade</th>
                                        <th>Sexo</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    
                                </tbody>
                            </table>    
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Button trigger modal -->

  
        <div class="modal fade" id="telaCadastro" tabindex="-1" aria-labelledby="telaCadastroLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        @include('telacadastro')
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="telaExclusao" tabindex="-1" aria-labelledby="telaExclusaoLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="telaExclusaoLabel">Exclusão de Clientes</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        Tem certeza que deseja excluir esse cliente?
                        <input type="hidden" id="eID" name="eID" />
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-danger" onclick="excluirCliente(this)">Sim, Desejom excluir!</button>
                      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" aria-label="Close">Cancelar</button>
                    </div>
                </div>
            </div>
        </div>

    </body>
    <script>
            var tableResultado = $('#resultadoPesquisa').DataTable({
                ajax: {
                    url: '/api/listar-clientes',
                    type: 'POST',
                    "data": function ( d ) {
                        return $('#formCliente').serialize();
                    },
                },
                "info": false,
                "searching": false,
                "ordering": false,
                "language": {
                    "lengthMenu": "Mostrando _MENU_ registro por pagina",
                    "zeroRecords": "Sem registro encontrados",
                    "info": "Exibindo página _PAGE_ de _PAGES_",
                    "infoEmpty": "Sem registros encontrados",
                    "infoFiltered": "(filtered from _MAX_ total records)",
                    "search": "Pesquisar:",
                    "decimal": ",",
                    "thousands": ".",
                    "pagingType": "full_numbers",
                    searchPlaceholder: "Pesquisar",
                    paginate: {
                        first: "Primeiro",
                        previous: "Anterior",
                        next: "Próximo",
                        last: "Último"
                    },
                },
                columns: [
                    {
                        className: 'dt-excluir',
                        orderable: false,
                        data: null,
                        defaultContent: '<button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#telaExclusao" data-whatever="@Delete">Excluir</button>',
                        width: '20px',
                    },
                    {
                        className: 'dt-editar',
                        orderable: false,
                        data: null,
                        defaultContent: '<button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#telaCadastro" data-whatever="@Edit">Alterar</button>',
                        width: '20px',
                    },
                    {data : 'nomeCliente'},
                    {data : 'numeroCPF'},
                    {data : 'dataNascimento'},
                    {data : 'estado'},
                    {data : 'cidade'},
                    {data : 'sexoCliente'},
                ],
            });

        $('#resultadoPesquisa tbody').on('click', 'td.dt-editar', function () {
            var tr = $(this).closest('tr');
            var row = tableResultado.row(tr);
            tr.addClass('dt-hasChild shown');
            document.getElementById('xID').value = row.data().id;
            document.getElementById('xnumeroCPF').value = row.data().numeroCPF;
            document.getElementById('xnomeCliente').value = row.data().nomeCliente;
            document.getElementById('xnomeRua').value = row.data().nomeRua;
            document.getElementById('xdataNascimento').value = row.data().dataNascimento;
            document.getElementById('xestado_id').value = row.data().estado_id;
            buscaCidades(document.getElementById('xestado_id'), xCidade='xcidade_id', row.data().cidade_id);
            document.querySelector('input[name=xsexoCliente][value="'+row.data().sexoCliente+'"]').click();
            
        });
        $('#resultadoPesquisa tbody').on('click', 'td.dt-excluir', function () {
            var tr = $(this).closest('tr');
            var row = tableResultado.row(tr);

            tr.addClass('dt-hasChild shown');
            document.getElementById('eID').value = row.data().id;
        });

        comboEstados = document.getElementById('estado_id');
        while (comboEstados.length) {
            comboEstados.remove(0);
        }

        xComboEstados = document.getElementById('xestado_id');
        while (xComboEstados.length) {
            xComboEstados.remove(0);
        }

        $.getJSON("/api/estados", function(data){            
            var opt0 = document.createElement("option");
            opt0.value = 0;
            opt0.text = 'Todos';
            comboEstados.add(opt0, comboEstados.options[0]);
            
            $.each(data, function(index,valor){
                var opt0 = document.createElement("option");
                opt0.value = valor.id;
                opt0.text = valor.estado;
                comboEstados.add(opt0, comboEstados.options[0])
            });

            var opt1 = document.createElement("option");
            opt1.value = 0;
            opt1.text = 'Todos';
            xComboEstados.add(opt1, xComboEstados.options[0]);
            
            $.each(data, function(index,valor){
                var opt1 = document.createElement("option");
                opt1.value = valor.id;
                opt1.text = valor.estado;
                xComboEstados.add(opt1, xComboEstados.options[0])
            });
        });

        function buscaCidades(componente, xCidade='cidade_id', vCidade) {
            iEstado = componente.options[componente.selectedIndex].value;
            comboCidades = document.getElementById(xCidade);
            while (comboCidades.length) {
                comboCidades.remove(0);
            }
            $.getJSON("/api/listar-cidades/"+iEstado, function(data){             
                $.each(data, function(index,valor){
                    var opt0 = document.createElement("option");
                    opt0.value = valor.id;
                    opt0.text = valor.cidade;
                    if (valor.id==vCidade) {
                        opt0.selected = true;
                    }
                    comboCidades.add(opt0, comboCidades.options[0])
                });
            });
            
        }

        function pesquisarCliente() {
            var table = $('#resultadoPesquisa').DataTable();
            table.ajax.reload(null, false);
        }

        function resetCliente() {
            document.getElementById("formCliente").reset();
        }

        document.getElementById('resultadoPesquisa_length').style.display = 'none';


        $('#telaCadastro').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget) 
            var recipient = button.data('whatever') 
            var modal = $(this);
            document.getElementById('botaoSalvar').value = recipient;
            document.getElementById("xformCliente").reset();
        });

        $('#telaCadastro').on('hidden.bs.modal', function (e) {
            var table = $('#resultadoPesquisa').DataTable();
            table.ajax.reload(null, false);
        })
        

        $('#telaExclusao').on('hidden.bs.modal', function (e) {
            var table = $('#resultadoPesquisa').DataTable();
            table.ajax.reload(null, false);
        })


    function salvarCliente(botao) {

        var dataForm = $('#xformCliente').serialize();
        if (botao.value=="@Insert") {
            $.ajax({
                url: "/api/cliente",
                async: false,
                type:   "POST",
                data : dataForm,
                success: function (data){
                    alert('Registro Criado com Sucesso!!!!');
                    $(".btn-close").click();
                },
                error: function (jqXhr, textStatus, errorMessage){
                    alert('Problemas ao Criar Registro!!!!\n\r' + jqXhr.responseText);
                },
            });
        } else if (botao.value=="@Edit") {
            $.ajax({
                url: "/api/cliente/"+document.getElementById('xID').value,
                async: false,
                type:   "PUT",
                data : dataForm,
                success: function (data){
                    alert('Registro Criado com Sucesso!!!!');
                    $(".btn-close").click();
                },
                error: function (jqXhr, textStatus, errorMessage){
                    alert('Problemas ao Criar Registro!!!!', textStatus);
                },
            });
        }
        
    }
    function excluirCliente(botao) {
        $.ajax({
            url: "/api/cliente/"+document.getElementById('eID').value,
            async: false,
            type:   "DELETE",
            success: function (data){
                alert('Registro Excluido com Sucesso!!!!');
                $(".btn-close").click();
            },
            error: function (jqXhr, textStatus, errorMessage){
                alert('Problemas ao Excluir Registro!!!!', textStatus);
            },
        });
    }
    </script>
</html>
