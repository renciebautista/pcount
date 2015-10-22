<?php
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

use Box\Spout\Reader\ReaderFactory;
use Box\Spout\Common\Type;

use App\Division;
use App\Category;
use App\SubCategory;
use App\Brand;
use App\Sku;

class UploadItemSeeder extends Seeder
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
		DB::table('divisions')->truncate();
		DB::table('categories')->truncate();
		DB::table('sub_categories')->truncate();
		DB::table('brands')->truncate();
		DB::table('skus')->truncate();

		$reader = ReaderFactory::create(Type::XLSX); // for XLSX files
		$filePath = 'database/seeds/seed_files/Items.xlsx';
		$reader->open($filePath);

		foreach ($reader->getSheetIterator() as $sheet) {
			if($sheet->getName() == 'SKU Data'){
				$rowcnt = 0;
				foreach ($sheet->getRowIterator() as $row) {
					if($rowcnt > 1){
						if(!is_null($row[0])){
							$division = Division::firstOrCreate(['division' => $row[8]]);
							$category = Category::firstOrCreate(['category_short' => strtoupper($row[1]),'category_long' => strtoupper($row[0])]);
							$sub_category = SubCategory::firstOrCreate(['subcategory' => strtoupper($row[6])]);
							$brand = Brand::firstOrCreate(['brand' => strtoupper($row[7])]);
							$sku = Sku::firstOrCreate(['division_id' => $division->id,
								'category_id' => $category->id,
								'sub_category_id' => $sub_category->id,
								'brand_id' => $brand->id,
								'sku_code' => $row[2],
								'item_desc' => $row[3],
								'sku_desc' => $row[4],
								'conversion' => $row[5]]);
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
