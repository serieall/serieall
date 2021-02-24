<?php

declare(strict_types=1);

namespace App\Packages\Hashing;

use Illuminate\Contracts\Hashing\Hasher as HasherContract;
use Illuminate\Hashing\BcryptHasher;

/**
 * Class YourHasher.
 */
class YourHasher implements HasherContract
{
    protected $hasher;

    /**
     * Create a new Sha512 hasher instance.
     */
    public function __construct()
    {
        $this->hasher = new BcryptHasher();
    }

    /**
     * Add Info method to implement HasherContract.
     *
     * @param string $hashedValue
     */
    public function info($hashedValue): string
    {
        return $hashedValue;
    }

    /**
     * Hash the given value.
     *
     * @param string $value
     *
     * @throws \RuntimeException
     */
    public function make($value, array $options = []): string
    {
        return $this->hasher->make($value, $options);
    }

    /**
     * Check the given plain value against a hash.
     *
     * @param string $value
     * @param string $hashedValue
     */
    public function check($value, $hashedValue, array $options = []): bool
    {
        return $hashedValue === md5($value) || $this->hasher->check($value, $hashedValue, $options);
    }

    /**
     * Check if the given hash has been hashed using the given options.
     *
     * @param string $hashedValue
     */
    public function needsRehash($hashedValue, array $options = []): bool
    {
        return 0 !== strncmp($hashedValue, '$2y$', 4);
    }
}
