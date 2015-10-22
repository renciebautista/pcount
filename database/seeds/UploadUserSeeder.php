<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

use Box\Spout\Reader\ReaderFactory;
use Box\Spout\Common\Type;

use App\User;
use App\Store;

class UploadUserSeeder extends Seeder
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
		DB::table('users')->truncate();
		DB::table('store_user')->truncate();

		$reader = ReaderFactory::create(Type::XLSX); // for XLSX files
		$filePath = 'database/seeds/seed_files/User.xlsx';
		$reader->open($filePath);

		foreach ($reader->getSheetIterator() as $sheet) {
			if($sheet->getName() == 'File'){
				$rowcnt = 0;
				$errorCnt = 0;
				foreach ($sheet->getRowIterator() as $row) {
					if($rowcnt > 0){
						if(!is_null($row[0])){
							$user = User::where('email',strtolower($row[19]).'@unilever.com')->first();
							if(count($user) == 0){
								$user = User::firstOrCreate(['name' =>  strtoupper($row[18]), 
								'email' => strtolower($row[19]).'@unilever.com',
								'username' => $row[19],
								'password' =>  Hash::make('password')]);
							}

							$store = Store::where('store_code', $row[5])->first();
							if(!empty($store)){
								$store->users()->attach($user->id);
							}else{
								$errorCnt++;
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
