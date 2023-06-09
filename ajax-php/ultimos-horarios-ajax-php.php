<?php
header('Content-Type: text/html; charset = utf-8');
header('Access-Control-Allow-Origin: localhost');
header('Access-Control-Allow-Methods: *');

require '../controller/ultimos-horarios-controller.php';
$retorno = array();

if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST)){
  $UltimosHorariosController = new UltimosHorariosController();

  if(!empty($_POST['solicitacao']) && !empty($_POST['quantidade'])){
    $retorno['mensagem'] = 'Dados recebidos';
    $retorno['sucesso'] = true;

    $retorno['dados'] = array();
    $quantidade = filter_input(INPUT_POST, 'quantidade', FILTER_SANITIZE_SPECIAL_CHARS);

    if(empty($_POST['filtro'])){
      foreach($UltimosHorariosController -> registrosUsuariosLimite(1, $quantidade) -> fetchAll(PDO::FETCH_ASSOC) as $key => $value){
        $dia = !empty($value['data_usuario_registro']) ? htmlentities($value['data_usuario_registro']) : '';      
        $entrada = !empty($value['hora_entrada_usuario_registro']) ? htmlentities($value['hora_entrada_usuario_registro']) : '';
        $saida = !empty($value['hora_saida_usuario_registro']) ? htmlentities($value['hora_saida_usuario_registro']) : '';
        $saida_almoco = !empty($value['hora_saida_usuario_almoco']) ? htmlentities($value['hora_saida_usuario_almoco']) : '';
        $retorno_almoco = !empty($value['hora_retorno_usuario_almoco']) ? htmlentities($value['hora_retorno_usuario_almoco']) : '';
        
        array_push($retorno['dados'], 
        array(
          "dia_semana_usuario_horario" => $dia, 
          "hora_entrada_usuario_horario" => $entrada, 
          "hora_saida_usuario_horario" => $saida, 
          "hora_saida_usuario_almoco" => $saida_almoco, 
          "hora_retorno_usuario_almoco" => $retorno_almoco)
        );
      }
    }else{
      $filtro = filter_input(INPUT_POST, 'filtro', FILTER_SANITIZE_SPECIAL_CHARS);
      $retorno['entrada'] = $filtro;

      foreach($UltimosHorariosController -> registrosUsuariosFiltro(1, $quantidade, $filtro) -> fetchAll(PDO::FETCH_ASSOC) as $key => $value){
        $dia = !empty($value['data_usuario_registro']) ? htmlentities($value['data_usuario_registro']) : '';      
        $entrada = !empty($value['hora_entrada_usuario_registro']) ? htmlentities($value['hora_entrada_usuario_registro']) : '';
        $saida = !empty($value['hora_saida_usuario_registro']) ? htmlentities($value['hora_saida_usuario_registro']) : '';
        $saida_almoco = !empty($value['hora_saida_usuario_almoco']) ? htmlentities($value['hora_saida_usuario_almoco']) : '';
        $retorno_almoco = !empty($value['hora_retorno_usuario_almoco']) ? htmlentities($value['hora_retorno_usuario_almoco']) : '';
        
        array_push($retorno['dados'], 
        array(
          "dia_semana_usuario_horario" => $dia, 
          "hora_entrada_usuario_horario" => $entrada, 
          "hora_saida_usuario_horario" => $saida, 
          "hora_saida_usuario_almoco" => $saida_almoco, 
          "hora_retorno_usuario_almoco" => $retorno_almoco)
        );
      }
    }

  }else if(!empty($_POST['solicitacao']) && !empty($_POST['inicio']) && !empty($_POST['fim'])){
    $retorno['mensagem'] = 'Dados recebidos';
    $retorno['sucesso'] = true;

    $retorno['dados'] = array();
    $inicio = filter_input(INPUT_POST, 'inicio', FILTER_SANITIZE_SPECIAL_CHARS);
    $fim = filter_input(INPUT_POST, 'fim', FILTER_SANITIZE_SPECIAL_CHARS);

    foreach($UltimosHorariosController -> registrosUsuariosPeriodos(1, $inicio, $fim) -> fetchAll(PDO::FETCH_ASSOC) as $key => $value){
      $dia = !empty($value['data_usuario_registro']) ? htmlentities($value['data_usuario_registro']) : '';      
      $entrada = !empty($value['hora_entrada_usuario_registro']) ? htmlentities($value['hora_entrada_usuario_registro']) : '';
      $saida = !empty($value['hora_saida_usuario_registro']) ? htmlentities($value['hora_saida_usuario_registro']) : '';
      $saida_almoco = !empty($value['hora_saida_usuario_almoco']) ? htmlentities($value['hora_saida_usuario_almoco']) : '';
      $retorno_almoco = !empty($value['hora_retorno_usuario_almoco']) ? htmlentities($value['hora_retorno_usuario_almoco']) : '';
      
      array_push($retorno['dados'], 
      array(
        "dia_semana_usuario_horario" => $dia, 
        "hora_entrada_usuario_horario" => $entrada, 
        "hora_saida_usuario_horario" => $saida, 
        "hora_saida_usuario_almoco" => $saida_almoco, 
        "hora_retorno_usuario_almoco" => $retorno_almoco)
      );
    }

  }else{
    $retorno['mensagem'] = 'Dados vazios';
    $retorno['sucesso'] = false;
  }
}else{
  $retorno['mensagem'] = 'Nenhum dado foi recebido';
  $retorno['sucesso'] = false;
}

echo json_encode($retorno);
?>