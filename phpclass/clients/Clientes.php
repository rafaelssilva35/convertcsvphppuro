<?php

//include_once('../db/Conn.php');

class Clientes
{
    public $conn;

    public function __construct()
    {
        $conn = new Conn();
        $this->conn = $conn->conn;
    }

    /**
     * Pega todos os resultados do banco, e retorna um array de objetos
     * @return array|void
     */
    public function getAll()
    {
        $dadosCliente = $this->conn->query($this->queryGetAll());
        $result = $dadosCliente->fetchAll(PDO::FETCH_OBJ);
        $result = $this->converteCampos($result);
        return $result;
    }

    /**
     * converter o campo valor em double em moeda
     * e de date em data brasil
     * @param $array
     */
    public function converteCampos($array)
    {
        foreach ($array as $dado) {
            $dado->valor = $this->converteDoubleToReal($dado->valor);
            $dado->vencimento = $this->convertDateToBrDate($dado->vencimento);
            $dado->cnpj = $this->convertIntToCNPJ($dado->cnpj);
            $dado->telefone = $this->convertIntToFone($dado->telefone);
        }
        return $array;
    }

    public function convertIntToCNPJ($cnpj)
    {
        $cnpj_um     = substr($cnpj, 0, 3);
        $cnpj_dois   = substr($cnpj, 3, 3);
        $cnpj_tres   = substr($cnpj, 6, 3);
        $cnpj_quatro = substr($cnpj, 9, 2);
        return ($cnpj_um.'.'.$cnpj_dois.'.'.$cnpj_tres.'-'.$cnpj_quatro );
    }

    public function convertIntToFone($fone)
    {
        $fone_um     = substr($fone, 0, 2);
        $fone_dois   = substr($fone, 2, 4);
        $fone_tres   = substr($fone, 4, 4);

        return ('('.$fone_um.')'.$fone_dois.'-'.$fone_tres);
    }

    /**
     * converte doule em string
     * @param $double
     * @return string
     */
    public function converteDoubleToReal($double)
    {
        return number_format($double, 2, ',', '.');
    }

    /**
     * converte date em data brasileira
     * @param $data
     * @return string
     */
    public function convertDateToBrDate($data)
    {
         $data_br = DateTime::createFromFormat('Y-m-d', $data);
         return $data_br->format('d/m/Y');
    }


    /**
     * pega todos os valores one se parecer com parâmetro $param
     * @param $where
     * @param $param
     * @return array|mixed
     */
    public function getWhereLike($where, $param)
    {
        $query = 'SELECT * FROM dados WHERE ' .$where. ' LIKE ' ."'%".$param."%'";

        $dadosCliente = $this->conn->query($query);
        $result = $dadosCliente->fetchAll(PDO::FETCH_OBJ);

        $result = $this->converteCampos($result);
        return $result;
    }

    /**
     * prepara query para pegar todos os valores do banco da tabela dados
     * @return string
     */
    public function queryGetAll()
    {
        return 'SELECT * FROM dados';
    }
}