<?php
// src/OC/PlatformBundle/Antispam/OCAntispam.php

namespace OC\PlatformBundle\Antispam;

class OCAntispam
{

    private $minLength;

    public function __construct($minLength)
    {
        $this->minLength = (int) $minLength;
    }

    /**
    * Vérifie si le texte est un spam ou non
    *
    * @param string $text
    * @return bool
    */
    public function isSpam($text)
    {
        return strlen($text) < $this->minLength;
    }

}