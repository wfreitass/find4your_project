<?php

namespace Tests\Feature;

use App\Http\Resources\FornecedorResource;
use App\Interfaces\FornecedorServiceInterface;
use App\Interfaces\BuscaCnpjServiceInterface;
use App\Models\Fornecedor;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use Tests\TestCase;

class FornecedorControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    private $fornecedorServiceMock;
    private $buscaCnpjServiceMock;

    protected function setUp(): void
    {
        parent::setUp();

        // Mockando os serviços
        $this->fornecedorServiceMock = $this->createMock(FornecedorServiceInterface::class);
        $this->buscaCnpjServiceMock = $this->createMock(BuscaCnpjServiceInterface::class);

        // Registrando os mocks no container do Laravel
        $this->app->instance(FornecedorServiceInterface::class, $this->fornecedorServiceMock);
        $this->app->instance(BuscaCnpjServiceInterface::class, $this->buscaCnpjServiceMock);
    }

    /** @test */
    public function deve_retornar_lista_de_fornecedores()
    {
        $fornecedores = Fornecedor::factory()->count(3)->make();

        $this->fornecedorServiceMock->method('filters')->willReturn($fornecedores);

        $response = $this->getJson(route('fornecedores.index'));

        $response->assertStatus(200)
            ->assertJsonStructure([
                'success',
                'data' => [['id', 'nome', 'cpf_cnpj']],
            ]);
    }

    /** @test */
    public function deve_criar_um_novo_fornecedor()
    {
        $dados = [
            'nome' => 'Fornecedor Teste',
            'cpf_cnpj' => '12345678901',
            'enderecos' => [],
            'telefones' => [],
        ];

        $fornecedorMock = Fornecedor::factory()->make($dados);
        $this->fornecedorServiceMock->method('create')->willReturn($fornecedorMock);

        $response = $this->postJson(route('fornecedores.store'), $dados);

        $response->assertStatus(200)
            ->assertJsonStructure([
                'success',
                'data' => [['id', 'nome', 'cpf_cnpj']],
            ]);
    }

    /** @test */
    public function deve_retornar_erro_ao_criar_fornecedor_com_dados_invalidos()
    {
        $dadosInvalidos = [
            'nome' => '',
            'cpf_cnpj' => '123',
        ];

        $response = $this->postJson(route('fornecedores.store'), $dadosInvalidos);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['nome', 'cpf_cnpj']);
    }

    /** @test */
    public function deve_atualizar_um_fornecedor()
    {
        $fornecedor = Fornecedor::factory()->create();
        $dadosAtualizados = ['nome' => 'Fornecedor Atualizado'];

        $this->fornecedorServiceMock->method('update')->willReturn($fornecedor);

        $response = $this->putJson(route('fornecedores.update', $fornecedor->id), $dadosAtualizados);

        $response->assertStatus(201)
            ->assertJsonStructure([
                'success',
                'data' => ['id', 'nome', 'cpf_cnpj'],
            ]);
    }

    /** @test */
    public function deve_deletar_um_fornecedor()
    {
        $fornecedor = Fornecedor::factory()->create();

        $this->fornecedorServiceMock->method('delete')->willReturn(true);

        $response = $this->deleteJson(route('fornecedores.destroy', $fornecedor->id));

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
            ]);
    }

    /** @test */
    public function deve_buscar_cnpj_na_brasil_api()
    {
        $cnpj = '12345678000195';
        $dadosCnpj = ['razao_social' => 'Empresa Teste'];

        $this->buscaCnpjServiceMock->method('buscaCnpj')->willReturn($dadosCnpj);

        $response = $this->getJson(route('fornecedores.buscaCnpj', $cnpj));

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'data' => $dadosCnpj,
            ]);
    }
}
