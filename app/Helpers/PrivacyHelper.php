<?php

namespace App\Helpers;

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

        static $unitNames = [];

        if (isset($unitNames[$unitId])) {
            return $unitNames[$unitId];
        }

        try {
            $client = new \GuzzleHttp\Client();
            $response = $client->get("http://apps.sinjaikab.go.id/api/pegawai/get_unit?unit_id={$unitId}");
            $data = json_decode($response->getBody()->getContents(), true);

            if (isset($data['unit_nama'])) {
                $unitNames[$unitId] = $data['unit_nama'];
                return $data['unit_nama'];
            }
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error("Failed to fetch unit name for ID {$unitId}: " . $e->getMessage());
        }

        return $unitId; // Fallback
    }
}
