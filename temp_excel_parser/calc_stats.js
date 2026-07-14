const fs = require('fs');
const data = JSON.parse(fs.readFileSync('output_utf8.json', 'utf8'));
const rows = data.slice(1).filter(r => r.length > 0); // skip header
const N = rows.length;
console.log('Total N =', N);

let roles = { 'Admin Utama OPD / Operator': 0, 'Pejabat Fungsional / Struktural': 0, 'Lainnya': 0 };
let masa = { '< 1 Tahun': 0, '1-3 Tahun': 0, '> 3 Tahun': 0 }; // using logic
let pemahaman = { 'Pemula': 0, 'Menengah (Paham penggunaan web & aplikasi)': 0, 'Lanjut': 0 };

let likert_stats = Array(12).fill(0).map(() => ({ 1: 0, 2: 0, 3: 0, 4: 0, other: 0 }));
let produktivitas = { ya: 0, tidak: 0 };

for (let r of rows) {
    let role = r[5];
    if (roles[role] !== undefined) roles[role]++; else roles['Lainnya']++;
    
    let time = r[6];
    if (time === 10 || time === '< 1 Tahun') masa['< 1 Tahun']++;
    else if (time === 11 || time === '1-3 Tahun') masa['1-3 Tahun']++;
    else masa['> 3 Tahun']++;
    
    let paham = r[7];
    if (paham && paham.includes('Pemula')) pemahaman['Pemula']++;
    else if (paham && paham.includes('Menengah')) pemahaman['Menengah (Paham penggunaan web & aplikasi)']++;
    else pemahaman['Lanjut']++;

    // likert cols: index 8 to 18 (11 indicators)
    // 1: 8, 2: 9, 3: 10, 4: 11, 5: 12, 6: 13, 7: 14, 8: 15, 9: 17, 10: 18, 11: 19
    let mapIndikator = [
        8, // 1. Kemandirian mengunggah
        9, // 2. Kemanfaatan pengelompokan
        10, // 3. Keakuratan verifikasi
        11, // 4. Keringkasan alur
        12, // 5. Kecepatan respons
        13, // 6. Kemudahan mengelola
        14, // 7. Kemudahan memahami menu
        15, // 8. Kejelasan pesan kesalahan
        17, // 9. Kenyamanan estetika (wait, 16 is "Berapa lama admin baru..")
        18, // 10. Keamanan
        19 // 11. Produktivitas (ini beda, boolean)
    ];

    for (let i = 0; i < 10; i++) {
        let val = r[mapIndikator[i]];
        if (val == 1) likert_stats[i][1]++;
        else if (val == 2) likert_stats[i][2]++;
        else if (val == 3) likert_stats[i][3]++;
        else if (val == 4) likert_stats[i][4]++;
        else likert_stats[i]['other']++;
    }

    if (r[19] == 1) produktivitas.ya++; else produktivitas.tidak++;
}

console.log('Roles:', roles);
console.log('Masa:', masa);
console.log('Pemahaman:', pemahaman);
console.log('Likert Stats:');
for (let i=0; i<10; i++) {
    console.log(`Indikator ${i+1}: 1:${likert_stats[i][1]} (${(likert_stats[i][1]/N*100).toFixed(2)}%), 2:${likert_stats[i][2]} (${(likert_stats[i][2]/N*100).toFixed(2)}%), 3:${likert_stats[i][3]} (${(likert_stats[i][3]/N*100).toFixed(2)}%), 4:${likert_stats[i][4]} (${(likert_stats[i][4]/N*100).toFixed(2)}%), Other:${likert_stats[i].other}, Setuju+SangatSetuju: ${((likert_stats[i][3]+likert_stats[i][4])/N*100).toFixed(2)}%`);
}
console.log(`Produktivitas: Ya:${produktivitas.ya} (${(produktivitas.ya/N*100).toFixed(2)}%), Tidak:${produktivitas.tidak}`);
