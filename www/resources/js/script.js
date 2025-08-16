import Clipboard from 'clipboard';

let btn = document.getElementById('btn01');
let clipboard = new Clipboard(btn);

clipboard.on('success', function(e) {
    console.log(e);
});

clipboard.on('error', function(e) {
    console.log(e);
});