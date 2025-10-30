<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserMakeAdmin extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:make-admin {email}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update a user as ADMIN';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $email = $this->argument('email');

        $validator = Validator::make(['email' => $email], [
            'email' => ['required', 'email', 'exists:users,email'],
        ]);

        if ($validator->fails()) {
            $this->error('L\'email spécifié n\'est pas valide ou n\'existe pas dans la base de données.');
            return Command::FAILURE;
        }

        $user = User::where('email', $email)->first();

        if ($user) {
            $user->role = 'ADMIN';
            $user->save();
            $this->info("L\'utilisateur {$user->email} est maintenant un ADMINISTRATEUR.");
            return Command::SUCCESS;
        }

        return Command::FAILURE;
    }
}
