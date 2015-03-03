/**
 * message center javascript
 * 
 * @package betterrecipes
 * @subpackage message
 * @author Bastian Kuberek <bkuberek@resolute.com>
 */

$(document).ready(function() {
    
    $('.message-list input.toggle').click(function(event) {
        var checked = $(this).attr('checked') ? true : false;
        if (checked) {
            $('.message-list input[type="checkbox"]').attr('checked', 'checked');
        } else {
            $('.message-list input[type="checkbox"]').removeAttr('checked');
        }
    });
    
    $('.message-list form').bind('submit', function(event) {
        event.preventDefault();
        
        var checked = [];
        $('.message-list input[type="checkbox"]').each(function() {
            if ($(this).attr('checked')) {
                checked.push(this);
            }
        })
        
        if (checked.length === 0) {
            alert('You have not selected any messages');
            return false;
        }
        
        this.submit();
        return true;
    });
    
    (function() {
        var resultsArray = {};
        $('input.autocomplete').autocomplete({
            delay: 500,
            minLength: 2,
            create: function(event, ui) {
                $(this).keypress(function(e){
                    if(e.which == '13'){
                        e.preventDefault();
                    }
                });
            },
            close: function(e, ui){
                if ($(this).hasClass('multiple')) {
                    $(this).attr('value', '');
                }
            },
            source: function(request, response) {
                var input = this.element;
                input.addClass('loading');
                var term = request.term;
                var resource = this.element.attr('data-resource');
                var display = this.element.attr('data-display') || ':name';
                var id = this.element.attr('data-id') || 'id';
                var params = this.element.attr('data-params');
                var limit = this.element.attr('data-limit') || 5;
                
                
                console.log(limit);
                
                var max_selection = this.element.attr('data-max-selection') || null;
                var extra_params = {};
                var exclude_ids = [];
                if (params) {
                    params = params.split(',');
                    for (var i = 0; i < params.length; i++) {
                        var tmp = params[i].split(':');
                        var val = tmp[1].split('|');
                        extra_params[tmp[0]] = val.length == 1 ? val[0] : val;
                    }
                }
                if (this.element.hasClass('multiple')) {
                    this.element.siblings('.tags').children('li').each(function() {
                        exclude_ids.push($(this).children('input').attr('value'));
                    });
                }
                if (max_selection != null && exclude_ids.length >= max_selection) {
                    this.element.attr('value','');
                    alert('You have reached the maximun number of selections.');
                    return;
                }
                $.ajax({
                    url: resource,
                    type: 'get',
                    data: {
                        'limit': limit,
                        'q': term,
                        'params': extra_params,
                        'exclude_ids': exclude_ids
                    },
                    dataType: "json",
                    success: function(data) {
                        var b = [];
                        var collection_name = 'results';
                        for (var i in data[collection_name]){
                            var string = display;
                            var object = data[collection_name][i];
                            object.autocomplete_id = object[id];
                            var match, j=0;
                            while (true) {
                                match = /:([a-z0-9_]+)/ig.exec(string);
                                if (!match) break;
                                string = string.replace(match[0], object[match[1]] ? object[match[1]] : 'n/a');
                                if (j++ > 10) break;
                            }
                            resultsArray[string] = object;
                            b.push(string);
                        }
                        response(b);
                        input.removeClass('loading');
                    }
                });
            },
            search: function(event, ui) {},
            select: function(event, ui) {
                var object = resultsArray[ui.item.value];
                var input = $(this);
                if (input.hasClass('multiple')) {
                    var form_name = $(this).attr('data-form-name');
                    var field_name = $(this).attr('data-field-name');
                    if (!form_name && field_name) alert('missing data-form-name and/or data-field-name');
                    field_name = form_name + '['+field_name+'][]';
                    var tag = '<li class="tag"><a href="#" class="close-tag">Close</a>' + ui.item.value + '<input type="hidden" name="'+field_name+'" value="' + object.autocomplete_id + '" /></li>';
                    input.siblings('.autocomplete-target').append(tag);
                    $('a.close-tag').click(function(){
                        $(this).parent().remove();
                        return false;
                    });
                } else if (input.next().hasClass('autocomplete-target')){
                    input.next().val(object.id);
                }
            }
        })
    })();
    
    $('.tags .tag .close-tag').bind('click', function (event) {
        event.preventDefault();
        $(this).parent().remove();
        return false;
    });
});
