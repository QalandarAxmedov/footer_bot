<?php
include 'lib/uz.telebot.php';
// uz.telebot from https://github.com/QalandarAxmedov
$token = "your-bot-token";
$updates = file_get_contents("php://input");
$db = ['name' => 'db-name', 'user' => 'db-user', 'pass' => 'db-pass'];
$bot = new uz_telebot($token, $updates, $db);
$admin = 354742944;
$bot_name = "@xfooterbot";
function str_replace_first($from, $to, $content)
{
    $from = '/'.preg_quote($from, '/').'/';

    return preg_replace($from, $to, $content, 1);
}
function str_replace_last($from,$to,$content){
   return substr_replace($content, $to, strrpos($content, $from), strlen($from));
}
 function addFooter_Text($message,$id=1){
    global $bot;
    $a="\n";
    
    $text=$a.$a._italic("Urganch Davlat Universiteti \"Yoshlar Ittifoqi\" boshlang'ich tashkilotining rasmiy sahifalariga obuna bo'ling:")."\n";
    $text.=_a("Telegram","https://t.me/joinchat/GFvaSesVX8BlODA6")
        ." | "._a("Instagram","https://instagram.com/UrDUYoshlarIttifoqi")
        ." | "._a("Facebook","https://facebook.com/UrDUYoshlarIttifoqi")
        ." | "._a("YouTube", "https://www.youtube.com/channel/UCC--XtnTXdFm2PRInmwG0Qg?sub_confirmation=1")
        ." | "._a("Twitter","https://twitter.com/UrDUYI")
        ." | "._a("OK-RU","https://ok.ru/UrDUYI")
        ." | "._a("Tumblr","https://UrDUYI.tumblr.com")." | "._a("Web sahifa","https://www.google.co.uz/search?q=urdu+yoshlar+ittifoqi");
    $new_text=trim($message->text);
    if (strpos($new_text," ")!==false){
        $new_text=str_replace_first(" ",_a(" ","https://t.me/joinchat/GFvaSesVX8BlODA6"),$new_text);
        if(substr_count($text, ' ')>=3){
            $new_text=str_replace_last(" ",_a(" ","https://t.me/UrDU_Yoshlar_Ittifoqi/".$message->message_id),$new_text);
        }
    }
    $new_text.=$text;
    $btn1=buttonUrl("👍🏻","https://facebook.com/UrDUYoshlarIttifoqi");
    $btn2=buttonUrl("🔈","https://instagram.com/UrDUYoshlarIttifoqi");
    $btn3=buttonUrl("🔔","https://www.youtube.com/channel/UCC--XtnTXdFm2PRInmwG0Qg?sub_confirmation=1");
    $bnt4=buttonUrl("🌐","https://www.google.co.uz/search?q=urdu+yoshlar+ittifoqi");
    $btn5=buttonUrl("➕","https://t.me/joinchat/GFvaSesVX8BlODA6");
    $btn6=buttonUrl("🔁","https://telegram.me/share/url?url=@UrDU_Yoshlar_Ittifoqi&text=https://t.me/UrDU_Yoshlar_Ittifoqi/".$message->message_id);
    $rows=buttonRows([$btn5,$btn2,$btn1,$btn3,$bnt4,$btn6]);
    $key=inlineButton([$rows]);
    $id=($id==1)?$message->message_id:$id;
    $bot->editmessage(
        $message->chat->id,
        $id,
        $new_text,
        $key
    );
}
function addFooter_Caption($message,$id=1){
    global $bot;
    $a="\n";
    
    $text=$a.$a._italic("Urganch Davlat Universiteti \"Yoshlar Ittifoqi\" boshlang'ich tashkilotining rasmiy sahifalariga obuna bo'ling:")."\n";
    $text.=_a("Telegram","https://t.me/joinchat/GFvaSesVX8BlODA6")
        ." | "._a("Instagram","https://instagram.com/UrDUYoshlarIttifoqi")
        ." | "._a("Facebook","https://facebook.com/UrDUYoshlarIttifoqi")
        ." | "._a("YouTube", "https://www.youtube.com/channel/UCC--XtnTXdFm2PRInmwG0Qg?sub_confirmation=1")
        ." | "._a("Twitter","https://twitter.com/UrDUYI")
        ." | "._a("OK-RU","https://ok.ru/UrDUYI")
        ." | "._a("Tumblr","https://UrDUYI.tumblr.com")
        ." | "._a("Web sahifa","https://www.google.co.uz/search?q=urdu+yoshlar+ittifoqi");
    $new_text=trim($message->caption);
    $new_text.=$text;
    $btn1=buttonUrl("👍🏻","https://facebook.com/UrDUYoshlarIttifoqi");
    $btn2=buttonUrl("🔈","https://instagram.com/UrDUYoshlarIttifoqi");
    $btn3=buttonUrl("🔔","https://www.youtube.com/channel/UCC--XtnTXdFm2PRInmwG0Qg?sub_confirmation=1");
    $bnt4=buttonUrl("🌐","https://www.google.co.uz/search?q=urdu+yoshlar+ittifoqi");
    $btn5=buttonUrl("➕","https://t.me/joinchat/GFvaSesVX8BlODA6");
    $btn6=buttonUrl("🔁","https://telegram.me/share/url?url=@UrDU_Yoshlar_Ittifoqi&text=https://t.me/UrDU_Yoshlar_Ittifoqi/".$message->message_id);
    $rows=buttonRows([$btn5,$btn2,$btn1,$btn3,$bnt4,$btn6]);
    $key=inlineButton([$rows]);
    $id=($id==1)?$message->message_id:$id;
    if($message->media_group_id){
        $bot->GET_ROW("SELECT * FROM xfooter WHERE media_group_id=?",[$message->media_group_id]);
        if(intval($bot->result)<1){
            $bot->QUERY(
                "INSERT INTO xfooter(media_group_id) VALUES(?)",
                [$message->media_group_id]
            );
            $bot->QUERY(
                "DELETE FROM xfooter WHERE media_group_id!=?",
                [$message->media_group_id]
            );
            $bot->editMessageCaption(
                $message->chat->id,
                $id,
                $new_text,
                $key
            );
        }
    }else{
        $bot->editMessageCaption(
            $message->chat->id,
            $id,
            $new_text,
            $key
        );
    }
    
}
if(!is_null($bot->channel_post)){
    if($bot->channel_post->forward_from_chat || $bot->channel_post->forward_from){
        $bot->copymessage(
            $bot->channel_post->chat->id,
            $bot->channel_post->chat->id,
            $bot->channel_post->message_id
        );
        $bot->deletemessage($bot->channel_post->chat->id,$bot->channel_post->message_id);
        if($bot->channel_post->photo || $bot->channel_post->document || $bot->channel_post->audio || $bot->channel_post->video){
            addFooter_Caption($bot->channel_post,$bot->channel_post->message_id+1);
        }
        addFooter_Text($bot->channel_post,$bot->channel_post->message_id+1);
    }
    if($bot->channel_post->photo || $bot->channel_post->document || $bot->channel_post->audio || $bot->channel_post->video){
        addFooter_Caption($bot->channel_post);
    }
    else{
        addFooter_Text($bot->channel_post);
    }
    
}
 


