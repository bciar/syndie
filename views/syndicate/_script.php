<?php
use yii\helpers\Url;

error_log(urldecode(Url::to(['add-'.$relID])));

?>
<script>
    function addRow<?= $class ?>() {
        var data = $('#add-<?= $relID?> :input').serializeArray();
        data.push({name: '_action', value : 'add'});
        $.ajax({
            type: 'POST',
            url: '<?php echo Url::to(['add-'.$relID]); ?>',
            data: data,
            success: function (data) {
                $('#add-<?= $relID?>').html(data);
            }
        });
    }
    function delRow<?= $class ?>(id) {
        $('#add-<?= $relID?> tr[data-key=' + id + ']').remove();
    }
</script>
