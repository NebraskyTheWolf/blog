<?php

namespace App\Lib;
use Httpful\Exception\ConnectionErrorException;
use Httpful\Request;

class BetterStackService
{
    private static string $openAIKey = 'sk-proj-nee8W6u3vMySGCkRgLmIT3BlbkFJ6HNTxjtqePuVumMNohYN';


    public static function fetchTags(string $text): ?array
    {
        $openAIUrl = 'https://api.openai.com/v1/completions';

        $data = [
            'prompt' => 'Extract keywords from the following article: "' . $text . '"',
            'model' => 'gpt-3.5-turbo-instruct',
            'temperature' => 0.7,
            'max_tokens' => 12
        ];

        $headers = [
            'Content-Type: application/json',
            'Authorization: Bearer ' . self::$openAIKey
        ];

        $response = self::sendRequest($openAIUrl, 'POST', $data, $headers);

        if ($response && $response['code'] == 200) {
            $parsedResponse = json_decode($response['body']);

            return array_map(function($choice) {
                return [
                    'name' => $choice->text,
                    'slug' => strtolower(str_replace(' ', '-', $choice->text))
                ];
            }, $parsedResponse->choices);
        }

        return [
            ['name' => 'Nebyly nastaveny žádné značky.', 'slug' => 'missingno']
        ];
    }
    /**
     * @throws ConnectionErrorException
     */
    public static function fetchRoles(string $userId, bool $needArray): string|array
    {
        $response = Request::get("https://api.fluffici.eu/api/users/roles/plucked?id=" . intval($userId))
            ->addHeaders([
                "Content-Type" => 'application/json',
                "Authorization" => "Bearer " . env('FLUFFICI_API_TOKEN')
            ])
            ->expectsJson()
            ->send();

        if ($response->code === 200) {
            $body = json_decode(json_encode($response->body), true);
            $data = $body['data'];

            if ($needArray) {
                return $data['lists'];
            } else {
                return $data['roles'];
            }
        } else {
            return $needArray ? [/*Empty fox uwu*/] : 'Guest';
        }
    }

    public static function pluck($array, $key): array
    {
        return array_map(function ($item) use ($key) {
            return $item[$key];
        }, $array);
    }


    // Function to extract discussion tags from text
    private static function extractTags($text): array {
        preg_match_all('/\b[A-Z][a-z]+\b/', $text, $matches);
        return $matches[0];
    }

    // Function to send HTTP request
    private static function sendRequest($url, $method, $data = null, $headers = []): array
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        if ($data) {
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        }

        if ($headers) {
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        }

        $response = curl_exec($ch);
        $statusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        return ['body' => $response, 'code' => $statusCode];
    }
}
