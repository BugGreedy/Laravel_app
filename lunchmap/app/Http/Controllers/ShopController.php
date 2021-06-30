<?php

namespace App\Http\Controllers;

use App\Models\Shop;
// 下記を追加
use App\Models\Category;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //下記を記述
        $shops = Shop::all();
        return view('index',['shops'=>$shops]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $shop = new Shop;
        $categories = Category::all()->pluck('name','id');
        return view('new',['categories'=> $categories]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // 下記を追加
        $shop = new Shop();
        $shop->name = request('name');
        $shop->address = request('address');
        $shop->category_id = request('category_id'); 
        $shop->save();
        return redirect()->route('shop.detail',['id' => $shop->id]);
    }

    /**
     * Display the specified resource.
     * 
     * @param  \App\Models\Shop  $shop
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $shop = Shop::find($id);
        return view('show',['shop'=>$shop]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Shop  $shop
     * @return \Illuminate\Http\Response
     */
    // 下記を編集
    public function edit(Shop $shop, $id)
    {   
        $shop = Shop::find($id);
        $categories = Category::all()->pluck('name','id');
        return view('edit',['shop' => $shop, 'categories' => $categories]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Shop  $shop
     * @return \Illuminate\Http\Response
     */
    // 下記を編集
    public function update(Request $request, $id, Shop $shop)
    {
        $shop = Shop::find($id);
        $shop->name = request('name');
        $shop->address = request('address');
        $shop->category_id = request('category_id');
        $shop->save();
        return redirect()->route('shop.detail', ['id' => $shop->id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Shop  $shop
     * @return \Illuminate\Http\Response
     */
    // 下記を編集
    public function destroy($id)
    {
        $shop = Shop::find($id);
        $shop->delete();
        return redirect('/shops');
    }
}
