<?php

namespace Martanto\MagmaTrait\Traits;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;

trait JsonFromFileTrait
{
    protected array $json;

    /**
     * Load JSON file as an array
     */
    public function json(
        string $name,
        string|int|null $keyOne = null,
        string|int|null $keyTwo = null
    ): array {
        if (! Storage::disk('json')->exists($name.'.json')) {
            return $this->error("File $name tidak ditemukan!");
        }

        $this->json = json_decode(
            Storage::disk('json')->get($name.'.json'), true
        );

        switch (true) {
            case ! is_null($keyTwo):
                return $this->json = $this->json[$keyOne][$keyTwo];
            case ! is_null($keyOne):
                return $this->json = $this->json[$keyOne];
        }

        return $this->json;
    }

    /**
     * Load JSON file as Collection
     */
    public function collection(
        string $name,
        string|int|null $keyOne = null,
        string|int|null $keyTwo = null
    ): Collection {
        return collect($this->json($name, $keyOne, $keyTwo));
    }
}
