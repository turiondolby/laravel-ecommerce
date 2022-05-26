<div x-data="{ body: '' }"
     x-show="body.length"
     x-cloak
     @notification.window="body = $event.detail.body; setTimeout(() => body = '', $event.detail.timeout || 2 * 1000)"
     class="fixed inset-0 flex px-4 py-6 items-start pointer-events-none"
     x-init="
        @if (session()->has('notification'))
            window.onload = () => {
                window.dispatchEvent(new CustomEvent('notification', {
                    detail: {
                        body: '{{ session('notification') }}',
                        timeout: 3000
                    }
                }))
            }
        @endif
     "
>
    <div class="w-full flex flex-col items-center space-y-4">
        <div class="max-w-sm w-full bg-gray-900 rounded-lg pointer-events-auto">
            <div class="p-4 flex items-center">
                <div x-text="body" class="ml-2 w-0 flex-1 text-white"></div>
                <button @click="body = ''" class="inline-flex text-gray-400">
                    <span class="sr-only">Close</span>
                    <span class="text-2xl">&times;</span>
                </button>
            </div>
        </div>
    </div>
</div>
