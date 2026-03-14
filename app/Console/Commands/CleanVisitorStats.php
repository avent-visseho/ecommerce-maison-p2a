<?php

namespace App\Console\Commands;

use App\Models\SiteVisit;
use Illuminate\Console\Command;

class CleanVisitorStats extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'visitor:stats {--clean : Clean all visitor data}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Display visitor statistics or clean visitor data';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        if ($this->option('clean')) {
            if ($this->confirm('Êtes-vous sûr de vouloir supprimer toutes les données de visites ?')) {
                $count = SiteVisit::count();
                SiteVisit::truncate();
                $this->info("✅ {$count} enregistrements supprimés avec succès.");
                return Command::SUCCESS;
            }
            $this->info('Opération annulée.');
            return Command::SUCCESS;
        }

        $this->displayStats();
        return Command::SUCCESS;
    }

    private function displayStats()
    {
        $this->info('📊 Statistiques des visiteurs');
        $this->newLine();

        // Aujourd'hui
        $this->line('🗓️  Aujourd\'hui:');
        $this->line('   Visiteurs uniques: ' . SiteVisit::countUniqueVisitors('today'));
        $this->line('   Pages vues: ' . SiteVisit::countPageViews('today'));
        $this->newLine();

        // Cette semaine
        $this->line('📅 Cette semaine:');
        $this->line('   Visiteurs uniques: ' . SiteVisit::countUniqueVisitors('week'));
        $this->line('   Pages vues: ' . SiteVisit::countPageViews('week'));
        $this->newLine();

        // Ce mois
        $this->line('📆 Ce mois:');
        $this->line('   Visiteurs uniques: ' . SiteVisit::countUniqueVisitors('month'));
        $this->line('   Pages vues: ' . SiteVisit::countPageViews('month'));
        $this->newLine();

        // Total
        $this->line('📈 Total:');
        $this->line('   Visiteurs uniques: ' . SiteVisit::countUniqueVisitors());
        $this->line('   Pages vues: ' . SiteVisit::countPageViews());
    }
}
