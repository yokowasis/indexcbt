var themedir = 'wp-content/themes/unbk';
var themedir2 = '../wp-content/themes/unbk';
var themedir3 = '../../wp-content/themes/unbk';

$.fn.shuffle = function() {

    var allElems = this.get(),
        getRandom = function(max) {
            return Math.floor(Math.random() * max);
        },
        shuffled = $.map(allElems, function(){
            var random = getRandom(allElems.length),
                randEl = jQuery(allElems[random]).clone(true)[0];
            allElems.splice(random, 1);
            return randEl;
       });

    this.each(function(i){
        jQuery(this).replaceWith(jQuery(shuffled[i]));
    });

    return jQuery(shuffled);

};


function timer() {
    var days        = Math.floor(seconds/24/60/60);
    var hoursLeft   = Math.floor((seconds) - (days*86400));
    var hours       = Math.floor(hoursLeft/3600);
    var minutesLeft = Math.floor((hoursLeft) - (hours*3600));
    var minutes     = Math.floor(minutesLeft/60);
    var remainingSeconds = seconds % 60;
    if (remainingSeconds < 10) {
        remainingSeconds = remainingSeconds; 
    }
    if (hours<10) {
        hours = '0' + hours;
    }
    if (minutes<10) {
        minutes = '0' + minutes;
    }
    if (remainingSeconds<10) {
        remainingSeconds = '0' + remainingSeconds;
    }
    document.getElementById('countdown').innerHTML = hours + ":" + minutes + ":" + remainingSeconds;
    if (seconds <= 0) {
        clearInterval(countdownTimer);
        document.getElementById('countdown').innerHTML = "Completed";
        jQuery('#selesai').removeClass('btn-default');
        jQuery('#selesai').addClass('btn-success');
        jQuery('#selesai').click();
    } else {
        seconds--;
    }
}

function removeOuterTag(elem){
    elem.replaceWith(elem.html());
}

function replaceTag(elem,begin,end,log) {
    s = begin;
    s += elem.html();
    s += end;
    elem.replaceWith(s);
}

function tabletodiv(table){

    table.each(function(index, el) {
        jQuery(this).children('tbody').each(function(index, el) {
            jQuery(this).children('tr').each(function(index, el) {
                jQuery(this).children('td').each(function(index, el) {
                    replaceTag(jQuery(this),'<div class="ex-td">','</div>');
                });
                replaceTag(jQuery(this),'<div class="ex-tr">','</div>');
            });
            replaceTag(jQuery(this),'<div class="ex-tbody">','</div>');
        });
        replaceTag(jQuery(this),'<div class="ex-table">','</div>');
    });

}