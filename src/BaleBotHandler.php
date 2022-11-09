<?php

namespace TheCoder\MonologBale;

use GuzzleHttp\Client;
use Monolog\Handler\AbstractProcessingHandler;
use Monolog\Handler\HandlerInterface;
use Monolog\Logger;

class BaleBotHandler extends AbstractProcessingHandler implements HandlerInterface
{
    /**
     * bot api url
     * @var string
     */
    private $botApi;

    /**
     * Bale bot access token provided by BotFather.
     * Create bale bot with https://bale.me/BotFather and use access token from it.
     * @var string
     */
    private $token;

    /**
     * if bale is blocked in your region you can use proxy
     * @var null
     */
    private $proxy;

    /**
     * Bale channel name.
     * Since to start with '@' symbol as prefix.
     * @var string
     */
    private $chatId;

    /**
     * @param string $token Bale bot access token provided by BotFather
     * @param string $channel Bale channel name
     * @inheritDoc
     */
    public function __construct(string $token, string $chat_id, $level = Logger::DEBUG, bool $bubble = true, $bot_api = 'https://api.bale.org/bot', $proxy = null)
    {
        parent::__construct($level, $bubble);

        $this->token = $token;
        $this->botApi = $bot_api;
        $this->chatId = $chat_id;
        $this->level = $level;
        $this->bubble = $bubble;
        $this->proxy = $proxy;
    }

    /**
     * @inheritDoc
     */
    protected function write(array $record): void
    {
        $this->send($record['formatted']);
    }

    /**
     * Send request to @link https://api.bale.org/bot on SendMessage action.
     * @param string $message
     */
    protected function send(string $message, $option = []): void
    {
        try {
            if (!isset($option['verify'])) {
                $option['verify'] = false;
            }
            if (!is_null($this->proxy)) {
                $option['proxy'] = $this->proxy;
            }
            $option['timeout'] = 5;

            $httpClient = new Client($option);

            if (strpos($this->botApi, 'https://api.bale.org') === false) {
                $url = $this->botApi;
            } else {
                $url = $this->botApi . $this->token . '/SendMessage';
            }

            $options = [
                'form_params' => [
                    'text' => $message,
                    'chat_id' => $this->chatId,
                    'parse_mode' => 'html',
                    'disable_web_page_preview' => true,
                ]
            ];
            $response = $httpClient->post($url, $options);
        } catch (\Exception $e) {

        }
    }
}
