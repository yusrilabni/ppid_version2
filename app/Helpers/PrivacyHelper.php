<?php

namespace App\Helpers;

use App\Helpers\GeneralHelper;

class PrivacyHelper
{
    public static function maskName(string $name, bool $should_mask): string
    {
        if (!$should_mask || empty($name)) {
            return $name;
        }
        return substr($name, 0, 1) . str_repeat('*', strlen($name) - 1);
    }

    public static function maskEmail(string $email, bool $should_mask): string
    {
        if (!$should_mask || empty($email)) {
            return $email;
        }
        $parts = explode('@', $email);
        if (count($parts) === 2) {
            return substr($parts[0], 0, 1) . str_repeat('*', strlen($parts[0]) - 1) . '@' . $parts[1];
        }
        return str_repeat('*', strlen($email)); // Fallback
    }

    // For general strings like phone number or address, mask completely
    public static function maskFull(string $value, bool $should_mask): string
    {
        if (!$should_mask || empty($value)) {
            return $value;
        }
        return str_repeat('*', 10); // Generic mask, adjust length as needed
    }

    public static function getUnitName(?string $unitId): string
    {
        if (empty($unitId)) {
            return 'Unit tidak tersedia';
        }

        $units = GeneralHelper::getUnitData();
        if ($units->has($unitId)) {
            return $units->get($unitId)['unit_nama'];
        }

        return $unitId; // Fallback to ID if not found in hardcoded list
    }
}
