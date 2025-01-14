<?php
	ini_set('display_errors',1);
	ini_set('display_startup_erros',1);
	error_reporting(E_ALL);
	require_once("../Classes/Ponto.php");

    $ponto = new Ponto(); 
    $retornoOutdoor = $ponto->listarOutdoor($_POST);
    $retornoFront = $ponto->listarFront($_POST);
?>
<!DOCTYPE html>
<html lang="en">
<body>
    <div class="my-8">
        <h1 class="text-dark font-weight-bolder">Meus Pontos</h1>
    </div>
    <div class="row justify-content-center">
    <div class="text-right w-100 mb-5 mr-3">
            <button class="btn btn-primary" data-toggle="modal" data-target="#modal">Adicionar Ponto</button>
        </div>
        <div class="modal fade" id="modal" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" >Gravar Ponto</h5>
                    </div>
                    <div class="modal-body">
                        <form id="form_ponto">
                            <div class="form-group col-6">
                                <label>Localidade: <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="ds_localidade" name="ds_localidade" />
                            </div>
                            <div class="form-group col-6">
                                <label>Sentido: <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="ds_sentido" name="ds_sentido" />
                            </div>
                            <div class="form-group col-6">
                                <label>Latitude/Longitude: <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="nu_localidade" name="nu_localidade" />
                            </div>
                            <div class="form-group col-6">
                                <label>Tipo: <span class="text-danger">*</span></label>
                                <select class="form-control" name="id_tipo" id="id_tipo">
                                    <option  value="">Selecione...</option>
                                    <option  value="1" >Outdoor</option>
                                    <option  value="2">Front-light</option>
                                </select>
                            </div>
                            <div class="form-group col-6">
                                <label>Valor: <span class="text-danger">*</span></label>
                                <input type="number" class="form-control" id="nu_valor_ponto" name="nu_valor_ponto" />
                            </div>
                            <div class="form-group col-6">
                                <label>Foto:<span class="text-danger">*</span></label>
                                <input type="file" class="form-control" name="ds_foto" id="ds_foto">
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                        <button type="button" id="salvarPonto" class="btn btn-primary">Salvar</button>
                    </div>
                </div> 
            </div>
        </div>
        <div class="col-6 ">
            <div class="card card-custom bgi-no-repeat bgi-size-cover gutter-b bg-white"  >
                <div class="card-body">
                    <div class="row mb-10">
                        <div class="col-6">
                            <h3 class="font-weight-bolder col-6">
                                Outdoor
                            </h3>
                        </div>
                        <div class="text-right col-6 dropdown">
                            <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" >Listar</button>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                <a class="dropdown-item"  href="appPonto/outdoor_disponiveis.php" target="_blank">Disponíveis</a>
                                <a class="dropdown-item"  href="appPonto/outdoor_todos.php" target="_blank">Todos</a>
                            </div>
                        </div>
                    </div>
                    <table class="table table-hover" id="table_outdoor">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Local</th>
                                <th>Lat/long</th>
                                <th>Status</th>
                                <th>Ações</th>
                            </tr>

                        </thead>
                        <tbody>
                            <?php
                                while ($dados = $retornoOutdoor->fetch())
                                {
                                    $hoje = date('Y-m-d');
                                    
                                    if($hoje >= $dados["dt_inicial"] && $dados["dt_final"] >= $hoje){
                                        $status = "<span class='label label-xl label-dot label-danger mr-2 mt-1'></span><p>Indisponível agora</p>";
                                    }
                                    if($hoje < $dados["dt_inicial"]){
                                        $status = "<span class='label label-xl label-dot label-warning mr-2 mt-1'></span><p>Reservado depois</p>";
                                    }
                                    if(empty($dados["dt_final"]) && empty($dados["dt_inicial"])){
                                        $status = "<span class='label label-xl label-dot label-success mr-2 mt-1'></span><p>Disponível agora</p>";
                                    }
                                    
                                    echo "<tr>
                                            <td>".$dados['id_ponto']."</td>
                                            <td>".$dados['ds_localidade']."</td>
                                            <td>".$dados['nu_localidade']."</td>
                                            <td class='d-flex'>".$status."</td>
                                            <td nowrap></td>
                                        </tr>";
                                }
                            ?>
                            
                        </tbody>

                    </table>
                </div>
            </div>
            
        </div>
        <div class="col-6 ">
            <div class="card card-custom bgi-no-repeat bgi-size-cover gutter-b bg-white"  >
                <div class="card-body">
                    <div class="row mb-10">
                        <div class="col-6">
                            <h3 class="font-weight-bolder col-6">
                                Front-light
                            </h3>
                        </div>
                        <div class="text-right col-6 dropdown">
                            <button class="btn btn-primary dropdown-toggle" type="button" id="dropdown-front" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" >Listar</button>
                            <div class="dropdown-menu" aria-labelledby="dropdown-front">
                                <a class="dropdown-item"  href="appPonto/front_disponiveis.php" target="_blank">Disponíveis</a>
                                <a class="dropdown-item" href="appPonto/front_todos.php" target="_blank">Todos</a>
                            </div>
                        </div>
                    </div>
                    <table class="table table-hover" id="table_front">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Local</th>
                                <th>Lat/long</th>
                                <th>Status</th>
                                <th>Ações</th>
                            </tr>

                        </thead>
                        <tbody>
                            <?php
                                while ($dados = $retornoFront->fetch())
                                {
                                    $hoje = date('Y-m-d');
                                    
                                    if($hoje >= $dados["dt_inicial"] && $dados["dt_final"] >= $hoje){
                                        $status = "<span class='label label-xl label-dot label-danger mr-2 mt-1'></span><p>Indisponível agora</p>";
                                    }
                                    if($hoje < $dados["dt_inicial"]){
                                        $status = "<span class='label label-xl label-dot label-warning mr-2 mt-1'></span><p>Reservado depois</p>";
                                    }
                                    if(empty($dados["dt_final"]) && empty($dados["dt_inicial"])){
                                        $status = "<span class='label label-xl label-dot label-success mr-2 mt-1'></span><p>Disponível agora</p>";
                                    }
                                    
                                    echo "<tr>
                                            <td>".$dados['id_ponto']."</td>
                                            <td>".$dados['ds_localidade']."</td>
                                            <td>".$dados['nu_localidade']."</td>

                                            <td class='d-flex'>".$status."</td>
                                            <td nowrap></td>
                                        </tr>";
                                }
                            ?>
                            
                        </tbody>

                    </table>
                </div>
            </div>
            
        </div>
       
            
    </div>
    <script src="./assets/js/datatables.bundle.js" type="text/javascript"></script>
    <script src="./assets/js/appPonto/lista_ponto.js" type="text/javascript"></script>
</body>

</html>