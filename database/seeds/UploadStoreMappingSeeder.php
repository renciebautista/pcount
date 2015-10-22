<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

use Box\Spout\Reader\ReaderFactory;
use Box\Spout\Common\Type;

use App\Customer;
use App\Area;
use App\Premise;
use App\Store;

class UploadStoreMappingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

		DB::statement('SET FOREIGN_KEY_CHECKS=0;');
		DB::table('customers')->truncate();
		DB::table('areas')->truncate();
		DB::table('premises')->truncate();
		DB::table('stores')->truncate();

		$reader = ReaderFactory::create(Type::XLSX); // for XLSX files
		$filePath = 'database/seeds/seed_files/Store Mapping.xlsx';
		$reader->open($filePath);

		foreach ($reader->getSheetIterator() as $sheet) {
			if($sheet->getName() == 'Sheet1'){
				$rowcnt = 0;
				foreach ($sheet->getRowIterator() as $row) {
					if($rowcnt > 1){
						if(!is_null($row[0])){
							$customer = Customer::firstOrCreate(['customer_code' => $row[8], 'customer' => strtoupper($row[9])]);
							$area = Area::firstOrCreate(['area_code' => $row[2], 'area' => strtoupper($row[3])]);
							$premise = Premise::firstOrCreate(['premise_code' => $row[4], 'premise' => strtoupper($row[5])]);

							Store::firstOrCreate(['customer_id' => $customer->id, 
								'area_id' => $area->id,
								'premise_id' => $premise->id,
								'store_code' => strtoupper($row[0]),
								'store' => strtoupper($row[1]),
								]);
						}

					}
					$rowcnt++;
				}
			}
		}

		$reader->close();




		DB::statement('SET FOREIGN_KEY_CHECKS=1;');
		Model::reguard();
    }
}
