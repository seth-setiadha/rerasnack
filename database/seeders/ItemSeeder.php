<?php

namespace Database\Seeders;

use App\Models\Item;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Item::factory()->count(300)->create();

        $items = [
            ['A-001', 'AJISAN SAKURA COKLAT', 4], 
            ['A-002', 'AJISAN SAKURA WARNA - WARNI', 3], 
            ['A-003', 'ALEN -ALEN', 4], 
            ['A-004', 'AMPYANG JAHE RAJAWALI', 2.5], 
            ['B-001', 'BARCELONA BLEK', 4], 
            ['B-002', 'BARCELONA BOX', 4], 
            ['B-003', 'BASRENG ANEKA KRIPIK ORI', 2], 
            ['B-005', 'BELUT', 2], 
            ['B-007', 'BIDARAN BALADO 2N', 3], 
            ['B-008', 'BIDARAN KEJU TRIGER', 2.5], 
            ['B-011', 'BASRENG STIK SANJAYA', 2], 
            ['B-013', 'BASRENG STIK SINAR FAJAR', 2], 
            ['C-001', 'CEKER', 1], 
            ['D-002', 'DOROKDOK ORI', 0.5], 
            ['D-003', 'DOROKDOK BALADO', 0.5], 
            ['D-004', 'DODOL ZEBRA HERMA', 10], 
            ['D-005', 'DODOL COKLAT HERMA', 10], 
            ['E-003', 'EMPING MLINJO', 5], 
            ['E-004', 'EMPING MLINJO PEDAS CAP JEMPOL', 5], 
            ['E-005', 'EMPING MLINJO MANIS', 5], 
            ['J-002', 'JAMUR ORI KHANZA', 2], 
            ['K-001', 'KACANG ATOM SP', 5], 
            ['K-003', 'KACANG MIX JAIPONG', 4], 
            ['K-008', 'KERIPIK MBOTHE', 2], 
            ['K-009', 'KORO KULIT JAIPONG', 4], 
            ['K-012', 'KORO KUPAS ORI JAIPONG', 4], 
            ['K-015', 'KULIT MLINJO', 2], 
            ['K-016', 'KUPING GAJAH MADU RASA', 5], 
            ['K-017', 'KUPING GAJAH SPONGEBOB', 5], 
            ['K-030', 'KWACI REBO', 2], 
            ['K-031', 'KERUPUK IKAN', 2.5], 
            ['K-032', 'KERIPIK KACA', 1.5], 
            ['K-033', 'KAKAP NDARU LAUT', 1], 
            ['K-034', 'KWACI MATAHARI', 2], 
            ['M-001', 'MAKARONI DJ_70K', 4], 
            ['M-001', 'MAKARONI DJ_72K', 4], 
            ['M-003', 'MAKARONI SPIRAL DOYAN', 4], 
            ['M-014', 'MANCO WIJEN', 3], 
            ['M-015', 'MIE SETAN', 2], 
            ['N-001', 'NANGKA', 2], 
            ['O-001', 'OPAK GAMBIR CONTONG', 2], 
            ['O-003', 'OPAK GAMBIR GULUNG', 2], 
            ['O-004', 'OPAK GAMBIR MAWAR 1 KG', 1], 
            ['O-005', 'OPAK GAMBIR MAWAR 1,5 KG', 1.5], 
            ['P-001', 'PANG - PANG LARIZE', 3], 
            ['P-003', 'PARE BAROKAH', 2], 
            ['P-010', 'PERMEN TAPE', 5], 
            ['P-011', 'PILUS AUSIE PEDAS', 4], 
            ['P-014', 'PISANG KOIN MAHKOTA', 3], 
            ['P-015', 'PISANG KOIN ORI GOLDEN', 3], 
            ['P-016', 'PISANG PANJANG ECO', 2], 
            ['P-017', 'PISANG KEPOK', 2], 
            ['S-006', 'SALE KERING', 3], 
            ['S-007', 'SALE LIDAH', 4], 
            ['S-008', 'SALE PISANG AROMA', 2], 
            ['S-010', 'SEBLAK JENGKOL PEDO', 1.30], 
            ['S-012', 'BASRENG STIK PEDO', 1.90], 
            ['S-012', 'SEBLAK KENCUR CK_67K', 2.70], 
            ['S-014', 'SEBLAK MAWAR PEDO', 2], 
            ['S-016', 'SEBLAK SOTO IJO PEDO', 2], 
            ['S-018', 'SINGKONG GADUNG', 3], 
            ['S-021', 'SINGKONG SAMBAL DOYAN', 3], 
            ['S-024', 'SOES WALLENS', 3.5], 
            ['S-025', 'SOSRENG', 2], 
            ['S-028', 'STIK SUKUN', 3], 
            ['S-030', 'STIK TALAS 2 JEMPOL', 3], 
            ['S-035', 'STIK BAWANG', 5], 
            ['S-036', 'SEBLAK RING SINAR JAYA', 2], 
            ['T-004', 'TALAS GELOMBANG ORI 2 JEMPOL', 3], 
            ['T-005', 'TALAS GELOMBANG SAPI PANGGANG', 3], 
            ['T-009', 'TEMPE MENJES', 2], 
            ['T-010', 'TEMPE SAGU PARIMAS', 2], 
            ['T-016', 'TES STIK BALADO', 2], 
            ['T-018', 'TES TWIST CORN', 2], 
            ['T-021', 'TONGKOL', 1], 
            ['T-023', 'TAHU WALIK PARIMAS', 2], 
            ['T-025', 'TES TORTILA BBQ', 2], 
            ['U-004', 'USUS GENTONG_80K', 2], 
            ['U-006', 'USUS SAMBAL', 2], 
            ['U-007', 'USUS BAKUL', 2], 
            ['Y-001', 'YOLA - YOLA', 2]
        ];
        foreach($items as $key => $value) {
            DB::table('items')->insert([
                'item_code' => $value[0],
                'item_name' => $value[1],
                'bal_kg' => $value[2],
                'bal_gr' => ($value[2] * 1000),
                'user_id' => 1
            ]);
        }
    }
}
