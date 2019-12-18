<?php

namespace ExemploAPi;

class ExemploAPi
{
    public function enviarDadosContato()
    {
        $dados = $this->montarDados();
        // inicia o curl para realizar o envio
        $curl = $this->iniciaCurl(
            // Substituir pela a url correta do Rubeus
            'https://crmteste.apprubeus.com.br/api/Contato/cadastro',
            $dados
        );
        // Executa a chamada da API via curl
        $retorno = $this->executarCurl($curl);
        // Exibe o resultado da chamada
        var_dump($retorno);
    }

    public function montarDados()
    {
        /**
         * Os campos aqui podem ser iguais aos
         * disponiveis na API
         */

        // Verifica se os campos existem no objeto _POST
        if (
            isset($_POST['nome']) &&
            isset($_POST['email']) &&
            isset($_POST['origem']) &&
            isset($_POST['token'])
        ) {
            // Pega os dados vindo da requisição POST
            $contatoData = [
                'nome' => $_POST['nome'],
                'email' => $_POST['email'],
                'origem' => $_POST['origem'],
                'token' => $_POST['token'],
            ];

            return $contatoData;
        }
    }

    public function iniciaCurl($url, $dados)
    {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HEADER, true);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt(
            $curl,
            CURLOPT_HTTPHEADER,
            [
                'Content-Type: application/json',
            ]
        );
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($dados));
        return $curl;
    }

    public function executarCurl($curl)
    {
        $resposta = curl_exec($curl);
        curl_close($curl);
        if (!$resposta) {
            return false;
        }
        return $resposta;
    }
}
