<?php

namespace App\Helpers;

class StorageHelper
{
    /**
     * Get the correct URL for storage files.
     * Ensures the /v2/storage prefix is used in production.
     */
    public static function getUrl($path)
    {
        if (!$path) {
            return asset('assets/img/default.png');
        }

        // asset('storage/...') will use APP_URL/storage/...
        // In production, APP_URL=https://ppidkab.sinjaikab.go.id/v2
        // Result: https://ppidkab.sinjaikab.go.id/v2/storage/...
        return asset('storage/' . $path);
    }
}
