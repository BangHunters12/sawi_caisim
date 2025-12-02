@extends('layouts.app')

@section('content')
    @php
        // Biar aman kalau $settings belum ada
        $settings = $settings ?? [];
        $controlMode   = $settings['control_mode'] ?? 'auto';
        $manualRefill  = $settings['manual_pump_refill'] ?? 0;
    @endphp

    <div class="max-w-2xl mx-auto">
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">

            <div class="px-6 py-4 border-b border-gray-100">
                <h2 class="text-lg font-semibold text-gray-800">Manual Control</h2>
                <p class="text-sm text-gray-500">Override automatic settings & control pumps manually.</p>
            </div>

            <div class="p-6">
                @if(session('success'))
                    <div class="mb-6 p-4 bg-green-50 text-green-700 rounded-lg text-sm font-medium">
                        {{ session('success') }}
                    </div>
                @endif

                {{-- ============================
                     FORM MODE AUTO / MANUAL
                 ============================= --}}
                <form action="{{ route('control.save') }}" method="POST" class="space-y-8">
                    @csrf

                    <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg border border-gray-200">
                        <div>
                            <h3 class="font-medium text-gray-900">System Mode</h3>
                            <p class="text-sm text-gray-500">Automatic or manual pump control.</p>
                        </div>

                        <div class="flex items-center bg-white rounded-lg border border-gray-200 p-1">
                            {{-- Auto --}}
                            <label class="cursor-pointer">
                                <input type="radio"
                                       name="control_mode"
                                       value="auto"
                                       class="peer sr-only"
                                       {{ $controlMode === 'auto' ? 'checked' : '' }}
                                       onchange="toggleControls(false)">
                                <span class="px-4 py-2 rounded-md text-sm font-medium peer-checked:bg-emerald-100 peer-checked:text-emerald-700">
                                    Auto
                                </span>
                            </label>

                            {{-- Manual --}}
                            <label class="cursor-pointer">
                                <input type="radio"
                                       name="control_mode"
                                       value="manual"
                                       class="peer sr-only"
                                       {{ $controlMode === 'manual' ? 'checked' : '' }}
                                       onchange="toggleControls(true)">
                                <span class="px-4 py-2 rounded-md text-sm font-medium peer-checked:bg-emerald-100 peer-checked:text-emerald-700">
                                    Manual
                                </span>
                            </label>
                        </div>
                    </div>

                    {{-- Refill Pump --}}
                    <div id="refill-control"
                         class="flex items-center justify-between {{ $controlMode === 'auto' ? 'opacity-50 pointer-events-none' : '' }}">
                        <div class="flex items-center gap-3">
                            <div class="p-2 bg-emerald-100 text-emerald-600 rounded-lg">
                                💧
                            </div>
                            <div>
                                <h3 class="font-medium text-gray-900">Refill Pump</h3>
                                <p class="text-sm text-gray-500">Manual override for refill pump.</p>
                            </div>
                        </div>

                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="hidden" name="manual_pump_refill" value="0">
                            <input type="checkbox"
                                   name="manual_pump_refill"
                                   value="1"
                                   class="sr-only peer"
                                   {{ $manualRefill == 1 ? 'checked' : '' }}>
                            <div class="w-11 h-6 bg-gray-200 rounded-full peer-checked:bg-emerald-600
                                after:content-[''] after:absolute after:top-[2px] after:left-[2px]
                                after:h-5 after:w-5 after:bg-white after:rounded-full 
                                peer-checked:after:translate-x-full transition-all">
                            </div>
                        </label>
                    </div>

                    <button class="px-4 py-2 bg-emerald-600 text-white rounded-lg">Save Mode</button>

                </form>

                {{-- ============================
                     AB MIX A / B BUTTON CONTROLS
                 ============================= --}}
                <div id="abmix-controls"
                     class="mt-8 space-y-6 {{ $controlMode === 'auto' ? 'opacity-50 pointer-events-none' : '' }}">

                    {{-- AB Mix A --}}
                    <div class="flex items-center justify-between p-4 border rounded-lg">
                        <div class="flex items-center gap-3">
                            <div class="p-2 bg-blue-100 text-blue-600 rounded-lg">A</div>
                            <div>
                                <h3 class="font-medium text-gray-900">AB Mix A</h3>
                                <p class="text-sm text-gray-500">ON for 4 seconds automatically.</p>
                            </div>
                        </div>

                        <div class="flex gap-2">
                            {{-- ON --}}
                            <form action="{{ route('pump.control') }}" method="POST">
                                @csrf
                                <input type="hidden" name="pump" value="pumpA">
                                <input type="hidden" name="state" value="ON">
                                <button class="px-3 py-1 bg-emerald-600 text-white rounded-md text-sm">ON</button>
                            </form>

                            {{-- OFF --}}
                            <form action="{{ route('pump.control') }}" method="POST">
                                @csrf
                                <input type="hidden" name="pump" value="pumpA">
                                <input type="hidden" name="state" value="OFF">
                                <button class="px-3 py-1 bg-gray-300 text-gray-700 rounded-md text-sm">OFF</button>
                            </form>
                        </div>
                    </div>

                    {{-- AB Mix B --}}
                    <div class="flex items-center justify-between p-4 border rounded-lg">
                        <div class="flex items-center gap-3">
                            <div class="p-2 bg-purple-100 text-purple-600 rounded-lg">B</div>
                            <div>
                                <h3 class="font-medium text-gray-900">AB Mix B</h3>
                                <p class="text-sm text-gray-500">ON for 4 seconds automatically.</p>
                            </div>
                        </div>

                        <div class="flex gap-2">
                            {{-- ON --}}
                            <form action="{{ route('pump.control') }}" method="POST">
                                @csrf
                                <input type="hidden" name="pump" value="pumpB">
                                <input type="hidden" name="state" value="ON">
                                <button class="px-3 py-1 bg-emerald-600 text-white rounded-md text-sm">ON</button>
                            </form>

                            {{-- OFF --}}
                            <form action="{{ route('pump.control') }}" method="POST">
                                @csrf
                                <input type="hidden" name="pump" value="pumpB">
                                <input type="hidden" name="state" value="OFF">
                                <button class="px-3 py-1 bg-gray-300 text-gray-700 rounded-md text-sm">OFF</button>
                            </form>
                        </div>
                    </div>

                </div>

            </div>
        </div>
    </div>

<script>
function toggleControls(enable) {
    const refill = document.getElementById('refill-control');
    const abmix  = document.getElementById('abmix-controls');

    if (enable) {
        refill.classList.remove('opacity-50', 'pointer-events-none');
        abmix.classList.remove('opacity-50', 'pointer-events-none');
    } else {
        refill.classList.add('opacity-50', 'pointer-events-none');
        abmix.classList.add('opacity-50', 'pointer-events-none');
    }
}
</script>
@endsection
