<?php
$content = file_get_contents('resources/views/admin/dashboard.blade.php');
$search = '<div class="flex justify-between items-end">
                            <p class="text-2xl font-black text-gray-900 leading-none">{{ number_format($ai[\'usage_today\']) }}</p>
                            <p class="text-[9px] font-black text-gray-400 uppercase text-right">Requests<br><span class="text-purple-600">{{ number_format($ai[\'token_words_today\']) }} Tokens</span></p>
                        </div>';
$replace = '<div class="grid grid-cols-2 gap-2">
                            <div>
                                <p class="text-2xl font-black text-gray-900 leading-none">{{ number_format($ai[\'usage_today\']) }}</p>
                                <p class="text-[9px] font-black text-gray-400 uppercase mt-1">Requests</p>
                            </div>
                            <div class="text-right">
                                <p class="text-2xl font-black text-purple-600 leading-none">{{ number_format($ai[\'token_words_today\']) }}</p>
                                <p class="text-[9px] font-black text-purple-400 uppercase mt-1">Tokens</p>
                            </div>
                        </div>';
$newContent = str_replace($search, $replace, $content);
file_put_contents('resources/views/admin/dashboard.blade.php', $newContent);
echo 'Done!';
