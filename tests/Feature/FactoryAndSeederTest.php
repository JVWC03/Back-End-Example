<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use App\Models\User;
use App\Models\Supplier;
use Database\Seeders\UserSeeder;
use Database\Seeders\SupplierSeeder;
use Tests\TestCase;

class FactoryAndSeederTest extends TestCase
{
   use RefreshDatabase;

   protected function setUp(): void
   {
      parent::setUp();
   }

   public function test_user_factory()
   {
      $user = User::factory()->make();

      $this->assertInstanceOf(User::class, $user);
      $this->assertNotnull($user->name);
      $this->assertNotnull($user->email);
      $this->assertNotnull($user->email_verified_at);
      $this->assertNotnull($user->password);
      $this->assertNotnull($user->remember_token);

      $user = User::factory()->make();
      $this->assertDatabaseMissing('users', ['email' => $user->email]);

      $user = User::factory()->create();
      $this->assertDatabaseHas('users', ['email' => $user->email]);
   }

   public function test_user_seeder()
   {
      $this->seed(UserSeeder::class);
      $this->assertDatabaseCount('users', 10);
   }

   public function test_supplier_factory()
   {
      $supplier = Supplier::factory()->make();

      $this->assertInstanceOf(Supplier::class, $supplier);
      $this->assertNotnull($supplier->name);
      $this->assertNotnull($supplier->address);
      $this->assertNotnull($supplier->phone);
      $this->assertNotnull($supplier->email);
   
      $supplier= Supplier::factory()->make();
      $this->assertDatabaseMissing('suppliers', ['email' => $supplier->email]);
      
      $supplier = Supplier::factory()->create();
      $this->assertDatabaseHas('suppliers', ['email' => $supplier->email]);

   }

   public function test_supplier_seeder()
   {
      $this->seed(SupplierSeeder::class);
      $this->assertDatabaseCount('suppliers', 10);
   }
}
