<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
use App\Models\Category;
use App\Models\ItemPicture;
use App\Models\ItemSize;
use App\Models\ItemColor;

class Item extends Model
{
    use HasFactory;
    protected $table = "items";
    
    public function item_pictures()
    {
        return $this->hasMany(ItemPicture::class, "item_id");
    }
    
    public function item_colors()
    {
        return $this->hasMany(ItemColor::class, "item_id");
    }
    
    public function item_sizes()
    {
        return $this->hasMany(ItemSize::class, "item_id");
    }
    public function category()
    {
        return $this->belongsTo(Category::class, "category_id");
    }
    
    public static function getItemList($request)
    {
        $data = self::select("*")
        ->selectRaw("
            items.id AS 'id',
            items.name AS 'name',
            categories.name AS 'category',
            items.description  AS 'description'
        ")
        ->leftJoin("categories", "categories.id", "=", "items.category_id");
        $datatableResult = DataTables::of($data)
        ->filterColumn('name', function ($query, $keyword) {
            $sql = "items.name like ?";
            $query->whereRaw($sql, ['%'.$keyword.'%']);
        })
        ->filterColumn('category', function ($query, $keyword) {
            $sql = "categories.name like ?";
            $query->whereRaw($sql, ['%'.$keyword.'%']);
        })
        ->filterColumn('description', function ($query, $keyword) {
            $sql = "items.description like ?";
            $query->whereRaw($sql, ['%'.$keyword.'%']);
        });
        return $datatableResult->toJson();
    }

    public static function saveItem($data)
    {
        $result = [];
        $result["success"] = false;
        $result["message"] = "Terjadi kesalahan, silahkan coba kembali";
        $result["jsonCode"] = 500;
        try {
            if(!isset($data["name"])) {
                $result["message"] = "Nama belum diset.";
                return $result;
            }
            if(isset($data["id"])) {
                return self::updateItem($data);
            }
            if(self::where("name",'=',$data["name"])->count() != 0) {
                $result["message"] = "Barang dengan nama yang sama sudah ada.";
                return $result;
            }
            DB::beginTransaction();
            $item = new self;
            $item->name = $data['name'];
            $item->category_id = $data['category'];
            $item->description = $data['description'] ?? "";
            $item->save();

            foreach($data["image"] ?? [] as $eachImage) {
                if($eachImage == "") continue;
                $itemImage = new ItemPicture;
                $itemImage->item_id = $item->id;
                $itemImage->link = $eachImage;
                $itemImage->save();
            }

            foreach($data["color"] ?? [] as $eachColor) {
                if($eachColor == "") continue;
                $itemColor = new ItemColor;
                $itemColor->item_id = $item->id;
                $itemColor->color = $eachColor;
                $itemColor->save();
            }

            foreach($data["size"] ?? [] as $eachSize) {
                if($eachSize["size"] == "" && $eachSize["price"] == "") continue;
                $itemSize = new ItemSize;
                $itemSize->item_id = $item->id;
                $itemSize->size = $eachSize["size"];
                $itemSize->price = $eachSize["price"];
                $itemSize->save();
            }

            DB::commit();
            $result["success"] = true;
            $result["message"] = "Data sudah berhasil disimpan.";
            $result["jsonCode"] = 200;
        } catch(Exception $e) {
            throw $e;
        }
        return $result;
    }
    
    public static function updateItem($data)
    {
        $result = [];
        $result["success"] = false;
        $result["message"] = "Terjadi kesalahan, silahkan coba kembali";
        $result["jsonCode"] = 500;
        try {
            if(self::where("name",'=',$data["name"])->where("id","!=",$data["id"])->count() != 0) {
                $result["message"] = "Barang lain dengan nama yang sama sudah ada.";
                return $result;
            }
            DB::beginTransaction();
            $item = self::where("id",'=',$data["id"])->first();
            $item->name = $data['name'];
            $item->category_id = $data['category'];
            $item->description = $data['description'] ?? "";
            $item->save();

            //Update validator
            $validImageCount = 0;
            foreach($data["image"] ?? [] as $eachImage) {
                if($eachImage != "") $validImageCount++;
            }
            $existingImageCount = ItemPicture::where("item_id",'=',$item->id)->count();
            if($existingImageCount > $validImageCount) {
                ItemPicture::where("item_id",'=',$item->id)
                ->skip($validImageCount)
                ->take($existingImageCount - $validImageCount)
                ->delete();
            }
            $existingImageCount = ItemPicture::where("item_id",'=',$item->id)->count();
            
            $validColorCount = 0;
            foreach($data["color"] ?? [] as $eachColor) {
                if($eachColor != "") $validColorCount++;
            }
            $existingColorCount = ItemColor::where("item_id",'=',$item->id)->count();
            if($existingColorCount > $validColorCount) {
                ItemColor::where("item_id",'=',$item->id)
                ->skip($validColorCount)
                ->take($existingColorCount - $validColorCount)
                ->delete();
            }
            $existingColorCount = ItemColor::where("item_id",'=',$item->id)->count();
            
            $validSizeCount = 0;
            foreach($data["size"] ?? [] as $eachSize) {
                if($eachSize["size"] != "" && $eachSize["price"] != "") $validSizeCount++;
            }
            $existingSizeCount = ItemSize::where("item_id",'=',$item->id)->count();
            if($existingSizeCount > $validSizeCount) {
                ItemSize::where("item_id",'=',$item->id)
                ->skip($validSizeCount)
                ->take($existingSizeCount - $validSizeCount)
                ->delete();
            }
            $existingSizeCount = ItemSize::where("item_id",'=',$item->id)->count();
            //End of update validator

            $index = 0;
            foreach($data["image"] ?? [] as $eachImage) {
                if($eachImage == "") continue;
                $itemImage = null;
                if($index < $existingImageCount) {
                    $itemImage = ItemPicture::where("item_id",'=',$item->id)->skip($index)->first();
                } else {
                    $itemImage = new ItemPicture;
                }
                $itemImage->item_id = $item->id;
                $itemImage->link = $eachImage;
                $itemImage->save();
                $index++;
            }

            $index = 0;
            foreach($data["color"] ?? [] as $eachColor) {
                if($eachColor == "") continue;
                $itemColor = null;
                if($index < $existingColorCount) {
                    $itemColor = ItemColor::where("item_id",'=',$item->id)->skip($index)->first();
                } else {
                    $itemColor = new ItemColor;
                }
                $itemColor->item_id = $item->id;
                $itemColor->color = $eachColor;
                $itemColor->save();
                $index++;
            }

            $index = 0;
            foreach($data["size"] ?? [] as $eachSize) {
                if($eachSize["size"] == "" && $eachSize["price"] == "") continue;
                $itemSize = null;
                if($index < $existingSizeCount) {
                    $itemSize = ItemSize::where("item_id",'=',$item->id)->skip($index)->first();
                } else {
                    $itemSize = new ItemSize;
                }
                $itemSize->item_id = $item->id;
                $itemSize->size = $eachSize["size"];
                $itemSize->price = $eachSize["price"];
                $itemSize->save();
                $index++;
            }

            DB::commit();
            $result["success"] = true;
            $result["message"] = "Data sudah berhasil diupdate.";
            $result["jsonCode"] = 200;
        } catch(Exception $e) {
            throw $e;
        }
        return $result;
    }

    public static function getItemDetail($id)
    {
        $data = self::where("id",'=',$id)
        ->with("item_pictures","item_colors","item_sizes","category")
        ->first();

        if($data) {
            $data = $data->toArray();
        } else {
            $data = [];
        }
        return $data;
    }

    public static function deleteItem($id)
    {
        $result = [];
        $result["success"] = false;
        $result["message"] = "Terjadi kesalahan, silahkan coba kembali";
        $result["jsonCode"] = 500;
        if(!isset($id)) {
            $result["message"] = "Id tidak didefinisikan.";
            return $result;
        }
        try {
            self::where("id",'=',$id)->delete();

            $result["success"] = true;
            $result["message"] = "Data sudah berhasil dihapus.";
            $result["jsonCode"] = 200;
        } catch(Exception $e) {
            throw $e;
        }
        return $result;
    }
    
    public static function getItemListApi($request)
    {
        $data = self::select("*")
        ->selectRaw("
            items.id AS 'id',
            items.name AS 'name',
            categories.name AS 'category',
            items.description  AS 'description'
        ")
        ->leftJoin("categories", "categories.id", "=", "items.category_id");
        if(isset($request["name"])) {
            $data->whereRaw("items.name LIKE ?",['%'.$request["name"].'%']);
        }
        if(isset($request["category"])) {
            $data->whereRaw("categories.name LIKE ?",['%'.$request["category"].'%']);
        }
        if(isset($request["description"])) {
            $data->whereRaw("items.descriptio LIKE ?",['%'.$request["description"].'%']);
        }
        $data->with("item_pictures","item_colors","item_sizes");
        if($data->count() != 0) {
            $data = $data->get()->toArray();
        } else {
            $data = [];
        }
        return $data;
    }
}
