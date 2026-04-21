/**
 * Konfigurasi API PPID Kabupaten Sinjai
 * Gunakan file ini untuk memanggil URL API dari aplikasi Android
 */

const BASE_URL = 'https://ppidkab.sinjaikab.go.id/v2/api/v1';

export const API_ENDPOINTS = {
    // Ambil Data
    OFFICIALS: `${BASE_URL}/officials`,
    INFORMASI: `${BASE_URL}/informasi`,
    LAPORAN: `${BASE_URL}/laporan`,
    SLIDERS: `${BASE_URL}/sliders`,
    
    // Cek Status Permohonan (tambahkan kode unik di ujungnya)
    CHECK_STATUS: `${BASE_URL}/permohonan/status/`,
    
    // Kirim Data (POST)
    SUBMIT_PERMOHONAN: `${BASE_URL}/permohonan`,
};

export default BASE_URL;
