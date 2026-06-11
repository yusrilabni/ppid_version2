<?php

return [
    'api_url' => env('PPID_API_URL', 'http://apps.sinjaikab.go.id/api/pegawai/'),
    'app_name' => 'PPID',

    'whatsapp' => [
        'api_url' => env('WA_API_URL', 'http://36.95.15.72:3000/api/send'),
        'api_key' => env('WA_API_KEY', '3047a8cc-6efd-4dfd-a4c6-dc7b3363de3f'),
    ],

    'contact_info' => [
        'address' => 'Jl. Persatuan Raya No.101',
        'phone' => '0851-7448-8744',
        'email' => 'ppidkabsinjai@gmail.com',
        'service_hours_weekday' => 'Senin - Kamis: 08:00 - 16:00 WIB',
        'service_hours_friday' => 'Jumat: 08:00 - 11:30 WIB',
        'service_hours_weekend' => 'Sabtu - Minggu: Tutup',
    ],
];
