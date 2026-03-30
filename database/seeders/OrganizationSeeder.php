<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Organization;
use Illuminate\Support\Str;

class OrganizationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $json_data = <<<JSON
[{"unit_id":"730707","unit_nama":"Badan Kepegawaian dan Pengembangan Sumber Daya Manusia Aparatur","unit_alamat":"Jl. Stadion Mini No. 7 Sinjai Utara","jml_pegawai":"35"},{"unit_id":"730729","unit_nama":"Badan Kesatuan Bangsa dan Politik","unit_alamat":"Jl. Persatuan Raya No. 134 Kab. Sinjai","jml_pegawai":"17"},{"unit_id":"730711","unit_nama":"Badan Keuangan dan Aset Daerah","unit_alamat":"Jl. Jend. Ahmad Yani No.1 Kab. Sinjai","jml_pegawai":"38"},{"unit_id":"730710","unit_nama":"Badan Penanggulangan Bencana Daerah","unit_alamat":"Jl. Bulo-Bulo Timur","jml_pegawai":"18"},{"unit_id":"730715","unit_nama":"Badan Pendapatan Daerah","unit_alamat":"Jl. Bulo-bulo Barat No. 1. Kel. Biringere, Kec. Sinjai Utara, Sulsel. Kode Pos 92611. Tlp. (0482) 21004 ","jml_pegawai":"33"},{"unit_id":"730747","unit_nama":"Badan Penelitian dan Pengembangan Daerah ","unit_alamat":"","jml_pegawai":"14"},{"unit_id":"730706","unit_nama":"Badan Perencanaan Pembangunan Daerah","unit_alamat":"Jalan. Bulo \u2013 Bulo Barat No. 1 Kab. Sinjai","jml_pegawai":"23"},{"unit_id":"730726","unit_nama":"Dinas Kependudukan dan Pencatatan Sipil","unit_alamat":"Jalan Persatuan Raya No. 116 Kelurahan Biringere, Kecamatan Sinjai Utara, Kabupaten Sunjai, Sulawesi Selatan. Kode Pos 92611","jml_pegawai":"30"},{"unit_id":"730722","unit_nama":"Dinas Kesehatan","unit_alamat":"Jalan Jenderal Sudirman No. 04 Sinjai","jml_pegawai":"821"},{"unit_id":"730713","unit_nama":"Dinas Ketahanan Pangan","unit_alamat":"Jl. H. Abdul Latief No. 08 Kabupaten Sinjai<br>Provinsi Sulawesi Selatan Telp.(0482) 2425372, Fax (0482) 22270","jml_pegawai":"31"},{"unit_id":"730714","unit_nama":"Dinas Komunikasi Informatika dan Persandian","unit_alamat":"Jl. Persatuan Raya No. 101 Kec. Sinjai Utara, Kabupaten Sinjai, Sulawesi Selatan 92611 Tlp. 0482-21432 Fax 0482-223227, Email:info@sinjaikab.go.id","jml_pegawai":"44"},{"unit_id":"730743","unit_nama":"Dinas Koperasi Usaha Kecil Menengah dan Tenaga Kerja","unit_alamat":"Jl. Jend. Sudirman No. 19 Kabupaten Sinjai","jml_pegawai":"20"},{"unit_id":"730731","unit_nama":"Dinas Lingkungan Hidup dan Kehutanan","unit_alamat":"Jalan Persatuan Raya No.141 Telp (0482) 23655 Kode Pos 92611","jml_pegawai":"43"},{"unit_id":"730746","unit_nama":"Dinas Pariwisata dan Kebudayaan","unit_alamat":"Jl. Jendral Sudirman No.21 Telp. (0482) 21226 Kode Pos 92615","jml_pegawai":"20"},{"unit_id":"730724","unit_nama":"Dinas Pekerjaan Umum dan Penataan Ruang","unit_alamat":"JL. LAMATTI NO. 1","jml_pegawai":"88"},{"unit_id":"730708","unit_nama":"Dinas Pemberdayaan Masyarakat dan Desa","unit_alamat":"Lingk. Tanassang Kel. Alehanuae Kec. Sinjai Utara Kab. Sinjai Telp. (0482) 23305 Kode Pos 92611","jml_pegawai":"25"},{"unit_id":"730709","unit_nama":"Dinas Pemberdayaan Perempuan, Perlindungan Anak, Pengendalian Penduduk dan Keluarga Berencana","unit_alamat":"","jml_pegawai":"32"},{"unit_id":"730745","unit_nama":"Dinas Pemuda dan Olahraga","unit_alamat":"Jl. H. A. Abdul Latief No. 1, Kab. Sinjai, Sulawesi Selatan Kode Pos 92612","jml_pegawai":"18"},{"unit_id":"730712","unit_nama":"Dinas Penanaman Modal dan Pelayanan Terpadu Satu Pintu","unit_alamat":"J. Persatuan Raya No. 116 Sinjai","jml_pegawai":"30"},{"unit_id":"730723","unit_nama":"Dinas Pendidikan","unit_alamat":"0","jml_pegawai":"2585"},{"unit_id":"730721","unit_nama":"Dinas Perdagangan, Perindustrian dan Energi Sumber Daya Mineral","unit_alamat":"Jl. Jend. Ahmad Yani No. 01 ","jml_pegawai":"46"},{"unit_id":"730716","unit_nama":"Dinas Perhubungan","unit_alamat":"Jln. Bulu Pattuku No.   Kel. Bongki Kec. Sinjai Utara Kab. Sinjai<br>Provinsi Sulawesi Selatan Kode Pos 92613 Telp\/Fax. (0482) 22233.","jml_pegawai":"77"},{"unit_id":"730720","unit_nama":"Dinas Perikanan","unit_alamat":"Jl. Persatuan Raya No.98 Telp\/Fax (0482) 21138 Kode Pos 92611","jml_pegawai":"36"},{"unit_id":"730730","unit_nama":"Dinas Perpustakaan dan Kearsipan","unit_alamat":"Jl. Kartini No.1 Sinjai","jml_pegawai":"20"},{"unit_id":"730725","unit_nama":"Dinas Perumahan, Kawasan Pemukiman dan Pertanahan","unit_alamat":": Jl. Persatuan Raya No. 116","jml_pegawai":"28"},{"unit_id":"730717","unit_nama":"Dinas Peternakan dan Kesehatan Hewan","unit_alamat":"Jalan Lamatti No. 1","jml_pegawai":"59"},{"unit_id":"730727","unit_nama":"Dinas Sosial","unit_alamat":"Jl. Jend. Sudirman No. 3 Sinjai","jml_pegawai":"20"},{"unit_id":"730718","unit_nama":"Dinas Tanaman Pangan, Holtikultura dan Perkebunan","unit_alamat":"Jl. Persatuan Raya No. 121 Kelurahan Biringere, Kecamatan Sinjai Utara, <br> Kabupaten Sinjai, Provinsi Sulawesi Selatan, Kode Pos 92611","jml_pegawai":"33"},{"unit_id":"730705","unit_nama":"Inspektorat","unit_alamat":"Tanassang, Kel. Alehanuae, Kec. Sinjai Utara, Kab. Sinjai, Prov. Sulawesi Selatan. Kode Pos 92616","jml_pegawai":"51"},{"unit_id":"730740","unit_nama":"Kantor Kecamatan Bulupoddo","unit_alamat":"0","jml_pegawai":"10"},{"unit_id":"730741","unit_nama":"Kantor Kecamatan Pulau Sembilan","unit_alamat":"0","jml_pegawai":"13"},{"unit_id":"730737","unit_nama":"Kantor Kecamatan Sinjai Barat","unit_alamat":"Jl. Persatuan Raya No A.69 Manipi Kode Pos 92653","jml_pegawai":"23"},{"unit_id":"730738","unit_nama":"Kantor Kecamatan Sinjai Borong","unit_alamat":"Jl. Pendidikan No.64, Lingk. Paroppo Kel. Pasir Putih Kode Pos 92622","jml_pegawai":"16"},{"unit_id":"730736","unit_nama":"Kantor Kecamatan Sinjai Selatan","unit_alamat":"Jl. Persatuan Raya Bikeru No. 1B Kecamatan SInjai Selatan<br>Kabupaten Sinjai Provinsi Sulawesi Selatan Kode Pos 92661","jml_pegawai":"20"},{"unit_id":"730735","unit_nama":"Kantor Kecamatan Sinjai Tengah","unit_alamat":"Jl. Damai No.1 Lappadata Telp. (0482) 2424001. Kode Pos 92652","jml_pegawai":"22"},{"unit_id":"730734","unit_nama":"Kantor Kecamatan Sinjai Timur","unit_alamat":"Jl. Abd. Latif No.    Telp. (0482) 23014 Kode Pos 92611","jml_pegawai":"21"},{"unit_id":"730733","unit_nama":"Kantor Kecamatan Sinjai Utara","unit_alamat":"Jl. Bulu Kunyi No.1 Telp. (0482) 21014 Kode Pos 92612","jml_pegawai":"48"},{"unit_id":"730739","unit_nama":"Kantor Kecamatan Tellulimpoe","unit_alamat":"0","jml_pegawai":"18"},{"unit_id":"7307","unit_nama":"PEMERINTAH DAERAH KABUPATEN SINJAI","unit_alamat":"","jml_pegawai":"3"},{"unit_id":"730728","unit_nama":"Rumah Sakit Umum Daerah","unit_alamat":"0","jml_pegawai":"368"},{"unit_id":"730732","unit_nama":"Satuan Polisi Pamong Praja dan Pemadam Kebakaran","unit_alamat":"Lingk. Tanassang Kel. Alehanuae Kec. Sinjai Utara Kab. Sinjai Telp. (0482) 23305 Kode Pos 92611","jml_pegawai":"61"},{"unit_id":"730701","unit_nama":"Sekretariat Daerah","unit_alamat":"Tanassang, Kel. Alehanuae, Kec. Sinjai Utara Kabupaten Sinjai Provinsi Sulawesi Selatan Kode Pos 92611","jml_pegawai":"96"},{"unit_id":"730702","unit_nama":"Sekretariat DPRD","unit_alamat":"Tanassang","jml_pegawai":"21"}]
JSON;

        $units = json_decode($json_data, true);

        if (is_array($units)) {
            foreach ($units as $unit) {
                if (isset($unit['unit_id']) && isset($unit['unit_nama'])) {
                    Organization::updateOrCreate(
                        ['remote_id' => $unit['unit_id']],
                        [
                            'name' => $unit['unit_nama'],
                            'slug' => Str::slug($unit['unit_nama']),
                            'type' => 'unit',
                            'status' => 'active',
                            'unit_id' => $unit['unit_id'], // Add unit_id
                            'remote_id' => $unit['unit_id'], // Ensure remote_id is also set
                        ]
                    );
                }
            }
        }
    }
}
