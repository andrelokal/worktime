<?php
class Emogi
{
    
    private static function linkEmoticon($emoticon, $word)
    {
        return("<img src='images/".$emoticon.".png' word='".$word."' />");
    }
    
    public function getEmogi($post)
    {
        $links = array(":)", 
                       ":D", 
                       "(A)", 
                       "lalala", 
                       "(!)", 
                       "(t+)", 
                       ":S", 
                       "(Y)", 
                       "(N)", 
                       "zzz", 
                       ":P", 
                       "8D", 
                       "o0", 
                       "(palmas)", 
                       ":@", 
                       "(ran)", 
                       "(yeah)", 
                       "_|_", 
                       ";(",
                       "kkk",
                       "(dah)",
                       ":(", 
                       ":|",
                       "*_*",
                       "(rage)",
                       "s2",
                       "(heart_eyes)",
                       "(kissing_heart)",
                       "(pensive)",
                       "(flushed)");
        $emoticons = array("smile", 
                           "smiley", 
                           "innocent", 
                           "kissing", 
                           "scream", 
                           "kissing_face", 
                           "confounded", 
                           "+1", 
                           "-1", 
                           "sleeping", 
                           "stuck_out_tongue", 
                           "grimacing", 
                           "scream", 
                           "clap", 
                           "angry", 
                           "triumph", 
                           "stuck_out_tongue_winking_eye",
                           "fu",
                           "sob",
                           "joy",
                           "sleepy",
                           "disappointed",
                           "no_mouth",
                           "astonished",
                           "rage",
                           "heart",
                           "heart_eyes",
                           "kissing_heart",
                           "pensive",
                           "flushed"
                           );
        $post = nl2br($post);
        for($i = 0; $i < count($emoticons); $i++)
        {
            $post = str_replace($links[$i], self::linkEmoticon($emoticons[$i],$links[$i] ), $post);
        }
        return($post);
    }
    
}
?>
