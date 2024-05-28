<x-gohost-auth::layout.app>
  <div class="nc-PageLogin">
    <div class="container mb-24 lg:mb-32 my-20 space-y-6 ring-1 ring-gray-950/5 sm:max-w-lg sm:rounded-xl sm:px-12 sm:px-16 sm:py-16">
      <a href="{{env('APP_URL')}}" class="justify-center"  aria-label="Brand">
        <img src="/images/logo.png" class="h-14 mx-auto"/>
      </a>
      <h2 class="flex items-center text-2xl leading-[115%] md:text-3xl md:leading-[115%] font-semibold text-neutral-900 justify-center">
        Thông tin đã được gởi!
      </h2>
        <div class="max-w-md mx-auto space-y-6 text-center">
          <span>
            Bạn có thể cập nhật lại mật khẩu bằng cách click vào link trong email.
            <br/><br/>
            Nếu không nhận được email, bạn có thể liên hệ với chúng tôi qua email hi@gohost.vn hoặc hotline: 0935.322.272
          </span>
        </div>
    </div>
  </div>
</x-gohost-auth::layout.app>
