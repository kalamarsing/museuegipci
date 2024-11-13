<div class="section-container">
    <section class="bg-opacity-82 bg-primaryColor rounded-lg p-6">
        <header class="text-center">
            <p class="text-secondaryColor text-uppercase font-medium text-19 leading-25">
                {{get_dinamic_field_value('enter-code.text')}}
            </p>
        </header>

        <form method="post" action="{{ route('verify.code', ['locale' => App::getLocale()]) }}" class="mt-6 space-y-6">
            @csrf

            <div class="mt-6">
                <div class="flex items-center">
                    <x-text-input id="code" name="code" type="text" class="block w-full h-50 border-1 border-grayColor rounded-7" autocomplete="off" value="{{ old('code') }}" />
                </div>
                <x-input-error :messages="$errors->get('code')" class="mt-2" />

                <div class="flex justify-center mt-4">
                    <button type="submit" class="flex items-center justify-center border-2 border-secondaryColor rounded-7 text-19 leading-25 submit-code">
                        <div>{{get_dinamic_field_value('enter-code.btn.text')}}</div>
                    </button>
                </div>
            </div>
        </form>
    </section>
</div>