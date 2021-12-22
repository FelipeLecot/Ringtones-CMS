let loadRingtones = (lastId) => {
    $.ajax({
        url: 'https://do2indie.com/Play/Ringtones/getRingtones.php',
        data: {
            latest: lastId,
            order: $('.select-order').val(),
            cat: $('.select-cat').val(),
        },
        method: "GET",
        success: function(response) {
            let data = JSON.parse(response)
            displayRingtoneItems(data.list)
        },
        error: function(response) {
            toast.alert(`Cannot load ringtones. (${response})`)
        },
    })
}

$('.load-container').on('click', function() {
    loadRingtones($('.ringtone-item:last').attr('id'))
})

$('.select-order, .select-cat').on('change', function() {
    $('.ringtone-container').html('')
    loadRingtones(0)
})

function displayRingtoneItems(ringtones) {
    ringtones.forEach(element => {
        let ringtone = JSON.parse(element)
        
        $('.ringtone-container').append(
            `<div class="col-md-6 col-lg-4 col-xl-4 ringtone-item">
                <div>
                    <div class="audio-cont-top">
                        <div id="${ringtone.id}" class="play-audio"><i class="fa fa-play-circle fa-3x color-main"></i></div>
                        <h1 class="color-main">${ringtone.h}</h1>
                    </div>
                    <div class="audio-cont-middle">
                        <p class="audio-tag">${ringtone.t[0]}</p>
                        <p class="audio-tag">${ringtone.t[1]}</p>
                        <p class="audio-tag">${ringtone.t[2]}</p>
                    </div>
                    <div class="audio-cont-other">
                        <button idVal="${ringtone.id}" class="btn like-button" type="button">
                            <i class="fa fa-heart"></i><span class="ringtone-data">${ringtone.likes}</span>
                        </button>
                        <a href="/media/${ringtone.h}.mp3" idVal="${ringtone.id}" download="${ringtone.h}.mp3" class="btn download-button">Download<span class="ringtone-data">${ringtone.downloads}</span></a>
                    </div>
                </div>
            </div>`)   
    });
    addEventListenerToPlayButton()
    addEventListenerToAddButton()
}

function addEventListenerToPlayButton() {
    $('.play-audio').on('click', function() {
        ($(this).children('i')).removeClass('fa-play-circle').addClass('fa-pause-circle')
        let audio = new Audio(`/media/${$(this).attr('id')}.mp3`)
        audio.play()
        $(this).off().on('click', function() {
            ($(this).children('i')).removeClass('fa-pause-circle').addClass('fa-play-circle')
            audio.pause()
            audio.currentTime = 0
            addEventListenerToPlayButton()
        })
    })
}

function addEventListenerToAddButton() {
    $('.like-button').on('click', function() {
        addToRingtone($(this).attr('idVal'), 'likes')
        $(this).off()
    })

    $('.download-button').on('click', function() {
        addToRingtone($(this).attr('idVal'), 'downloads')
        $(this).off()
    })

    let addToRingtone = (id, type) => {
        $.ajax({
            url: 'https://do2indie.com/Play/Ringtones/addValueToRingtone.php',
            data: {
                id: id,
                type: type,
            },
            method: "POST",
            success: function(response) {
                if (type == 'likes') {
                    toast.success('You liked that ringtone!')
                    $(`.like-button[idVal=${id}] span`).text(parseInt($(`.like-button[idVal=${id}] span`).text()) + 1)
                }
                else {
                    toast.success('You downloaded that ringtone!')
                    $(`.download-button[idVal=${id}] span`).text(parseInt($(`.download-button[idVal=${id}] span`).text()) + 1)
                }
            },
            error: function(response) {
                toast.alert('Could not complete that action.')
            },
        })
    }
}

loadRingtones(0)