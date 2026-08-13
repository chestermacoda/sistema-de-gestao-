<?php

namespace Database\Factories;

use App\Models\Cliente;
use App\Models\Medidores;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Cliente>
 */
class ClienteFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'tipo_pessoa' => fake()->randomElement(['fisica', 'juridica']),
            'nome_completo' => fake()->name(),
            'bi' => fake()->unique()->numerify('BI#########'),
            'nuit' => fake()->unique()->numerify('NUIT########'),
            'email' => fake()->unique()->safeEmail(),
            'telefone' => fake()->phoneNumber(),
            'data_nascimento' => fake()->date(),

            'responsavel_legal' => fake()->name(),

            'cidade' => fake()->city(),
            'endereco' => fake()->streetAddress(),
            'numero_casa' => fake()->buildingNumber(),
            'bairro' => fake()->word(),
            'zona_distribuicao' => fake()->randomElement(['Zona Sul', 'Zona Norte', 'Zona Oeste', 'Zona Leste']),
            'ponto_referencia' => fake()->sentence(),
            'latitude' => fake()->latitude(),
            'longitude' => fake()->longitude(),

            'numero_matricula' => fake()->unique()->numerify('MAT-#######'),
            'categoria_consumo' => fake()->randomElement(['Residencial', 'Comercial', 'Industrial', 'Público']),
            'tipo_ligacao' => fake()->randomElement(['Ligação Nova']),
            'diametro_ramal' => fake()->randomElement(['15mm', '20mm']),
            'data_solicitacao' => fake()->date(),
            'data_prevista_ligacao' => fake()->date(),
            'tipo_imovel' => fake()->randomElement(['Casa', 'Apartamento']),
            'numero_economias' => fake()->numberBetween(1, 5),

            'observacoes' => fake()->sentence(),
            'status' => fake()->randomElement(['ativo']),
        ];
        //php artisan make:factory ClienteFactory --model=Cliente
    }

    public function configure()
    {
        return $this->afterCreating(function ($cliente) {

            $medidor = Medidores::whereNull('cliente_id')
                ->inRandomOrder()
                ->first();

            if ($medidor) {
                $medidor->update([
                    'cliente_id' => $cliente->id,
                    'status_inicial' => 'instalado'
                ]);
            }
        });
    }
}