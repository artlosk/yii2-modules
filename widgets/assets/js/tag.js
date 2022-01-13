$(document).ready(function () {

    /*function serialize(tokenfield) {
        var items = tokenfield.getItems();
        var prop;
        var data = {};
        items.forEach(function(item) {
            if (item.isNew) {
                prop = tokenfield._options.newItemName;
            } else {
                prop = tokenfield._options.itemName;
            }
            if (typeof data[prop] === 'undefined') {
                data[prop] = [];
            }
            if (item.isNew) {
                data[prop].push(item.name);
            } else {
                data[prop].push(item[tokenfield._options.itemValue]);
            }
        });
        return data;
    }
    */

    if($('#tags-input').val() != '') {
        $.ajax({
            type: 'GET',
            url: '/cp/tag/default/get-current-tags',
            data: {ids: $('#tags-input').val()},
            success: function (data) {
                jpn.setItems(data);
            },
            error: function (data) {
                console.log('error');
            }
        });
    }
    var jpn = new Tokenfield({
        el: document.querySelector('#tags-input'),
        //items: colors,
        remote: {
            url: '/cp/tag/default/list-tag'
        },
        //form: document.querySelector('form'),
        addItemOnBlur: false,
        addItemsOnPaste: true,
        delimiters: [',', ' '],
        minChars: 0,
        maxSuggestWindow: 5,
        singleInput: true,
        singleInputValue: 'id'
    });

    //console.log(items);
    //jpn.setItems(items);

    jpn.on('change', function() {
        //console.log(jpn.getItems());
        //document.querySelector('.js-primary-new-result').textContent = out;
    });
    jpn.on('addToken', function(e, data) {
        //console.log(data);
        if(data.isNew) {
            $.ajax({
                type: 'GET',
                dataType: 'JSON',
                url: '/cp/tag/default/check-tag',
                data: {item: data.name},
            }).done(function (data) {
                //console.log(data);
                if (data.success) {
                    var currentObj = [];

                    $('.tokenfield-set ul li').each(function(i, el) {
                        var id = $(el).find('.item-input').val();
                        var label = $(el).find('.item-label').text();
                        if(label == data.record.name) {
                            id = data.record.id;
                        }
                        currentObj.push({
                            id: id,
                            name: label
                        });


                    });
                    //console.log(currentObj);
                    jpn.setItems(currentObj);
                }
            }).fail(function (fail) {
                // request failed
            });
        } else {

        }
        //var out = JSON.stringify(serialize(jpn), null, 2);
        //console.log(out);
    });

})
;