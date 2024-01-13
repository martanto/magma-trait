<?php

namespace Martanto\MagmaTrait\Traits;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

trait JsonFromFileTrait
{
    /**
     * @var array $json
     */
    protected array $json;

    /**
     * Load JSON file as an array
     *
     * @param string $file
     * @param string|int|null $keyOne
     * @param string|int|null $keyTwo
     * @return array
     * @throws ValidationException
     */
    public function json(
        string $file,
        string|int|null $keyOne = null,
        string|int|null $keyTwo = null
    ): array {
        $json = "json/$file.json";

        if (! Storage::disk('local')->exists($json)) {
            throw ValidationException::withMessages(
                messages: [
                    'file_not_found' => "File $file not found!"]
            );
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
     * @param string $name
     * @param string|int|null $keyOne
     * @param string|int|null $keyTwo
     * @return Collection
     * @throws ValidationException
     */
    public function collection(
        string $name,
        string|int|null $keyOne = null,
        string|int|null $keyTwo = null
    ): Collection {
        return collect($this->json($name, $keyOne, $keyTwo));
    }
}
