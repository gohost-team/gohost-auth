@props(['title'])

<mjml>
  <mj-head>
    <mj-title>{{$title}}</mj-title>
    <mj-font name="Roboto" href="https://fonts.googleapis.com/css?family=Roboto:400,700"></mj-font>
    <mj-attributes>
      <mj-all font-family="Roboto, Helvetica, Arial, sans-serif" padding="0px"></mj-all>
      <mj-text font-weight="400" font-size="16px" color="#222" line-height="21px"></mj-text>
    </mj-attributes>
  </mj-head>
  <mj-body background-color="#ffffff">

    {{ $slot }}    

    <mj-section>
      <mj-column>
            <mj-divider border-width="1px" border-style="solid" border-color="#C9CCCF" padding="10px 0px 10px 0px" ></mj-divider>
      </mj-column>
    </mj-section>

    <mj-section padding-top="20px">
      <mj-column width="14%" vertical-align="middle">
        <mj-image src="https://gohost.vn/images/logo.png" target="_blank" href="https://gohost.vn" ></mj-image>
      </mj-column>
      <mj-column width="86%">        
      </mj-column>
    </mj-section>   
    <mj-section padding="10px 0px 10px 0px">
      <mj-column>
        <mj-text font-size="13px">
          Hotline: {{ env('HOTLINE', '0935.322.272')}}<br/>
          Địa chỉ: {{ env('ADDRESS', '120 Võ Nguyên Giáp, Sơn Trà, Đà Nẵng')}}
        </mj-text>
      </mj-column>
    </mj-section>
    <mj-section padding="0px 0px 30px 0px">
      <mj-group>
          <mj-column vertical-align="middle" width="35px">
            <mj-image src="https://direct-booking.s3-ap-southeast-1.amazonaws.com/prod/assets/icon/facebook.png" target="_blank" href="https://www.facebook.com/gohost.vn" width="30px" height="30px"></mj-image>
          </mj-column>          
      </mj-group>
    </mj-section>
  </mj-body>
</mjml>