Dropzone.options.myDropzone = {
    uploadMultiple: true,
    parallelUploads: 2,
    maxFilesize: 16,
    previewTemplate: document.querySelector('#preview').innerHTML,
    addRemoveLinks: true,
    dictRemoveFile: 'Remove file',
    dictFileTooBig: 'Image is larger than 16MB',
    timeout: 10000,

    init: function () {
        this.on("removedfile", function (file) {
            remove(file.id);
        });
    },
    success: function (file, done) {
        file.id = done.data.id;
        showImage();
    }
};

$(document).ready(function() {
    showImage();
    //deleteImage();
});

/**
 * show comment for post
 */
function showImage()
{
    $('#img-show').empty();
    $.ajax({
        type: "GET",
        url: '/image/index',
        success: function( data ) {
            if (data.code === 200){
                var html = '';

                $.each( data.data, function( key, value ) {
                    html = html +
                        '<div class="card">' +
                        '    <img class="card-img-top" src="/images/' + value.resized_name + '" alt="' + value.original_name + '">' +
                        '    <div class="card-body">' +
                        '        <h5 class="card-title">' + value.original_name + '</h5>' +
                        '        <form action="" method="post">' +
                        '             <button type="button" onclick="return deleteImage(this);" data-img="' + value.id +'" class="btn btn-warning">Remove</button></td>' +
                        '       </form>'+
                        '    </div>' +
                        '</div>';
                });
                $('#img-show').append(html);
            }
        }
    });
}

function remove(id) {
    $.post({
        url: '/image/delete',
        data: {id: id, _token: $('[name="_token"]').val()},
        dataType: 'json',
        success: function (data) {
            showImage();
        }
    });
}
function deleteImage(element) {
    var id = element.dataset.img
    remove(id);
}



