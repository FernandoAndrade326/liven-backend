<?php

use PHPUnit\Framework\TestCase;
use GuzzleHttp\Client;

class APITest extends TestCase
{
    private $baseUri = 'http://localhost/liven/teste_backend/';
    private $client;

    protected function setUp(): void
    {
        $this->client = new Client(['base_uri' => $this->baseUri]);
    }

    public function testLogin()
    {
        // Dados para a requisição de login
        $loginData = [
            "username" => "FernandoTesteLivenAlterado93",
            "password" => "123"
        ];

        try {
            // Fazendo a solicitação POST para o endpoint de login
            $response = $this->client->post("authServices", [
                'headers' => [
                    'Content-Type' => 'application/json',
                ],
                'body' => json_encode($loginData),
            ]);

            // Verificando se a resposta tem o status 201 Created
            $this->assertEquals(201, $response->getStatusCode());

            // Verificando a mensagem de sucesso na resposta
            $responseBody = $response->getBody()->getContents();
            $responseData = json_decode($responseBody, true);

            // Adicionando debug de resposta
            if (is_null($responseData)) {
                echo "Response Body: " . $responseBody;
            }

            // Verificando se o array foi decodificado corretamente
            //$this->assertNotNull($responseData);

            // Verificando a presença da mensagem e do token na resposta
            $this->assertArrayHasKey('message:', $responseData);
            $this->assertEquals('Login bem-sucedido!', $responseData['message:']);

            // Verificando se o token JWT está presente na resposta
            $this->assertArrayHasKey('token', $responseData);
            $this->assertNotEmpty($responseData['token']);
        } catch (\GuzzleHttp\Exception\RequestException $e) {
            // Se houver uma exceção ao fazer a solicitação POST, falha no teste
            $response = $e->getResponse();
            $this->fail('Request failed: ' . $this->getBody($response));
        }
    }

    public function getBody($response)
    {
        return $response->getBody()->getContents();
    }

    public function testUserInsert()
    {
        $data = [
            'username' => 'FernandoTeste264',
            'password' => '123',
            'email' => 'fernandoandrade264@gmail.com'
        ];

        $response = $this->postRequest('users', $data);

        $this->assertEquals(201, $response->getStatusCode());

        $responseBody = (string) $response->getBody();
        $responseData = json_decode($responseBody, true);

        $this->assertNotNull($responseData, "A resposta não contém um JSON válido: $responseBody");
        $this->assertArrayHasKey('message', $responseData);
        $this->assertEquals('Cadastro realizado com sucesso!', $responseData['message']);
    }

    public function testGetAllUsers()
    {
        $response = $this->getRequest('users');

        $this->assertEquals(200, $response->getStatusCode());

        $responseBody = (string) $response->getBody();
        $responseData = json_decode($responseBody, true);

        $this->assertNotNull($responseData, "A resposta não contém um JSON válido: $responseBody");

        $this->assertArrayHasKey('data', $responseData);
        $this->assertGreaterThan(0, count($responseData['data'])); // Verifica se há pelo menos um usuário
    }

    public function testGetUsersById()
    {
        $userId = 11;
        $response = $this->getRequest("users/$userId");

        $this->assertEquals(200, $response->getStatusCode());

        $responseData = json_decode($response->getBody(), true);

        $this->assertEquals("Informações do seu cadastro.", $responseData['message']);
        $this->assertEquals(11, $responseData['data']['user_id']);
        $this->assertEquals("RenataLiven", $responseData['data']['user_name']);
        $this->assertEquals("renata_alterada3@gmail.com", $responseData['data']['user_email']);
        $this->assertEquals(1, $responseData['data']['user_is_active']);

        // Verificando os endereços retornados
        $expectedaddressess = [
            [
                "address_id" => 1,
                "address_street" => "Rua Anhanguera",
                "address_number" => "273",
                "address_complement" => null,
                "address_neighborhood" => "Centro",
                "address_city" => "São José do Rio Pardo",
                "address_state" => "SP",
                "address_zip_code" => "13720000",
                "address_country" => "BR"
            ],
            [
                "address_id" => 2,
                "address_street" => "Rua Alterada",
                "address_number" => "111",
                "address_complement" => null,
                "address_neighborhood" => "Centro",
                "address_city" => "São José do Rio Pardo",
                "address_state" => "SP",
                "address_zip_code" => "13720000",
                "address_country" => "BR"
            ],
            [
                "address_id" => 10,
                "address_street" => "Rua Crystal",
                "address_number" => "2369",
                "address_complement" => null,
                "address_neighborhood" => "Centro",
                "address_city" => "Campinas",
                "address_state" => "SP",
                "address_zip_code" => "13840000",
                "address_country" => "BR"
            ],
            [
                "address_id" => 12,
                "address_street" => "Rua Alterada15",
                "address_number" => "111",
                "address_complement" => null,
                "address_neighborhood" => "Centro",
                "address_city" => "São José do Rio Pardo",
                "address_state" => "SP",
                "address_zip_code" => "13720000",
                "address_country" => "BR"
            ],
            [
                "address_id" => 13,
                "address_street" => "Rua Sparta",
                "address_number" => "11111",
                "address_complement" => null,
                "address_neighborhood" => "Centro",
                "address_city" => "Campinas",
                "address_state" => "SP",
                "address_zip_code" => "13840000",
                "address_country" => "BR"
            ],
            [
                "address_id" => 14,
                "address_street" => "Rua BloodyAxe",
                "address_number" => "11111",
                "address_complement" => null,
                "address_neighborhood" => "Centro",
                "address_city" => "Campinas",
                "address_state" => "SP",
                "address_zip_code" => "13840000",
                "address_country" => "BR"
            ],
            [
                "address_id" => 15,
                "address_street" => "Rua Teste Liven",
                "address_number" => "11111",
                "address_complement" => null,
                "address_neighborhood" => "Centro",
                "address_city" => "Campinas",
                "address_state" => "SP",
                "address_zip_code" => "13840000",
                "address_country" => "UK"
            ]
        ];

        $this->assertCount(51, $responseData['data']['addressess']);

        foreach ($expectedaddressess as $key => $expectedAddress) {
            $this->assertEquals($expectedAddress['address_id'], $responseData['data']['addressess'][$key]['address_id']);
            $this->assertEquals($expectedAddress['address_street'], $responseData['data']['addressess'][$key]['address_street']);
            $this->assertEquals($expectedAddress['address_number'], $responseData['data']['addressess'][$key]['address_number']);
            $this->assertEquals($expectedAddress['address_complement'], $responseData['data']['addressess'][$key]['address_complement']);
            $this->assertEquals($expectedAddress['address_neighborhood'], $responseData['data']['addressess'][$key]['address_neighborhood']);
            $this->assertEquals($expectedAddress['address_city'], $responseData['data']['addressess'][$key]['address_city']);
            $this->assertEquals($expectedAddress['address_state'], $responseData['data']['addressess'][$key]['address_state']);
            $this->assertEquals($expectedAddress['address_zip_code'], $responseData['data']['addressess'][$key]['address_zip_code']);
            $this->assertEquals($expectedAddress['address_country'], $responseData['data']['addressess'][$key]['address_country']);
        }
    }

    public function testDeleteUser()
    {
        // ID do usuário a ser deletado
        $userId = 77;

        try {
            // Fazendo a solicitação DELETE para o endpoint com o token JWT
            $response = $this->client->delete("users/{$userId}", [
                'headers' => [
                    'Authorization' => 'Bearer ' . $this->getAuthToken(),
                ],
            ]);

            // Verificando se a resposta tem o status 200 OK
            $this->assertEquals(200, $response->getStatusCode());

            // Verificando a mensagem de sucesso na resposta
            $responseData = json_decode($response->getBody(), true);
            $this->assertArrayHasKey('message', $responseData);
            $this->assertEquals('Usuário deletado com sucesso.', $responseData['message']);

            // Verificando se o usuário foi realmente deletado
            try {
                $getResponse = $this->client->get("users/{$userId}", [
                    'headers' => [
                        'Authorization' => 'Bearer ' . $this->getAuthToken(),
                    ],
                ]);

                // Verificando se o status code retornado é 404
                $this->assertEquals(404, $getResponse->getStatusCode());
            } catch (\GuzzleHttp\Exception\RequestException $e) {
                // Se o usuário não for encontrado, deve retornar 404
                $response = $e->getResponse();
                $this->assertEquals(404, $response->getStatusCode());
            }
        } catch (\GuzzleHttp\Exception\RequestException $e) {
            // Se houver uma exceção ao fazer a solicitação DELETE, falha no teste
            $response = $e->getResponse();
            $this->fail('Request failed: ' . $response->getBody());
        }
    }



    public function testAddressInsert()
    {
        $data = [
            'street' => 'Rua Teste Liven23',
            'number' => '11111',
            'complement' => 'Ap',
            'neighborhood' => 'Centro',
            'city' => 'Campinas',
            'state' => 'SP',
            'zip_code' => '13840000',
            'country' => 'BR'
        ];

        $response = $this->postRequest('addressess', $data);

        $this->assertEquals(201, $response->getStatusCode());

        $responseBody = (string) $response->getBody();
        $responseData = json_decode($responseBody, true);

        $this->assertNotNull($responseData, "A resposta não contém um JSON válido: $responseBody");

        $this->assertArrayHasKey('data', $responseData);
        $this->assertArrayHasKey('message', $responseData);
        $this->assertEquals('Endereço inserido com sucesso!', $responseData['message']);
        $this->assertNotNull($responseData['data']['user_id']); // Assuming 'id' is present in 'data' array
    }

    private function postRequest($endpoint, $data)
    {
        try {
            $response = $this->client->post($endpoint, [
                'json' => $data,
                'headers' => ['Authorization' => 'Bearer ' . $this->getAuthToken()]
            ]);
            return $response;
        } catch (\GuzzleHttp\Exception\RequestException $e) {
            if ($e->hasResponse()) {
                return $e->getResponse();
            } else {
                throw $e; // Re-throw the exception if no response
            }
        }
    }

    private function getRequest($endpoint)
    {
        try {
            $response = $this->client->get($endpoint, [
                'headers' => ['Authorization' => 'Bearer ' . $this->getAuthToken()]
            ]);
            return $response;
        } catch (\GuzzleHttp\Exception\RequestException $e) {
            if ($e->hasResponse()) {
                return $e->getResponse();
            } else {
                throw $e; // Re-throw the exception if no response
            }
        }
    }

    public function testUpdateAddress()
    {
        $addressId = 12; // ID do endereço a ser atualizado

        $data = [
            'street' => 'Rua Alterada15',
            'number' => '111',
            'complement' => 'Ap',
            'neighborhood' => 'Cassuci',
            'city' => 'São José do Rio Pardo',
            'state' => 'SP',
            'zip_code' => '13720000',
            'country' => 'BR'
        ];

        $response = $this->putRequest('addressess/' . $addressId, $data);

        $this->assertEquals(201, $response->getStatusCode());

        $responseBody = (string) $response->getBody();
        $responseData = json_decode($responseBody, true);

        // Verifica se a resposta contém um JSON válido
        $this->assertNotNull($responseData, "A resposta não contém um JSON válido: $responseBody");

        // Verifica se a mensagem de sucesso está presente na resposta
        $this->assertEquals('Atualizado com sucesso!', $responseData['message']);

        // Verifica se os dados do endereço foram atualizados corretamente
        $this->assertEquals($data['street'], $responseData['data']['street']);
        $this->assertEquals($data['number'], $responseData['data']['number']);
        $this->assertEquals($data['complement'], $responseData['data']['complement']);
        $this->assertEquals($data['neighborhood'], $responseData['data']['neighborhood']);
        $this->assertEquals($data['city'], $responseData['data']['city']);
        $this->assertEquals($data['state'], $responseData['data']['state']);
        $this->assertEquals($data['zip_code'], $responseData['data']['zip_code']);
        $this->assertEquals($data['country'], $responseData['data']['country']);
    }


    public function testUpdateUser()
    {
        $userId = 11; // ID do usuário a ser atualizado

        $data = [
            'username' => 'RenataLiven',
            'password' => '123',
            'email' => 'renata_alterada3@gmail.com'
        ];

        $response = $this->putRequest('users/' . $userId, $data);

        $this->assertEquals(200, $response->getStatusCode());

        $responseBody = (string) $response->getBody();
        $responseData = json_decode($responseBody, true);

        // Verifica se a resposta contém um JSON válido
        $this->assertNotNull($responseData, "A resposta não contém um JSON válido: $responseBody");

        // Verifica se a mensagem de sucesso está presente na resposta
        $this->assertEquals('Dados do usuário atualizados com sucesso.', $responseData['message']);

        // Verifica se os dados do usuário foram atualizados corretamente
        $this->assertEquals($data['username'], $responseData['data']['user_name']);
        $this->assertEquals($data['email'], $responseData['data']['user_email']);

        // Verifica se o número de endereços é maior que zero
        $this->assertGreaterThan(0, count($responseData['data']['addressess']));
    }

    public function testGetAlladdressess()
    {
        $response = $this->getRequest('addressess');

        $this->assertEquals(200, $response->getStatusCode());

        $responseBody = (string) $response->getBody();
        $responseData = json_decode($responseBody, true);

        // Verifica se a resposta contém um JSON válido
        $this->assertNotNull($responseData, "A resposta não contém um JSON válido: $responseBody");

        // Verifica se a mensagem de sucesso está presente na resposta
        $this->assertEquals('Endereços recuperados com sucesso.', $responseData['message']);

        // Verifica se há dados na resposta
        $this->assertArrayHasKey('data', $responseData);

        // Verifica se os dados de endereço estão presentes e são um array
        $this->assertIsArray($responseData['data']);
        $this->assertGreaterThan(0, count($responseData['data']), 'A lista de endereços está vazia.');

        // Verifica os detalhes de cada endereço retornado
        foreach ($responseData['data'] as $address) {
            $this->assertArrayHasKey('id', $address);
            $this->assertArrayHasKey('user_id', $address);
            $this->assertArrayHasKey('street', $address);
            $this->assertArrayHasKey('number', $address);
            $this->assertArrayHasKey('complement', $address);
            $this->assertArrayHasKey('neighborhood', $address);
            $this->assertArrayHasKey('city', $address);
            $this->assertArrayHasKey('state', $address);
            $this->assertArrayHasKey('zip_code', $address);
            $this->assertArrayHasKey('country', $address);
        }
    }


    public function testGetaddressessByCountry()
    {
        // Simulate a request with query string country=BR
        $response = $this->getRequest('addressess?country=uk');

        $this->assertEquals(200, $response->getStatusCode());

        $responseBody = (string) $response->getBody();
        $responseData = json_decode($responseBody, true);

        // Verifica se a resposta contém um JSON válido
        $this->assertNotNull($responseData, "A resposta não contém um JSON válido: $responseBody");

        // Verifica se a mensagem de sucesso está presente na resposta
        $this->assertEquals("Endereços recuperados com sucesso.", $responseData['message']);

        // Verifica se a estrutura de dados está correta
        $this->assertArrayHasKey('data', $responseData);
        $this->assertIsArray($responseData['data']);

        // Verifica se os endereços têm o país correto (BR) e conta quantos são retornados
        $countUKaddressess = 0;
        foreach ($responseData['data'] as $address) {
            if ($address['country'] === 'UK') {
                $countUKaddressess++;
            }
        }

        // Verifica se o número de endereços retornados com país "UK" é correto
        $this->assertCount(1, $responseData['data']); // Espera-se 6 endereços no total
        $this->assertEquals(1, $countUKaddressess); // Espera-se 6 endereços com país "BR"

        // Aqui você pode adicionar mais verificações conforme a estrutura do seu retorno

    }

    public function testDeleteAddress()
    {
        // ID do endereço a ser deletado
        $addressId = 53;

        try {
            // Fazendo a solicitação DELETE para o endpoint com o token JWT
            $response = $this->client->delete("addressess/{$addressId}", [
                'headers' => [
                    'Authorization' => 'Bearer ' . $this->getAuthToken(),
                ],
            ]);

            // Verificando se a resposta tem o status 200 OK
            $this->assertEquals(200, $response->getStatusCode());

            // Verificando a mensagem de sucesso na resposta
            $responseData = json_decode($response->getBody(), true);
            $this->assertArrayHasKey('message', $responseData);
            $this->assertEquals('Endereço deletado com sucesso!', $responseData['message']);
            $this->assertArrayHasKey('data', $responseData);
            $this->assertIsArray($responseData['data']);
            $this->assertEquals($addressId, $responseData['data']['id']);

            // Verificando se o endereço foi realmente deletado
            try {
                $getResponse = $this->client->get("addressess/{$addressId}", [
                    'headers' => [
                        'Authorization' => 'Bearer ' . $this->getAuthToken(),
                    ],
                ]);

                // Verificando se o status code retornado é 404
                $this->assertEquals(404, $getResponse->getStatusCode());
            } catch (\GuzzleHttp\Exception\RequestException $e) {
                // Se o endereço não for encontrado, deve retornar 404
                $response = $e->getResponse();
                $this->assertEquals(404, $response->getStatusCode());
            }
        } catch (\GuzzleHttp\Exception\RequestException $e) {
            // Se houver uma exceção ao fazer a solicitação DELETE, falha no teste
            $response = $e->getResponse();
            $this->fail('Request failed: ' . $response->getBody());
        }
    }

    private function putRequest($endpoint, $data)
    {
        try {
            $response = $this->client->put($endpoint, [
                'json' => $data,
                'headers' => ['Authorization' => 'Bearer ' . $this->getAuthToken()]
            ]);
            return $response;
        } catch (\GuzzleHttp\Exception\RequestException $e) {
            if ($e->hasResponse()) {
                return $e->getResponse();
            } else {
                throw $e; // Re-throw the exception if no response
            }
        }
    }


    private function getAuthToken()
    {
        // Aqui você pode implementar a lógica para obter um token de autenticação válido
        // Para este exemplo, estamos retornando um token estático
        return 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJ1c2VyX2lkIjoxMSwidXNlcm5hbWUiOiJSZW5hdGFMaXZlbiJ9.UA2cID8e4cY3DZe8Iu7cBl0UKTsBS1qF-NDzu-xUBRM';
    }
}
