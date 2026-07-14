const xlsx = require('xlsx');
const fs = require('fs');
const workbook = xlsx.readFile('../Laporan_Survei_6_20260714_011044.xlsx');
const sheetName = workbook.SheetNames[0];
const worksheet = workbook.Sheets[sheetName];
const data = xlsx.utils.sheet_to_json(worksheet, { header: 1 });
fs.writeFileSync('output_utf8.json', JSON.stringify(data, null, 2), 'utf-8');
