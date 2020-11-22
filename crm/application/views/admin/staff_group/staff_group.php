<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<div class="modal fade" id="staff_group_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button group="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">
                    <span class="edit-title"><?php echo _l('staff_group_edit_heading'); ?></span>
                    <span class="add-title"><?php echo _l('staff_group_add_heading'); ?></span>
                </h4>
            </div>
            <?php echo form_open('admin/staff_group/staff_group_manager',array('id'=>'staff-group-modal')); ?>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <?php echo render_input('staff_group_name','staff_group_name'); ?>
                        <?php echo form_hidden('id'); ?>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button group="button" class="btn btn-default" data-dismiss="modal"><?php echo _l('close'); ?></button>
                <button group="submit" class="btn btn-info"><?php echo _l('submit'); ?></button>
                <?php echo form_close(); ?>
            </div>
        </div>
    </div>
</div>
<script>
    function staff_group_hash(){
        var pint=parseInt(getHashValue('staff_groupid'))||0;
        csrfData.formatted['id']=pint;
        var fdata=csrfData.formatted;
        if(pint>0){
            $.ajax({
              method: "POST",
              url: "<?=admin_url('staff_group/ajax')?>",
              data: fdata
            })
              .done(function( msg ) {
                msg=JSON.parse(msg)||{};
                console.log("msg",msg);
                if(msg.staff_group_name){
                    $(".modal-body input[name='staff_group_name']").val(msg.staff_group_name);
                }
                if(msg.staff_groupid){
                    $(".modal-body input[name='id']").val(msg.staff_groupid);
                    setTimeout(function(){
                        $(".modal-body input[name='id']").val(msg.staff_groupid);
                    },100);
                    $("#staff_group_modal").modal("show");
                }
              });
        }
    }
    document.addEventListener('DOMContentLoaded',function(){
    staff_group_hash();
    $(window).on('hashchange', function(e){
        staff_group_hash();
    });
});

    window.addEventListener('load',function(){
       appValidateForm($('#staff-group-modal'), {
        name: 'required'
    }, manage_staff_groups);

       $('#staff_group_modal').on('show.bs.modal', function(e) {
        var invoker = $(e.relatedTarget);
        var group_id = $(invoker).data('id');
        $('#staff_group_modal .add-title').removeClass('hide');
        $('#staff_group_modal .edit-title').addClass('hide');
        $('#staff_group_modal input[name="id"]').val('');
        $('#staff_group_modal input[name="name"]').val('');
        // is from the edit button
        if (typeof(group_id) !== 'undefined') {
            $('#staff_group_modal input[name="id"]').val(group_id);
            $('#staff_group_modal .add-title').addClass('hide');
            $('#staff_group_modal .edit-title').removeClass('hide');
            $('#staff_group_modal input[name="name"]').val($(invoker).parents('tr').find('td').eq(0).text());
        }
    });
   });
    function manage_staff_groups(form) {
        var data = $(form).serialize();
        var url = form.action;
        $.post(url, data).done(function(response) {
            response = JSON.parse(response);
            if (response.success == true) {
                if($.fn.DataTable.isDataTable('.table-staff-groups')){
                    $('.table-staff-groups').DataTable().ajax.reload();
                }
                if($('body').hasClass('dynamic-create-groups') && typeof(response.id) != 'undefined') {
                    var groups = $('select[name="groups_in[]"]');
                    groups.prepend('<option value="'+response.id+'">'+response.name+'</option>');
                    groups.selectpicker('refresh');
                }
                alert_float('success', response.message);
            }
            $('#staff_group_modal').modal('hide');
        });
        return false;
    }

</script>
