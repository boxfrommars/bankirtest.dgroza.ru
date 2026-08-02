<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class OwnerActionsTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->withSession(['_token' => 'test-csrf-token'])
            ->withHeader('X-CSRF-TOKEN', 'test-csrf-token');
        $this->seed();
        config(['owner.password_hash' => password_hash('secret', PASSWORD_BCRYPT)]);
    }

    public function test_guests_are_redirected_to_the_hidden_login_before_mutations(): void
    {
        $this->post('/beverages', [
            'name' => 'Вода',
            'description' => 'Простая вода',
        ])->assertRedirect('/login');

        $this->get('/beverages/edit/21')->assertRedirect('/login');
        $this->get('/beverages/delete/21')->assertRedirect('/login');
        $this->post('/filledbottles', [
            'name' => 'water',
            'bottle_id' => 1,
            'beverage_id' => 21,
        ])->assertRedirect('/login');

        $this->assertDatabaseMissing('beverages', ['name' => 'Вода']);
    }

    public function test_write_access_fails_closed_without_an_owner_password_hash(): void
    {
        config(['owner.password_hash' => null]);

        $this->withSession(['owner_authenticated' => true])
            ->post('/beverages', [
                'name' => 'Вода',
                'description' => 'Простая вода',
            ])
            ->assertServiceUnavailable();

        $this->assertDatabaseMissing('beverages', ['name' => 'Вода']);
    }

    public function test_csrf_rejects_a_mutation_with_an_invalid_token(): void
    {
        $this->app['env'] = 'local';

        $this->withHeader('X-CSRF-TOKEN', 'invalid-token')
            ->post('/login', ['password' => 'secret'])
            ->assertStatus(419);
    }

    public function test_owner_can_log_in_and_out(): void
    {
        $this->post('/login', ['password' => 'secret'])
            ->assertRedirect('/')
            ->assertSessionHas('owner_authenticated', true);

        $this->withHeader('X-CSRF-TOKEN', session()->token())
            ->post('/logout')
            ->assertRedirect('/')
            ->assertSessionMissing('owner_authenticated');
    }

    public function test_invalid_owner_password_is_rejected(): void
    {
        $this->from('/login')
            ->post('/login', ['password' => 'wrong'])
            ->assertRedirect('/login')
            ->assertSessionHasErrors('password');
    }

    public function test_owner_can_create_update_and_delete_beverages(): void
    {
        $owner = $this->withSession(['owner_authenticated' => true]);

        $owner->post('/beverages', [
            'name' => 'Вода',
            'description' => 'Простая вода',
        ])->assertRedirect('/beverages');

        $beverageId = (int) $this->app['db']->table('beverages')->where('name', 'Вода')->value('id');
        $this->assertDatabaseHas('beverages', ['id' => $beverageId, 'description' => 'Простая вода']);

        $owner->post('/beverages/edit/'.$beverageId, [
            'name' => 'Вода',
            'description' => 'Свежая вода',
        ])->assertRedirect('/beverages/'.$beverageId);
        $this->assertDatabaseHas('beverages', ['id' => $beverageId, 'description' => 'Свежая вода']);

        $owner->post('/beverages/delete/'.$beverageId)->assertRedirect('/beverages');
        $this->assertDatabaseMissing('beverages', ['id' => $beverageId]);
    }

    public function test_beverage_names_remain_unique(): void
    {
        $this->withSession(['owner_authenticated' => true])
            ->from('/beverages')
            ->post('/beverages', [
                'name' => 'Лимонад',
                'description' => 'Дубликат',
            ])
            ->assertRedirect('/beverages')
            ->assertSessionHasErrors('name');
    }

    public function test_owner_can_add_and_remove_a_filled_bottle(): void
    {
        $owner = $this->withSession(['owner_authenticated' => true]);

        $owner->post('/filledbottles', [
            'name' => 'water',
            'bottle_id' => 1,
            'beverage_id' => 21,
        ])->assertRedirect('/filledbottles');

        $filledBottleId = (int) $this->app['db']->table('filled_bottles')->where('name', 'water')->value('id');
        $this->assertDatabaseHas('filled_bottles', ['id' => $filledBottleId]);

        $owner->post('/filledbottles/delete/'.$filledBottleId)->assertRedirect('/filledbottles');
        $this->assertDatabaseMissing('filled_bottles', ['id' => $filledBottleId]);
    }

    public function test_deleting_a_beverage_cascades_to_its_filled_bottles(): void
    {
        $this->assertDatabaseHas('filled_bottles', ['id' => 9, 'beverage_id' => 21]);

        $this->withSession(['owner_authenticated' => true])
            ->post('/beverages/delete/21')
            ->assertRedirect('/beverages');

        $this->assertDatabaseMissing('beverages', ['id' => 21]);
        $this->assertDatabaseMissing('filled_bottles', ['id' => 9]);
    }
}
