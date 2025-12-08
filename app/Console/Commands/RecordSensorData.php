<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use PhpMqtt\Client\MqttClient;
use PhpMqtt\Client\ConnectionSettings;
use App\Models\Sensor;

class RecordSensorData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sensor:record';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetch sensor data from MQTT and save to database';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $server   = 'c19cb715626944f6991e5ad93c7c93f2.s1.eu.hivemq.cloud';
        $port     = 8883;
        $clientId = 'laravel-recorder-' . uniqid();
        $username = 'dendi';
        $password = 'Dendi123';

        $connectionSettings = (new ConnectionSettings)
            ->setUsername($username)
            ->setPassword($password)
            ->setUseTls(true)
            ->setTlsSelfSignedAllowed(true)
            ->setTlsVerifyPeer(false);

        $mqtt = new MqttClient($server, $port, $clientId);

        try {
            $this->info('Connecting to MQTT...');
            $mqtt->connect($connectionSettings, true);
            $this->info('Connected!');

            $topic = 'hydro/sistem1/data';
            
            $this->info("Subscribing to {$topic}...");

            $mqtt->subscribe($topic, function ($topic, $message) use ($mqtt) {
                $this->info("Received: {$message}");
                
                $data = json_decode($message, true);

                if ($data) {
                    Sensor::create([
                        'temperature'   => $data['temp'] ?? null,
                        'humidity'      => null, // ESP32 doesn't send humidity
                        'tds_value'     => $data['tds'] ?? null,
                        'ph'            => $data['ph'] ?? null,
                        'water_level'   => $data['dist'] ?? null, // dist maps to water_level
                        'pump_a_status' => $data['pA'] ?? 0,
                        'pump_b_status' => $data['pB'] ?? 0,
                        'refill_status' => $data['pR'] ?? 0,
                    ]);
                    
                    $this->info('Data saved to database.');
                } else {
                    $this->error('Invalid JSON.');
                }

                $mqtt->interrupt(); // Stop loop after one message
            }, 0);

            $mqtt->registerLoopEventHandler(function ($mqtt, $elapsedTime) {
                if ($elapsedTime > 10) { // Timeout after 10 seconds
                    $this->info('Timeout waiting for message.');
                    $mqtt->interrupt();
                }
            });

            $mqtt->loop(true);
            $mqtt->disconnect();

        } catch (\Exception $e) {
            $this->error('Error: ' . $e->getMessage());
        }
    }
}
