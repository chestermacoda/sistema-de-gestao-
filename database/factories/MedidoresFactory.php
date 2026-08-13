<?php

namespace Database\Factories;

use App\Models\Medidores;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Medidores>
 */
class MedidoresFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            // SEM CLIENTE POR PADRÃO
            'cliente_id' => null,

            'numero_hidrometro' => fake()->unique()->numerify('HM-########'),
            'numero_serie' => fake()->unique()->numerify('SR-########'),

            'marca' => fake()->randomElement(['Zenner', 'Itron', 'Elster', 'Arad']),
            'modelo' => fake()->bothify('M-###'),

            'diametro' => fake()->randomElement(['15mm', '20mm', '25mm']),
            'tipo_hidrometro' => fake()->randomElement(['Unijato / Velocidade', 'Multijato', 'Woltman']),
            'classe_metrologica' => fake()->randomElement(['Classe A', 'Classe B', 'Classe C']),

            'qn' => fake()->randomFloat(2, 1, 10),
            'qmax' => fake()->randomFloat(2, 10, 50),
            'qmin' => fake()->randomFloat(2, 0.1, 1),

            'ano_fabricacao' => fake()->year(),
            'data_aquisicao' => fake()->date(),

            'fornecedor' => fake()->company(),
            'nota_fiscal' => fake()->numerify('NF-########'),

            'status_inicial' => fake()->randomElement([
                'Estoque'
            ]),

            'observacoes' => fake()->sentence(),

            'certificado_calibracao' => fake()->boolean(),
            'laudo_inmetro' => fake()->boolean(),

            'numero_certificado_inmetro' => fake()->numerify('INM-########'),
            'validade_certificado' => fake()->date(),
            'laboratorio_calibracao' => fake()->company(),

            'quantidade' => 1,
        ];
    }
}