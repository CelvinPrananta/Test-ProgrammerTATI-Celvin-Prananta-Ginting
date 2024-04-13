$(document).on('click', '.edit_bidang', function() {
    var _this = $(this).parents('tr');
    $('#e_id').val(_this.find('.id').text());
    $('#bidang_edit').val(_this.find('.bidang').text());
});

$(document).on('click', '.delete_bidang', function() {
    var _this = $(this).parents('tr');
    $('.e_id').val(_this.find('.id').text());
});