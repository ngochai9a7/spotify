

<?php include("includes/includedFiles.php"); ?>
<h1 class=" pageHeadingBig">You Might Also Like</h1>
<div class="gridviewContainer">
    <?php
        $albumQuery = mysqli_query($con, "SELECT * FROM albums ORDER BY RAND() LIMIT 10");
        while($row = mysqli_fetch_array($albumQuery)) {
            echo "<div class='gridVIewItem'>
            <span role='link' tabindex='0' onclick='openPage(\"album.php?id=".$row['id']."\")'>
                    <img src= '" . $row['artworkPath']."'>
                    <div class='gridViewInfo'>"
                        . $row['title'] .
                    "</div>
                </span>
                
            </div>";
        }
    ?>
</div>
<script>

let __protocol = document.location.protocol;
let __baseUrl = __protocol + '//livechat.fpt.ai/v35/src';

let prefixNameLiveChat = 'Music Chatbot';
let objPreDefineLiveChat = {
        appCode: '20ede8f55fc9a7e75bb95f09fa402996',
        themes: '',
        appName: prefixNameLiveChat ? prefixNameLiveChat : 'Live support',
        thumb: '',
        icon_bot: ''
    },
    appCodeHash = window.location.hash.substr(1);
if (appCodeHash.length == 32) {
    objPreDefineLiveChat.appCode = appCodeHash;
}

let fpt_ai_livechat_script = document.createElement('script');
fpt_ai_livechat_script.id = 'fpt_ai_livechat_script';
fpt_ai_livechat_script.src = __baseUrl + '/static/fptai-livechat.js';
document.body.appendChild(fpt_ai_livechat_script);

let fpt_ai_livechat_stylesheet = document.createElement('link');
fpt_ai_livechat_stylesheet.id = 'fpt_ai_livechat_script';
fpt_ai_livechat_stylesheet.rel = 'stylesheet';
fpt_ai_livechat_stylesheet.href = __baseUrl + '/static/fptai-livechat.css';
document.body.appendChild(fpt_ai_livechat_stylesheet);

fpt_ai_livechat_script.onload = function () {
    fpt_ai_render_chatbox(objPreDefineLiveChat, __baseUrl, 'livechat.fpt.ai:443');
}
</script>