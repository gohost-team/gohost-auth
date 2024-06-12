<x-gohost-auth::layout.app>
  <div class="nc-PageLogin">
    <div class="container mb-24 lg:mb-32 my-20 space-y-6 ring-1 ring-gray-950/5 sm:max-w-lg sm:rounded-xl sm:px-12 sm:px-16 sm:py-16">
      <a href="{{env('APP_URL')}}" class="justify-center"  aria-label="Brand">
        <img src="/images/logo.png" class="h-14 mx-auto"/>
      </a>
      <h2 class="flex items-center text-2xl leading-[115%] md:text-3xl md:leading-[115%] font-semibold text-neutral-900 justify-center">
        Kích hoạt tài khoản
      </h2>
      <div class="max-w-md mx-auto space-y-6 text-center">
        <span>Vui lòng đặt mật khẩu để kích hoạt tài khoản</span>
      </div>

      <div>
        <form class="grid grid-cols-1 gap-4" method="post" action="{{route('auth.do_active_account', ['token' => $token])}}">

          @csrf
          @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
              {{-- @foreach ($errors->all() as $error) --}}
              <span class="block sm:inline">{{ $errors->all()[0] }}</span></br/>
              {{-- @endforeach --}}
            </div>
          @endif

          <label class="block">
            <label
                class="nc-Label text-sm font-medium text-neutral-700 after:content-['*'] after:ml-0.5 after:text-red-500 ">Mật khẩu</label>
            <input
                class="block w-full border-neutral-200 focus:border-primary-300 focus:ring focus:ring-primary-200 focus:ring-opacity-50 bg-white rounded-2xl text-sm font-normal h-11 px-4 py-3 mt-1"
                placeholder="password"
                name="password"
                type="password" required>
          </label>
          <label class="block">
            <label
                class="nc-Label text-sm font-medium text-neutral-700 after:content-['*'] after:ml-0.5 after:text-red-500 ">Xác nhận mật khẩu</label>
            <input
                class="block w-full border-neutral-200 focus:border-primary-300 focus:ring focus:ring-primary-200 focus:ring-opacity-50 bg-white rounded-2xl text-sm font-normal h-11 px-4 py-3 mt-1"
                placeholder="password"
                name="password_confirmation"
                type="password" required>
          </label>
          <div class="flex space-x-2 pt-2">
            <button type="submit"
                    class="w-full px-22 inline-block rounded-full border-2 border-lp-red px-6 pb-[6px] pt-2 font-bold leading-normal text-white bg-lp-red transition duration-150 ease-in-out hover:bg-white hover:text-red-600 focus:bg-white focus:text-red-600"
                    wire:loading.attr="disabled"
                    wire:target="save"
                    data-te-ripple-init>
              Kích hoạt tài khoản
            </button>
          </div>
        </form>
      </div>

    </div>
  </div>
</x-gohost-auth::layout.app>  
