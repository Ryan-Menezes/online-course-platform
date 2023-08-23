<x-guest-layout>
    <x-authentication-card>
        <x-slot name="logo">
            <x-authentication-card-logo />
        </x-slot>

        <x-validation-errors class="mb-4" />

        <form method="POST" action="{{ route('password.update') }}">
            @csrf

            <input type="hidden" name="token" value="{{ $request->route('token') }}">

            <div class="mb-4">
                <x-input icon="mail" label="Email" id="email" type="email" name="email" :value="old('email', $request->email)" required autofocus autocomplete="username" />
            </div>

            <div class="mb-4">
                <x-inputs.password icon="lock-closed" label="Password" id="password" type="password" name="password" required autocomplete="new-password" />
            </div>

            <div class="mb-6">
                <x-inputs.password icon="lock-closed" label="Confirm Password" id="password_confirmation" type="password_confirmation" name="password_confirmation" required autocomplete="new-password" />
            </div>

            <div class="flex items-center justify-end mt-4">
                <x-button type="submit" label="Reset Password" rounded primary />
            </div>
        </form>
    </x-authentication-card>
</x-guest-layout>
