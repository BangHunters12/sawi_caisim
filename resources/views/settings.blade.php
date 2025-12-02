@extends('layouts.app')

@section('content')
    <div class="max-w-2xl mx-auto">
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100">
                <h2 class="text-lg font-semibold text-gray-800">Automation Settings</h2>
                <p class="text-sm text-gray-500">Configure thresholds for automatic pump control.</p>
            </div>
            
            <div class="p-6">
                @if(session('success'))
                    <div class="mb-6 p-4 bg-green-50 text-green-700 rounded-lg text-sm font-medium flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        {{ session('success') }}
                    </div>
                @endif

                <form action="{{ route('settings.update') }}" method="POST" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <!-- Soil Moisture Threshold -->
                    <div>
                        <label for="min_soil_moisture" class="block text-sm font-medium text-gray-700 mb-1">
                            Minimum Soil Moisture (%)
                        </label>
                        <div class="relative">
                            <input type="number" step="0.1" name="min_soil_moisture" id="min_soil_moisture" 
                                value="{{ old('min_soil_moisture', $settings['min_soil_moisture'] ?? 40) }}"
                                class="w-full rounded-lg border-gray-300 focus:border-emerald-500 focus:ring-emerald-500 shadow-sm pl-3 pr-12">
                            <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                <span class="text-gray-500 sm:text-sm">%</span>
                            </div>
                        </div>
                        <p class="mt-1 text-xs text-gray-500">Water pump turns ON if moisture is below this value.</p>
                        @error('min_soil_moisture')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- TDS Threshold -->
                    <div>
                        <label for="min_tds_value" class="block text-sm font-medium text-gray-700 mb-1">
                            Minimum TDS Value (ppm)
                        </label>
                        <div class="relative">
                            <input type="number" step="1" name="min_tds_value" id="min_tds_value" 
                                value="{{ old('min_tds_value', $settings['min_tds_value'] ?? 600) }}"
                                class="w-full rounded-lg border-gray-300 focus:border-emerald-500 focus:ring-emerald-500 shadow-sm pl-3 pr-12">
                            <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                <span class="text-gray-500 sm:text-sm">ppm</span>
                            </div>
                        </div>
                        <p class="mt-1 text-xs text-gray-500">Nutrient pump turns ON if TDS is below this value.</p>
                        @error('min_tds_value')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Water Level Threshold -->
                    <div>
                        <label for="min_water_level" class="block text-sm font-medium text-gray-700 mb-1">
                            Minimum Water Level (cm)
                        </label>
                        <div class="relative">
                            <input type="number" step="0.1" name="min_water_level" id="min_water_level" 
                                value="{{ old('min_water_level', $settings['min_water_level'] ?? 10) }}"
                                class="w-full rounded-lg border-gray-300 focus:border-emerald-500 focus:ring-emerald-500 shadow-sm pl-3 pr-12">
                            <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                <span class="text-gray-500 sm:text-sm">cm</span>
                            </div>
                        </div>
                        <p class="mt-1 text-xs text-gray-500">System safety cutoff. Pumps stop if water is below this level.</p>
                        @error('min_water_level')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="pt-4 border-t border-gray-100 flex justify-end">
                        <button type="submit" class="px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white font-medium rounded-lg shadow-sm transition-colors">
                            Save Settings
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
