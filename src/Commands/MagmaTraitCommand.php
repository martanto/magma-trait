<?php

namespace Martanto\MagmaTrait\Commands;

use Illuminate\Console\Command;

class MagmaTraitCommand extends Command
{
    public $signature = 'magma-trait';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
