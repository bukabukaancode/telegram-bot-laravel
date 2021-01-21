<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Telegram;
use Telegram\Bot\FileUpload\InputFile;
use App\Message;

class BotController extends Controller
{
    public function getMe()
    {
        $response = Telegram::getMe();

        return $response;
    }

    public function getUpdate()
    {
        $response = Telegram::getUpdates();

        foreach ($response as $key => $value) {
            Message::firstOrCreate(
            ['updated_id' => $value->update_id],
            [
                'payload' => $value->message,
                'replied' => false
            ]);
        }
        
        return $response;
    }

    public function replyMessage()
    {
        $messages = Message::where('replied', 0)->get();

        if (count($messages) > 0) {
            foreach ($messages as $message) {
                $payload = collect(json_decode($message->payload));
                $message_to_send = $this->generateMessage($payload);

                if($message_to_send != ''){
                    Telegram::sendMessage([
                        'chat_id' => $payload['chat']->id, 
                        'text' => $message_to_send
                    ]);
                    
                    // Telegram::sendPhoto([
                    //     'chat_id' => $payload['chat']->id, 
                    //     'photo' => InputFile::create('https://thehearingheroes.com/wp-content/uploads/2019/02/female-avatar-profile-icon-round-woman-face-vector-18307274.jpg', public_path('/uploads')), 
                    //     'caption' => 'Some caption'
                    // ]);
                } else {
                    $response = 'no message';
                }

                $message->update(['replied'=>1]);
            }
        }
    }

    public function generateMessage($payload)
    {
        $text = $payload['text'];
        $username = $payload['from']->username;
        
        switch($text){
            case '/start':
                $message_to_send = 'ayo kita mulai ngobrol';
                break;

            case '/?':
                $message_to_send = 'mang ngapa?';
                break;

            default:
                $message_to_send = '';
                break;
        }

        return $message_to_send;
    }
}
