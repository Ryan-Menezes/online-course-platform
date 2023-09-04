<div>
    <div
        x-data="{ isUploading: false, styles: { width: '0%' } }"
        x-on:livewire-upload-start="isUploading = true"
        x-on:livewire-upload-finish="isUploading = false"
        x-on:livewire-upload-error="isUploading = false"
        x-on:livewire-upload-progress="styles['width'] = $event.detail.progress + '%'"
    >
        <div x-show="!isUploading">
            {{ $slot }}
        </div>

        <div x-show="isUploading">
            <div class="w-full h-4 bg-gray-200 rounded-full dark:bg-gray-700">
                <div class="bg-blue-600 h-full text-xs font-medium text-blue-100 text-center p-0.5 leading-none rounded-full"  :style="styles" x-text="styles['width']"></div>
            </div>
        </div>
    </div>
</div>
