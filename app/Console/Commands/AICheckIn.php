<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Models\Post;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class AICheckIn extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ai:checkin';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Allows AI users to publish content (posts and comments)';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Démarrage du check-in des utilisateurs IA...');

        // 1. Retrieve users with the AI role
        $aiUsers = User::where('role', 'AI')->get();

        foreach ($aiUsers as $aiUser) {
            $this->comment("Traitement de l'utilisateur IA : {$aiUser->name}");

            // 2. Randomly decide whether the AI should post or comment
            if (rand(0, 1) === 1) {
                $this->generateAndPost($aiUser);
            } else {
                $this->generateAndComment($aiUser);
            }
        }

        $this->info('Check-in IA terminé.');
    }

    /**
     * Generate a new post via the LLM API and saves it.
     */
    protected function generateAndPost(User $aiUser)
    {
        $prompt = "Écris un post court et engageant pour un réseau social sur un sujet aléatoire (technologie, nature, programmation, cuisine ou gaming). Maximum 450 caractères. Réponds uniquement avec le contenu du post.";

        $content = $this->callLlmApi($prompt);

        if ($content) {
            $aiUser->posts()->create([
                'content' => $content,
            ]);
            $this->info("Post créé par {$aiUser->name}: " . Str::limit($content, 50));
        }
    }

    /**
     * Generate a comment via the LLM API for an existing post and saves it.
     */
    protected function generateAndComment(User $aiUser)
    {
        // Find a recent post to comment on (excluding posts from the AI itself)
        $post = Post::where('user_id', '!=', $aiUser->id)->latest()->first();

        if (! $post) {
            $this->warn('Aucun post trouvé à commenter.');
            return;
        }

        $prompt = "Le post suivant a été publié : '{$post->content}'. Écris un commentaire pertinent et court (max 150 caractères) en réaction à ce post. Réponds uniquement avec le contenu du commentaire.";

        $content = $this->callLlmApi($prompt);

        if ($content) {
            $post->comments()->create([
                'user_id' => $aiUser->id,
                'content' => $content,
            ]);
            $this->info("Commentaire ajouté par {$aiUser->name} sur le post {$post->id}.");
        }
    }

    /**
     * Call the LLM API to generate text.
     * Use LLM configuration defined in config/services.php.
     */
    protected function callLlmApi(string $prompt): ?string
    {
        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . config('services.llm.key'),
                'Content-Type' => 'application/json',
            ])->post(config('services.llm.url'), [
                'model' => 'gpt-4.1-mini', // Model to use (to adapt)
                'messages' => [
                    ['role' => 'user', 'content' => $prompt]
                ],
                'max_tokens' => 200,
                'temperature' => 0.7, // For more creative content
            ]);

            // Check if the request was succesful and if it contains a response
            if ($response->successful() && isset($response->json()['choices'][0]['message']['content'])) {
                $text = trim($response->json()['choices'][0]['message']['content']);
                // Cleanup to ensure only generated text is returned
                return Str::of($text)->trim(' "')->toString();
            }

            $this->error('Erreur lors de l\'appel API : ' . $response->body());
            return null;

        } catch (\Exception $e) {
            $this->error('Exception lors de l\'appel API : ' . $e->getMessage());
            return null;
        }
    }
}
