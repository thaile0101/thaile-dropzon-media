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
    $('#show-image').empty();
    $.ajax({
        type: "GET",
        url: '/image/index',
        success: function( data ) {
            if (data.code === 200){
                var html = '';

                $.each( data.data, function( key, value ) {
                    html = html +
                        '<tr>' +
                        '    <td><img src="/images/' + value.resized_name + '"></td>' +
                        '    <td>' + value.original_name + '</td>' +
                        '    <td>' +
                        '<form action="" method="post">' +
                        '<button type="button" onclick="return deleteImage(this);" data-img="' + value.id +'" class="btn btn-warning">Remove</button></td>' +
                        '</form>' +
                        '</tr>'
                });
                $('#show-image').append(html);
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



