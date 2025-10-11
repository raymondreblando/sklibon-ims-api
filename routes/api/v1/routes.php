<?php

use Illuminate\Support\Facades\Broadcast;

require __DIR__ .'/auth.php';
require __DIR__ .'/guest.php';
require __DIR__ .'/resources.php';
require __DIR__ .'/partial-resources.php';

Broadcast::routes(['middleware' => ['auth:sanctum']]);
