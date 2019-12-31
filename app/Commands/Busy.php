<?php

namespace App\Commands;

use BotMan\BotMan\BotMan;
use Tightenco\Collect\Support\Collection;

class Busy
{
    /** @const Array of verbs */
    protected const VERBS = [
        'absorbing', 'adjusting', 'allocating', 'compiling', 'compressing',
        'deallocating', 'decoding', 'decompliling', 'decompressing',
        'decrypting', 'demultiplexing', 'disabling', 'enabling', 'encoding',
        'encrypting', 'factoring', 'generating', 'indexing', 'initializing',
        'mapping', 'multiplexing', 'parsing', 'prioritizing', 'reordering',
        'resolving', 'reticulating', 'routing', 'sorting', 'transcoding',
        'upgrading', 'unravelling'
    ];

    /** @const Array of adjecetives */
    protected const ADJECTIVES = [
        'active', 'associative', 'bi-directional', 'corrupt', 'complex',
        'cyberprotectedero', 'tertiary', 'unlinked', 'unusual', 'well-documented',
        'vectorized', '' // Intentionally blank
    ];

    /** @const Array of nouns */
    protected const NOUNS = [
        'algorithms', 'archives', 'arrays', 'caches', 'coprocesses', 'cores',
        'datasets', 'fields', 'frames', 'functions', 'datastores', 'lists',
        'matrices', 'objects', 'procedures', 'processes', 'queues',
        'receptacles', 'repositories', 'sectors', 'segments', 'sequences',
        'splines', 'states', 'structures', 'tables', 'threads'
    ];

    /** @var Collection */
    protected $verbs;

    /** @var Collection */
    protected $adjectives;

    /** @var Collection */
    protected $nouns;

    public function __construct()
    {
        $this->verbs = new Collection(self::VERBS);
        $this->adjectives = new Collection(self::ADJECTIVES);
        $this->nouns = new Collection(self::NOUNS);
    }

    /**
     * Handle the incoming request.
     *
     * @param BotMan $botman
     *
     * @return void
     */
    public function __invoke(BotMan $botman)
    {
        $botman->reply(
            sprintf('%s %s %s',
                $this->verbs->random(),
                $this->adjectives->random(),
                $this->nouns->random()
            )
        );
    }
}
