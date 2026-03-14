<?php

namespace Tests\Feature;

use App\Models\SiteVisit;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TrackVisitorTest extends TestCase
{
    use RefreshDatabase;

    public function test_first_visit_creates_unique_visitor(): void
    {
        $this->assertEquals(0, SiteVisit::count());

        $response = $this->get('/');

        $response->assertStatus(200);

        // Devrait créer 1 enregistrement pour un visiteur unique
        $this->assertEquals(1, SiteVisit::count());

        $visit = SiteVisit::first();
        $this->assertTrue($visit->is_unique_visit);
        $this->assertEquals(1, $visit->page_views);
    }

    public function test_multiple_pages_same_visitor_updates_existing_record(): void
    {
        // Première visite
        $this->get('/');
        $this->assertEquals(1, SiteVisit::count());

        // Deuxième page (même visiteur)
        $this->get('/shop');
        $this->assertEquals(1, SiteVisit::count(), 'Should still have only 1 visitor record');

        $visit = SiteVisit::first();
        $this->assertEquals(2, $visit->page_views, 'Page views should increment to 2');

        // Troisième page
        $this->get('/blog');
        $visit->refresh();
        $this->assertEquals(3, $visit->page_views, 'Page views should increment to 3');
    }

    public function test_different_ip_creates_separate_visitor(): void
    {
        // Première IP
        $this->get('/', ['REMOTE_ADDR' => '192.168.1.1']);
        $this->assertEquals(1, SiteVisit::count());

        // Deuxième IP
        $this->get('/', ['REMOTE_ADDR' => '192.168.1.2']);
        $this->assertEquals(2, SiteVisit::count(), 'Different IP should create new visitor');

        // Vérifier que les deux sont des visiteurs uniques
        $this->assertEquals(2, SiteVisit::where('is_unique_visit', true)->count());
    }

    public function test_admin_routes_are_not_tracked(): void
    {
        // Les routes admin ne devraient pas être trackées
        $this->get('/admin');
        $this->assertEquals(0, SiteVisit::count());
    }

    public function test_unique_visitors_count_method(): void
    {
        // Créer 3 visiteurs uniques
        $this->get('/', ['REMOTE_ADDR' => '192.168.1.1']);
        $this->get('/', ['REMOTE_ADDR' => '192.168.1.2']);
        $this->get('/', ['REMOTE_ADDR' => '192.168.1.3']);

        // Le premier visiteur visite 2 pages supplémentaires
        $this->get('/shop', ['REMOTE_ADDR' => '192.168.1.1']);
        $this->get('/blog', ['REMOTE_ADDR' => '192.168.1.1']);

        // Devrait avoir 3 visiteurs uniques
        $this->assertEquals(3, SiteVisit::countUniqueVisitors());

        // Mais 5 pages vues au total (1+2+1+1)
        $this->assertEquals(5, SiteVisit::countPageViews());
    }
}
