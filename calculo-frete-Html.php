<?php
include "enum.php";
include "CalcularFrete.php";

?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content>
    <link href="bootstrap-5.0.0-beta2-dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Cálculo de Frete</title>
    <style>
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerDemo01"
                aria-controls="navbarTogglerDemo01" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarTogglerDemo01">
                <a class="navbar-brand" href="#">Tabela de Frete</a>
            </div>
        </div>
    </nav>
    <div class="page">
        <div class="container-fluid" style="margin-top:100px">
        </div>
        <div class="title-top" style="margin-top:15px">
        </div>
        <div class="container" style="margin-bottom: 50px;" class="row">
            <div class="col-lg-6 col-md-6">
                <div style="text-align:center;font-weight:bold;margin-bottom:15px;">
                    <h1><span class="badge badge-success"></span></h1>
                </div>
                <h5 style="font-weight:bold;">Simulador de Frete</h5>
                <form class="simulador ng-pristine ng-valid" name="s1" method="post" action="calculo-frete.php"
                    >
                    <div class="row">
                        <div class="col-lg-12 col-md-12">

                            <div class="row">
                                <div class="col-lg-12 col-md-12">
                                    <label>Categoria do transporte:</label>
                                    <select name="category" class="form-control" required="">
                                        <?php
                                        foreach ($category as $index => $label) {
                                            echo "<option value=".$index." ".(isset($_POST['category']) && $_POST['category'] == $index ? "selected" : "").">".$label."</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="col-lg-6 col-md-6">
                                    <label>Tipo de carga:</label>
                                    <select name="type" class="form-control" required="">
                                       <?php
                                       foreach ($type as $index => $label) {
                                           echo "<option value=".$index." ".(isset($_POST['type']) && $_POST['type'] == $index ? "selected" : "").">".$label."</option>";
                                       }
                                       ?>
                                    </select>
                                </div>
                                <div class="col-lg-6 col-md-6">
                                    <label>Número de eixos:</label>
                                    <input name="axes" type="number" min="0" max="15" class="form-control"  required="">
                                </div>
                                <div class="col-lg-6 col-md-6">

                                    <label>Distância (km):</label>
                                    <input name="distance" type="number" class="form-control" required="">
                                </div>
                                <div class="col-lg-6 col-md-6">
                                    <input type="submit" class="btn btn-primary" value="Calcular"
                                        style="width:100%;margin-top:24px;background-color: #F5B52D; color: black; border-color: black;">
                                </div>
                                <div
                                    style="padding: 40px;min-height: 100px;border:solid 1px #ebebeb;border-radius:4px;">
                                    <div id="result">
                                    <?php
                                    if($_SERVER['REQUEST_METHOD'] == 'POST') {

                                        /* Criando um novo objeto para calcular o frete com base nos dados informados pelo usuário */
                                        $frete = new CalcularFrete($_POST['category'], $_POST['type'], $_POST['axes'], $_POST['distance']);

                                        /* Calculando o valor do frete */
                                        $frete->calculate();

                                          /* Imprimindo o HTML na tela */
                                        
                                        $val  = '<h6 style="text-align: center"><b>Deslocamento (CCD)</b>: R$ ' . number_format($frete->getCC(), 2, ',', '.').'</h6>';
                                        $val .= '<h6 style="text-align: center"><b>Carga e descarga (CC)</b>: R$ ' . number_format($frete->getCCD(), 2, ',', '.').'</h6>';
                                        $val .= '<h6 style="text-align: center"><b>Total = (CCD + CC)</b>'.'</h6>';
                                        $val .= '<br/><h3 style="text-align: center"><b>Total</b>: R$ ' . number_format($frete->getTotal(), 2, ',', '.').'</h3>';
                                        $val .= '<br/>';
                                        $val .= ('<h6 style="text-align: center"><b>Categoria do transporte</b>: ') .$category[$_POST['category']].'</h6>';
                                        $val .= ('<h6 style="text-align: center"><b>Tipo de Transporte</b>: ') .$type[$_POST['type']].'</h6>';
                                        $val .= ('<h6 style="text-align: center"><b>Número de eixos</b>: ') .$_POST['axes'].'</h6>'; //.= significa acrescente
                                        $val .= ('<h6 style="text-align: center"><b>Distância (Km)</b>: ') .$_POST['distance'].'</h6>';
                                        
                                        echo($val);
                                    }
                                    ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
            </div>
        </div>
    </div>
    </div>
    </form>
    </div>
    </div>
    </div>
    </div>
    </div>
    <script src="bootstrap-5.0.0-beta2-dist/js/bootstrap.bundle.min.js"></script> //JAVASCRIPT
    <!--<script>
        var table = [];
        fetch("./table.json").then(
            res => {
                res.json().then(
                    data => {
                        table = data;
                    }
                )
            }
        )
        Number.prototype.round = function (places) {
            return +(Math.round(this + "e+" + places) + "e-" + places);
        }
        var a = document.querySelector(".form-control");
        var n = maxNumber(15);

        a.addEventListener('keyup', n);
        a.addEventListener('blur', n);

        function maxNumber(max) {
            var running = false;

            return function () {
                if (running) return;
                running = true;

                if (parseFloat(this.value) > max) {
                    this.value = 15;
                }
                running = false;
            }
        }
        function printCalResult(event) {
            event.preventDefault();//NAO ATUALIZAR A TELA
            /* Capturando as variaveis para uso */
            var htmlCategory = window.document.querySelector('select[name=category]');
            var htmlType = window.document.querySelector('select[name=type]');
            var htmlAxe = window.document.querySelector('input[name=axes]');
            var htmlDistance = window.document.querySelector('input[name=distance]');
            var divResult = window.document.getElementById('result');
            /* Calculando os dados digitados pelo usuario */
            var resultFunction = calculete(htmlCategory.value, htmlType.value, htmlAxe.value, htmlDistance.value);
            /* Capturando os resultados */
            var ccdValue = resultFunction[0].round(2).toLocaleString('pt-br', { style: 'currency', currency: 'BRL' });
            var ccValue = resultFunction[1].round(2).toLocaleString('pt-br', { style: 'currency', currency: 'BRL' });
            var total = resultFunction[2].round(2).toLocaleString('pt-br', { style: 'currency', currency: 'BRL' });
            /* Imprimindo os dados na Tela */
            divResult.innerHTML = '<b>Deslocamento (CCD): </b>' + ccdValue + '<br><b> Carga e Descarga (CC): </b>' + ccValue + '<br><b> Total (CCD + CD): </b>' + total + '<br><b>Categoria do transporte</b>: ' + htmlCategory.selectedOptions[0].text + '<br><b>Tipo de Carga</b>: ' + htmlType.selectedOptions[0].text + '<br><b>Número de eixos</b>: ' + htmlAxe.value + '<br><b>Distância</b>: ' + htmlDistance.value + ' Km';
        }
        function calculete(categoryValue, typeValue, axeValue, distanceValue) {
            var dados = filterJson(table, categoryValue, typeValue, axeValue);
            dados = dados[0];
            /*Fazendo uma verificação se o tipo do eixo é undefined*/
            if (typeof (dados.deslocamento) !== 'undefined') {//verificando o tipo eixo
                var ccd = (dados.deslocamento * distanceValue);
            } else {
                ccd = 0;
            } if (typeof (dados.carga_descarga) !== 'undefined') {
                var cc = (dados.carga_descarga);
            } else {
                cc = 0;
            }
            total = (ccd + cc);
            return [
                ccd,
                cc,
                total
            ];
        }
        /*filter table.json (arquivo)*/
        function filterJson(table, categoryValue, typeValue, axeValue) {
            var retorno = [];
            retorno = table.filter(function (item) {
                if (item.categoria == categoryValue && item.tipo_de_carga == typeValue && item.eixos == axeValue) {
                    return item;
                }
            })
            return retorno;
        }
    </script>-->
</body>

</html>
