<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Route;
use Illuminate\Validation\ValidationException;
use Tests\TestCase;

class HandleSecureRedirectTest extends TestCase
{
    public function testSecureRedirect()
    {
        Route::get('/test-route', function () {
            return redirect()->back();
        });

        $this
            ->withoutExceptionHandling()
            ->withHeader('referer', 'https://example.org')
            ->get('/test-route')
            ->assertRedirect('http://localhost');
    }

    public function testSecureValidationRedirect()
    {
        Route::get('/test-route', function () {
            throw ValidationException::withMessages(['foo' => 'bar']);
        });

        $this
            ->withoutExceptionHandling([ValidationException::class])
            ->withHeader('referer', 'https://example.org')
            ->get('/test-route')
            ->assertRedirect('http://localhost');
    }
}
