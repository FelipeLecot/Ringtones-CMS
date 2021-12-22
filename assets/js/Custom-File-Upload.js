$('#upload-button').on('click', function() {
    $('.load-container').toggleClass('d-none')
    $('.ringtone-container').html('')
    $('body').append(
        `<form id="upload-content" class="p-4 d-flex justify-content-center flex-wrap cont-upload align-content-center">
            <h1 class="text-main w-100 text-center">Upload your ringtone</h1>
            <div class="text-center">
                <label id="user_group_label" class="form-label" for="user_group_logo"><i class="fas fa-upload"></i> Choose an audio...</label>
            </div>
            <div class="w-100 d-flex justify-content-sm-evenly flex-wrap">
                <input id="heading" class="form-control w-40 upload-ringtone m-30 color-main" type="text" placeholder="Title"/>
                <input id="tags" class="form-control m-30 w-40 upload-ringtone color-main" type="text" placeholder="Tags (3 max)"/>
            </div>
            <div style="width: 200px;"><input id="user_group_logo" class="form-control custom-file-input d-none" type="file" accept="audio/mp3" name="file"/>
                <div class="text-center mt-2">
                    <button class="btn btn-primary upload-button" type="submit">Upload</button>
                </div>
            </div>
        </form>`
    )

    var fileInput = document.getElementById('user_group_logo');
        
    fileInput.onchange = function(e){
        var fullPath = fileInput.value;
        if (fullPath) {
            var startIndex = (fullPath.indexOf('\\') >= 0 ? fullPath.lastIndexOf('\\') : fullPath.lastIndexOf('/'));
            var filename = fullPath.substring(startIndex);
            if (filename.indexOf('\\') === 0 || filename.indexOf('/') === 0) {
                filename = filename.substring(1);
            }
            $('#user_group_label').text(filename);
        }
    };
    
    $('#upload-content').submit(function(e){
        e.preventDefault();
        
        let formData = new FormData(document.getElementById('upload-content'))
        let inputData = `{"data":{"h": "${$('#heading').val()}", "t": ["${$('#tags').val().split(' ')[0]}", "${$('#tags').val().split(' ')[1]}", "${$('#tags').val().split(' ')[2]}"]}}`
        formData.append('data', inputData);
    
        $.ajax({
            url: 'https://do2indie.com/Play/Ringtones/pushRingtones.php',
            method: "POST",
            data: formData,
            success: function(response) {
                toast.success('Ringtone uploaded successfully.')
                $(this).remove()
                $('.load-container').toggleClass('d-none')
                $('.ringtone-container').html('')
                loadRingtones(0)
            },
            error: function(response) {
                toast.alert('Could not upload the ringtone. ' + response)
            },
            cache: false,
            contentType: false,
            processData: false,
        })
    })
})
