<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('Profile Information') }}
        </h2>
        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __("Update your account's profile information, email address, photo, and signature.") }}
        </p>
    </header>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6" enctype="multipart/form-data">
        @csrf
        @method('patch')

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" name="name" type="text" class="form-control" :value="old('name', $user->name)" required
                autofocus autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <!-- Email -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" name="email" type="email" class="form-control" :value="old('email', $user->email)" required
                autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />
            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && !$user->hasVerifiedEmail())
                <div>
                    <p class="text-sm mt-2 text-gray-800 dark:text-gray-200">
                        {{ __('Your email address is unverified.') }}
                        <button form="send-verification"
                            class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800">
                            {{ __('Click here to re-send the verification email.') }}
                        </button>
                    </p>
                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-medium text-sm text-green-600 dark:text-green-400">
                            {{ __('A new verification link has been sent to your email address.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <!-- Photo Upload -->
        <div>
            <x-input-label for="foto" :value="__('Profile Photo')" />
            <input id="foto" name="foto" type="file" class="form-control" accept="image/*" />
            <x-input-error class="mt-2" :messages="$errors->get('foto')" />
            @if ($user->foto)
                <div class="mt-2">
                    <img src="{{ asset('storage/' . $user->foto) }}" alt="Profile Photo" width="100">
                    <p class="text-sm text-gray-600 dark:text-gray-400">{{ __('Current photo') }}</p>
                </div>
            @endif
        </div>

        <!-- Signature Upload -->
        <div>
            <x-input-label for="sign" :value="__('Signature')" />
            <input id="sign" name="sign" type="file" class="form-control" accept="image/*" />
            <x-input-error class="mt-2" :messages="$errors->get('sign')" />
            @if ($user->sign)
                <div class="mt-2">
                    <img src="{{ asset('storage/' . $user->sign) }}" alt="Signature" width="100">
                    <p class="text-sm text-gray-600 dark:text-gray-400">{{ __('Current signature') }}</p>
                </div>
            @endif
        </div>

        <div class="flex items-center gap-4">
            <button class="btn btn-primary">{{ __('Save') }}</button>
            @if (session('status') === 'profile-updated')
                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600 dark:text-gray-400">{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
</section>