$(document).ready(function() {
   var menuId = parseInt($('input#menuId').val());
   if(menuId > 0){
       $('select.parent').each(function(){
           $(this).val($('input#parent_' + $(this).attr('data-id')).val());
       });
       $('select.parent').change(function(){
           var id = $(this).attr('data-id');
           var value = $(this).val();
           var text = $('select#parentItemId_' + id + ' option[value="' + value + '"]').text();
           if(text == 'Không có') $('input#level_' + id).val('1');
           else if(text.indexOf('+>') >= 0) $('input#level_' + id).val('3');
           else $('input#level_' + id).val('2');
       });


       $('#tbodyMenuItem').on('click', '.link_update', function(){
           var id = parseInt($(this).attr('data-id'));
           var itemName = $('input#itemName_' + id).val().trim();
           var itemmUrl = $('input#itemUrl_' + id).val().trim();
           if(itemName == '' || itemmUrl == ''){
               showNotification('Tên và URL không được bỏ trống', 0);
               return false;
           }
           $.ajax({
               type: "POST",
               url: $('input#updateMenuItem').val(),
               data: {
                   MenuItemId: id,
                   MenuId: menuId,
                   ItemName: itemName,
                   ItemUrl: itemmUrl,
                   ParentItemId: $('select#parentItemId_' + id).val(),
                   DisplayOrder: $('select#displayOrder_' + id).val(),
                   MenuLevel: $('input#level_' + id).val()
               },
               success: function (response) {
                   var json = $.parseJSON(response);
                   showNotification(json.message, json.code);
                   if (json.code == 1) redirect(true, '');
               },
               error: function (response) {
                   showNotification($('input#errorCommonMessage').val(), 0);
               }
           });
           return false;
       }).on('click', '.link_delete', function() {
           var id = parseInt($(this).attr('data-id'));
           if(id > 0){
               $.ajax({
                   type: "POST",
                   url: $('input#deleteMenuItem').val(),
                   data: {
                       MenuItemId: id
                   },
                   success: function (response) {
                       var json = $.parseJSON(response);
                       showNotification(json.message, json.code);
                       if (json.code == 1) $('tr#trMenuItem_' + id).remove();
                   },
                   error: function (response) {
                       showNotification($('input#errorCommonMessage').val(), 0);
                   }
               });
           }
           else{
               $('input#itemName_0').val('');
               $('input#itemUrl_0').val('');
               $('input#parentItemId_0').val('0');
               $('input#displayOrder_0').val('1');
               $('input#level_0').val('1');
           }
           return false;
       });
   }
   $('.submit').click(function(){
       var menuName = $('input#menuName').val().trim();
       if(menuName == ''){
           showNotification('Tên menu không được bỏ trống', 0);
           return false;
       }
       var btn = $(this);
       btn.prop('disabled', true);
       $.ajax({
           type: "POST",
           url: $('input#updateMenuUrl').val(),
           data: {
               MenuId: menuId,
               MenuName: menuName,
               StatusId: $('select#statusId').val(),
               MenuPositionId: $('select#menuPositionId').val()
           },
           success: function (response) {
               var json = $.parseJSON(response);
               showNotification(json.message, json.code);
               if(json.code == 1 && menuId == 0) redirect(false, $('input#editMenuUrl').val() + json.data);
               btn.prop('disabled', false);
           },
           error: function (response) {
               showNotification($('input#errorCommonMessage').val(), 0);
               btn.prop('disabled', false);
           }
       });
   });
});