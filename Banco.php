<?php

class Banco {
      //atributos  
      public    $numConta; //int
      protected $tipo; // cc(50,00) ou cp (150,00)
      private   $dono;
      private   $saldo; 
      private   $status; // aberta(true) ou fechada(false)
      //metodos
      
      public function abrirConta($t) {
          $this->setTipo($t);
          $this->setStatus(true);
          if ($t == 'CC' ){
              $this->setSaldo(50); // dar sempre ferencia p esse metodo
          } elseif ($t == 'CP') {
              $this->saldo = 150;
          }
                    
      }   
      public function fecharConta(){
        if ($this->getSaldo() > 0){
           echo "<p>Erro ainda tem dinheiro, não posso fecha-la!</p>";
        }
        elseif ($this->getsaldo() < 0) {
            echo "<p>Conta está em debito. Impossissivel encerrar!</p>";
        }
        else {
            $this->setStatus(false); 
        }          
    }
      
      public function depositar($valor){
          if ($this->gettStatus()) {
              $this->setSaldo($this->getSaldo() + $valor);
              //$this->saldo = $this->saldo = $valor;
          }else {
              echo "<p>Conta fechada. Não Consigo depositar </p>";
          }
      }
      public function sacar($valor){
          if ($this->getStatus()){
              if($this->getSaldo > $valor){
                 //$this->saldo = $this->saldo - $valor;
                  $this->setSaldo($this->getSaldo() - $valor);
              }else {
                  echo "<p>Saldo insuficiente para sague!</p>";
              }
          }else {
              echo "<p>Não posso sacar de uma conta Fechada!";
          }
      }
      public function pagaMensal(){
          if ($this->getTipo()== "CC"){
              $valor = 12;
          }elseif ($this->getTipo() == "CP"){
              $valor = 20;
          }
          if ($this->getStatus()){
              $this->setSaldo($this->getSaldo() - $valor);
          }else{
              echo "<p>Problemas com a conta. Não podemos cobrar! ";
          }  
      }
      //metodos especiais
      
      public function Banco() {
         $this->setSaldo(0);
         $this->setStatus(false);
         echo "<p>Conta Criada com sucesso!</p>";
      }
      public function getnumConta(){
          return $this->numConta;
      }
      public function setnumConta($numConta){
          $this->numConta = $numConta;
      }
      public function getTipo(){
          return $this->tipo;
      }
      public function settipo($t){
          $this->tipo = $t;
      }
      public function getDono(){
          return $this->Dono;
      }
      public function setDono($dono){ //$dono - variavael. dono é um atributo que tem o $this na frente.
          $this->dono = $dono;
      }
      public function getSaldo(){
          return $this->saldo; 
      }
      public function setSaldo($saldo){
          $this->saldo($saldo);
      }
      public function getStatus(){
          return $this->saldo;
      }
      public function setStatus($status){
          $this->status = $status;
      }
}      
    