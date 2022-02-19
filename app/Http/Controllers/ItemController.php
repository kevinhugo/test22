<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Item;
use Illuminate\Http\Response;

class ItemController extends Controller
{
    public function index(Request $request)
    {
        $categoryList = Category::getAllCategoryList()->toArray();
        return view('index', [
            "categoryList" => $categoryList
        ]);
    }
    
    public function getItemList(Request $request)
    {
        return Item::getItemList($request);
    }

    public function saveItem(Request $request)
    {
        $saveResult = Item::saveItem($request->all());
        return response()->json($saveResult,$saveResult["jsonCode"]);
    }

    public function getItemDetail(Request $request)
    {
        return Item::getItemDetail($request->id);
    }

    public function deleteItem(Request $request)
    {
        $deleteResult = Item::deleteItem($request->id);
        return response()->json($deleteResult,$deleteResult["jsonCode"]);
    }
}
