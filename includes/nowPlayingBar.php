<?php // Tao 10 bai nhac random
$songQuery = mysqli_query($con, "SELECT * from songs order by RAND() LIMIT 10 ");
$resultArray = array();
while ($row = mysqli_fetch_array($songQuery)) {
    array_push($resultArray, $row['id']);
}
$jsonArray = json_encode($resultArray);
?>

<script>
$(document).ready(function() { //Khi trang load xong
    var newPlaylist = <?php echo $jsonArray; ?> // Tao playlist 10 bai nhac random
   
    audioElement = new Audio(); // Tao object audio
    setTrack(newPlaylist[0], newPlaylist, false);
    updateVolumeProgressBar(audioElement.audio); // set volume

    $("#nowPlayingBarContainer").on("mousedown touchstart mousemove touchmove  ", function(e) {
        e.preventDefault();
    });

    $(".playbackBar .progressBar").mousedown(function() { // Tua
        mouseDown = true;
    });
    $(".playbackBar .progressBar").mousemove(function(e) {
        if(mouseDown == true) {
            //set time depend on mouse
            timeFromOffset(e, this);
        }
    });
    $(".playbackBar .progressBar").mouseup(function(e) {
        timeFromOffset(e, this);
    });

    $(".volumeBar .progressBar").mousedown(function() { // Volume
        mouseDown = true;
    });
    $(".volumeBar .progressBar").mousemove(function(e) {
        if(mouseDown == true) {
            var percentage = e.offsetX / $(this).width();
            if (percentage >= 0 && percentage <= 1) {
                audioElement.audio.volume = percentage;
            }
        }
    });
    $(".volumeBar .progressBar").mouseup(function(e) {
        
        var percentage = e.offsetX / $(this).width();
            if (percentage >= 0 && percentage <= 1) {
                audioElement.audio.volume = percentage;
            }
    });



    $(document).mouseup(function () {
        mouseDown = false;
    });

});

function timeFromOffset(mouse, progressBar) {
    var percentage = mouse.offsetX / $(".playbackBar .progressBar").width() * 100; // tinh phan tram
    var seconds = audioElement.audio.duration * (percentage / 100); // tinh so giay tai luc click
    audioElement.setTime(seconds);
}

function prevSong() {
    if (currentIndex == 0) {
        audioElement.setTime(0);
    }
    else {
        currentIndex--;
        setTrack(currentPlaylist[currentIndex], currentPlaylist, true);
    }

}


function nextSong() {
    if (repeat == true) {
        audioElement.setTime(0);
        playSong();
        return;
    }

    if (currentIndex == currentPlaylist.length - 1) { // Index o vi tri cuoi cung cua list nhac
        currentIndex = 0;
    }
    else {
        currentIndex++;
    }
    var trackToPlay = shuffle ? shufflePlaylist[currentIndex] : currentPlaylist[currentIndex];
    setTrack(trackToPlay, currentPlaylist, true);
}

function setRepeat() {
    repeat = !repeat;
    var imageName = repeat ? "repeat-active.png" : "repeat.png";
    $(".controlButton.repeat img").attr("src","assets/images/icons/" + imageName);

}

function setMute() {
    audioElement.audio.muted = !audioElement.audio.muted;
    var imageName = audioElement.audio.muted ? "volume-mute.png" : "volume.png";
    $(".controlButton.volume img").attr("src","assets/images/icons/" + imageName);
}
function setShuffle() {
	shuffle = !shuffle;
	var imageName = shuffle ? "shuffle-active.png" : "shuffle.png";
	$(".controlButton.shuffle img").attr("src", "assets/images/icons/" + imageName);

	if(shuffle == true) {
		//Randomize playlist
		shuffleArray(shufflePlaylist);
		currentIndex = shufflePlaylist.indexOf(audioElement.currentlyPlaying.id);
	}
	else {
		//shuffle has been deactivated
		//go back to regular playlist
		currentIndex = currentPlaylist.indexOf(audioElement.currentlyPlaying.id);
	}

}

function shuffleArray(a) {
    var j, x, i;
    for (i = a.length - 1; i > 0; i--) {
        j = Math.floor(Math.random() * (i + 1));
        x = a[i];
        a[i] = a[j];
        a[j] = x;
    }
    
}


////////////////////////////////////////////////////
////////////////////////////////////////////////////
////////////////////////////////////////////////////
function setTrack(trackId, newPlaylist, play) {

    if(newPlaylist != currentPlaylist) {
		currentPlaylist = newPlaylist;
		shufflePlaylist = currentPlaylist.slice();
		shuffleArray(shufflePlaylist);
	}

	if(shuffle == true) {
		currentIndex = shufflePlaylist.indexOf(trackId);
	}
	else {
		currentIndex = currentPlaylist.indexOf(trackId);
	}
	pauseSong();

    $.post("includes/handlers/ajax/getSongJson.php", {songId: trackId}, function(data) {   
        var track = JSON.parse(data); // Chuyen thanh doi tuong javascript + giong ten bang songs trong sql   
        $(".trackName span").text(track.title); // Lay ten bai

        $.post("includes/handlers/ajax/getArtistJson.php", {artistId: track.artist}, function(data) { // Lay ca si
            console.log(data);
            var artist = JSON.parse(data);
            console.log(artist);
            $(".trackInfo .artistName span").text(artist.name);
            $(".trackInfo .artistName span").attr("onclick", "openPage('artist.php?id=" + artist.id +"')");
        });

        $.post("includes/handlers/ajax/getAlbumJson.php", {albumId: track.album}, function(data) { // Lay anh bia
            var album = JSON.parse(data);
            $(".content .albumLink img").attr("src", album.artworkPath);
            $(".content .albumLink img").attr("onclick","openPage('album.php?id=" + album.id +"')");
            $(".content .albumLink span").attr("onclick", "openPage('album.php?id=" + album.id +"')");
            $(".trackInfo .trackName span").attr("onclick", "openPage('album.php?id=" + album.id +"')");

        });
        audioElement.setTrack(track);

        if(play) {
            playSong();
        }
        
    });

    
}

function playSong() {
    if(audioElement.audio.currentTime == 0) {
        $.post("includes/handlers/ajax/updatePlays.php", { songId : audioElement.currentlyPlaying.id})
        
    }

    $(".controlButton.play").hide();
    $(".controlButton.pause").show();
    audioElement.play();
}
function pauseSong() {
    $(".controlButton.pause").hide();
    $(".controlButton.play").show();
    audioElement.pause();
}


</script>


<div id="nowPlayingBarContainer">
    <div id="nowPlayingBar">
        <div id="nowPlayingLeft">
            <div class="content">
                <span class="albumLink">
					<img role="link" tabindex="0" src="" class="albumArtwork">
			    </span>

				<div class="trackInfo">

					<span class="trackName">
						<span role="link" tabindex="0"></span>
					</span>

					<span class="artistName">
						<span role="link" tabindex="0"></span>
					</span>

				</div>
            </div>


        </div> 

        <div id="nowPlayingCenter">
            <div class="content playerControls">
                <div class="buttons">
                    <button class="controlButton shuffle" title="Shuffle" onclick="setShuffle()"><img src="assets/images/icons/shuffle.png" alt="Shuffle"></button>
                    <button class="controlButton previous" title="Previous" onclick="prevSong()"><img src="assets/images/icons/previous.png" alt="Previous"></button>
                    <button class="controlButton play" title="Play" onclick="playSong()"><img src="assets/images/icons/play.png" alt="Play"></button>
                    <button class="controlButton pause" title="Pause" onclick="pauseSong()" style="display: none;"><img src="assets/images/icons/pause.png"  alt="Pause"></button>
                    <button class="controlButton next" title="Next" onclick="nextSong()"><img src="assets/images/icons/next.png" alt="Next"></button>
                    <button class="controlButton repeat" title="Repeat" onclick="setRepeat()"><img src="assets/images/icons/repeat.png" alt="Repeat"></button>
                </div>

                <div class="playbackBar">
                    <span class="progressTime current">0.00</span>
                    <div class="progressBar">
                        <div class="progressBarBg">
                            <div class="progress"></div>
                        </div>
                    </div>
                    <span class="progressTime remaining">0.00</span>


                </div>
            </div>

        </div>

        <div id="nowPlayingRight">
            <div class="volumeBar">
                <button class="controlButton volume" title="Volume Button" onclick="setMute()">
                    <img src="assets\images\icons\volume.png" alt="Volume">
                </button>
                <div class="progressBar">
                    <div class="progressBarBg">
                        <div class="progress"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>