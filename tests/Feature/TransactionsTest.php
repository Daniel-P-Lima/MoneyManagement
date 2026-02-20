<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Transaction;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TransactionsTest extends TestCase
{
    use RefreshDatabase;

    // ---------------------------------------------------------------
    // index
    // ---------------------------------------------------------------

    public function test_index_returns_ok(): void
    {
        $response = $this->get(route('transactions.index'));

        $response->assertStatus(200);
    }

    public function test_index_renders_correct_inertia_component(): void
    {
        $response = $this->get(route('transactions.index'));

        $response->assertInertia(fn ($page) =>
            $page->component('Transactions/Index')
                 ->has('transactions')
                 ->has('totalIncome')
                 ->has('totalExpense')
        );
    }

    public function test_index_lists_transactions_of_current_month(): void
    {
        $current  = Transaction::factory()->create(['date' => now()]);
        $old      = Transaction::factory()->create(['date' => now()->subYear()]);

        $response = $this->get(route('transactions.index'));

        $response->assertInertia(fn ($page) =>
            $page->component('Transactions/Index')
                 ->has('transactions', 1)
                 ->where('transactions.0.id', $current->id)
        );
    }

    // ---------------------------------------------------------------
    // create
    // ---------------------------------------------------------------

    public function test_create_returns_ok(): void
    {
        $response = $this->get(route('transactions.create'));

        $response->assertStatus(200);
    }

    // ---------------------------------------------------------------
    // store
    // ---------------------------------------------------------------

    public function test_store_creates_transaction_and_redirects(): void
    {
        $category = Category::factory()->create(['type' => 'expense']);

        $response = $this->post(route('transactions.store'), [
            'category_id' => $category->id,
            'type'        => 'expense',
            'amount'      => 5000,
            'description' => 'Conta de luz',
            'notes'       => null,
            'date'        => now()->toDateString(),
        ]);

        $response->assertRedirect(route('transactions.index'));
        $this->assertDatabaseHas('transactions', ['amount' => 5000, 'category_id' => $category->id, 'description' => 'Conta de luz']);
    }

    public function test_store_requires_description(): void
    {
        $category = Category::factory()->create();

        $response = $this->post(route('transactions.store'), [
            'category_id' => $category->id,
            'type'        => 'expense',
            'amount'      => 5000,
            'date'        => now()->toDateString(),
        ]);

        $response->assertSessionHasErrors('description');
    }

    public function test_store_requires_valid_type(): void
    {
        $category = Category::factory()->create();

        $response = $this->post(route('transactions.store'), [
            'category_id' => $category->id,
            'type'        => 'invalid',
            'amount'      => 5000,
            'description' => 'Teste',
            'date'        => now()->toDateString(),
        ]);

        $response->assertSessionHasErrors('type');
    }

    // ---------------------------------------------------------------
    // show
    // ---------------------------------------------------------------

    public function test_show_returns_ok(): void
    {
        $transaction = Transaction::factory()->create();

        $response = $this->get(route('transactions.show', $transaction));

        $response->assertStatus(200);
    }

    // ---------------------------------------------------------------
    // update
    // ---------------------------------------------------------------

    public function test_update_changes_transaction_and_redirects(): void
    {
        $transaction = Transaction::factory()->create(['description' => 'Original']);
        $category    = Category::factory()->create();

        $response = $this->put(route('transactions.update', $transaction), [
            'category_id' => $category->id,
            'type'        => 'income',
            'amount'      => 1000,
            'description' => 'Atualizado',
            'notes'       => null,
            'date'        => now()->toDateString(),
        ]);

        $response->assertRedirect(route('transactions.show', $transaction));
        $this->assertDatabaseHas('transactions', ['description' => 'Atualizado']);
        $this->assertDatabaseMissing('transactions', ['description' => 'Original']);
    }

    // ---------------------------------------------------------------
    // destroy
    // ---------------------------------------------------------------

    public function test_destroy_deletes_transaction_and_redirects(): void
    {
        $transaction = Transaction::factory()->create();

        $response = $this->delete(route('transactions.destroy', $transaction));

        $response->assertRedirect(route('transactions.index'));
        $this->assertDatabaseMissing('transactions', ['id' => $transaction->id]);
    }
}
