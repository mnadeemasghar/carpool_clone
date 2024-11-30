<div class="py-4">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div style="background-color: white; overflow: hidden; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); border-radius: 0.75rem;">
            <div style="padding: 1.5rem; border-bottom: 1px solid #e2e8f0; display: flex; align-items: center; gap: 1rem; transition: background-color 0.3s;">
                <div style="flex-shrink: 0; color: #3b82f6;">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="width: 2rem; height: 2rem;">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h18v6H3V3zM3 9h18v6H3V9zM3 15h18v6H3v-6z" />
                    </svg>
                </div>
                <div style="flex-grow: 1;">
                    <div style="color: #1f2937; font-size: 1.25rem; font-weight: 600;">
                        <span style="color: #2563eb;">Entry ID:</span> {{ $entry->id }}
                    </div>
                    <div style="color: #4b5563; margin-top: 0.25rem;">
                        <span>{{ $entry->type == 'dr' ? 'Debit' : 'Credit' }}</span> - 
                        <span style="color: #f59e0b; font-weight: 500;">{{ $entry->wallet->currency_symbol }}{{ number_format($entry->amount, 0) }}</span>
                    </div>
                    <div style="color: #6b7280; font-style: italic; margin-top: 0.25rem;">
                        {{ $entry->description }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
