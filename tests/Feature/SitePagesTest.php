<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SitePagesTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->withSession(['_token' => 'test-csrf-token'])
            ->withHeader('X-CSRF-TOKEN', 'test-csrf-token');
        $this->seed();
    }

    public function test_seed_data_matches_the_original_visible_collections(): void
    {
        $this->assertDatabaseCount('beverages', 7);
        $this->assertDatabaseCount('bottles', 3);
        $this->assertDatabaseCount('filled_bottles', 6);
        $this->assertDatabaseHas('beverages', ['id' => 21, 'name' => 'Лимонад']);
        $this->assertDatabaseHas('filled_bottles', ['id' => 10, 'name' => 'Эспрессо']);
    }

    public function test_public_pages_and_legacy_urls_are_available(): void
    {
        $this->get('/')->assertOk()->assertSee('99 Bottles')->assertSee('sing!');
        $this->get('/beverages')->assertOk()->assertSee('Beverages:')->assertSee('Лимонад');
        $this->get('/beverages/21')->assertOk()->assertSee('Лимонад')->assertSee('редактировать');
        $this->get('/bottles')->assertOk()->assertSee('Bottles:')->assertSee('широкая');
        $this->get('/bottles/1')->assertOk()->assertSee('узкая');
        $this->get('/filledbottles')->assertOk()->assertSee('Filled Bottles')->assertSee('Эспрессо');
        $this->get('/search')->assertOk()->assertSee('Search');
    }

    public function test_invalid_resources_and_unknown_pages_return_404(): void
    {
        $this->get('/beverages/9999')->assertNotFound();
        $this->get('/bottles/nope')->assertNotFound();
        $this->get('/does-not-exist')->assertNotFound();
    }

    public function test_ajax_details_do_not_include_the_page_layout(): void
    {
        $this->get('/beverages/21', ['X-Requested-With' => 'XMLHttpRequest'])
            ->assertOk()
            ->assertSee('Лимонад')
            ->assertDontSee('<html', false);

        $this->get('/bottles/1', ['X-Requested-With' => 'XMLHttpRequest'])
            ->assertOk()
            ->assertSee('узкая')
            ->assertDontSee('<html', false);
    }

    public function test_search_is_case_insensitive_for_cyrillic_and_searches_descriptions(): void
    {
        $this->post('/search', ['searchstring' => 'ЛИМОНАД'])
            ->assertOk()
            ->assertSee('Лимонад');

        $this->post('/search', ['searchstring' => 'жареных зёрен'])
            ->assertOk()
            ->assertSee('Кофе');

        $this->post('/search', ['searchstring' => 'совершенно отсутствует'])
            ->assertOk()
            ->assertSee('соответствий не найдено');
    }

    public function test_forms_render_csrf_tokens(): void
    {
        $this->get('/beverages')->assertSee('name="_token"', false);
        $this->get('/filledbottles')->assertSee('name="_token"', false);
        $this->get('/login')->assertSee('name="_token"', false);
    }
}
