<x-gohost-auth::layout.app>  
  <div class="nc-PageLogin">
    <div class="container mb-24 lg:mb-32 my-20 space-y-6 ring-1 ring-gray-950/5 sm:max-w-lg sm:rounded-xl sm:px-12 sm:px-16 sm:py-16">
      <a href="{{env('APP_URL')}}" class="justify-center"  aria-label="Brand">
        <img src="/images/logo.png" class="h-14 mx-auto"/>
      </a>
      <h2 class="flex items-center text-2xl leading-[115%] md:text-3xl md:leading-[115%] font-semibold text-neutral-900 justify-center">
        Đăng nhập
      </h2>
      
      <div>
        <form class="grid grid-cols-1 gap-4" method="POST" action="{{ route('auth.authenticate') }}">
          @csrf
          @if ($errors->has('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
              <span class="block sm:inline">{{ $errors->first('error') }}</span>
            </div>
          @endif

          <label class="block">          
            <label
              class="nc-Label text-sm font-medium text-neutral-700 after:content-['*'] after:ml-0.5 after:text-red-500 ">
              Địa chỉ email
            </label>
            <input
              class="block w-full border-neutral-200 focus:border-primary-300 focus:ring focus:ring-primary-200 focus:ring-opacity-50 bg-white rounded-2xl text-sm font-normal h-11 px-4 py-3 mt-1"
              placeholder="email"
              name="email"
              type="email" required>
          </label>
          <label class="block">
            <label
              class="nc-Label text-sm font-medium text-neutral-700 after:content-['*'] after:ml-0.5 after:text-red-500 ">
              Mật khẩu
            </label>
            <input
              class="block w-full border-neutral-200 focus:border-primary-300 focus:ring focus:ring-primary-200 focus:ring-opacity-50 bg-white rounded-2xl text-sm font-normal h-11 px-4 py-3 mt-1"
              placeholder="password"
              name="password"
              type="password" required>
          </label>          
          <div class="flex space-x-2 pt-2 cursor-pointer hover:cursor-pointer">
            <button type="submit" class="w-full px-22 inline-block rounded-full border-2 border-lp-red px-6 pb-[6px] pt-2 font-bold leading-normal text-white bg-lp-red transition duration-150 ease-in-out hover:bg-white hover:text-red-600 focus:bg-white focus:text-red-600">Đăng nhập</button>
              
          </div>
          <div class="space-x-2 pt-2">
            <p class="text-center">
              <a href="{{route('auth.reset_password')}}" class="ms-2 text-sm font-sans text-sky-500 dark:text-sky-500 hover:underline" >
                Bạn quên mật khẩu? Bấm vào đây để lấy lại mật khẩu!
              </a>
            </p>
          </div>
        </form>
      </div>

    </div>
  </div>
</x-gohost-auth::layout.app>