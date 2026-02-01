<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use App\Models\User;

class CleanDatabaseCommand extends Command
{
    protected $signature = 'db:clean {--force : Force without confirmation}';

    protected $description = 'Clean orders, visitors, payments and users (keeps products, categories, blog posts)';

    public function handle()
    {
        $this->warn('This will delete:');
        $this->line('  - All orders and order items');
        $this->line('  - All site visits (visitor tracking)');
        $this->line('  - All rental reservations');
        $this->line('  - All blog comments and newsletters');
        $this->line('  - All users except admins');
        $this->newLine();
        $this->info('The following will be PRESERVED:');
        $this->line('  - Products, categories, brands');
        $this->line('  - Product variants and attributes');
        $this->line('  - Blog posts, categories, tags');
        $this->line('  - Rental categories and items');
        $this->line('  - Admin users');
        $this->newLine();

        if (!$this->option('force') && !$this->confirm('Are you sure you want to proceed?')) {
            $this->info('Operation cancelled.');
            return 0;
        }

        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        $this->info('Cleaning order items...');
        DB::table('order_items')->truncate();

        $this->info('Cleaning orders...');
        DB::table('orders')->truncate();

        $this->info('Cleaning site visits...');
        DB::table('site_visits')->truncate();

        $this->info('Cleaning rental reservations...');
        DB::table('rental_reservations')->truncate();

        $this->info('Cleaning blog comments...');
        DB::table('blog_comments')->truncate();

        $this->info('Cleaning blog newsletters...');
        DB::table('blog_newsletters')->truncate();

        $this->info('Cleaning non-admin users...');
        $adminRoleId = DB::table('roles')->where('slug', 'admin')->value('id');
        if ($adminRoleId) {
            User::where('role_id', '!=', $adminRoleId)->delete();
        } else {
            $this->warn('Admin role not found, keeping all users.');
        }

        // Clean cache and jobs tables
        $this->info('Cleaning cache...');
        DB::table('cache')->truncate();
        DB::table('cache_locks')->truncate();

        $this->info('Cleaning jobs...');
        DB::table('jobs')->truncate();
        DB::table('job_batches')->truncate();
        DB::table('failed_jobs')->truncate();

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $this->newLine();
        $this->info('Database cleaned successfully!');

        return 0;
    }
}
