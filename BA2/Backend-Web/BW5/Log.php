<?php

class Log {

    private const TYPES = array(
        "S" => "Success",
        "E" => "Error",
    );
    private DateTime $date;
    private int $time;
    private string $username;
    private string $ip;
    private string $type;

    public function __construct(string $username, string $ip, string $type) {
        $this->date = new DateTime();
        $this->time = $this->date->getTimestamp();
        $this->username = $username;
        $this->ip = $ip;
        $this->type = self::TYPES[$type];
    }

    public function print(): string {
        $s = date_format($this->date, 'Y/m/d-H:i:s');
        $msg = $this->type == "Success" ? "logged in successfully" : " failed to log in";
        return "[$s] - $this->type - User '$this->username' $msg";
    }

    public function logToFile() {
        $file = fopen(__DIR__ . "/loginaudit.txt", "a");
        if (!$file) {
            printf("Failed to open file");
            return;
        }
        fwrite($file, $this->print() . "\n");
        fwrite($file, serialize($this) . "\n");
        fclose($file);
    }

    public static function showLog(): string {
        $file = fopen(__DIR__ . "/loginaudit.txt", "r");
        if (!$file) {
            return "No log file found";
        }
        $log = "";
        while (!feof($file)) {
            $log .= fgets($file) . "<br>";
        }
        fclose($file);
        return $log;
    }


}