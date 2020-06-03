<?php

namespace Tests\Commands;

use App\Commands\Busy;
use BotMan\BotMan\BotMan;
use Tests\TestCase;

class BusyTest extends TestCase
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

    public function test_it_respond_with_a_busy_message(): void
    {
        $botman = $this->createMock(BotMan::class);
        $botman->expects($this->once())->method('reply')->with(
            $this->callback(function (string $parameter): bool {
                preg_match('/(?<verb>[\w-]+) (?<adjective>[\w-]+)? (?<noun>[\w-]+)/', $parameter, $matches);
                extract($matches);

                if (! in_array($verb, self::VERBS)) {
                    return false;
                }

                if (! in_array($adjective, self::ADJECTIVES)) {
                    return false;
                }

                if (! in_array($noun, self::NOUNS)) {
                    return false;
                }

                return true;
            })
        );

        (new Busy)($botman);
    }
}
