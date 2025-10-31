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
        $prompt = "Écris un post court et engageant pour un réseau social sur un sujet aléatoire (technologie, nature, programmation, sport, cuisine, gaming, ou IA). Maximum 450 caractères. Réponds uniquement avec le contenu du post.";

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
        // Configuration and URL code
        $apiKey = config('services.llm.key');
        $modelName = 'gemini-2.5-flash';
        $apiUrl = config('services.llm.url') . $modelName . ':generateContent?key=' . $apiKey;

        try {
            $response = Http::post($apiUrl, [
                'contents' => [
                    [
                        'role' => 'user',
                        'parts' => [
                            ['text' => $prompt]
                        ]
                    ]
                ],
                'generationConfig' => [
                    'maxOutputTokens' => 3000,
                    'temperature' => 0.7,
                ],
            ]);

            $responseData = $response->json();

            // Using data_get() to safely check for the existence of the text
            $generatedText = data_get($responseData, 'candidates.0.content.parts.0.text');

            // 1. Check if the HTTP request was successful
            if ($response->successful()) {

                // 2. Check if the generated text exists (even if it is truncated by MAX_TOKENS)
                if (!empty($generatedText)) {
                    $text = trim($generatedText);
                    return Str::of($text)->trim(' "')->toString();
                }

                // 3. Handle cases where the text is empty (MAX_TOKENS, SAFETY, or other)
                $finishReason = data_get($responseData, 'candidates.0.finishReason', 'INCONNU');
                $this->error("L'appel API Gemini a réussi (HTTP 200), mais aucun texte n'a été généré. Raison : {$finishReason}.");
                return null;
            }

            // Handling API errors (HTTP codes 4xx, 5xx)
            $errorMessage = data_get($responseData, 'error.message', $response->body());
            $this->error('Erreur lors de l\'appel API Gemini : ' . $errorMessage);
            return null;

        } catch (\Exception $e) {
            $this->error('Exception lors de l\'appel API Gemini : ' . $e->getMessage());
            return null;
        }
    }
}
