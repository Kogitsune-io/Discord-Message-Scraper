<?php
namespace App\Controller;
use Symfony\Component\HttpClient\HttpClient; 
class DiscordScraper {

    /**
     * Obtain the messages from your Discord channels.
     * @todo
     * Requires account developer mode enabled
     * Requires each of your server channel ID's
     * Requires the creation of a discord bot 
     * Requires your discord bots token
     */
    public function getServerChannelMessages()
    { 
        // Categories
        $web = [
            // Channel / Channel ID
            'frontend' => '<< INT: CHANNEL ID >>',
            'backend' => '<< INT: CHANNEL ID >>',
        ];

        $api = [
            // Channel / Channel ID
            'cURL' => '<< INT: CHANNEL ID >>',
            'restful' => '<< INT: CHANNEL ID >>',
        ];

        // Combine arrays to form multi dimentional array
        $categories = [
            'web' => $web,
            'api' => $api,
        ];


        foreach ($categories as $category => $channel){            
            foreach ($channel as $title => $id){

                // Directory, File title and file format
                $directory = 'YourFolderName/'.$category.'_'.$title.'.json';

                // Makes sure the file doesn't already exist
                if(!file_exists($directory)){

                    $client = HttpClient::create();

                    // Gets the current channel ID's messages and attemts to authorize the bot
                    $response = $client->request('GET', "https://discordapp.com/api/channels/$id/messages", [
                        'headers' => [
                            'Authorization'  => 'Bot << STRING: DISCORD BOT TOKEN >>'
                        ]
                    ]);

                    // Get the response
                    // decodes then encodes to pretty format the json
                    // Add the data discovered to json file.
                    $json = $response->getContent();
                    $data = json_decode($json);
                    $encoded = json_encode($data, JSON_PRETTY_PRINT);
                    file_put_contents($directory,$encoded);

                }
            }            
        }
    }
}
