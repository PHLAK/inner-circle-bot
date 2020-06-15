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
        'cybernetic', 'dank', 'deterministic', 'duplicate', 'dynamic',
        'ethereal', 'euclidean', 'finite', 'high-level', 'infinite', 'inverse',
        'linked', 'low-level', 'multi-dimensional', 'negative', 'non-euclidean',
        'positive', 'prallel', 'quantifiable', 'random', 'sentient', 'static',
        'sub-zero', 'tertiary', 'unlinked', 'unusual', 'well-documented',
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

    /** Handle the incoming request. */
    public function __invoke(BotMan $botman): void
    {
        $botman->reply(
            sprintf('%s %s %s',
                Collection::make(self::VERBS)->random(),
                Collection::make(self::ADJECTIVES)->random(),
                Collection::make(self::NOUNS)->random()
            )
        );
    }
}
