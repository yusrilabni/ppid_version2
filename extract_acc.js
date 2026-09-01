import fs from 'fs';
const html = fs.readFileSync('resources/views/frontend/layouts/app.blade.php', 'utf8');
const match = html.match(/<div[^>]*class="[^"]*acc-widget-container[^"]*"[\s\S]*?<\/script>/i);
if (match) {
    fs.writeFileSync('acc_extracted.txt', match[0]);
    console.log('Extracted to acc_extracted.txt');
} else {
    console.log('Not found');
}
