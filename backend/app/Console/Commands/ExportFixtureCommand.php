<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Services\PortfolioPayloadService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class ExportFixtureCommand extends Command
{
    protected $signature = 'app:export-fixture {--path= : Caminho customizado para salvar o arquivo JSON}';

    protected $description = 'Exporta o payload atual de /api/v1/portfolio para frontend/src/data/portfolio.fixture.json';

    public function handle(PortfolioPayloadService $service): int
    {
        $customPath = $this->option('path');
        $targetPath = is_string($customPath) && $customPath !== ''
            ? $customPath
            : base_path('../frontend/src/data/portfolio.fixture.json');

        $directory = dirname($targetPath);
        if (! File::isDirectory($directory)) {
            File::makeDirectory($directory, 0755, true);
        }

        $payload = $service->buildPayload();
        $json = json_encode($payload, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);

        if ($json === false) {
            $this->error('Falha ao serializar o fixture JSON.');

            return self::FAILURE;
        }

        File::put($targetPath, $json."\n");

        $this->info("Fixture exportado com sucesso em: {$targetPath}");

        return self::SUCCESS;
    }
}
