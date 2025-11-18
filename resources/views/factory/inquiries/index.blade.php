<x-layout :title="__('Inquiries')">
    <h1 class="text-2xl font-semibold mb-4">
        {{ __('Inquiries') }}
    </h1>

    @if (session('status') === 'inquiry_status_updated')
        <div class="mb-4 rounded-md bg-green-50 p-4 text-sm text-green-700">
            {{ __('Inquiry status updated.') }}
        </div>
    @endif

    <form method="GET" class="mb-4 flex flex-wrap gap-4 items-end text-sm">
        <div>
            <x-input-label for="status" :value="__('Status')" />
            <select id="status" name="status"
                class="mt-1 block w-full rounded-md border-gray-300 text-sm">
                <option value="">
                    {{ __('All') }}
                </option>
                <option value="new" @selected(request('status') === 'new')>{{ __('New') }}</option>
                <option value="in_review" @selected(request('status') === 'in_review')>{{ __('In review') }}</option>
                <option value="closed" @selected(request('status') === 'closed')>{{ __('Closed') }}</option>
            </select>
        </div>

        <div class="mt-6">
            <x-primary-button>
                {{ __('Filter') }}
            </x-primary-button>
        </div>
    </form>

    <div class="space-y-3">
        @forelse ($inquiries as $inquiry)
            <div class="rounded-md border bg-white p-3 text-sm flex justify-between items-start gap-4">
                <div>
                    <div class="font-semibold">
                        {{ $inquiry->buyer_name ?? __('Unknown buyer') }}
                    </div>
                    @if ($inquiry->product)
                        <div class="text-xs text-gray-500">
                            {{ $inquiry->product->name }}
                        </div>
                    @endif
                    <div class="text-xs text-gray-500 mt-1">
                        {{ $inquiry->buyer_email ?? '' }}
                        @if ($inquiry->buyer_phone)
                            · {{ $inquiry->buyer_phone }}
                        @endif
                    </div>
                    @if ($inquiry->message)
                        <div class="text-xs text-gray-600 mt-1">
                            {{ \Illuminate\Support\Str::limit($inquiry->message, 160) }}
                        </div>
                    @endif
                    <div class="text-[11px] text-gray-500 mt-1">
                        {{ __('Source') }}: {{ $inquiry->source }} ·
                        {{ __('Quantity') }}: {{ $inquiry->quantity ?? '-' }}
                    </div>
                </div>
                <div class="text-xs text-gray-600 text-right space-y-2">
                    <span
                        class="inline-flex items-center rounded-full px-2 py-0.5 text-[11px] font-medium
                        @class([
                            'bg-yellow-50 text-yellow-700' => $inquiry->status === 'new',
                            'bg-blue-50 text-blue-700' => $inquiry->status === 'in_review',
                            'bg-gray-100 text-gray-700' => $inquiry->status === 'closed',
                        ])">
                        {{ $inquiry->status }}
                    </span>

                    <form method="POST" action="{{ route('factory.inquiries.update-status', $inquiry->id) }}"
                        class="space-y-1">
                        @csrf
                        @method('PUT')
                        <select name="status"
                            class="block w-full rounded-md border-gray-300 text-[11px]">
                            <option value="new" @selected($inquiry->status === 'new')>{{ __('New') }}</option>
                            <option value="in_review" @selected($inquiry->status === 'in_review')>{{ __('In review') }}
                            </option>
                            <option value="closed" @selected($inquiry->status === 'closed')>{{ __('Closed') }}</option>
                        </select>
                        <x-primary-button>
                            {{ __('Update') }}
                        </x-primary-button>
                    </form>
                </div>
            </div>
        @empty
            <p class="text-sm text-gray-600">
                {{ __('No inquiries yet.') }}
            </p>
        @endforelse
    </div>

    @if ($inquiries instanceof \Illuminate\Contracts\Pagination\Paginator)
        <div class="mt-4">
            {{ $inquiries->withQueryString()->links() }}
        </div>
    @endif
</x-layout>

