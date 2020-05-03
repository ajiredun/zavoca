$(function() {
    'use strict';

    var zavoca_context_search_last = '';

    $('#btn-zavoca-context-search-exit').click(function () {
        zavoca_context_search(false);
    });

    $('#btn-zavoca-context-search').click(function (event) {
        event.preventDefault();
        var text = $('#zavoca-context-search-input').val();
        var newCard = zavoca_context_search_new_card('This feature is still under development!', text);
        zavoca_context_search_add_card(newCard);
        zavoca_context_search_last = text;
        $('#zavoca-context-search-input').val('');
    });

    $('#zavoca-context-search-input').keydown(function(event) {
        var keyUpPressed = false;
        var keyDownPressed = false;
        if (event.key !== undefined) {
            if (event.key == "ArrowUp") {
                keyUpPressed = true;
            }
            if (event.key == "ArrowDown") {
                keyDownPressed = true;
            }
        } else if (event.keyIdentifier !== undefined) {
            if (event.keyIdentifier == 38) {
                keyUpPressed = true;
            }
            if (event.keyIdentifier == 40) {
                keyDownPressed = true;
            }
        } else if (event.keyCode !== undefined) {
            if (event.keyCode == 38) {
                keyUpPressed = true;
            }
            if (event.keyCode == 40) {
                keyDownPressed = true;
            }
        }

        if (keyUpPressed) {
            $('#zavoca-context-search-input').val(zavoca_context_search_last);
            var input = $('#zavoca-context-search-input');
            input.focus();
            var tmpStr = input.val();
            input.val('');
            input.val(tmpStr);
        } else {
            if (keyDownPressed) {
                $('#zavoca-context-search-input').val('');
            }
        }
    });

    $('#btn-open-zavoca-context-search').click(function () {
        zavoca_context_search(true);
    });

    $('.zavoca-search-card .close').on('click',function () {
        var parent = $(this).parent();
        parent.slideToggle('slow');
        setTimeout(zavoca_context_search_delete_card,3000, parent);
    });


});

function zavoca_context_search_new_card(title, msg) {
    var newCardId = zavoca_context_search_new_card_id();

    return '<div id="'+newCardId+'" class="card animated fadeInUp m-b-20 zavoca-search-card zavoca-search-card-quick-tips">\n' +
        '    <div class="close bg-white"><i class="ti-close font-10"></i></div>\n' +
        '    <div class="card-body">\n' +
        '        <h3 class="card-title text-warning">'+title+'</h3>'+
        '<p class="card-text">You have typed the following: '+msg+'</p> ' +
        '<p class="card-text text-warning">This awesome feature will soon be available. </p>' +
        '</div>\n' +
        '</div>';
}

function zavoca_context_search_add_card(card) {
    $('#zavoca-context-search').append(card);
    zavoca_context_search_delete_old_cards();

    // NEED TO REDO THIS STUFF
    /*var lastCardId = zavoca_context_search_last_card_id();
    window.location.href = '/#'+lastCardId;*/
    $('#zavoca-context-search-input').focus();

}

function zavoca_context_search_delete_card(card) {
    card.remove();
}

function zavoca_context_search_last_card_id() {
    // THIS CREATES A BUG WHEN IT COMES TO ASSIGNING A NEW ID TO NEW CARDS, after we start deleting, the count stays the same
    var cardsCount = $('#zavoca-context-search .zavoca-search-card').length;

    return 'zsc-'+cardsCount;
}

function zavoca_context_search_new_card_id() {
    // THIS CREATES A BUG WHEN IT COMES TO ASSIGNING A NEW ID TO NEW CARDS, after we start deleting, the count stays the same
    var cardsCount = $('#zavoca-context-search .zavoca-search-card').length;

    cardsCount = cardsCount + 1;

    return 'zsc-'+cardsCount;
}

function zavoca_context_search_delete_old_cards() {

    // THIS CREATES A BUG WHEN IT COMES TO ASSIGNING A NEW ID TO NEW CARDS, after we start deleting, the count stays the same
    var allowedCount = 100;
    var cardsCount = $('#zavoca-context-search .zavoca-search-card').length;
    if (cardsCount > allowedCount) {
        var toDelete = cardsCount - allowedCount;
        $('#zavoca-context-search .zavoca-search-card').each(function(index) {
            if (toDelete > index) {
                var card = $(this);
                zavoca_context_search_delete_card(card);
            }
        });
    }
}

function zavoca_context_search($action) {
    if ($action) {
        $('.preloader').fadeIn();
        $('#zavoca-content-wrapper').fadeOut();
        $('#zavoca-breadcrumb-wrapper').fadeOut();
        $('#zavoca-content-footer').fadeOut();
        setTimeout(function () {
            $('.preloader').fadeOut();
            $('#zavoca-context-search-container').fadeIn();
        },500);
    } else {
        $('.preloader').fadeIn();
        $('#zavoca-context-search-container').fadeOut();
        setTimeout(function () {
            $('#zavoca-content-wrapper').fadeIn();
            $('#zavoca-breadcrumb-wrapper').fadeIn();
            $('#zavoca-content-footer').fadeIn();
            $('.preloader').fadeOut();
        },500);
    }
}