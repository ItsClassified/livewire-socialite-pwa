<div id="g_id_onload"  data-client_id="1091366472343-de1pvurdi6lipp6s2t65jcrcotr2vt57.apps.googleusercontent.com"  data-callback="GoogleSignInHandle" data-auto_prompt="true" wire:ignore>
</div>
<div wire:ignore class="g_id_signin w-full" data-type="standard" data-size="large" data-theme="outline" data-text="sign_in_with" data-shape="circular" data-logo_alignment="center" data-width="100%">
</div>
<script>
    function GoogleSignInHandle(response) {
        window.livewire.emit('loginWithGoogleOnSuccess', response);
    }
</script>
