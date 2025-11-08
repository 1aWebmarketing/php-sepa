<?php
declare(strict_types=1);

namespace ufozone\phpsepa\Sepa;

use \ufozone\phpsepa\Sepa;
use \ufozone\phpsepa\Sepa\Validator\Factory as ValidatorFactory;

/**
 * Direct Debit Legacy (pain.008.001.02)
 *
 * @author Markus (extended for pain.008.001.02)
 * @since      2017-06-08 (extended 2024)
 */
class DirectDebitLegacy extends Sepa
{
    /**
     * Constructor
     */
    public function __construct(ValidatorFactory $validatorFactory, string $sepaSequence = 'OOFF')
    {
        $this->validatorFactory = $validatorFactory;
        $this->type = self::DIRECT_DEBIT;
        $this->pain = 'pain.008.001.02';
        $this->defaultScope = 'CORE';
        $this->defaultSequence = $sepaSequence;
    }
}
