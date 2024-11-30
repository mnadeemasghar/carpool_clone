<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Referral') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-lg sm:rounded-lg">
                <div class="grid grid-cols-1 gap-6 p-6">
                    
                    <div class="text-gray-700">
                        
                        <div class="mb-4">
                            <strong>The top 10 users with the most referrals each month will receive PKR 1000</strong>
                            <p>Payments will be made monthly based on verified user signups</p>
                            <p>Share your referral link below with others to increase your chances of being one of the top referrers and earn rewards for successful signups</p>
                        </div>
                        
                        <div class="mb-4">
                            <div class="ml-5 mt-2">
                                <div>{{ route('register',['referred_by' => auth()->user()->id]) }}</div>
                            </div>
                        </div>


                    </div>

                    @if (isset($referrals) && $referrals->count() > 0)
                    
                    <div class="text-gray-700">
                        
                        <div class="mb-4">
                            <strong>Your refferal(s): ( {{ $referrals->count() }} )</strong>
                        </div>
                        
                        <div class="mb-4">
                            <div class="ml-5 mt-2">

                                @foreach ($referrals as $referral)
                                    <div>
                                        {{ $referral->name }} ( {{ $referral->phone }} ) - {{ $referral->email }} - 
                                        @if ($referral->email_verified_at !== null)
                                        <span class="mb-1 text text-success">{{ __("Verified") }}</span>
                                        @else
                                        <span class="mb-1 text text-danger">{{ __("Not Verified") }}</span>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        </div>

                    </div>

                    @endif

                    @if (isset($leaders) && $leaders->count() > 0)

                    <div class="text-gray-700">
                        <div class="mb-4">
                            <strong>Leader Board</strong>
                        </div>
                        <div class="mb-4">
                            <table class="table table-responsive">
                                <thead>
                                    <th>{{ __('No') }}</th>
                                    <th>{{ __('Name') }}</th>
                                    <th>{{ __('Referral Count') }}</th>
                                </thead>

                                <tbody>
                                    @php
                                        $count = 1;
                                    @endphp
                                    @foreach ($leaders as $leader)
                                    <tr class="{{ auth()->user()->id == $leader->id ? 'table-primary' : '' }}">
                                        <td>{{ $count++ }}</td>
                                        <td>{{ $leader->name }}</td>
                                        <td>{{ $leader->refer_count }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                    @endif
                </div>
            </div>
        </div>
    </div>

</x-app-layout>
