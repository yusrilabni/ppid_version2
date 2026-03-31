<?= '<?xml version="1.0" encoding="UTF-8"?>' . PHP_EOL ?>
<rss version="2.0" xmlns:content="http://purl.org/rss/1.0/modules/content/" xmlns:dc="http://purl.org/dc/elements/1.1/" xmlns:atom="http://www.w3.org/2005/Atom" xmlns:sy="http://purl.org/rss/1.0/modules/syndication/" xmlns:slash="http://purl.org/rss/1.0/modules/slash/">
    <channel>
        <title>PPID Kabupaten Sinjai - Feed Informasi</title>
        <atom:link href="{{ route('extra.rss.generate') }}" rel="self" type="application/rss+xml" />
        <link>{{ url('/') }}</link>
        <description>Dapatkan update informasi publik terbaru dari Pejabat Pengelola Informasi dan Dokumentasi Kabupaten Sinjai</description>
        <lastBuildDate>{{ now()->toRssString() }}</lastBuildDate>
        <language>id-ID</language>
        <sy:updatePeriod>hourly</sy:updatePeriod>
        <sy:updateFrequency>1</sy:updateFrequency>

        @foreach($informasis as $info)
        <item>
            <title>{{ $info->title }}</title>
            <link>{{ route('frontend.informasi.detail', $info->slug) }}</link>
            <dc:creator><![CDATA[{{ $info->user->name ?? 'Admin PPID' }}]]></dc:creator>
            <pubDate>{{ \Carbon\Carbon::parse($info->tanggal_upload)->toRssString() }}</pubDate>
            <category><![CDATA[{{ $info->category }}]]></category>
            <status><![CDATA[{{ strtoupper($info->status) }}]]></status>
            <organization><![CDATA[{{ $info->organization->name ?? '-' }}]]></organization>
            <guid isPermaLink="false">{{ url('/') }}/informasi/{{ $info->id }}</guid>
            <description><![CDATA[{{ Str::limit(strip_tags($info->deskripsi), 250) }}]]></description>
            <content:encoded><![CDATA[{{ $info->deskripsi }}]]></content:encoded>
        </item>
        @endforeach
    </channel>
</rss>
