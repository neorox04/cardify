<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $companies = [
            [
                'name' => 'TechFlow Solutions',
                'description' => 'Soluções tecnológicas inovadoras para empresas modernas.',
                'website' => 'https://techflow.pt',
                'email' => 'geral@techflow.pt',
                'phone' => '+351 210 123 456',
                'address' => 'Av. da Liberdade 100, 1250-096 Lisboa',
                'industry' => 'Tecnologia',
                'size' => 'medium',
                'founded_year' => 2018,
            ],
            [
                'name' => 'Green Energy Portugal',
                'description' => 'Líder em energias renováveis e sustentabilidade.',
                'website' => 'https://greenenergy.pt',
                'email' => 'info@greenenergy.pt',
                'phone' => '+351 220 987 654',
                'address' => 'Rua do Ouro 50, 4000-380 Porto',
                'industry' => 'Energia',
                'size' => 'large',
                'founded_year' => 2015,
            ],
            [
                'name' => 'FinanceHub',
                'description' => 'Consultoria financeira e gestão de investimentos.',
                'website' => 'https://financehub.pt',
                'email' => 'contacto@financehub.pt',
                'phone' => '+351 211 456 789',
                'address' => 'Praça do Comércio 10, 1100-148 Lisboa',
                'industry' => 'Finanças',
                'size' => 'small',
                'founded_year' => 2020,
            ],
            [
                'name' => 'Creative Studio',
                'description' => 'Design, branding e marketing digital.',
                'website' => 'https://creativestudio.pt',
                'email' => 'hello@creativestudio.pt',
                'phone' => '+351 912 345 678',
                'address' => 'Rua Augusta 200, 1100-053 Lisboa',
                'industry' => 'Marketing',
                'size' => 'startup',
                'founded_year' => 2019,
            ],
            [
                'name' => 'HealthPlus Clínicas',
                'description' => 'Rede de clínicas médicas com foco no paciente.',
                'website' => 'https://healthplus.pt',
                'email' => 'geral@healthplus.pt',
                'phone' => '+351 213 654 321',
                'address' => 'Av. da República 75, 1050-189 Lisboa',
                'industry' => 'Saúde',
                'size' => 'enterprise',
                'founded_year' => 2010,
            ],
        ];

        $roles = ['employee', 'manager', 'admin'];
        $positions = [
            'TechFlow Solutions' => ['Developer', 'Tech Lead', 'Product Manager', 'DevOps Engineer', 'UX Designer'],
            'Green Energy Portugal' => ['Engenheiro', 'Gestor de Projeto', 'Analista', 'Técnico', 'Consultor'],
            'FinanceHub' => ['Analista Financeiro', 'Consultor', 'Gestor de Conta', 'Controller', 'Auditor'],
            'Creative Studio' => ['Designer', 'Copywriter', 'Social Media Manager', 'Art Director', 'Motion Designer'],
            'HealthPlus Clínicas' => ['Médico', 'Enfermeiro', 'Rececionista', 'Administrador', 'Técnico de Saúde'],
        ];

        foreach ($companies as $companyData) {
            $company = Company::create([
                'name' => $companyData['name'],
                'slug' => Str::slug($companyData['name']),
                'description' => $companyData['description'],
                'website' => $companyData['website'],
                'email' => $companyData['email'],
                'phone' => $companyData['phone'],
                'address' => $companyData['address'],
                'industry' => $companyData['industry'],
                'size' => $companyData['size'],
                'founded_year' => $companyData['founded_year'],
                'is_active' => true,
            ]);

            $companyPositions = $positions[$companyData['name']];

            // Create 5 users for each company
            for ($i = 1; $i <= 5; $i++) {
                $firstName = fake()->firstName();
                $lastName = fake()->lastName();
                $isFirstUser = ($i === 1); // First user is always company admin

                $user = User::create([
                    'name' => "{$firstName} {$lastName}",
                    'email' => Str::slug("{$firstName}.{$lastName}") . '@' . Str::slug($companyData['name']) . '.pt',
                    'password' => Hash::make('password123'),
                    'phone' => fake()->phoneNumber(),
                    'bio' => fake()->sentence(10),
                    'type' => $isFirstUser ? 'company_admin' : 'user',
                    'is_active' => true,
                    'email_verified_at' => now(),
                ]);

                // Attach user to company
                $company->users()->attach($user->id, [
                    'role' => $isFirstUser ? 'admin' : $roles[array_rand($roles)],
                    'is_admin' => $isFirstUser,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                $this->command->info("  → Criado utilizador: {$user->name} ({$user->email})");
            }

            $this->command->info("✓ Empresa '{$company->name}' criada com 5 utilizadores.");
        }

        $this->command->info('');
        $this->command->info('=================================');
        $this->command->info('Seeding concluído com sucesso!');
        $this->command->info('5 empresas criadas');
        $this->command->info('25 utilizadores criados');
        $this->command->info('Password padrão: password123');
        $this->command->info('=================================');
    }
}
