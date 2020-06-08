@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="">
        <div class="mx-auto" style="max-width:1200px">
            <h1 style="color:#555555; text-align:center; font-size:1.2em; padding:24px 0px; font-weight:bold;">
                {{ Auth::user()->name }}さんのカートの中身
            </h1>
            <div class="">
                <p class="text-center">{{ $message ?? ''}}</p><br>
                <div class="d-flex flex-row flex-wrap">
                    @if($my_carts->isNotEmpty()) 
                        @foreach($my_carts as $my_cart)
                            <div class="mycart_box">
                                {{$my_cart->stock->name}} <br>                                
                                {{ number_format($my_cart->stock->fee)}}円 <br>
                                <img src="/image/{{$my_cart->stock->imgpath}}" alt="" class="incart" >
                                <br>

                                <p>カートに{{$my_cart->number}}個入っています。</p>
                                <form action="/numberchange" method="post">
                                    @csrf
                                    <input type="hidden" name="stock_id" value="{{ $my_cart->stock->id }}">
                                    <select name="item_number" id="">
                                        @for($i=1; $i<=10; $i++)
                                            <option value="{{$i}}">{{$i}}</option>
                                        @endfor
                                        <input type="submit" value="数量変更">
                                    </select>
                                </form>
                                
                                <form action="/cartdelete" method="post">
                                    @csrf
                                    <input type="hidden" name="stock_id" value="{{ $my_cart->stock->id }}">
                                    <input type="submit" value="カートから削除する">
                                </form>
                            <p>小計：{{number_format($my_cart->stock->fee*$my_cart->number)}}円</p>
                            </div>
                        @endforeach 
                    </div>

                    <div class="text-center p-2">
                        <p style="font-size:1.2em; font-weight:bold;">合計金額:{{number_format($sum)}}円</p>  
                    </div> 
                    <form action="/checkout" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-danger btn-lg text-center buy-btn" >購入する</button>
                    </form>
                @else
                   <p class="text-center">カートはからっぽです。</p>
                @endif
                <a href="/">商品一覧へ</a>
            </div>
        </div>
    </div>
</div>
@endsection