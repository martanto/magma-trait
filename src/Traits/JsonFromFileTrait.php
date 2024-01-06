<?php

namespace Martanto\MagmaTrait\Traits;

use Illuminate\Console\Concerns\InteractsWithIO;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;

trait JsonFromFileTrait
{
    use InteractsWithIO;

    protected array $json;

    /**
     * Load JSON file as an array
     */
    public function json(
        string $name,
        string|int|null $keyOne = null,
        string|int|null $keyTwo = null
    ): array {
        $json = "json/$name.json";

        if (! Storage::disk('local')->exists($json)) {
            return $this->error("File $name tidak ditemukan!");
        }

        $this->json = json_decode(
            Storage::disk('local')->get($json), true
        );

        return match (true) {
            ! is_null($keyTwo) => $this->json = $this->json[$keyOne][$keyTwo],
            ! is_null($keyOne) => $this->json = $this->json[$keyOne],
            default => $this->json,
        };

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
