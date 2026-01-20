<?php

namespace Database\Seeders;

use App\Models\Outlet;
use App\Models\User;
use Illuminate\Database\Seeder;

class OutletSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $arnesUser = User::where('email', 'arnes@gmail.com')->first();
        $userId = $arnesUser ? $arnesUser->id : null;

        $outlets = [
            ['kode_outlet' => 'AFT', 'nama_outlet' => 'ALFATHU'],
            ['kode_outlet' => 'SMD', 'nama_outlet' => 'ASIA PLAZA'],
            ['kode_outlet' => 'BTS', 'nama_outlet' => 'BALTOS'],
            ['kode_outlet' => 'BIJ', 'nama_outlet' => 'BANDARA KERTAJATI (BIJB)'],
            ['kode_outlet' => 'BKS', 'nama_outlet' => 'BEKASI'],
            ['kode_outlet' => 'BBT', 'nama_outlet' => 'BUAH BATU'],
            ['kode_outlet' => 'CKK', 'nama_outlet' => 'CAWANG, CIKOKO'],
            ['kode_outlet' => 'CJR', 'nama_outlet' => 'CIANJUR'],
            ['kode_outlet' => 'SKM', 'nama_outlet' => 'CIASEM'],
            ['kode_outlet' => 'CGN', 'nama_outlet' => 'CIGANEA'],
            ['kode_outlet' => 'CKP', 'nama_outlet' => 'CIKOPO'],
            ['kode_outlet' => 'CLY', 'nama_outlet' => 'CILEUNYI'],
            ['kode_outlet' => 'CRB', 'nama_outlet' => 'CIREBON'],
            ['kode_outlet' => 'CST', 'nama_outlet' => 'CISAAT SPBU 34-43110 (VIRTUAL PICKUP POINT)'],
            ['kode_outlet' => 'IDM', 'nama_outlet' => 'INDRAMAYU'],
            ['kode_outlet' => 'FMI', 'nama_outlet' => 'ITC FATMAWATI'],
            ['kode_outlet' => 'JTA', 'nama_outlet' => 'JATINANGOR'],
            ['kode_outlet' => 'KDP', 'nama_outlet' => 'KADIPATEN'],
            ['kode_outlet' => 'KUN', 'nama_outlet' => 'KUNINGAN CITY HALTE (VIRTUAL PICKUP POINT)'],
            ['kode_outlet' => 'LBR', 'nama_outlet' => 'LOHBENER'],
            ['kode_outlet' => 'LSR', 'nama_outlet' => 'LOSARANG'],
            ['kode_outlet' => 'MDR', 'nama_outlet' => 'MADTARI'],
            ['kode_outlet' => 'MJA', 'nama_outlet' => 'MAJA'],
            ['kode_outlet' => 'NHC', 'nama_outlet' => 'NIAGA HANDAL CEMERLANG'],
            ['kode_outlet' => 'PLM', 'nama_outlet' => 'PALIMANAN'],
            ['kode_outlet' => 'PMK', 'nama_outlet' => 'PAMANUKAN'],
            ['kode_outlet' => 'PCR', 'nama_outlet' => 'PANCORAN'],
            ['kode_outlet' => 'KRG', 'nama_outlet' => 'PAREAN GIRANG'],
            ['kode_outlet' => 'PRK', 'nama_outlet' => 'PARUNG KUDA'],
            ['kode_outlet' => 'PST', 'nama_outlet' => 'PASTEUR'],
            ['kode_outlet' => 'PTR', 'nama_outlet' => 'PATROL'],
            ['kode_outlet' => 'PSM', 'nama_outlet' => 'PICKUP SUMEDANG'],
            ['kode_outlet' => 'GIA', 'nama_outlet' => 'PWK KOTA'],
            ['kode_outlet' => 'STS', 'nama_outlet' => 'SADANG A'],
            ['kode_outlet' => 'SDG', 'nama_outlet' => 'SADANG B'],
            ['kode_outlet' => 'PSO', 'nama_outlet' => 'SOREANG BALE'],
            ['kode_outlet' => 'SOR', 'nama_outlet' => 'SOREANG SPBU'],
            ['kode_outlet' => 'SBM', 'nama_outlet' => 'SUKABUMI'],
            ['kode_outlet' => 'SKL', 'nama_outlet' => 'SUKALARANG'],
            ['kode_outlet' => 'SRJ', 'nama_outlet' => 'SUKARAJA'],
            ['kode_outlet' => 'TNJ', 'nama_outlet' => 'TONJONG'],
            ['kode_outlet' => 'UKI', 'nama_outlet' => 'UKI CAWANG HALTE (VIRTUAL PICKUP POINT)'],
            ['kode_outlet' => 'BKC', 'nama_outlet' => 'BURGER KING CIKARANG (VIRTUAL PICKUP POINT)'],
            ['kode_outlet' => 'DTM', 'nama_outlet' => 'DELTAMAS (AGEN)'],
            ['kode_outlet' => 'PCK', 'nama_outlet' => 'HALTE 08 LIPPO MALL CIKARANG (VIRTUAL PICKUP POINT)'],
            ['kode_outlet' => 'KKM', 'nama_outlet' => 'MAXX COFFEE MEIKARTA (VIRTUAL PICKUP POINT)'],
            ['kode_outlet' => 'CKR', 'nama_outlet' => 'PASAR CENTRAL LIPPO CIKARANG'],
        ];

        foreach ($outlets as $outlet) {
            Outlet::updateOrCreate(
                ['kode_outlet' => $outlet['kode_outlet']],
                [
                    'nama_outlet' => $outlet['nama_outlet'],
                    'user_id' => $userId,
                    'status' => 'aktif',
                ]
            );
        }
    }
}
