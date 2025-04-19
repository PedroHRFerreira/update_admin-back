<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Goals;

class GoalsSeeder extends Seeder
{
    public function run(): void
    {
        Goals::truncate();

        $cards = [
            [
                'title'       => 'Venda',
                'description' => 'Superar o total de vendas do mês anterior para garantir crescimento constante.',
                'completed'   => 0,
            ],
            [
                'title'       => 'Venda',
                'description' => 'Exceder a média de vendas dos últimos 3 meses, reforçando a tendência de alta.',
                'completed'   => 0,
            ],
            [
                'title'       => 'Venda',
                'description' => 'Alcançar resultado acima da média dos últimos 5 meses para consolidar o progresso.',
                'completed'   => 0,
            ],
            [
                'title'       => 'Venda',
                'description' => 'Realizar vendas totais acima de R$ 100,00 em um período, estabelecendo um patamar mínimo.',
                'completed'   => 0,
            ],
            [
                'title'       => 'Produto',
                'description' => 'Cadastrar ao menos 5 novos produtos para diversificar o catálogo.',
                'completed'   => 0,
            ],
            [
                'title'       => 'Produto',
                'description' => 'Incluir 10 novos itens para ampliar as opções disponíveis aos clientes.',
                'completed'   => 0,
            ],
            [
                'title'       => 'Produto',
                'description' => 'Adicionar 20 produtos inéditos, aumentando o alcance de mercado.',
                'completed'   => 0,
            ],
            [
                'title'       => 'Produto',
                'description' => 'Reduzir o custo médio por produto, garantindo margem de lucro saudável.',
                'completed'   => 0,
            ],
            [
                'title'       => 'Gasto',
                'description' => 'Diminuir os custos totais em relação ao mês anterior para otimizar o orçamento.',
                'completed'   => 0,
            ],
            [
                'title'       => 'Gasto',
                'description' => 'Registrar o menor gasto nos últimos 3 meses, promovendo economia constante.',
                'completed'   => 0,
            ],
            [
                'title'       => 'Gasto',
                'description' => 'Atingir o nível de gasto mais baixo dos últimos 5 meses, reforçando o controle financeiro.',
                'completed'   => 0,
            ],
            [
                'title'       => 'Gasto',
                'description' => 'Balancear receita e despesas, conquistando o maior número de vendas enquanto controla custos.',
                'completed'   => 0,
            ],
        ];

        foreach ($cards as $card) {
            Goals::create($card);
        }
    }
}
