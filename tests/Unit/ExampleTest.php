<?php

use App\Models\Todo;

test('todo model uses todo_id as its primary and route key', function () {
    $todo = new Todo;

    expect($todo->getRouteKeyName())->toBe('todo_id');
    expect($todo->getKeyName())->toBe('todo_id');
});
