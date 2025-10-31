<?php

namespace App\Console\Commands;

use App\Models\BlogPost;
use App\Models\BlogNewsletter;
use App\Mail\NewBlogPostNotification;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class PublishScheduledPosts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'blog:publish-scheduled';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Publie automatiquement les articles du blog dont la date de publication planifiée est arrivée';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Vérification des articles planifiés...');

        // Récupérer les articles planifiés dont la date est passée
        $posts = BlogPost::where('status', 'scheduled')
            ->where('scheduled_at', '<=', now())
            ->get();

        if ($posts->isEmpty()) {
            $this->info('Aucun article à publier.');
            return 0;
        }

        $count = 0;

        foreach ($posts as $post) {
            try {
                // Publier l'article
                $post->update([
                    'status' => 'published',
                    'published_at' => now(),
                ]);

                $this->info("✓ Article publié : {$post->title}");

                // Envoyer la newsletter
                $this->sendNewsletter($post);

                $count++;
            } catch (\Exception $e) {
                $this->error("✗ Erreur lors de la publication de '{$post->title}': {$e->getMessage()}");
                Log::error("Erreur publication article planifié {$post->id}: {$e->getMessage()}");
            }
        }

        $this->info("✓ {$count} article(s) publié(s) avec succès.");

        return 0;
    }

    /**
     * Envoyer la newsletter aux abonnés
     */
    private function sendNewsletter(BlogPost $post)
    {
        $subscribers = BlogNewsletter::where('is_active', true)->get();

        if ($subscribers->isEmpty()) {
            $this->info("  → Aucun abonné newsletter pour cet article.");
            return;
        }

        $sentCount = 0;
        $errorCount = 0;

        foreach ($subscribers as $subscriber) {
            try {
                Mail::to($subscriber->email)->send(new NewBlogPostNotification($post, $subscriber));
                $sentCount++;
            } catch (\Exception $e) {
                $errorCount++;
                Log::error("Erreur envoi newsletter à {$subscriber->email}: {$e->getMessage()}");
            }
        }

        $this->info("  → Newsletter envoyée à {$sentCount} abonné(s)" . ($errorCount > 0 ? " ({$errorCount} erreur(s))" : ""));
    }
}
