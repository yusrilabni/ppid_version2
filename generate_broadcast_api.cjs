const fs = require('fs');

async function run() {
    try {
        console.log("Fetching from live API...");
        const res = await fetch('https://ppidkab.sinjaikab.go.id/api/profil/organisasi-belum-isi', {
            headers: { 'Accept': 'application/json' }
        });
        const data = await res.json();
        
        if (!data.success || !data.data) {
            console.log("Failed to parse API response");
            return;
        }
        
        let opds = data.data.opds || [];
        let kecamatans = data.data.kecamatans || [];
        let desas = data.data.desas || [];
        
        function formatList(arr) {
            return arr.map(org => {
                let text = `- ${org.name} - *${org.official_name.trim()}*`;
                if (!org.is_updated) {
                    text += ' _(Belum Update)_';
                }
                return text;
            }).join("\n");
        }
        
        let msg = "PENGUMUMAN UPDATE DATA PIMPINAN DAERAH\n\n";
        msg += "Yth. Bapak/Ibu Admin OPD/Kecamatan/Desa,\n";
        msg += "Berikut adalah daftar nama pimpinan masing-masing unit organisasi yang terdata di sistem saat ini.\n";
        msg += "*Apabila ada perubahan data pimpinan, silakan segera di-update. Jika di dalam kurung tertulis (Belum Update), mohon segera mengisi data yang valid.*\n\n";
        
        msg += "*[ DINAS / BADAN / KANTOR ]*\n";
        msg += formatList(opds) + "\n\n";
        
        msg += "*[ KECAMATAN ]*\n";
        msg += formatList(kecamatans) + "\n\n";
        
        msg += "*[ DESA & KELURAHAN ]*\n";
        msg += formatList(desas) + "\n\n";
        
        msg += "Terima Kasih.\n";
        
        fs.writeFileSync('C:/Users/ASUS/.gemini/antigravity-cli/brain/b295ce56-6659-4b98-8586-5f50d2fbe15b/Daftar_Pimpinan_Update.md', msg);
        console.log("File saved!");
    } catch(e) { console.error(e); }
}
run();
