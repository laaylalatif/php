<?php

class CalcularFrete {

    /* Atributos de conexão do banco de dados */
    protected $username = 'root';
    protected $password = '';
    protected $host     = 'localhost';
    protected $dbname   = 'dbphp7';

    /* Atributos necessários para a existência da classe */
    protected $category;
    protected $type;
    protected $axles;
    protected $distance;

    /* Atributos que a classe vai descobrir */
    protected $cc;
    protected $ccd;
    protected $total;

    /**
     * CalcularFrete constructor.
     *
     * @param $category
     * @param $type
     * @param $axles
     * @param $distance
     */
    public function __construct($category, $type, $axles, $distance) {
        $this->category = $category;
        $this->type     = $type;
        $this->axles    = $axles;
        $this->distance = $distance;
    }

    /**
     * Calcula o valor do frete
     *
     * @author Layla Latif
     * @since 14/04/2021
     */
    public function calculate() {

        /* Captura o item da tabela do banco de dados com os valores já filtrados */
        $item = $this->itemFromDataBase();

        /* Calculando o CCD (Valor de Deslocamento), se existir */
        if (isset($item['deslocamento'])) {
            $this->ccd = ((double)$item['deslocamento'] * $this->distance);
        } else {
            $this->ccd = 0;
        }

        /* Calculando o CC (Valor de Carga/Descarga), se existir */
        if (isset($item['carga_descarga'])) {
            $this->cc = ((double)$item['carga_descarga']);
        } else {
            $this->cc = 0;
        }

        /* Calculando o valor total do frete */
        $this->total = $this->cc + $this->ccd;
    }

    /**
     * Retorna todos os resultados do frete em uma única array
     *
     * @return array
     */
    public function getResults() {
        return [
            'cc'    => $this->getCC(),
            'ccd'   => $this->getCCD(),
            'total' => $this->getTotal()
        ];
    }

    /**
     * Retorna o valor total do frete
     *
     * @return mixed
     */
    public function getTotal() {
        return $this->total;
    }

    /**
     * Retorna o valor do CC (Carga e Descarga)
     *
     * @return mixed
     */
    public function getCC() {
        return $this->cc;
    }

    /**
     * Retorna o valor do CCD (Deslocamento)
     *
     * @return mixed
     */
    public function getCCD() {
        return $this->ccd;
    }

    /**
     * Captura todos os dados da tabela de frete
     *
     * @author Layla Latif
     * @since 14/04/2021
     * @return mixed
     */
    protected function itemFromDataBase() {

        $tableJson = file_get_contents('table.json');
        $table = json_decode($tableJson, true);

        /* Filtra a tabela afim de retornar um item especifico */
        $item = $this->filterTable($table, $this->category, $this->type, $this->axles);

        return $item[0];
    }

    /**
     * Receba a tabela e filtra os parametros passados e retorna o item correspondente
     *
     * @author Layla Latif
     * @since 16/04/2021
     * @param $table
     * @param $categoryValue
     * @param $typeValue
     * @param $axeValue
     * @return array
     */
    protected function filterTable($table, $categoryValue, $typeValue, $axeValue) {
        $retorno = [];
        $retorno = array_filter($table, function ($item) use (&$categoryValue, &$typeValue, &$axeValue) {
            if ($item['categoria'] == $categoryValue && $item['tipo_de_carga'] == $typeValue && $item['eixos'] == $axeValue) {
                return $item;
            }
        });
        return $retorno;
    }

}

?>
