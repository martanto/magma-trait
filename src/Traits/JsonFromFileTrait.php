<?php

namespace Martanto\MagmaTrait\Traits;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;

trait JsonFromFileTrait
{
    protected array $json;

    /**
     * Load JSON file as an array
     *
     * @param string $name
     * @param string|int|null $keyOne
     * @param string|int|null $keyTwo
     * @return array
     */
    public function json(
        string $name,
        string|int $keyOne = null,
        string|int $keyTwo = null
    ): array
    {
        if (!Storage::disk('json')->exists($name . '.json')) {
            return $this->error("File $name tidak ditemukan!");
        }

        $this->json = json_decode(
            Storage::disk('json')->get($name . '.json'),true
        );

        switch (true) {
            case !is_null($keyTwo):
                return $this->json = $this->json[$keyOne][$keyTwo];
            case !is_null($keyOne):
                return $this->json = $this->json[$keyOne];
        }

        return $this->json;
    }

    /**
     * Load JSON file as Collection
     *
     * @param string $name
     * @param string|int|null $keyOne
     * @param string|int|null $keyTwo
     * @return Collection
     */
    public function collection(
        string $name,
        string|int $keyOne = null,
        string|int $keyTwo = null
    ): Collection
    {
        return collect($this->json($name, $keyOne, $keyTwo));
    }
}
