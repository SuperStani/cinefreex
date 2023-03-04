<?php

namespace superbot\App\Services;

use superbot\App\Storage\DB;
use superbot\Telegram\Client;
use superbot\App\Configs\Interfaces\GeneralConfigs;

class BroadcastService
{
    private $id;
    private $message;
    private $keyboard;
    private $target;
    private $cacheService;
    private $conn;
    private $bot_token;
    public function __construct(
        CacheService $cacheService,
        DB $conn
    ) {
        $this->cacheService = $cacheService;
        $this->conn = $conn;
    }

    public function init($message, $process_id, $query, $token = null)
    {
        if($message == 'start') {
            $message = str_replace("{MENTION}", "su Netfluz", $this->cacheService->getStartMessage());
            $menu[] = [["text" => '🍿 GUARDA SERIE / FILM 🍿', "web_app" => ["url" => GeneralConfigs::WEBAPP_URI. "/home"]]];
            $menu[] = [["text" => "🔎 RICERCA", "callback_data" => "Search:home|0"], ["text" => "🔝 CLASSIFICA", "web_app" => ["url" => GeneralConfigs::WEBAPP_URI. "/leadership"]]];
            $menu[] = [["text" => "➖➖➖➖➖➖➖➖", "callback_data" => "Home:null"]];
            $menu[] = [["text" => '✉️ RICHIESTE', "callback_data" => 'Home:request'], ["text" => "🗣 PROFILO", "callback_data" => "Profile:me|0"]];
            $menu[] = [["text" => "📝 TUTORIAL", "url" => "https://t.me/+FjXzQx6eStFhMDI8"], ["text" => '⛑️ STAFF ', "url" => "t.me/NetfluzSegnalazioniBOT"]];
            $this->keyboard["inline_keyboard"] = $menu;
        }
        $this->message = $message;
        $this->id = $process_id;
        $this->target = $this->conn->rqueryAll($query);
        $this->bot_token = $token;
    }

    public function run(): void
    {
        foreach($this->target as $process => $user) {
            $startTime = microtime(true);
            Client::sendMessage($user->id, $this->message, 'Markdown', null, null, null, null, null, null, $this->keyboard ?? null, $this->bot_token);
            //$this->cacheService->incrBroadcastUsersCounter($this->id);
            self::speedControl($startTime, 1);
        }
        Client::sendMessage(170172016, "Broadcast terminato", 'Markdown', null, null, null, null, null, null, $this->keyboard ?? null, $this->bot_token);
        self::shutdown($this->id);
    }

    public static function shutdown($id): void
    {
        shell_exec("sudo kill $id");
    }

    private function speedControl($start_process, $iterations_per_seconds)
    {
        $stop_process = microtime(true);

        $usleep = (1000000 - $iterations_per_seconds * (($stop_process - $start_process) * 1000000)) / $iterations_per_seconds;
        $usleep = ($usleep > 0 ? $usleep : 0);
        usleep($usleep);

        return $usleep;
    }

    public static function getStats($id) {

    }
}
