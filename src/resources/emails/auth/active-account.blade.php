<x-gohost-auth::layout.email :title="$title">
  <mj-section padding="40px 0px 40px 0px">
    <mj-column width="100%">
      <mj-text font-size="30px" line-height="1.3">
        <strong>{{$title}}</strong>
      </mj-text>
      <mj-text padding-top="16px">
        Chào {{$user->name}}, <br/>
        Bạn được mời đăng nhập vào hệ thống GoHost. Vui lòng click vào bên dưới để kích hoạt.
      </mj-text>
    </mj-column>
    <mj-column width="200px" vertical-align="middle" padding-top="20px">
      <mj-button href="{{$activeUrl}}" target="_blank" font-family="Helvetica" background-color="#f45e43" color="white">
        Kích hoạt tài khoản
       </mj-button>
    </mj-column>
  </mj-section>
<x-gohost-auth::layout.email>