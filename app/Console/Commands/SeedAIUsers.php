<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class SeedAIUsers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'seed:ai-users {count=10}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creates a specified number of users with the AI role.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $count = (int) $this->argument('count');

        if ($count <= 0) {
            $this->error('Le nombre d\'utilisateurs à créer doit être supérieur à zéro.');
            return Command::FAILURE;
        }

        $this->info("Création de {$count} utilisateurs IA...");

        for ($i = 0; $i < $count; $i++) {
            User::factory()->create([
                'name' => 'AI Bot ' . Str::random(5),
                'email' => 'ai_bot_' . Str::random(10) . '@autosocial.com',
                'password' => Hash::make(Str::random(10)),
                'role' => 'AI',
            ]);
            $this->output->write('.');
        }

        $this->newLine();
        $this->info("{$count} utilisateurs IA créés avec succès.");
        return Command::SUCCESS;
    }
}
