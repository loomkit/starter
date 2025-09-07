<button type="button" hidden id="installBtn" class="pwa-install-btn opacity-0" style="display:none;">
    📲 @lang('Install :app', ['app' => config('app.name')])
</button>
<p id="iosInstallMsg" class="pwa-ios-msg" style="display:none;">
    @lang('To install :app on your home screen', [
        'app' => config('app.name')
    ]):
    <br>
    @lang('Tap :x then ":y"', [
        'x' => '<span class="ios-icon">📤</span>',
        'y' => __('Add to Home Screen')
    ])
</p>
