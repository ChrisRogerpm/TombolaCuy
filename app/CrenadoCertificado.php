<?php
/**
 * Created by PhpStorm.
 * User: Software3000
 * Date: 08/02/2019
 * Time: 16:37
 */

namespace App;

class CrenadoCertificado
{
    protected $RNG_INT = array();

    public function XGSeed($seed)
    {
        if ($seed <= 0) {
            $seed = round(microtime(true));
        }
        $this->RandomInit((int)$seed);
    }

    private function XGRandom($limit): int
    {
        return $this->IRandom(0, $limit);
    }

    public function RandomInit($seed)
    {
        $s = $seed;
        for ($i = 0; $i < 5; $i++) {
            $s = $s * 29943829 - 1;
            $this->RNG_INT[$i] = $s;
        }
        for ($i = 0; $i < 19; $i++) {
            $this->BRandom();
        }
    }

    public function BRandom()
    {
        $sum =
            (int)2111111111 * (int)$this->RNG_INT[3] +
            (int)1492 * (int)$this->RNG_INT[2] +
            (int)1776 * (int)$this->RNG_INT[1] +
            (int)5115 * (int)$this->RNG_INT[0] +
            (int)$this->RNG_INT[4];

        $this->RNG_INT[3] = $this->RNG_INT[2];
        $this->RNG_INT[2] = $this->RNG_INT[1];
        $this->RNG_INT[1] = $this->RNG_INT[0];
        $this->RNG_INT[4] = $sum >> 32;
        $this->RNG_INT[0] = $sum;

        return $this->RNG_INT[0];
    }

    private function IRandom($min, $max): int
    {
        if ($max <= $min) {
            if ($max == $min) {
                return $min;
            } else {
                return 0;
            }
        }
        // Assume 64 bit integers supported. Use multiply and shift method
        $valor = (int)$this->BRandom();
        $interval = (int)($max - $min + 1);
        $longran = $valor * $interval;
        $iran = $longran >> 32;
        // Convert back to signed and return result
        $x = (int)$iran + $min;
        return (int)$x;
    }

    public function Generado($limite): int
    {
//        $seedd = round(microtime(true));
        $seedd = rand(0, 150000);
        $this->XGSeed($seedd);
        $numeroGenerado = $this->XGRandom($limite);
        return $numeroGenerado;
    }
}