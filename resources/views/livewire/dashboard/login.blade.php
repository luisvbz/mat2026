<div class="container-login-panel">
    <div class="container-form">
        <div class="container-form-logo">
           <img src="{{ asset('images/logo.png') }}">
        </div>
        <div class="container-form-fields">
            <form wire:submit.prevent="submitForm">
                <div class="field">
                    <label class="label has-text-centered has-text-weight-bold is-size-4"><i class="fal fa-university"></i> Matr&iacute;cula 2026</label>
                </div>
                <div class="field">
                    <label class="label"><i class="fal fa-envelope"></i> Usuario</label>
                    <div class="control">
                        <input type="text" wire:model.debounce.500ms="username" class="input input-login @error('username') is-danger @enderror">
                        @error('username')
                        <p class="has-text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                <div class="field">
                    <label class="label"><i class="fal fa-lock"></i> Contraseña</label>
                    <div class="control">
                        <input type="password"  wire:model.debounce.500ms="password"  class="input input-login @error('password') is-danger @enderror">
                        @error('password')
                        <p class="has-text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                @error('credentials')
                <div class="notification is-danger">
                    {{ $message }}
                </div>
                @enderror
                <div class="field">
                    <button type="submit" class="button button-login is-primary is-fullwidth">Entrar</button>
                </div>
            </form>
        </div>
    </div>
</div>
