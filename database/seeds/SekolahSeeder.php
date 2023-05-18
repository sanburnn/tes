<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SekolahSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('sekolah')->insert([
        [ 
                'nama'          => 'SD ISLAM PLUS MASYITOH',
                'alamat'        => 'Jl Cendrawasih 20, Bajing Kulon, Kec. Kroya, Kab. Cilacap Prov. Jawa Tengah',
                'logo'  => 'Logo_SD.png',
                'keterangan' => 'SD ISLAM PLUS MASYITHOH KROYA merupakan salah satu satuan pendidikan dengan jenjang SD di Bajing Kulon, Kec. Kroya, Kab. Cilacap, Jawa Tengah. Dalam menjalankan kegiatannya, SD ISLAM PLUS MASYITHOH berada di bawah naungan Kementerian Pendidikan dan Kebudayaan.',
                'telepon' => '(0282) 5298455',
                'email' => 'sdipmkroya@yahoo.co.id',
                'website' => ''
        ],

        [ 
                'nama'          => 'SMP MASYITOH KROYA (REGULER)',
                'alamat'        => 'Jl Merak No.28, BAJING KULON, Kec. Kroya, Kab. Cilacap Prov. Jawa Tengah',
                'logo'  => 'Logo_SMP.png',
                'keterangan' => 'SMP MASYITHOH KROYA merupakan sekolah dengan ciri khas keterpaduan antara kurikulum Dinas Pendidikan dan Kebudayaan dan Kurikulum Kepesantrenan. Nuansa islami pada seluruh kegiatan sangat kental untuk mencetak generasi muda yang cerdas dan berakhlaq mulia.',
                'telepon' => '(0282) 494388',
                'email' => 'tu.smpmasyithohkroya@gmail.com',
                'website' => 'https://smpmasyithohkroya.sch.id'
        ],	

        [ 
                'nama'          => 'SMA MA`ARIF KROYA',
                'alamat'        => 'Jl. Merak No. 28 Kroya, Bajing Kulon, Kec. Kroya, Kab. Cilacap Prov. Jawa Tengah',
                'logo'  => 'Logo_SMA.png',
                'keterangan' => 'Visi SMA Ma`arif Kroya adalah Terwujud peserta didik yang berakhlakul karimah, berbudaya, dan berprestasi. Sedangkan misi ditetapkan sebagai representasi dari elemen visi dan elemen Profil Pelajar Pancasila. Elemen visi tersebut yaitu berakhlakul karimah, berbudaya dan berprestasi.',
                'telepon' => '(0282) 492073',
                'email' => 'smamaarifkroya@gmail.com',
                'website' => 'https://www.smamaarifkroya.sch.id'
        ],	

        [ 
                'nama'          => 'SMK MA`ARIF KROYA',
                'alamat'        => 'JL. CENDRAWASIH NO. 13A, Bajing Kulon, Kec. Kroya, Kab. Cilacap Prov. Jawa Tengah',
                'logo'  => 'Logo_SMK.png',
                'keterangan' => 'SMK MA’ARIF 1 KROYA didirikan berdasarkan Surat Ijin Operasional No. 0948/I03/97 Tanggal 04 Juni 2007. Badan Penyelenggara Yayasan Miftahul Huda dengan Nama Sekolah SMK Ma`arif 1 Kroya yang beralamat Jl. Cendrawasih Bajing Kulon Kroya Telp. (0282) 492182 Cilacap Jawa Tengah 53282.',
                'telepon' => '(0282) 492182',
                'email' => 'smkmaarif1kroya.cilacap@yahoo.com',
                'website' => 'http://www.smkmaarif1kroyacilacap.sch.id'
        ],

        [ 
                'nama'          => 'SMP MASYITOH KROYA (INTENSIVE)',
                'alamat'        => 'Jl Merak No.28, BAJING KULON, Kec. Kroya, Kab. Cilacap Prov. Jawa Tengah',
                'logo'  => 'Logo_SMPINV.png',
                'keterangan' => 'SMP MASYITHOH KROYA merupakan sekolah dengan ciri khas keterpaduan antara kurikulum Dinas Pendidikan dan Kebudayaan dan Kurikulum Kepesantrenan. Nuansa islami pada seluruh kegiatan sangat kental untuk mencetak generasi muda yang cerdas dan berakhlaq mulia.',
                'telepon' => '(0282) 494388',
                'email' => 'tu.smpmasyithohkroya@gmail.com',
                'website' => 'https://smpmasyithohkroya.sch.id'
        ],
    ]);
   	}
}
