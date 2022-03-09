<?php

namespace Tests;

// include 'Utilities\functions.php';


use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication, RefreshDatabase;

    protected $base_route = null;
    protected $base_model = null;

    protected function signIn($user = null)
    {
        $user = $user ?? User::create([
            'name' => 'Seth Setiadha',
            'email' => 'seth.setiadha@gmail.com',
            'email_verified_at' => now(),
            'active' => 'Y',
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
        ]);
        
        $this->actingAs($user);
        return $this;
    }


    protected function setBaseRoute($route)
    {
        $this->base_route = $route;
    }

    protected function setBaseModel($model)
    {
        $this->base_model = $model;
    }

    protected function create($attributes = [], $model = '', $route = '')
    {
        $this->withoutExceptionHandling();

        $route = $this->base_route ? "{$this->base_route}.store" : $route;
        $model = $this->base_model ?? $model;

        if (! auth()->user()) {
            $this->expectException(\Illuminate\Auth\AuthenticationException::class);
        } 

        $response = $this->post(route($route), $attributes);
        $this->assertEquals(302, $response->getStatusCode());
        $this->assertEquals(1,$model::all()->count());
        $model = new $model;

        $this->assertDatabaseHas($model->getTable(), $attributes); 

        return $response;
    }

    protected function failCreate($attributes = [], $model = '', $route = '')
    {
        $this->withoutExceptionHandling();

        $route = $this->base_route ? "{$this->base_route}.store" : $route;
        $model = $this->base_model ?? $model;

        if (! auth()->user()) {
            $this->expectException(\Illuminate\Auth\AuthenticationException::class);
        } 

        $response = $this->post(route($route), $attributes)->assertRedirect('/login');
        $this->assertEquals(0,$model::all()->count());
        return $response;
    }

    protected function update($attributes = [], $model = '', $route = '')
    {
        $this->withoutExceptionHandling();

        $route = $this->base_route ? "{$this->base_route}.update" : $route;
        $model = $this->base_model ?? $model;

        $model = create($model); 

        if (! auth()->user()) {
            $this->expectException(\Illuminate\Auth\AuthenticationException::class);
        }

        $response = $this->patch(route($route, $model->id), $attributes);

        tap($model->fresh(), function ($model) use ($attributes) {
            collect($attributes)->each(function($value, $key) use ($model) {
                $this->assertEquals($value, $model[$key]);
            });
        });

        return $response;
    }

    protected function destroy($model = '', $route = '')
    {
        $this->withoutExceptionHandling();

        $route = $this->base_route ? "{$this->base_route}.destroy" : $route;
        $model = $this->base_model ?? $model;

        $model = create($model);

        if (! auth()->user()) {
            $this->expectException(\Illuminate\Auth\AuthenticationException::class);
        }

        $response = $this->deleteJson(route($route, $model->id));

        $this->assertDatabaseMissing($model->getTable(), $model->toArray());

        return $response;
    }

    public function multipleDelete ($model = '', $route = '')
    {
        $this->withoutExceptionHandling();

        $route = $this->base_route ? "{$this->base_route}.destroyAll" : $route;
        $model = $this->base_model ?? $model;

        $model = create($model, [], 5);

        $ids = $model->map(function ($item, $key) {
            return $item->id;
        });

        return $this->deleteJson(route($route), ['ids' => $ids ]);
    }
}
