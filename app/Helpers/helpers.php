<?php

if (! function_exists('validasiHarga')) {
    function validasiHarga(int $harga): int
    {
        if ($harga <= 0) {
            throw new \InvalidArgumentException('Harga produk tidak boleh nol');
        }

        return $harga;
    }
}
