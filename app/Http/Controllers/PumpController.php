<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PhpMqtt\Client\MqttClient;
use PhpMqtt\Client\ConnectionSettings;

class PumpController extends Controller
{
    // Halaman utama panel kontrol
    public function index()
    {
        $settings = session('settings', [
            'control_mode' => 'auto',
            'manual_pump_refill' => 0,
        ]);

        return view('control', compact('settings'));
    }

    // Simpan mode auto/manual + refill flag (tanpa MQTT)
    public function saveSettings(Request $request)
    {
        $settings = session('settings', []);

        $settings['control_mode'] = $request->input('control_mode', 'auto');
        $settings['manual_pump_refill'] = $request->input('manual_pump_refill', 0);

        session(['settings' => $settings]);

        return back()->with('success', 'System mode updated.');
    }

    // Kirim MQTT ke ESP32 untuk kontrol pompa
    public function controlPump(Request $request)
    {
        $pump  = $request->input('pump');   // pumpA / pumpB / refill
        $state = $request->input('state');  // ON / OFF

        // Konfigurasi sesuai dengan ESP32 / HiveMQ
        $server   = 'c19cb715626944f6991e5ad93c7c93f2.s1.eu.hivemq.cloud';
        $port     = 8883;
        $clientId = 'laravel-panel-' . uniqid();

        $username = 'dendi';
        $password = 'Dendi123';

        $connectionSettings = (new ConnectionSettings)
            ->setUsername($username)
            ->setPassword($password)
            ->setUseTls(true)
            ->setTlsSelfSignedAllowed(true)
            ->setTlsVerifyPeer(false); // sama seperti espClient.setInsecure();

        $mqtt = new MqttClient($server, $port, $clientId);

        try {
            $mqtt->connect($connectionSettings, true);

            // publish ke topik sesuai ESP32
            $topic = "hydro/sistem1/control/{$pump}";
            $mqtt->publish($topic, $state, 0);

            $mqtt->disconnect();

            return back()->with('success', "Pump {$pump} set to {$state}");
        } catch (\Throwable $e) {
            return back()->with('success', 'Gagal kirim MQTT: ' . $e->getMessage());
        }
    }
}
