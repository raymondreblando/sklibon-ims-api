<?php

namespace App\Traits\Resource;

use Illuminate\Support\Str;

trait MapFields
{
    protected function mapFields($resource, array $fields = [], array $aliases = []): array
    {
        if (! $resource) return [];

        $array = is_object($resource) && method_exists($resource, 'toArray')
            ? $resource->toArray()
            : (array) $resource;

        $fields = $fields ?: array_keys($array);

        return collect($fields)->mapWithKeys(function ($field) use ($array, $aliases) {
            $key = $aliases[$field] ?? $field;
            return [Str::camel($key) => $array[$field] ?? null];
        })->toArray();
    }
}
