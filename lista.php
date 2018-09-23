<?php
include_once('./html_includs/header.php');
include_once('./phpclass/db/Conn.php');
include_once('./phpclass/clients/Clientes.php');
$cliente = new Clientes();
$lista_cliente = $cliente->getAll();
?><br>
    <div class="container">
        <div class="alert alert-warning hide">
            <strong>Ops !</strong> Nada encontrado
            <button type="button" class="close" onclick="fecha('.alert')">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    </div>
    <div class="container">
        <div class="alert js_deletar_dados alert-warning hide">
            <strong>Ops !</strong> Dados deletados
            <button type="button" class="close" onclick="fecha('.alert')">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    </div>
    <div class="content">
        <div class="col-md-12 ">
            <div class="">
                <label for="find"></label>
                <input type="text" name="find">
                <button class="button" type="button" onclick="filter()">Procurar</button>
            </div>
            <br>
            <div class="">
                <button class="button" onclick="deletarDados()">Deletar dado</button>
            </div>
            <hr>

            <table class="table table-striped">
                <tr>
                    <th>#</th>
                    <th>RAZÃO SOCIAL</th>
                    <th>ENDEREÇO</th>
                    <th>BAIRRO</th>
                    <th>CEP</th>
                    <th>MUNICÍPIO</th>
                    <th>UF</th>
                    <th>TELEFONE</th>
                    <th>CNPJ</th>
                    <th>VALOR</th>
                    <th>VENCIMENTO</th>
                </tr>

                <!--                Código para template de tabela-->
                <tr class="js_table_template hide">
                    <td class="js_number" >{binde-value}</td>
                    <td class="js_razao_social" >{binde-value}</td>
                    <td class="js_endereco" >{binde-value}</td>
                    <td class="js_bairro" >{binde-value}</td>
                    <td class="js_cep" >{binde-value}</td>
                    <td class="js_municipio" >{binde-value}</td>
                    <td class="js_uf" >{binde-value}</td>
                    <td class="js_telefone" >{binde-value}</td>
                    <td class="js_cnpj" >{binde-value}</td>
                    <td class="js_valor" >{binde-value}</td>
                    <td class="js_vencimento" >{binde-value}</td>
                </tr>
                <!--                Código para template de tabela-->

                <?php
                foreach ($lista_cliente as $key => $cliente){
                    ?>

                    <tr id="table_<?=$key+1?>" class="js_table">
                        <td class="js_number" ><?= $key+1 ?></td>
                        <td class="js_razao_social" ><?= $cliente->razao_social?></td>
                        <td class="js_endereco" ><?= $cliente->endereco?></td>
                        <td class="js_bairro" ><?= $cliente->bairro?></td>
                        <td class="js_cep" ><?= $cliente->cep?></td>
                        <td class="js_municipio" ><?= $cliente->municipio?></td>
                        <td class="js_uf" ><?= $cliente->uf?></td>
                        <td class="js_telefone" ><?= $cliente->telefone?></td>
                        <td class="js_cnpj" ><?= $cliente->cnpj?></td>
                        <td class="js_valor" ><?= $cliente->valor?></td>
                        <td class="js_vencimento" ><?= $cliente->vencimento?></td>
                    </tr>

                    <?php
                }
                ?>
            </table>
        </div>


    </div>
    <script src="./assets/js/jquery.js"> </script>

    <script>
        function filter()
        {
            var filter_name = $('input[name=find]').val();
            $.ajax({
                url: ".//phpclass/http_consult/client.php?clients="+filter_name,
                dataType: "json",
            }).done(function(retorno) {
                if ($.isEmptyObject(retorno)) {
                    $('.alert').removeClass('hide');
                } else {
                    povoaTabela(retorno);
                }
            });
        }

        function deletarDados()
        {
            $.ajax({
                method:'POST',
                url: ".//phpclass/clients/limpar_dados.php",
            }).done(function(retorno) {
                window.location.reload(true);
            });
        }

        function povoaTabela(dados)
        {
            $('.js_table').remove();

            $.each(dados, function(key, dado){
                insertRowTable(dado, key);
            });
        }

        function insertRowTable(dados, key)
        {
            template = $('.js_table_template');
            template.find('.js_number').text(key+1);
            template.find('.js_razao_social').text(dados.razao_social);
            template.find('.js_endereco').text(dados.endereco);
            template.find('.js_bairro').text(dados.bairro);
            template.find('.js_cep').text(dados.cep);
            template.find('.js_municipio').text(dados.municipio);
            template.find('.js_uf').text(dados.uf);
            template.find('.js_telefone').text(dados.telefone);
            template.find('.js_cnpj').text(dados.cnpj);
            template.find('.js_valor').text(dados.valor);
            template.find('.js_vencimento').text(dados.vencimento);
            $('.table').append('<tr class="js_table">'+template.html()+'<tr>');
        }

        function fecha(element)
        {
            $(element).addClass('hide');
        }

    </script>
<?php
include_once('./html_includs/footer.php');
?>