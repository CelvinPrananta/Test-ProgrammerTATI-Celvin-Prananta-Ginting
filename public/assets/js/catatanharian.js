$(document).on('click', '.edit_catatan_harian', function()
{
    var _this = $(this).parents('tr');
    $('#e_id').val(_this.find('.id').text());
    $('#e_catatan_kegiatan').val(_this.find('.catatan_kegiatan').text());
    $('#e_tanggal_kegiatan').val(_this.find('.tanggal_kegiatan').text());
});

$('#name').on('change',function()
{
    $('#user_id').val($(this).find(':selected').data('user_id'));
    $('#nip').val($(this).find(':selected').data('nip'));
});