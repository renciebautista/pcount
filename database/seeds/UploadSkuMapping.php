<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

use Box\Spout\Reader\ReaderFactory;
use Box\Spout\Common\Type;

use App\Premise;
use App\Store;
use App\Sku;

class UploadSkuMapping extends Seeder
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
		DB::table('store_sku')->truncate();

		$reader = ReaderFactory::create(Type::XLSX); // for XLSX files
		$filePath = 'database/seeds/seed_files/SKU Mapping.xlsx';
		$reader->open($filePath);

		foreach ($reader->getSheetIterator() as $sheet) {
			if($sheet->getName() == 'Sheet1'){
				$rowcnt = 0;
				$errorCnt = 0;
				foreach ($sheet->getRowIterator() as $row) {
					if($rowcnt > 0){
						if(!is_null($row[0])){
							$premise = Premise::where('premise_code', $row[0])->first();
							if(!empty($premise)){
								$stores = Store::where('premise_id', $premise->id)->get();
								$sku = Sku::where('sku_code', $row[3])->first();
								if((!empty($stores)) && (!empty($sku))){
									foreach ($stores as $store) {
										$store->skus()->attach($sku,array('ig' => $sku->conversion + 20));
									}
								}
							}
						}

					}
					$rowcnt++;
				}
			}
		}

		$reader->close();

		echo $errorCnt;


		DB::statement('SET FOREIGN_KEY_CHECKS=1;');
		Model::reguard();
    }
}
