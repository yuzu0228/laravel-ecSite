<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Cart extends Model
{
    protected $fillable = [
        'stock_id',
        'user_id',
        'number'
    ];

    public function showCart()
    {
        $user_id = Auth::id();
        $data['my_carts'] = $this->where('user_id',$user_id)->get();

        $data['sum'] = 0;
        $data['count'] = 0;
        
        foreach($data['my_carts'] as $my_cart){
            $data['sum'] += $my_cart->stock->fee*$my_cart->number;
            $data['count']++;
        }
        return $data;
    }

    public function stock()
    {
       return $this->belongsTo('\App\Models\Stock');
    }

    public function addCart($stock_id)
    {
       $user_id = Auth::id(); 
       $cart_add_info = Cart::firstOrCreate(['stock_id' => $stock_id,'user_id' => $user_id]);

       if($cart_add_info->wasRecentlyCreated){
           $message = 'カートに追加しました';
       }
       else{
           $message = 'カートに登録済みです';
       }

       return $message;
    }

    public function numberChange($stock_id, $item_number)
    {
        $user_id = Auth::id();
        
        $data = [
            'number' => $item_number,
            'updated_at' => now(),
        ];

        return $this->where('user_id', $user_id)->where('stock_id',$stock_id)->update($data);
    }

    public function deleteCart($stock_id)
    {
       $user_id = Auth::id(); 
       $delete = $this->where('user_id', $user_id)->where('stock_id',$stock_id)->delete();
       
       if($delete > 0){
           $message = 'カートから一つの商品を削除しました';
       }else{
           $message = '削除に失敗しました';
       }
       return $message;
    }

    public function checkoutCart()
    {
       $user_id = Auth::id(); 
       $checkout_items = $this->where('user_id', $user_id)->get();
       $this->where('user_id', $user_id)->delete();

       return $checkout_items;     
    }
}
