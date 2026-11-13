<?php

namespace Tests\Feature;

use Tests\TestCase;

class ExampleTest extends TestCase
{
    public function test_guest_can_view_the_public_landing_page(): void
    {
        $this->get('/')
            ->assertOk()
            ->assertViewIs('welcome')
            ->assertSee('PWL POS')
            ->assertSee('Kelola toko lebih');
    }
}
