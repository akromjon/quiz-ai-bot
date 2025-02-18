<?php

use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});
Broadcast::channel('quiz.{uuid}', function ($user, $uuid) {
    return true; // Or add authorization logic if needed
});
