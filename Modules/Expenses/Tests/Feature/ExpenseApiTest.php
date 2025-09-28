<?php

namespace Modules\Expenses\Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Modules\Expenses\Models\Expense;

class ExpenseApiTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_creates_an_expense()
    {
        $payload = [
            'title' => 'Taxi Ride',
            'amount' => 50.25,
            'category' => 'travel',
            'expense_date' => '2025-09-25',
            'notes' => 'Airport drop',
        ];

        $this->postJson('/api/expenses', $payload)
             ->assertStatus(201)
             ->assertJsonPath('data.title', 'Taxi Ride');

        $this->assertDatabaseHas('expenses', ['title' => 'Taxi Ride']);
    }

    /** @test */
    public function it_lists_expenses()
    {
        Expense::factory()->create(['title' => 'Hotel Bill']);
        Expense::factory()->create(['title' => 'Lunch']);

        $this->getJson('/api/expenses')
             ->assertStatus(200)
             ->assertJsonCount(2, 'data');
    }

    /** @test */
    public function it_shows_a_single_expense()
    {
        $expense = Expense::factory()->create(['title' => 'Dinner']);

        $this->getJson("/api/expenses/{$expense->id}")
             ->assertStatus(200)
             ->assertJsonPath('data.title', 'Dinner');
    }

    /** @test */
    public function it_updates_an_expense()
    {
        $expense = Expense::factory()->create(['title' => 'Old Title']);

        $this->putJson("/api/expenses/{$expense->id}", [
            'title' => 'New Title',
        ])
        ->assertStatus(200)
        ->assertJsonPath('data.title', 'New Title');

        $this->assertDatabaseHas('expenses', ['title' => 'New Title']);
    }

    /** @test */
    public function it_deletes_an_expense()
    {
        $expense = Expense::factory()->create();

        $this->deleteJson("/api/expenses/{$expense->id}")
             ->assertStatus(204);

        $this->assertDatabaseMissing('expenses', ['id' => $expense->id]);
    }
}
