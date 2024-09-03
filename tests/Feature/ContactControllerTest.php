<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Contact;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ContactControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_create_contact()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post('/contacts', [
            'name' => 'Diego',
            'cpf' => '12343042012',
            'phone' => '1234567890',
            'logradouro' => 'R. Dr. Bley Zornig',
            'numero' => '123',
            'cep' => '81750-430',
            'bairro' => 'Boqueirão',
            'cidade' => 'Curitiba',
            'uf' => 'PR',
            'complemento' => 'Apto 101',
        ]);

        $response->assertRedirect('/contacts');
        $this->assertDatabaseHas('contacts', [
            'name' => 'Diego',
            'cpf' => '12343042012',
        ]);
    }

    public function test_user_can_update_contact()
    {
        $user = User::factory()->create();
        $contact = Contact::factory()->create();

        $response = $this->actingAs($user)->put("/contacts/{$contact->id}", [
            'name' => 'Kauco',
            'cpf' => '13229107071',
            'phone' => '0987654321',
            'logradouro' => 'Avenida Principal, s/n Quadra 02 Lote 01',
            'numero' => '321',
            'cep' => '87654-321',
            'bairro' => 'Setor Central',
            'cidade' => 'Chapada de Areia',
            'uf' => 'TO',
            'complemento' => 'Apto 202',
        ]);

        $response->assertRedirect('/contacts');
        $this->assertDatabaseHas('contacts', [
            'id' => $contact->id,
            'name' => 'Kauco',
            'cpf' => '13229107071',
        ]);
    }

    public function test_user_can_delete_contact()
    {
        $user = User::factory()->create();
        $contact = Contact::factory()->create();

        $response = $this->actingAs($user)->delete("/contacts/{$contact->id}");

        $response->assertRedirect('/contacts');
        $this->assertDatabaseMissing('contacts', [
            'id' => $contact->id,
        ]);
    }
}
