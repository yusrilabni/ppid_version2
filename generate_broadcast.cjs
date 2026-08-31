const fs = require('fs');

async function run() {
    try {
        console.log("Fetching units...");
        const resUnits = await fetch('http://apps.sinjaikab.go.id/api/pegawai/get_unit');
        const dataUnits = await resUnits.json();
        
        console.log("Fetching officials...");
        const resOff = await fetch('https://ppidkab.sinjaikab.go.id/api/profil/pejabat-daerah');
        const dataOff = await resOff.json();
        
        const eselon2 = dataOff.kepalaOpds?.eselon2 || [];
        const eselon3 = dataOff.kepalaOpds?.eselon3 || [];
        
        // Also fetch from db directly if we can't get placeholder ones? 
        // Wait, the API `pejabat-daerah` ONLY returns 'active' officials and ones that are not hidden!
        // So the API `pejabat-daerah` DOES return those with "Pejabat ..." because they are active.
        
        const allOff = [...eselon2, ...eselon3];
        
        const officialMap = {};
        for (const off of allOff) {
            if (off.organization?.remote_id) {
                officialMap[off.organization.remote_id] = off.full_name;
            }
        }
        
        const opds = [];
        const kecamatans = [];
        const desas = [];
        
        function processUnit(remoteId, unitName, isVillage = false) {
            if (unitName.toUpperCase().includes('PEMERINTAH DAERAH')) return;
            
            let officialName = 'Belum Ada Data / Kosong';
            let isUpdated = false;
            
            if (officialMap[remoteId]) {
                officialName = officialMap[remoteId];
                if (officialName.toLowerCase().startsWith('pejabat')) {
                    isUpdated = false;
                } else {
                    isUpdated = true;
                }
            }
            
            let text = `- ${unitName} - *${officialName.trim()}*`;
            if (!isUpdated) {
                text += ' _(Belum Update)_';
            }
            
            const lower = unitName.toLowerCase();
            if (isVillage) {
                desas.push(text);
            } else if (lower.includes('kecamatan ')) {
                kecamatans.push(text);
            } else {
                opds.push(text);
            }
        }
        
        if (dataUnits.units) {
            for (const u of dataUnits.units) {
                processUnit(u.unit_id, u.unit_nama, false);
            }
        }
        
        if (dataUnits.villages) {
            for (const v of dataUnits.villages) {
                processUnit(v.id, v.name, true);
            }
        }
        
        opds.sort();
        kecamatans.sort();
        desas.sort();
        
        let msg = "PENGUMUMAN UPDATE DATA PIMPINAN DAERAH\n\n";
        msg += "Yth. Bapak/Ibu Admin OPD/Kecamatan/Desa,\n";
        msg += "Berikut adalah daftar nama pimpinan masing-masing unit organisasi yang terdata di sistem saat ini.\n";
        msg += "*Apabila ada perubahan data pimpinan, silakan segera di-update. Jika di dalam kurung tertulis (Belum Update), mohon segera mengisi data yang valid.*\n\n";
        
        msg += "*[ DINAS / BADAN / KANTOR ]*\n";
        msg += opds.join("\n") + "\n\n";
        
        msg += "*[ KECAMATAN ]*\n";
        msg += kecamatans.join("\n") + "\n\n";
        
        msg += "*[ DESA & KELURAHAN ]*\n";
        msg += desas.join("\n") + "\n\n";
        
        msg += "Terima Kasih.\n";
        
        fs.writeFileSync('C:/Users/ASUS/.gemini/antigravity-cli/brain/b295ce56-6659-4b98-8586-5f50d2fbe15b/Daftar_Pimpinan_Update.md', msg);
        console.log("Done");
    } catch(e) { console.error(e); }
}
run();
