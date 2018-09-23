<?php
/**
 * Class responsável por manipular arquivo csv
 */
include_once('../db/Conn.php');

class Csv
{
    public $conn;

    public function __construct()
    {
        $conn = new Conn();
        $this->conn = $conn->conn;
    }

    /**
     * Pega arquivos csv, extrai a informação e insere no banco
     *
     * @param $nome_arquivo
     */
    public function getDadosCsvToArray($nome_arquivo)
    {
        $file = fopen('./'.$nome_arquivo, 'r');
        $r = 1;
        fgetcsv($file, 1000, ";");

        $array_dados_csv = [];

        while (($data = fgetcsv($file, 1000, ";")) !== FALSE) {
            $r++;
            $array_dados_csv[$r] = ($this->converteDadosCsvToArray($data));
        }

        return $this->insertDadosCSVInDB($array_dados_csv);
    }

    /**
     * Converte array de csv para array com indicies conhecidos
     * @param $arrayDados
     * @return array
     */
    public function converteDadosCsvToArray($arrayDados)
    {
        return [
            'razao_social' => $arrayDados[0],
            'endereco' => $arrayDados[1],
            'bairro' => $arrayDados[2],
            'cep' => $arrayDados[3],
            'municipio' => $arrayDados[4],
            'uf' => $arrayDados[5],
            'telefone' => $arrayDados[6],
            'cnpj' => $arrayDados[7],
            'valor' => $arrayDados[8],
            'vencimento' => $arrayDados[9]
        ];
    }

    /**
     * Insere dados do arquivo csv encido ao banco
     * @param array $dados
     */
    public function insertDadosCSVInDB(array $dados)
    {
        foreach ($dados as $key => $dado) {

            try {

                $sql = $this->mountSql();
                $conn = $this->conn;
                $bind = $conn->prepare($sql);
                $bind = $this->bindParametres($dado, $bind);

                $bind->execute();

            } catch (PDOException $e) {
                echo ('Erro: ' . $e->getMessage());
                die();
            }
        }
    }

    public function mountSql()
    {
        $sql = "INSERT INTO dados (razao_social, endereco, bairro, cep, municipio, uf, telefone, cnpj, valor, vencimento) 
                VALUES (:razao_social, :endereco, :bairro, :cep, :municipio, :uf, :telefone, :cnpj, :valor, :vencimento)";
        return $sql;
    }

    public function bindParametres(array $dado, $bind)
    {
        $razao_social = $dado['razao_social'];
        $endereco = $dado['endereco'];
        $bairro = $dado['bairro'];
        $cep = $dado['cep'];
        $municipio = $dado['municipio'];
        $uf = $dado['uf'];
        $telefone = $dado['telefone'];
        $cnpj = (int) $dado['cnpj'];
        $valor =  $this->converteReal($dado['valor']);
        $vencimento = $this->converteData($dado['vencimento']);

        $bind->bindParam(':razao_social', $razao_social, PDO::PARAM_STR);
        $bind->bindParam(':endereco', $endereco, PDO::PARAM_STR);
        $bind->bindParam(':bairro', $bairro, PDO::PARAM_STR);
        $bind->bindParam(':cep', $cep, PDO::PARAM_STR);
        $bind->bindParam(':municipio', $municipio, PDO::PARAM_STR);
        $bind->bindParam(':uf', $uf, PDO::PARAM_STR);
        $bind->bindParam(':telefone', $telefone, PDO::PARAM_STR);
        $bind->bindParam(':cnpj', $cnpj, PDO::PARAM_INT);
        $bind->bindParam(':valor', ($valor));
        $bind->bindParam(':vencimento', $vencimento);

        return $bind;
    }

    /**
     * Converte data brasil para datetime
     */
    public function converteData($data)
    {
            $data1 = DateTime::createFromFormat("d/m/Y", $data);
            return $data1->format("Y-m-d");
    }

    public function converteReal($numero)
    {
        $numero = str_replace('.', '', $numero);
        $numero = str_replace(',', '.', $numero);
        $numero = (double) $numero;

        return  (double) $numero;
    }
}