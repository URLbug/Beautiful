import Clipboard from 'clipboard';

document.addEventListener('DOMContentLoaded', function(){
    const btns = document.querySelectorAll('.js-share');

    btns.forEach(function(element) {
        let clipboard = new Clipboard(element);

        clipboard.on('success', function(e) {
            e.trigger.classList.add('text-success');

            setTimeout(function() {
                e.trigger.classList.remove('text-success')
            }, 5000)
        });
    });

});
