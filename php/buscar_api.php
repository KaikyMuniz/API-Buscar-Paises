<?php
    session_start();

    $nome_pais = $_POST['nome_pais'];

    if($nome_pais != ''){
        chamarAPI($nome_pais);
    }else{
        header("Location: index.html?erro=nome-nulo");
    }

    function chamarAPI($nome_pais) {
        $urlDaAPI = 'https://servicodados.ibge.gov.br/api/v1/paises/{paises}';
        $curl = curl_init($urlDaAPI);

        // Define que a função curl_exec() retornará a resposta como uma string
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        // Temporariamente desabilita a verificação do certificado SSL (cuidado ao usar isso em produção)
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

        $response = curl_exec($curl);

        if ($response === false) {
            $error = curl_error($curl);
            // Tratar o erro aqui
            echo "Erro na requisição: " . $error;
        } else {
            processarRespostaAPI($response, $nome_pais);
        }

        curl_close($curl);
    }

    function processarRespostaAPI($response, $nome_pais) {
        $decodedResponse = json_decode($response, true);

        if ($decodedResponse === null) {
            echo "Erro ao decodificar a resposta JSON";
            return;
        }

        foreach ($decodedResponse as $country) {
            if($country['nome']['abreviado'] === ucfirst($nome_pais) ||
                $country['nome']['abreviado-EN'] === ucfirst($nome_pais) ||
                $country['id']['ISO-3166-1-ALPHA-3'] === strtoupper($nome_pais)){
                $nome_internacional = $country['nome']['abreviado-EN'];
                $abreviacao = $country['id']['ISO-3166-1-ALPHA-3'];
                $nome =  $country['nome']['abreviado'];
                $continente = $country['localizacao']['regiao']['nome'];
                $capital = $country['governo']['capital']['nome'];
                foreach ($country['linguas'] as $idioma) {
                    $idioma = ucfirst($idioma['nome']);
                }
                
                foreach ($country['unidades-monetarias'] as $moeda) {
                    $moeda = ucfirst($moeda['nome']);
                }

                $dados = array(
                    'nome_internacional' => $nome_internacional,
                    'abreviacao' => $abreviacao,
                    'nome' => $nome,
                    'continente' => $continente,
                    'capital' => $capital,
                    'idioma' => $idioma,
                    'moeda' => $moeda,
                    'bandeira' => '',
                    'populacao' => '',
                    'simbolo_moeda' => '',
                );

                ChamarSegundaApi($dados);
                break;
            }else{
                header("Location: erro_busca.html");
            }
        }
    }

    function ChamarSegundaApi($dados){
        $urlDaAPI2 = 'https://restcountries.com/v3.1/alpha/'.$dados['abreviacao'];
        $curl2 = curl_init($urlDaAPI2);

        curl_setopt($curl2, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl2, CURLOPT_SSL_VERIFYPEER, false);

        $response2 = curl_exec($curl2);

        if ($response2 === false) {
            $error2 = curl_error($curl2);
            echo "Erro na requisição: " . $error2;
        } else {
            RespostaDaSegundaApi($response2, $dados);
        }

        curl_close($curl2);
    }

    function RespostaDaSegundaApi($response2, $dados){
        $decodedResponse2 = json_decode($response2, true);

        if ($decodedResponse2 === null) {
            echo "Erro ao decodificar a resposta JSON";
            return;
        }

        foreach($decodedResponse2 as $country_selected){
            $dados['bandeira'] = $bandeira = $country_selected['flags']['png'];
            $dados['populacao'] = $populacao = number_format($country_selected['population'], 0, ',', '.');
            foreach ($country_selected['currencies'] as $simbolo){
                $dados['simbolo_moeda'] = $simbolo_moeda = $simbolo['symbol'];
            }
        }
        DevolverApi($dados);
    }

    function DevolverApi($dados){
        $_SESSION['dados'] = $dados;
        header("Location: devolver_api.php");
        exit();
    }
?>