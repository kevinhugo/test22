<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
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
        // return DataTables::of($data)
        //     ->filterColumn('brand', function ($query, $keyword) {
        //     })
        //     ->filterColumn('category', function ($query, $keyword) {
        //     })
        //     ->filterColumn('sub_category', function ($query, $keyword) {
        //     });
        $datatableResult = DataTables::of($data)
        ->filterColumn('nama', function ($query, $keyword) {
            $sql = "items.name like ?";
            $query->whereRaw($sql, queryContains($keyword));
        })
        ->filterColumn('categories', function ($query, $keyword) {
            $sql = "categories.name like ?";
            $query->whereRaw($sql, queryContains($keyword));
        })
        ->filterColumn('description', function ($query, $keyword) {
            $sql = "items.description like ?";
            $query->whereRaw($sql, queryContains($keyword));
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
            if(self::where("name",'=',$data["name"])->count() != 0) {
                $result["message"] = "Barang dengan nama yang sama sudah ada.";
                return $result;
            }
            $item = new self;
            $item->name = $data['name'];
            $item->category_id = $data['category'];
            $item->description = $data['description'];
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

            $result["success"] = true;
            $result["message"] = "Data sudah berhasil disimpan.";
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
}
