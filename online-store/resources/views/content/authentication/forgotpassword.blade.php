@extends('layouts.home')
@section('content')
    <div style="margin-left: 30em; padding:5em 0 5em 0">
        <div class="forgotpassword">
            <h3>Quên mật khẩu</h3>
            <form>
                <label>Nhập địa chỉ email của bạn</label><br>
                <input placeholder="Nhập địa chỉ email của bạn"><br>
                <label>Nhập địa chỉ email bạn đã sử dụng khi đăng ký với trang web của chúng tôi</label><br>
                <button type="submit">Nhận mật khẩu mới</button>
                <button type="submit">Đăng nhập</button>
            </form>
        </div>
    </div>
@endsection