<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class CreateAdminCommand extends Command
{
    protected $signature = 'app:create-admin
                            {--name= : Nome do administrador}
                            {--email= : E-mail do administrador}
                            {--password= : Senha do administrador}';

    protected $description = 'Cria ou atualiza o usuário administrador do painel Filament';

    public function handle(): int
    {
        $nameOption = $this->option('name');
        $emailOption = $this->option('email');
        $passwordOption = $this->option('password');

        $name = is_string($nameOption) && $nameOption !== ''
            ? $nameOption
            : (string) $this->ask('Nome do administrador', 'Luan Kobs');

        $email = is_string($emailOption) && $emailOption !== ''
            ? $emailOption
            : (string) $this->ask('E-mail do administrador');

        $password = is_string($passwordOption) && $passwordOption !== ''
            ? $passwordOption
            : (string) $this->secret('Senha do administrador');

        if ($email === '' || $password === '') {
            $this->error('E-mail e senha são obrigatórios.');

            return self::FAILURE;
        }

        $user = User::query()->updateOrCreate(
            ['email' => $email],
            [
                'name' => $name,
                'password' => Hash::make($password),
                'is_admin' => true,
            ],
        );

        $this->info("Administrador [{$user->email}] configurado com sucesso.");

        return self::SUCCESS;
    }
}
