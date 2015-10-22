<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use Box\Spout\Reader\ReaderFactory;
use Box\Spout\Common\Type;
use Box\Spout\Writer\WriterFactory;

use App\User;
use App\Store;
use App\StoreSku;

class DownloadController extends Controller
{
    public function index(Request $request){
        $user = $request->id;
        $type = $request->type;

        $user = User::with('stores','stores.skus')->find($user);
        $storelist = $user->stores()->orderBy('store')->get();

        // get store list
        if($type == 1){
            $writer = WriterFactory::create(Type::CSV); 
            $writer->openToBrowser('stores.txt');
            foreach ($storelist as $store) {
                $data[0] = $store->id;
                $data[1] = $store->store_code;
                $data[2] = $store->store;
                $writer->addRow($data); 
            }

            $writer->close();
        }

        //get store sku list
        if($type == 2){
            $ids = array();
            foreach ($storelist as $store) {
                $ids[] = $store->id;
            }

            $skus = StoreSku::select('store_id', 'sku_code', 'sku_desc', 'ig', 'conversion', 'categories.category_long',
                'sub_categories.subcategory', 'brands.brand', 'divisions.division')
                ->join('skus', 'skus.id', '=', 'store_sku.sku_id')
                ->join('categories', 'categories.id', '=', 'skus.category_id')
                ->join('sub_categories', 'sub_categories.id', '=', 'skus.sub_category_id')
                ->join('brands', 'brands.id', '=', 'skus.brand_id')
                ->join('divisions', 'divisions.id', '=', 'skus.division_id')
                ->whereIn('store_id',$ids)->get();
            
            $writer = WriterFactory::create(Type::CSV); 
            $writer->openToBrowser('skus.txt');
            foreach ($skus as $sku) {
                $data[0] = $sku->sku_code;
                $data[1] = $sku->sku_desc;
                $data[2] = $sku->ig;
                $data[3] = $sku->conversion;
                $data[4] = $sku->category_long;
                $data[5] = $sku->subcategory;
                $data[6] = $sku->brand;
                $data[7] = $sku->division;
                $data[8] = $sku->store_id;
                $writer->addRow($data); 
            }

            // $writer->close();
        }
    }
}
