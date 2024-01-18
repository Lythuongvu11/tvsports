<div style="width: 600px;margin: 0 auto">
    <div style="text-align: center">
        <h2>Xin chào {{$user->name}}</h2>
        <p>Bạn đã yêu cầu đặt lại mật khẩu tại hệ thống của chúng tôi</p>
        <p>Vui lòng nhấn vào link bên dưới để đặt lại mật khẩu </p>
        <p>Chú ý mã xác nhận trong link chỉ có hiệu lực trong 24h</p>
        <p>
            <a href="{{route('user.getPassword',['user'=>$user->id,'token'=> $user->token])}}">Nhấn vào đây để đặt lại mật khẩu</a>
        </p>
    </div>
</div>
