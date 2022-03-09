<?php
/* tests\utilities\functions.php */
function create($class, $attributes = [], $times = null)
{
    return $class::factory()->create($attributes);
}
function make($class, $attributes = [], $times = null)
{
    return $class::factory()->make($attributes);
}
function raw($class, $attributes = [], $times = null)
{
    return $class::factory()->raw($attributes);
}